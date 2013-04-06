#!/usr/local/bin/perl
use Socket;
use Net::SSLeay qw(die_now die_if_ssl_error) ;
use DBI;

my $CertFile = "cert_200808.pem";
my $KeyFile = "key_200808.pem";
my $CAfile = "CAcert_roots.pem";
my $TargetHost="secure.cacert.org";
my $TargetScript="cats/cats_import.php";
my $ConnectInc="/home/cats/public_html/includes/db_connect.inc";

sub url_encode($)
{
  my ($Input) = @_;
  my $Result;
  
  $Input =~ s/([^A-Za-z0-9])/sprintf("%%%02X", ord($1))/seg;
  return $Input;
}

sub SendRecord($$$$$$)
{
  my ($ssl, $serial, $root, $type, $variant, $date) = @_;
  my $data;
  my $msg;
  my $res;
  my $CurLine;
  my $IsChunked;
  my $IsHTML;
  my $CurBlock;
  my $ChunkSize;
  my $BytesRead;
  my $Result;
  my $ContentLength;
  my $DoClose;
  my $HTTPResult;
  my $HTTPTextResult;
 
  $data = "serial=".url_encode($serial)."&root=".url_encode($root)."&type=".url_encode($type).
          "&variant=".url_encode($variant)."&date=".url_encode($date)."&OK=Anfrage+abschicken\r\n";
  $msg = 
        "POST https://$TargetHost/$TargetScript HTTP/1.1\r\n".
        "Host: $TargetHost\r\n".
        "Connection: keep-alive\r\n".
        "Content-Type: application/x-www-form-urlencoded\r\n".
        "Content-Length: ". length($data) . "\r\n\r\n".$data;

  $res = Net::SSLeay::ssl_write_all($ssl, $msg);  # Perl knows how long $msg is
  die_if_ssl_error("ssl write");
  
  $IsChunked = 0;
  $ContentLength = 0;
  $DoClose = 0;
  do {
    $CurLine = Net::SSLeay::ssl_read_CRLF($ssl);
    die_if_ssl_error("ssl_read_CRLF");
    if (!$CurLine) {
      print "ssl_read_CRLF returns nothing\n";
      return "BREAK";
    }
    if (CurLine =~ /^HTTP\/[0-9.]+ (\d+) (.+)/i) {
      $HTTPResult = $1;
      $HTTPTextResult = $2;
    }
    if ($CurLine =~ /^Transfer-Encoding: chunked/i) {
      $IsChunked = 1;
    }
    if ($CurLine =~ /^Content-Type: text\/html;/i) {
      $IsHTML = 1;
    }
    if ($CurLine =~ /^Content-Length:\s*(\d+)/) {
      $ContentLength = $1;
    }
    if ($CurLine =~ /^Connection: close/) {
      $DoClose = 1;
    }
  } while($CurLine ne "\r\n");
  
  if ($IsChunked && $IsHTML) {
    do {
      $CurLine = Net::SSLeay::ssl_read_CRLF($ssl);
      die_if_ssl_error("ssl_read_CRLF");
      if ($CurLine =~ /^([0-9A-F]+)/i) {
        $ChunkSize = hex($1);
      } else {
        die "Invalid format\n";
      }
      $BytesRead = 0;
      while($BytesRead < $ChunkSize) {
        $CurBlock = Net::SSLeay::read($ssl, $ChunkSize);
        $Result .= $CurBlock;
        $BytesRead += length($CurBlock);
      }
      # Trailing CR/LF
      $CurLine = Net::SSLeay::ssl_read_CRLF($ssl);
    } while($ChunkSize > 0);
  } elsif ($ContentLength > 0) {
    $Result = Net::SSLeay::read($ssl, $ContentLength);
  }
  
  return ($DoClose, $Result);
}

# parse db_connect.inc for database parameters
sub connect_with_php_inc($)
{
  my ($phpFile) = @_;
  my $user;
  my $password;
  my $DataBase;  
  my $dbh;

  open(INFILE, $phpFile) || die "Cannot open $phpFile\n";
  while(<INFILE>) {
    if (/\$user\s*=\s*\"([^\"]*)\"/i) {
      $user = $1;
    } elsif (/\$password\s*=\s*\"([^\"]*)\"/i) {
      $password =$1;
    } elsif (/\$database\s*=\s*\"([^\"]*)\"/i) {
      $DataBase = $1;
    }
    last if ($user && $password && $DataBase);
  }
  
  $dbh=DBI->connect("DBI:mysql:database=$DataBase", $user, $password);
  if (!$dbh) {
    die "Cannot open Database $DataBase/$user/$password\n";
  }
  
  return $dbh;
}

my $CurArg = 0;

while($CurArg < scalar(@ARGV)) {
  if ($ARGV[$CurArg] eq "--CertFile") {
    $CurArg++;
    $CertFile = $ARGV[$CurArg];
  } elsif ($ARGV[$CurArg] eq "--KeyFile") {
    $CurArg++;
    $KeyFile = $ARGV[$CurArg];
  } elsif ($ARGV[$CurArg] eq "--CAFile") {
    $CurArg++;
    $CAFile = $ARGV[$CurArg];
  } elsif ($ARGV[$CurArg] eq "--Host") {
    $CurArg++;
    $TargetHost = $ARGV[$CurArg];
  } elsif ($ARGV[$CurArg] eq "--ConnectInc") {
    $CurArg++;
    $ConnectInc = $ARGV[$CurArg];
  }
  $CurArg++;
}

Net::SSLeay::load_error_strings();
Net::SSLeay::SSLeay_add_ssl_algorithms();
Net::SSLeay::randomize();

my $dbh = connect_with_php_inc($ConnectInc);
my $sth;
my $RecID;
my $serial;
my $root;
my $type;
my $variant;
my $date;
my @OKIDs;
my @FailIDs;
my $RowNum;
my $DoClose;

$dbh->do("SET time_zone='+00:00'");
$sth = $dbh->prepare("SELECT `lp`.`lp_id`, `lp`.`user_id`, `lp`.`root`, `tt`.`text`, `t`.`topic`, `lp`.`date` ".
                     "FROM `learnprogress` AS `lp`, `topics` AS `t`, `topic_type` AS `tt` ".
                     "WHERE `lp`.`t_id`=`t`.`t_id` AND `lp`.`percentage` >= `t`.`percentage` AND `lp`.`correct`>0 ".
                     "  AND `t`.`type_id`=`tt`.`type_id` ".
                     "  AND `t`.`type_id` in (1, 3) ". # Upload Assurer Challenge and Triage challenge
                     "  AND `lp`.`uploaded` IS NULL");
if (!$sth->execute()) {
  die($sth->errstr);
}

$port = 443;
$dest_ip = gethostbyname ($TargetHost);
$dest_serv_params  = sockaddr_in($port, $dest_ip);

# Exchange data
$RowNum = 0;
$DoClose = 1;
do {
  ($RecID, $serial, $root, $type, $variant, $date) = $sth->fetchrow_array();

  if ($DoClose) {
    socket  (S, &AF_INET, &SOCK_STREAM, 0)  or die "socket: $!";
    connect (S, $dest_serv_params)          or die "connect: $!";
    select  (S); $| = 1; select (STDOUT);   # Eliminate STDIO buffering

    # The network connection is now open, lets fire up SSL    

    $ctx = Net::SSLeay::CTX_new() or die_now("Failed to create SSL_CTX $!");
    Net::SSLeay::CTX_set_options($ctx, &Net::SSLeay::OP_ALL)
     and die_if_ssl_error("ssl ctx set options");

    # Set accepted CAs
    Net::SSLeay::CTX_load_verify_locations($ctx, $CAfile, 0);

    # Add client vertificate
    Net::SSLeay::set_cert_and_key($ctx, $CertFile, $KeyFile);

    $ssl = Net::SSLeay::new($ctx) or die_now("Failed to create SSL $!");
    Net::SSLeay::set_fd($ssl, fileno(S));   # Must use fileno
    $res = Net::SSLeay::connect($ssl) and die_if_ssl_error("ssl connect");
    #print "Cipher `" . Net::SSLeay::get_cipher($ssl) . "'\n";
    # Still to do here. CRL/OCSP-Checking
  }
  
  if ($RecID) {
    ($DoClose, $got) = SendRecord($ssl, $serial, $root, $type, $variant, $date);
  
    $got =~ s/\s+$//g;
    print localtime(time).": $root/$serial, $type/$variant: $got\n";
    if (($got =~ /^OK/i) || ($got =~ /^Duplicate/i)) {
      push(@OKIDs, $RecID);
    } elsif ($got =~ /^Cannot find cert/i) {
      push(@FailIDs, $RecID);
    }
    $RowNum += 1;

    if ($DoClose) {
      # Server requested closing of connection
      CORE::shutdown S, 1;  # Half close --> No more output, sends EOF to server
      Net::SSLeay::free ($ssl);               # Tear down connection
      Net::SSLeay::CTX_free ($ctx);
      close S;
    }
  }
} while($RecID && ($got ne "BREAK"));

if (!$DoClose) {
  CORE::shutdown S, 1;  # Half close --> No more output, sends EOF to server
  Net::SSLeay::free ($ssl);               # Tear down connection
  Net::SSLeay::CTX_free ($ctx);
  close S;
}

$sth = $dbh->prepare("UPDATE `learnprogress` SET `uploaded`=1 WHERE `lp_id`=?");
foreach $RecID (@OKIDs) {
  $sth->execute($RecID);  
}

$sth = $dbh->prepare("UPDATE `learnprogress` SET `uploaded`=2 WHERE `lp_id`=?");
foreach $RecID (@FailIDs) {
  $sth->execute($RecID);  
}

$dbh->disconnect();

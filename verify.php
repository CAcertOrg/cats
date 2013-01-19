<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<head>
<title>Test verification</title>
</head>
<body>

<h1>Quick and dirty Test verifier</h1>  
<?php
  $CertSerial = '';
  if (isset($_POST["CertSerial"])) {
    for($i = 0; $i < strlen($_POST["CertSerial"]); $i++) {
      $Char = strtoupper($_POST["CertSerial"][$i]);
      if (($Char >= '0' && $Char <= '9') || ($Char >= 'A' && $Char <= 'F')) {
        $CertSerial = $CertSerial . $Char;
      }
    }
    
    if (substr($CertSerial, 0, 2) === "00") {
      $CertSerial = substr($CertSerial, 2);
    }
  }
  
  if (strlen($CertSerial)<4 || strlen($CertSerial)>8) {
    echo "Sorry, invalid serial number '$CertSerial'!\n";
  } elseif (strlen(stristr($_SERVER['SSL_CLIENT_S_DN'], "/emailAddress=education@cacert.org"))<1) {
    echo "Sorry, a client certificate with emailAddress=education@cacert.org is needed!\n";
  } elseif (strlen($CertSerial) > 0) {
    require_once("includes/db_connect.inc");
    $statement="SELECT t.t_id, t.topic, ".
               "       (SELECT max(lp.date) FROM learnprogress lp WHERE lp.t_id=t.t_id AND lp.user_id='$CertSerial' AND lp.percentage >= t.percentage) Time ".
               "FROM topics t ".
               "WHERE EXISTS(SELECT 1 FROM learnprogress lp WHERE lp.user_id='$CertSerial' AND lp.t_id=t.t_id AND lp.percentage >= t.percentage)";
    $query = mysql_query($statement);
    echo "<h3>Passed tests by certificate '$CertSerial'</h3>\n";
    echo "<table class='resulttable'><tr><td><b>TopicID</b></td><td><b>TopicName</b></td><td><b>Last Success</b></td></tr>\n";
    while($row = mysql_fetch_assoc($query)) {    
      echo "<tr><td>".$row['t_id']."</td><td>".$row['topic']."</td><td>".$row['Time']."</td></tr>\n";
    }
    echo "</table>\n";
  }
  
?>

<form action="verify.php" method="POST">

<p>Cert serial:<br /><input name="CertSerial" type="text" size="11" maxlength="11" /></p>

<input type='submit' value='OK' />
</form>
</body>

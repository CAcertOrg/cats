<? 
 function getocsp(){

	// Pfadangaben
	$command="C:\Programme\\xampp\apache\bin\openssl";                     // OpenSSL.exe
	$ocspServer="http://ocsp.cacert.org:2560";                             // OCSP Server
	$issuer="C:\Programme\\xampp\apache\conf\etc\ocsp\DataExchange.pem ";  // Issuer .pem Datei
  $vafile="C:\Programme\\xampp\apache\conf\etc\ocsp\CertExchange.pem";   // Va .pemDatei
 
  // OCSP Request
	$reqStr=$command." ocsp -url ".$ocspServer." -issuer ".$issuer." -VAfile ".$vafile." -serial ".hexdec($_SERVER["SSL_CLIENT_M_SERIAL"]);
	//echo $reqStr;
  // Aufruf
  exec($reqStr,$arr);

  // Verarbeitung der Response
	if($arr[0]=="".hexdec($_SERVER["SSL_CLIENT_M_SERIAL"]).": revoked")$_SESSION['profile']['OCSP']=1;
    else if($arr[0]=="".hexdec($_SERVER["SSL_CLIENT_M_SERIAL"]).": good")$_SESSION['profile']['OCSP']=1;
	   else $_SESSION['profile']['OCSP']=2;
  
  }
 ?> 

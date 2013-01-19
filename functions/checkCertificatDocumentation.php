<?php

// This is not used anymore, nevertheless the storing of sensitive data has been removed.

function checkCertificatDocumentation(){
    
  // Includieren
  include ("functions/certificateDocumentation.php");
  include ("functions/acceptLogin.php"); 
  
  // Überprüfung auf String  / Wertzuweisung
  $email=''; if("${_SERVER['SSL_CLIENT_S_DN_Email']}")$email=mysql_real_escape_string("${_SERVER['SSL_CLIENT_S_DN_Email']}");


  if ($_POST["perPost"]=='no' ){
    $sql="INSERT INTO user (user_id,root,admin,lang,sendCert) VALUES ('".mysql_real_escape_string($_SERVER["SSL_CLIENT_M_SERIAL"])."','".mysql_real_escape_string( $_SERVER['SSL_CLIENT_S_DN_CN'])."','".intval(0)."','".mysql_real_escape_string(EN)."','".mysql_real_escape_string(no)."')";
    $ok= mysql_query($sql); 
                                        
    $_SESSION['profile']['id']=$_SERVER["SSL_CLIENT_M_SERIAL"];
    $_SESSION['profile']['root'] =$_SERVER['SSL_CLIENT_I_DN_CN'];
    $_SESSION['profile']['admin'] =0;
    $_SESSION['profile']['language']='EN';
    $_SESSION['profile']['loggedin'] = 1; 
    unset($_SESSION['userInformation']);
    echo" <meta http-equiv='refresh' content='0; url=?' />"; 
    }
    
    if($_POST["perPost"]=='yes_mail'&& $_SERVER['SSL_CLIENT_S_DN_CN']!="CAcert WoT User"){
      $sql="INSERT INTO user (user_id,root,admin,lang,sendCert) VALUES ('".mysql_real_escape_string($_SERVER["SSL_CLIENT_M_SERIAL"])."','"..mysql_real_escape_string( $_SERVER['SSL_CLIENT_S_DN_CN'])."','".intval(0)."','".mysql_real_escape_string(EN)."','".mysql_real_escape_string(email)."')";
      $ok= mysql_query($sql); 
      
      $_SESSION['profile']['id']=$_SERVER["SSL_CLIENT_M_SERIAL"];
      $_SESSION['profile']['root'] =$_SERVER['SSL_CLIENT_I_DN_CN'];
      $_SESSION['profile']['admin'] =0;
      $_SESSION['profile']['language']='EN';
      $_SESSION['profile']['loggedin'] = 1; 
      unset($_SESSION['userInformation']);
      echo "<meta http-equiv='refresh' content='0; url=?' />"; 
    }
    
    if ($_POST["perPost"]=='yes_post'&& $_SERVER['SSL_CLIENT_S_DN_CN']!="CAcert WoT User"){
      //$fname=mysql_real_escape_string($_POST["firstname"]);
      //$sname=mysql_real_escape_string($_POST["surename"]);
      //$street=mysql_real_escape_string($_POST["street"]);
      //$hNumber=mysql_real_escape_string($_POST["housenumber"]);
      //$zipcode=mysql_real_escape_string($_POST["zipcode"]);
      //$city=mysql_real_escape_string($_POST["city"]);
      //$state=mysql_real_escape_string($_POST["state"]);
      //$country=mysql_real_escape_string($_POST["country"]);
      
        if($fname!=null && $sname!=null && $street!=null && $hNumber!=null && $zipcode!=null && city !=null && $state !=null && $country!=null){
          $sql="INSERT INTO user (user_id,root,admin,lang,sendCert) VALUES ('".mysql_real_escape_string($_SERVER["SSL_CLIENT_M_SERIAL"])."','".mysql_real_escape_string( $_SERVER['SSL_CLIENT_S_DN_CN'])."','".intval(0)."','".mysql_real_escape_string(EN)."','".mysql_real_escape_string(post)."')";
          $ok= mysql_query($sql); 
                                            
          //$sql_address= "INSERT INTO user_address (user_id,firstname,lastname,street,housenumber,zipcode,city,state,country) VALUES ('".mysql_real_escape_string($_SERVER["SSL_CLIENT_M_SERIAL"])."','".mysql_real_escape_string($fname)."','".mysql_real_escape_string($sname)."','".mysql_real_escape_string($street)."','".mysql_real_escape_string($hNumber)."','".mysql_real_escape_string($zipcode)."','".mysql_real_escape_string($city)."','".mysql_real_escape_string($state)."','".mysql_real_escape_string($country)."')";
          //$ok_address= mysql_query($sql_address); 
                                            
          unset($_SESSION['userInformation']);
          $_SESSION['profile']['id']=$_SERVER["SSL_CLIENT_M_SERIAL"];
          $_SESSION['profile']['root'] =$_SERVER['SSL_CLIENT_I_DN_CN'];
          $_SESSION['profile']['admin'] =0;
          $_SESSION['profile']['language']='EN';
          $_SESSION['profile']['loggedin'] = 1; 
          echo" <meta http-equiv='refresh' content='0; url=?' />"; 
        }
        
        else {
          echo '<div class="h8 centered">'.certificateDocu_12."</div>";
          
          // Session Variablen setzen     
          $_SESSION['userInformation']['firstname']=$fname;
          $_SESSION['userInformation']['surename']=$sname;
          $_SESSION['userInformation']['street']=$street;
          $_SESSION['userInformation']['housenumber']=$hNumber;
          $_SESSION['userInformation']['zipcode']=$zipcode;
          $_SESSION['userInformation']['city']=$city;
          $_SESSION['userInformation']['state']=$state;
          $_SESSION['userInformation']['country']=$country;
          $_SESSION['userInformation']['post']=1;
          
          cD();
        }
                                           
    }
    
    if((($_POST["perPost"]=='yes_post')||($_POST["perPost"]=='yes_mail')) && (strcmp($_SERVER['SSL_CLIENT_S_DN_CN'], "CAcert WoT User")==0)){
    
      // Fehlermeldung ausgeben
      echo '<div class="h9 centered">'.Check_Cert_01."</div>";
                                            
      acceptLogin();
    }
}

?>

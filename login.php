<?php

// einbinden der Dateien
include ("functions/api.php");
include ("functions/acceptLogin.php");

  if($_SERVER['HTTP_HOST'] == $_SESSION['_config']['securehostname'] && ($_SESSION['profile']['id'] == 0 ||
     !isset($_SESSION['profile']['loggedin']) || $_SESSION['profile']['loggedin'] == 0)){
    if($_SERVER['SSL_CLIENT_VERIFY']=='SUCCESS'){

        $user_id=0; if($_SERVER["SSL_CLIENT_M_SERIAL"])$user_id=$_SERVER["SSL_CLIENT_M_SERIAL"];
        $root=0; if($_SERVER['SSL_CLIENT_I_DN_CN'])$root=$_SERVER['SSL_CLIENT_I_DN_CN'];

        if (isset($_SERVER["SSL_CLIENT_S_DN_O"])) {
          echo '<h5 class="centered"><br />'.Login_03_No_Org_Certs.'</h5>';
        } elseif(!isset($_SERVER["SSL_CLIENT_S_DN_Email"]) {
          echo '<h5 class="centered"><br />'.Login_04_No_Server_Certs.'</h5>';
        } elseif( $user_id ){
        $sql="SELECT * FROM user where `user_id`='".$user_id."' and `root`='".$root."' ";
        $query = mysql_query($sql);
        $nr=mysql_num_rows($query);

          if($nr==0){
           unset($_SESSION ['userInformation']);
           $_SESSION['profile']['id']=$user_id;
           $_SESSION['profile']['root']=$root;
           acceptLogin();
          }
          else {
            $row = mysql_fetch_assoc($query);
            $_SESSION['profile']['loggedin'] = 1;
            $_SESSION['profile']['language']= $row['lang'];
            $_SESSION['profile']['id']=$row['user_id'];
            $_SESSION['profile']['root'] =$row['root'];
            $_SESSION['profile']['admin'] =$row['admin'];
            echo" <meta http-equiv='refresh' content='0; url=?' />";
        }

      } else {
      	echo Global_19;
	echo "<br>_SERVER[SSL_CLIENT_M_SERIAL]: ".$_SERVER["SSL_CLIENT_M_SERIAL"]."<br>\n";
      }
    }
    else {
      echo '<h5 class="centered"><br />'.Global_17.'</h5>';
    }
  }

  if(isset($_REQUEST['id']) && $_REQUEST['id'] == "logout"){
   // Sprachänderungen werden übernommen
     if(isset($_SESSION['profile']['language'])){
       $sql="UPDATE user SET lang='". $_SESSION['profile']['language'] ."' WHERE user_id='".mysql_real_escape_string ($_SESSION['profile']['id'])."'";
       $query = mysql_query($sql);
     }

    $_SESSION['profile']['loggedin'] = 0;
    $_SESSION['profile'] = "";
    unset($_SESSION);
    unset($_SESSION ['values']);
    unset($_SESSION ['profile']);
    session_destroy();
    echo" <meta http-equiv='refresh' content='0; url=?' />";

    exit;
  }

?>

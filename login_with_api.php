<?php
//print_r ($_SERVER);
//include ("functions/ocsp.php");
include ("functions/api.php");
include ("functions/acceptLogin.php");

  if($_SERVER['HTTP_HOST'] == $_SESSION['_config']['securehostname'] && ($_SESSION['profile']['id'] == 0 || $_SESSION['profile']['loggedin'] == 0))
  {
    if($_SERVER['SSL_CLIENT_VERIFY']=='SUCCESS'){
      if($_SERVER['SSL_CLIENT_I_DN_CN']=='CA Cert Signing Authority')$root=1;
      else if ($_SERVER['SSL_CLIENT_I_DN_CN']=='CAcert Class 3 Root')$root=2;

      $data = "serial=".$_SERVER['SSL_CLIENT_M_SERIAL']."&root=$root";
      $x = PostToHost("www.cacert.org", "/api/edu.php", "No_Referrer", $data);
      // 2007-10-22 Ted: Looks like the server has changed the number of header lines in its reply.
      //                 IMHO hardcoding the number of header lines in a HTTP response is ... adventurous ...
      //                 Look for the first empty line, the data line is the next! Put it in a function!
      $user_id=$x[10];
      if( $user_id!=0){
        $sql="SELECT * FROM user where `user_id`='".mysql_real_escape_string($user_id)."'";
        $query = mysql_query($sql);
        $nr=mysql_num_rows($query);

        if($nr==0){
          $_SESSION['profile']['id']=$user_id;
          acceptLogin();

        } else {
          $row = mysql_fetch_assoc($query);
          $_SESSION['profile']['loggedin'] = 1;
          $_SESSION['profile']['language']= $row['lang'];
          $_SESSION['profile']['id']=$row['user_id'];
          $_SESSION['profile']['admin'] =$row['admin'];
          $_SESSION['profile']['email'] =$row['email'];
          echo" <meta http-equiv='refresh' content='0; url=?' />";
        }

    //}
  // else if($_SESSION['profile']['OCSP']==2 )echo " <h3>".Login_01."</h3>";
   //else if($_SESSION['profile']['OCSP']==0)echo "<h3>".Login_02."</h3>";
      } else {
        echo "Fehler beim Loginvorgang<br />\n";
        // Debug prints for isolating login problems
        // echo "Data: $data<br />\n";
        // echo "<pre>".join("", @$x)."</pre>";
      }
    }
    else {
      echo '<h5 class="centered"><br />'.Global_17.'</h5>';
    }
  }
  /*  $query = "select * from `emailcerts` where `serial`='${_SERVER['SSL_CLIENT_M_SERIAL']}' and `revoked`=0 and
        UNIX_TIMESTAMP(`expire`) - UNIX_TIMESTAMP() > 0";
    $res = mysql_query($query);
    if(mysql_num_rows($res) > 0){
      $row = mysql_fetch_assoc($res);
      $_SESSION['profile']['loggedin'] = 0;
      $_SESSION['profile'] = "";
      foreach($_SESSION as $key){
        if($key == '_config')
          continue;
        if(is_int($key) || is_string($key))
                    unset($_SESSION[$key]);
                    unset($key);
                    session_unregister($key);
      }
      $sql=mysql_query("select * from `users` where `id`='".$row['memid']."'");
        if (mysql_num_rows($sql) ==1){
          $_SESSION['profile'] = mysql_fetch_assoc($sql);
            if($_SERVER['SSL_CLIENT_S_DN_Email']!=$_SESSION['profile']['email']){
              $sql_email=mysql_query("SELECT * FROM email WHERE email='${_SERVER['SSL_CLIENT_S_DN_Email']}'AND memid=".$_SESSION['profile']['id']." AND deleted='0000-00-00 00:00:00'");
                if (mysql_num_rows($sql_email) ==1)$_SESSION['profile']['loggedin'] = 1;
                  else unset($_SESSION['profile']);
            }
            else $_SESSION['profile']['loggedin'] = 1;
        }
      else  unset($_SESSION['profile']);
    } else {
      $_SESSION['profile']['loggedin'] = 0;
      $_SESSION['profile'] = "";
      foreach($_SESSION as $key)
      {
        if($key == '_config')
          continue;
          unset($_SESSION[$key]);
          unset($key);
          session_unregister($key);
      }
      exit;
    }
  }
   }
  if($_SERVER['HTTP_HOST'] == $_SESSION['_config']['securehostname'] && $_SESSION['profile']['id'] > 0 && $_SESSION['profile']['loggedin'] > 0)
  {
      $_SESSION['_config']['language'] = $_SESSION['profile']['language'];
      putenv("LANG=".$_SESSION['_config']['language']);
      setlocale(LC_ALL, $_SESSION['_config']['language']);
      $domain = 'messages';
      bindtextdomain("$domain", $_SESSION['_config']['filepath']."/locale");
      textdomain("$domain");
    //  echo" <META HTTP-EQUIV='refresh' content='0;URL=?'>";
  }*/

  if($_REQUEST['id'] == "logout")
  {
    if(isset($_SESSION['profile']['language'])){
      $sql="UPDATE user SET lang='".$_SESSION['profile']['language']."' WHERE user_id='".$_SESSION['profile']['id']."'";
      $query = mysql_query($sql);
    }
    $_SESSION['profile']['loggedin'] = 0;
    $_SESSION['profile'] = "";
    echo" <meta http-equiv='refresh' content='0; url=?' />";
    session_destroy();
    exit;
  }

?>

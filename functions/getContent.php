<?php

function unsetSession()
{
  if (isset($_SESSION ['values']['selectedAnswers'])) unset ($_SESSION ['values']['selectedAnswers']);
  if (isset($_SESSION ['values']['questionList'])) unset ($_SESSION ['values']['questionList']);
  if (isset($_SESSION ['values']['answerList'])) unset ($_SESSION ['values']['answerList']);
}

function getContent ()
{
  // Überprüfung auf String  / Wertzuweisung
  if (isset($_SESSION['values']['site'])) {
    $site=strval($_SESSION['values']['site']);
  } else {
    $site=0;
  }
  if (isset($_SESSION['profile']['admin'])) {
    $is_admin = $_SESSION['profile']['admin'];
  } else {
    $is_admin = 0;
  }
  
  switch($site) {
    case "topic" : 
    {
      unsetSession();
      if($is_admin==1)include("topic.php"); 
      break;
    }
    case "collect_question":
    {
      unsetSession();
      if($is_admin==1)include("collect_question.php"); 
      break;
    }
    case "statistic":
    {
      unsetSession();
      if($is_admin==1) include("statistic.php"); 
      break;
    }
    case "start_test":{
          include("start_test.php"); 
          break;
          }
    case "progress" :
    {
      unsetSession();
           
      include("progress.php"); 
      break;
    }
  case "login":{
              include("login.php"); 
              break;
                }
  case "lang":
  {
    unsetSession();
    if($_SESSION['profile']['language']=='DE') {
      $_SESSION['profile']['language']='EN';
    } elseif ($_SESSION['profile']['language']=='EN') {
      $_SESSION['profile']['language']='DE';
    } else {
      // Default language
      $_SESSION['profile']['language']='EN';
    }
    echo" <meta http-equiv='refresh' content='0; url=?' />";
    break;
  }
  case "accept_login":{
                          if($_REQUEST["submit"]==Global_13){
                          $sql="INSERT INTO user (user_id,root,admin,lang,sendCert) VALUES ('".mysql_real_escape_string($_SERVER["SSL_CLIENT_M_SERIAL"])."','".mysql_real_escape_string( $_SERVER['SSL_CLIENT_I_DN_CN'])."','".intval(0)."','".mysql_real_escape_string(EN)."','".mysql_real_escape_string(no)."')";
                          $ok= mysql_query($sql); 
                          $_SESSION['profile']['loggedin'] = 1;
                          $_SESSION['profile']['language']= 'EN';
                          $_SESSION['profile']['id']=$_SERVER["SSL_CLIENT_M_SERIAL"];
                          $_SESSION['profile']['root'] =$_SERVER['SSL_CLIENT_I_DN_CN'];
                          $_SESSION['profile']['admin'] =0;
                          echo" <meta http-equiv='refresh' content='0; url=?' />";
                          // No storage of personal data!
                          //include ("functions/certificateDocumentation.php");
                          //cD();
                          }
                          else{
                          echo '<div class="h8 centered">'.Get_Content_01."<br /></div>";
                          }
                          break;
                      }
  case "showCertificateInfo": {
                              include ("functions/acceptLogin.php");  
                              echo '<div class="certificateinfo">';
                              showCertificateInfos();
                              echo '</div>';
                              break;
                              }
   case "certificateDocumentation": {
                                      include ("functions/checkCertificatDocumentation.php");  
                                      checkCertificatDocumentation();
                                     
                                    break;
                                  }  
  default:  
      echo  '<br /><br /><h2 class="maintitle">'.Function_getContent_01.'</h2><br />';
      echo Function_getContent_02_Intro;
  }
}
?>

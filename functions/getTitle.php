<?php
function getTitle(){
  if (isset($_SESSION['values']['site'])) {
    $site=strval($_SESSION['values']['site']);
  } else {
    $site=0;
  }
  
        switch($site)   {
                case "topic" : {
                                 echo "<title>".Title_01."</title>\n";  
                                                          break;
                                                        }
                case "collect_question":{
                                            echo "<title>".Title_02."</title>\n";       
                                                                    break;
                                                                }
                case "statistic":{
                                    echo "<title>".Title_03."</title>\n";       
                                    break;
                                                          }
                case "start_test":{
                                                echo "<title>".Title_04."</title>\n";                   
                                                      break;
                                                    }
                case "progress" :{
                                    echo "<title>".Title_05."</title>\n";       
                                                            break;
                                                          }
  case "showCertificateInfo": {
                              echo "<title>".Title_06."</title>\n";     
                              break;
                              }
        default:echo "<title>CAcert Automated Training System</title>\n";                                         
        }
}
?>

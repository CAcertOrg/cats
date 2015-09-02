 <?php
// nur wenn man eingeloggt ist und admin Rechte hat
if(($_SESSION['profile']['loggedin']==1) &&($_SESSION['profile']['admin']==1)){
  
  // Includieren
  include ("includes/db_connect.inc");  
  include ("functions/reallyDel.php");
  include ("functions/clearDatabase.php");

  // Objekte erzeugen
  $topics=new Topic();    
  $question= new Question();
  $answer= new Answer();
  
  // Überprüfung auf String  / Wertzuweisung
  $action=''; if(isset($_GET['action']))$action=strval($_GET['action']);
  $error=''; 
  if(isset($_GET['error'])) $error =strval($_GET['error']);

  // Übeprüfung auf buchstaben (keine Zahlen zugelassen)
  if(!ctype_alpha($error)) unset($error); 
  
  // Überbrüfung auf integer / Wertzuweisung //Initialisierung
  $t_id=0; if(isset($_SESSION['values']['t_id']))$t_id=abs(intval($_SESSION['values']['t_id']));
  if(isset($_GET['t_id']))$t_id=abs(intval($_GET['t_id']));
  if(isset($_REQUEST['topic']))$t_id=abs(intval($_REQUEST['topic']));
  
  $q_id=0; if(isset($_GET['q_id']))$q_id=abs(intval($_GET['q_id']));
            
  // Wenn auf der Statistik-Seite Aktionen aufgerufen werden
  if(isset($_SESSION['values']['return_site']) && ($_SESSION['values']['return_site']=='statistic')) {
    $site="site=statistic&amp;action=getStatisticQuestions&amp;t_id=$t_id";
  } else {
    $site="site=topic&amp;action=getQuestions&amp;t_id=$t_id";
  }

  // Fetch encoding from session, simplifies future switch to utf-8 encoding.
  $encoding = $_SESSION['_config']['encoding'];
  if (!$encoding) {
    $encoding = "iso-8859-1"; // Backwards compatibility
  }
 
  // Löschen der Session Variable
  if (isset($_SESSION['values']['question']['new'])) unset($_SESSION['values']['question']['new']); 
    
    // Auswahl der gewählten Aktionen
    switch ($action){
    
    case 'save':{ // speichern eines neuen Topics
                    
                    // Wertzuweisung 
                    $questPerQuiz=0; if(isset($_REQUEST["questPerQuiz"]))$questPerQuiz =abs(intval($_REQUEST["questPerQuiz"]));
                    $rawToPass=0; if(isset($_REQUEST["rawToPass"]))$rawToPass =abs(intval($_REQUEST["rawToPass"]));
                    $name=""; if(isset($_REQUEST["new_topic"]))$name= $_REQUEST["new_topic"];
  
                    $topics->setTopicName($name);
                    $checkNum=$topics->setNumOfQu($questPerQuiz);
                    $checkPerc=$topics->setrawToPass($rawToPass);
                    $topics->setSession();
                    if($checkPerc!=0) echo" <meta http-equiv='refresh' content='0; url=?site=topic&amp;action=new_topic&amp;error=rawToPass' />"; 
                    if($checkNum!=0)echo" <meta http-equiv='refresh' content='0; url=?site=topic&amp;action=new_topic&amp;error=numOfQu' />"; 
                    else if($checkPerc==0 && $checkNum==0){ 
                      $reply=$topics->saveTopic();
                      if($reply=='none'){
                        $topics->unsetSession();
                        echo" <meta http-equiv='refresh' content='0; url=?site=topic' />";
                      } else echo" <meta http-equiv='refresh' content='0; url=?site=topic&amp;action=new_topic&amp;error=$reply' />"; 
                    }
                    break;
                  }
                  
    case 'new_topic':{  // neues Topic
                       if($error)$topics->setError($error);
                       $topics->newForm();
                       break;
                      }
                      
    case 'setTopicInactive':{ //inaktiv setzen
                              
                              $topics->setTopicID($t_id);
                              $topics->setInactiveTopic();
                              echo" <meta http-equiv='refresh' content='0; url=?site=topic' />";
                              break;
                            }
                            
    case 'setTopicAvtive':{ //aktivieren
                            
                            $topics->setTopicID($t_id);
                            $topics->setActiveTopic();
                            echo" <meta http-equiv='refresh' content='0; url=?site=topic' />";
                            break;
                          }
                          
    case'delTopic':{ // Löschen eines Themas
                      
                      $questionArray=array();
                      reallyDelTopic($t_id);
                      if($_REQUEST['submit']==Global_13){
                        $topics->setTopicID($t_id);
                        $topics->delTopic();
                         echo" <meta http-equiv='refresh' content='0; url=?site=topic' />";
                      }
                        else if($_REQUEST['submit']==Global_14)echo" <meta http-equiv='refresh' content='0; url=?site=topic' />";
                        break;
                    }
                    
    case 'getQuestions':{ // Fragen zum Thema anzeigen
                          
                          $topics->setTopic($t_id);
                          echo "<br /><h2> ".Topic_03." ".stripslashes($topics->getTopicName())."<br /></h2>";
                          $question->setTopic($t_id); 
                          $question->setAllQuestions();
                          $question->showQuestionTable();
                          break;
                          }
                          
    case 'delQuestion': { // Löschen einer Frage
                          
                          reallyDelQuestion($q_id,$t_id);
                          if($_REQUEST['submit']==Global_13){
                            $answer->delAnswers($q_id);
                            $question->delQuestion($q_id);
                            echo" <meta http-equiv='refresh' content='0; url=?$site' />";       
                          }
                          else if($_REQUEST['submit']==Global_14) echo" <meta http-equiv='refresh' content='0; url=?$site' />";  
                          break;
                        }
                        
    case 'setQuestionInactive':{ // Deaktivieren einer Frage
                                  
                                  $question->setID($q_id);
                                  $question->setInactive();
                                  echo" <meta http-equiv='refresh' content='0; url=?$site' />";  
                                  break;
                                }
                                
    case 'setQuestionActive':{ //Aktivieren einer Frage
                                  
                                  $question->setID($q_id);
                                  $question->setActive();
                                  echo" <meta http-equiv='refresh' content='0; url=?$site'>"; 
                                  break;
                              }
                              
    case 'showDetails':{ // Anzeigen der Fragedetails
                        if($q_id!=0) $_SESSION ['values']['question']['q_id']=$q_id;
                        if($error=='conflict') echo "<h5>".Topic_01." <br /></h5>";
                        $question->setID($_SESSION ['values']['question']['q_id']);
                        $question->loadQuestion();
                        $type=$question->getType();
                        $topics->getTopic();
                        $topicArray=$topics->getTopicArray();
                        $question->setAllTopics($topicArray);
                        $question->showQuestionDetails();
                        $answer->setQuestionID($_SESSION ['values']['question']['q_id']);
                        $answer->setAnswerType($_SESSION ['values']['question']['qt']);
                        $answer->getAnswers();
                        $answer->showAnswers();
                             
                        break;
                       }
                       
    case 'updateQuestion': { // Question updaten
    
                            // Wertzuweisung
                            $questionText=""; if(isset($_REQUEST["question"]))$questionText= $_REQUEST["question"];
                            $descriptionText=""; if(isset($_REQUEST["descriptionText"]))$descriptionText= $_REQUEST["descriptionText"];
                            $description=0; if(isset($_REQUEST["description"]))$description=$_REQUEST["description"];
                            
                            $question->setID($q_id);
                            $question->loadQuestion();
                            $reply=$question->setUpdateQuestion($questionText,$t_id);
                            
                            // neue Beschreibung
                            if($descriptionText!="" && $description==1)$question->saveDescription($q_id,$descriptionText);
                            
                            // Änderung der Beschreibung
                            else if($descriptionText!="" && $description==0)$question->updateDescription($q_id,$descriptionText);
                            
                            // Beschreibung löschen
                            if($descriptionText =="" && $description==0)$question->delDescription($q_id,$descriptionText);
                            
                            if($reply=='conflict')  echo" <meta http-equiv='refresh' content='0; url=?site=topic&amp;action=showDetails&amp;q_id=$q_id&amp;error=conflict' />";
                            else echo" <meta http-equiv='refresh' content='0; url=?site=topic&amp;action=showDetails&amp;q_id=$q_id' />";
                            break;
                            }
                            
    case 'updateAnswers': { // Antwort updaten
    
                            // Wertzuweisung
                            $type=0; if(isset($_GET['type'])) $type=abs(intval($_GET['type']));
                            $a_id=0; if(isset($_GET['a_id'])) $a_id=abs(intval($_GET['a_id']));
                            
                            $changed_answers=array(); if(isset($_REQUEST["change"]))$changed_answers= $_REQUEST["change"];// array der geänderten Antworten
                            //$answerList=array();$answerList=$_SESSION['values']['answerList'];
                          
                            $question->setID($q_id);
                            $question->loadQuestion();
                            $topics->getTopic();
                            $topicArray=$topics->getTopicArray();
                            $question->setAllTopics($topicArray);
                            $type=$question->getType();
                            $question->showQuestionDetails();
                            $answer->setQuestionID($q_id);
                            $answer->getAnswers();
                            $answer->setAnswerList();
                            $answer->setAnswerType($type);
                            
                            if(isset($_REQUEST['submit']) && !$a_id && $_REQUEST['submit']==Button_11){
                              $answer->setChangedAnswers($changed_answers);
                              $answer->updateChangedAnswers();
                            }
                            if($a_id){
                              $answer->changeCorrect($a_id);
                              $answer->updateTruthFalse();
                            }
                              
                            if (isset($_REQUEST["editAnsw"])){
                              //$answer->setAnswerList($answerList);
                              $answer->setType();
                            } 
                            if(!isset($_REQUEST["editAnsw"]) || empty($_REQUEST["editAnsw"])){
                              $answer->showAnswers();
                            }
                            break;
                          } 
                            
       case 'editTopic':{
                          if(!isset($_SESSION['values']['topic']) || empty($_SESSION['values']['topic'])){
                            $topics->setTopicID($t_id);
                            $topics->setTopic($t_id);
                          } else {
                            if($error)$topics->setError($error);
                            $topics->setTopicID($_SESSION['values']['topic']['t_id']);
                          }
                          $topics->updateForm();
                          break;
                        }   
                         
        case 'updateTopic':{ // Topic updaten
        
                            //Wertzuweisung
                            $name=""; if(isset($_REQUEST["new_topic"]))$name= $_REQUEST["new_topic"]; 
                            $numofQuiz=0; if(isset($_REQUEST["questPerQuiz"]))$numOfQuiz =abs(intval($_REQUEST["questPerQuiz"]));
                            $rawToPass=0; if(isset($_REQUEST["rawToPass"])) $rawToPass =abs(intval($_REQUEST["rawToPass"]));
                            
                            $topics->setTopicID($t_id);
                            $topics->setTopicName($name);
                            $checkNum=$topics->setNumOfQu($numOfQuiz);
                            $checkPerc=$topics->setrawToPass($rawToPass);
                            $topics->setSession();
                            if($checkPerc!=0) echo" <meta http-equiv='refresh' content='0; url=?site=topic&amp;action=editTopic&amp;error=rawToPass' />"; 
                            else if($checkNum!=0)echo" <meta http-equiv='refresh' content='0; url=?site=topic&amp;action=editTopic&amp;error=numOfQu' />"; 
                            else if($checkPerc==0 && $checkNum==0){
                              $topics->updateTopic();
                              $topics->unsetSession();
                              echo" <meta http-equiv='refresh' content='0; url=?site=topic' />";
                            }
                            break;
                          }         
                                
    default:   {  // Übersicht der Themen
                  echo"<h2><br />".Topic_02." </h2>"; 
                  clearDatabase(); 
                  $topics->unsetSession();
                  $question->unsetSession();
                  $topics->getTopic();
                  $topicarray=$topics->getTopicArray();
                  $number=$question->getNumberOfQuestions($topicarray);
                  $topics->showTopicTable($number);
                  unset($_SESSION['values']['return_site']); 
                }  
  }
  
}

else echo '<h5 class="centered">'.Global_01.'</h5>';

   


?>

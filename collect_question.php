<?php
// nur wenn man eingeloggt ist und admin Rechte hat
if(($_SESSION['profile']['loggedin']==1) &&($_SESSION['profile']['admin']==1)){

  // Dateien einbinden
  require_once($_SESSION['_config']['filepath']."functions/showQuestionForm.php");

  // Objekte erzeugen
  $question = new Question();
  $quiz = new Quiz();
  $answer= new Answer();
  $topic=new Topic;

  // Überprüfung auf String  / Wertzuweisung
  $action=''; if(isset($_GET['action'])) $action=strval($_GET['action']);

  // Auswahl der gewählten Aktionen
  switch ($action){

  case 'save_question':{ // Frage speichern
                          if($_REQUEST["set"]==1){

                          // Wertzuweisung
                          $_SESSION ['values']['question']['t_id']=0; if($_POST["t_id"])$_SESSION ['values']['question']['t_id'] =abs(intval($_REQUEST["t_id"]));
                          $_SESSION ['values']['question']['qt']=0;if($_POST["qt"])$_SESSION ['values']['question']['qt'] =abs(intval($_REQUEST["qt"]));
                          $_SESSION ['values']['question']['questionText']=''; if($_POST["questionText"])$_SESSION ['values']['question']['questionText']= htmlspecialchars($_REQUEST["questionText"]); // Umwandlung von Sonderzeichen in HTML-Code
                          $new=""; if($_REQUEST["new"])$new= htmlspecialchars($_POST["new"]); // Umwandlung von Sonderzeichen in HTML-Code
                          $_SESSION ['values']['question']['description']=0; if($_POST["description"])$_SESSION ['values']['question']['description']=abs(intval($_POST["description"]));
                          $_SESSION ['values']['question']['descriptionText']="";if($_POST["descriptionText"])$_SESSION ['values']['question']['descriptionText']=htmlspecialchars($_POST["descriptionText"]);

                          // Session Variable setzen
                          $_SESSION ['values']['question']['new']=1;
                          }

                          $question->setType($_SESSION ['values']['question']['qt'] );
                          $question->setTopic ($_SESSION ['values']['question']['t_id']);
                          if($_SESSION ['values']['question']['descriptionText']=='')  $_SESSION['values']['question']['description']=0;
                          if($_SESSION ['values']['question']['description']==0 && $_SESSION ['values']['question']['descriptionText']!='')$_SESSION ['values']['question']['descriptionText']='';
                          $check=$question->checkQuestion();
                          if( $check==1 &&  $_SESSION ['values']['question']['t_id']!='') {

                          $topic->getTopic();
                          $topicArray=$topic->getTopicArray();
                          $question->setAllTopics($topicArray);
                          $question->showQuestionInfos();
                          $answer->setQuestionType($_SESSION ['values']['question']['qt']);
                          $answer->addAnswer();
                          $answer->addAnswer();
                          $answer->setType();
                          } elseif ($check==2) {
                            echo "<meta http-equiv='refresh' content='0; url=index.php?site=collect_question&amp;error=exists' />";
                          } elseif($check==0) {
                            echo "<meta http-equiv='refresh' content='0; url=index.php?site=collect_question&amp;error=missing' />";
                          } elseif ($check==3) {
                            echo" <meta http-equiv='refresh' content='0; url=index.php?site=collect_question&amp;error=blank' />";
                          }
                        break;
                        }
  case 'setAnswers':{ // Antworten setzen

                      // Wertzuweisung
                      $id=0; if(isset($_REQUEST["questionId"]))$id=abs(intval($_REQUEST["questionId"]));
                      $answerList=array(); if(isset($_SESSION['values']['answerList'])) $answerList=$_SESSION['values']['answerList'];
                      $answerArray=array(); if($_POST["answer"])$answerArray=$_POST["answer"];
                      $correct=array(); if($_POST["correct"]) $correct=$_POST["correct"];

                      $limit=count($answerArray);
                      $limit_correct=count($correct);

                       for($i=0;$i<$limit;$i++){       // Antworten setzen
                        $answerList[$i]['answer'] =$answerArray[$i];
                        $answerList[$i]['correct']=0;
                      }
                        for($j=0;$j<$limit_correct;$j++){  // Richtg / Falsch setzen
                          if($correct[$j]!=''){
                            $index=$correct[$j];
                            $answerList[$index]['correct']=1;
                            }
                        }

                      $_SESSION['values']['answerList']=$answerList;
                      $topic->getTopic();
                      $topicArray=$topic->getTopicArray();
                      $question->setAllTopics($topicArray);
                      $question->showQuestionInfos();
                      $type=$question->getType();
                      $answer->setAnswerList();
                      $answer->setQuestionType($_SESSION ['values']['question']['qt']);
                        if(isset($_REQUEST["submit"])){

                          if($_SESSION ['values']['question']['qt']==4){
                           $answersCorrect=$question->getCorrectAnswerFillInTheBlanks($_SESSION ['values']['question']['questionText']);
                           $answer->setAnswersCorrect($answersCorrect);
                          }
                          $okCheck=$answer->checkAnswer();
                          if($okCheck==1){
                            if($_SESSION['values']['question']['new'])$question->saveQuestion();
                            $ok=$answer->saveAnswer();
                            if($_SESSION['values']['question']['new'])$question->setActive();
                            }

                            if( $_SESSION['values']['question']['new']!=1 && $ok == 1){
                              echo "<meta http-equiv='refresh' content='0; url=index.php?site=topic&amp;action=showDetails&amp;q_id=".$_SESSION['values']['question']['q_id']."' />";
                            } else if ( $_SESSION['values']['question']['new']==1 && $ok != false){
                              unset($_SESSION['values']['question']['new']);
                              unset ($_SESSION ['values']['question']);
                              echo" <meta http-equiv='refresh' content='0; url=?site=collect_question' />"; // wenn alles korrekt weiter zur Fragenerfassung

                          }
                        }
                          else if ($_REQUEST["addAnsw"]){
                            $answer->addAnswer();
                            $answer->setType();
                            }
                            else if ($_REQUEST["minAnsw"]){
                              $answer->minusAnswer();
                              $answer->setType();
                              }
                    break;
                    }
  default:   { // Frage erstellen

               $topic->unsetSession();

                // Wertzuweisung
                $qt_id=0; if(isset($_GET['qt_id'])) $qt_id=abs(intval($_GET['qt_id']));
                $error=""; if(isset($_GET["error"])) $error= htmlspecialchars($_GET["error"]); // Umwandlung von Sonderzeichen in HTML-Code
                $new=""; if(isset($_GET['new'])) $new=htmlspecialchars($_GET['new']);
                $questionText=""; if(isset($_REQUEST["questionText"])) $questionText= htmlspecialchars($_REQUEST["questionText"]);

                // Sessionvariable setzen
                $_SESSION['values']['error']=$error;

                $topic->getTopic();
                $arrayTopic = $topic->getTopicArray(); // array mit den vorhandenen Topics holen
                if($error=="") unset ($_SESSION ['values']['question']);
                if($error=='exists')echo '<h5 class="centered">'.Collect_Question_01.'</h5>';
                if($error=='blank')echo '<h5 class="centered">'.Collect_Question_02.'</h5>';
                showQuestionForm($arrayTopic);

              }

  }
}
else echo '<h5 class="centered">'.Global_01.'</h5>';
?>

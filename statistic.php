<?php
// nur wenn man eingeloggt ist und admin Rechte hat
if(($_SESSION['profile']['loggedin']==1)&&($_SESSION['profile']['admin']==1)){

  // Dateien einbinden
  require_once($_SESSION['_config']['filepath']."functions/statisticFunctions.php"); 
  
  // Objekte erzeugen
  $topics=new Topic();
  $qu=new Question();   
  $answer= new Answer();
   
  // Überprüfung auf String  / Wertzuweisung
  $action=''; if(isset($_GET['action']))$action=strval($_GET['action']);
  
  // Überbrüfung / Wertzuweisung
  $t_id=0; if(isset($_GET['t_id'])) $t_id=abs(intval($_GET['t_id']));
  if (isset($_REQUEST["t_id"]))$t_id=abs(intval($_REQUEST['t_id']));

  // Session Variable setzen (wird benötigt um auf die Seite zurück zu kehren)
  $_SESSION['values']['return_site']='statistic';
 
  // Auswahl der gewählten Aktionen
  switch ($action){
  
   case 'topQuestions': { // beste Beantwortung
                          
                          $questions=getQuestions();
                          if(count($questions)==0)echo '<div class="h8 centered">'.Global_07.'</div>';
                          else  getTopQuestions($questions);
                          break;
                        }
    case 'showBar':{ // als Liniendiagramm anzeigen
    
                    // Überbrüfung / Wertzuweisung
                    $value=""; if($_GET['value'])$value=strval($_GET['value']);
                    if(!ctype_alpha($value)) unset($value);
                    
                    $questions=0; $questions=getQuestions($t_id) ;
                    $questions=getQuestionNames( $questions); 
                    if(count($questions)==0)echo '<div class="h8 centered">'.Global_07."</div>";
                    else {
                      if($value=='topQuestions'){
                        $value=getTopQuestionValues($questions);
                      } 
                      if($value=='topTen')       $value=getTopTenValues($questions);
                      if($value=='flopTen')      $value=getFlopTenValues($questions);
                       
                      for ($i=0;$i<count($value);$i++){
                        unset ($value [$i] ['count']);
                        unset ($value [$i] ['countCorrect']);
                        unset ($value [$i] ['countIncorrect']);
                        unset ($value [$i] ['question']);
                        unset ($value [$i] ['percentagCorrect']);
                      }   
                              showBar($value);
                    }
                      break;
                  }
    case 'showGraph':{ // als Balkendiagramm anzeigen
                      
                       // Überbrüfung / Wertzuweisung
                      $value=""; if($_GET['value'])$value=strval($_GET['value']);
                      if(!ctype_alpha($value)) unset($value);
                      
                      $questions=0;$questions=getQuestions($t_id);
                      $questions=getQuestionNames( $questions); 
                      if(count($questions)==0)echo '<div class="h8 centered">'.Global_07.'</div>';
                      else {
                        if($value=='topQuestions') $value=getTopQuestionValues($questions);
                        if($value=='topTen')       $value=getTopTenValues($questions);
                        if($value=='flopTen')      $value=getFlopTenValues($questions);
                        for ($i=0;$i<count($value);$i++){
                          unset ($value [$i] ['count']);
                          unset ($value [$i] ['countCorrect']);
                          unset ($value [$i] ['countIncorrect']);
                          unset ($value [$i] ['question']);
                          unset ($value [$i] ['percentagCorrect']);
                        } 
                        showGraph($value);
                      }
                      break;
                    }
    case 'showPassed':{ // Versuche anzeigen mit bestandenen 
                        
                        $value=getStatisticInfoPie($t_id);
                        if(($value[0][1]==0) && ($value [1][1]==0))echo '<div class="h8 centered">'.Global_07.'</div>';
                        else showPie($value);
                        break;
                      }
    case 'topTen': { // die besten 10 antworten
                     
                      $questions=0;$questions=getQuestions($t_id);
                      if(count($questions)==0)echo '<div class="h8 centered">'.Global_07."</div>";
                      else { 
                        $topics->setTopicID($t_id);
                        $topics->setTopic($t_id);
                        $Topic =$topics->getTopicName();
                        echo "<br /><h2> ".Statistic_01." ".stripslashes($Topic)."<br /></h2>";
                        getTopTenCorrect($questions);
                      }
                     break;
                    }
    case 'flopTen':{ // die 10 schlechtest beantworteten Fragen
                     
                      $questions=0;$questions=getQuestions($t_id);
                      if(count($questions)==0)echo '<div class="h8 centered">'.Global_07."</div>";
                      else{ 
                          $topics->setTopicID($t_id);
                          $topics->setTopic($t_id);
                          $Topic =$topics->getTopicName();
                          echo "<br /><h2> ".Statistic_02." ".stripslashes($Topic)."<br /></h2>";
                          getFlopTenCorrects($questions);
                      }
                     break;
                    }
    case 'sortByTopic': { // Fragen nach Thema sortieren
                         
                         $topics->getTopic();
                         $topicarray=$topics->getTopicArray();
                         $number=$qu->getNumberOfQuestions($topicarray);
                         $inactive=$qu->getNumberOfInactiveQuestions($topicarray); //muss noch erstellt werden
                         $lp=$qu->getLearnpathCount($topicarray);
                         $topics->showTopicTableStatistic($number,$lp,$inactive);
                         break;
                        }
    case 'getStatisticQuestions': { // Fragen in Tabelle anzeigen
                                   
                                    $topics->setTopicID($t_id);
                                    $topics->setTopic($t_id);
                                    $Topic =$topics->getTopicName();
                                    echo "<br /><h2>".Statistic_03." ".stripslashes($Topic)."<br /></h2>";
                                    $qu->setTopic($t_id); 
                                    $ok=$qu->setStatisticQuestions();
                                    if($ok==1)$qu->showStatisticQuestionTable();
                                    break;
                                    }
    case 'changeActive':{  // Frage deaktivieren / aktivieren
    
                            // Überbrüfung / Wertzuweisung
                            $q_id=0; if($_GET['q_id'])$q_id=abs(intval($_GET['q_id']));
                            
                            $qu->setID($q_id);
                            $qu->changeActive();
                            $t_id=$_GET['t_id'];
                            $topics->setTopicID($t_id);
                            $topics->setTopic($t_id);
                            $Topic =$topics->getTopicName();
                            echo "<br /><h2> ".Statistic_03." ".stripslashes($Topic)."<br /></h2>";
                            $qu->setTopic($t_id); 
                            $ok=$qu->setStatisticQuestions();
                            if($ok==1)$qu->showStatisticQuestionTable();
                            break;
                        }
    case 'delQuestion':{ // Frage löschen
    
                           // Überbrüfung / Wertzuweisung
                           $q_id=0; if($_GET['q_id'])$q_id=abs(intval($_GET['q_id']));
                          
                          $topic_id=$qu->searchTopic($q_id);
                          $qu->delQuestion($q_id);
                          $answer->delAnswers ($q_id);
                          echo "<meta http-equiv='refresh' content='0; url=?site=statistic&amp;action=getStatisticQuestions&amp;t_id=$t_id' />";
                          break;
                        }
    
    case 'userInfo':{
                      getUserInfo();
                      break;
                    }
    case 'showStatisticTest':{
                              // Überbrüfung / Wertzuweisung
                              $t_id=0; if($_GET['t_id'])$t_id=abs(intval($_GET['t_id']));
                              getStatisticTest($t_id);
                              break;
                              }
   
  }
}
else echo '<h5 class="centered">'.Global_01.'</h5>';

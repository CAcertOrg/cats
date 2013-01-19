<?php  
if($_SESSION['profile']['loggedin']==1){
  
  // Objekte erzeugen
  $myQuiz=new Quiz;
  $topics=new Topic();
  
  // Überprüfung auf String  / Wertzuweisung    
  $action=''; if(isset($_GET['action'])) $action=strval($_GET['action']);
  
  // Session löschen 
  unset($_SESSION ['values']['t_id']);
  unset($_SESSION ['values']['return_site']);
  
  // Auswahl der gewählten Aktionen
  switch($action){ 
  case 'getQuestions': // Fragebogen genererien
    
    // Überbrüfung auf integer / Wertzuweisung
    $topic=0; if(isset($_REQUEST["t_id"])) $topic=abs(intval($_REQUEST["t_id"]));
                            
    // Session Variable leeren
    if (isset($_SESSION['values']['answerList'])) unset($_SESSION['values']['answerList']);
                            
    $topics->setTopicID($topic);
    $numOfQu=$topics->getNumOfQu();
    $percentage=$topics->getRawToPass();
    $myQuiz->setTopicID($topic); 
    $myQuiz->setQuestionLimit($numOfQu);
    $myQuiz->setRawToPass($percentage);
    $value=$myQuiz->generateQuestions();
    if($value!='notEnoughQuestions'){
      $myQuiz->getDBAnswers(); 
      $myQuiz->showQuiz();
      $t_id=$myQuiz->getTopicID();  
    }
    break;
  case 'evaluate':
    // Fragebogen auswerten
     
    //Wertzuweisung und Initalisierung
    $selectedAnswers=0; 
    if(isset($_REQUEST['selectedAnswers'])) {
      $selectedAnswers = $_REQUEST['selectedAnswers'];
      $_SESSION ['values']['selectedAnswers']=$selectedAnswers;
    }
    if (isset($_SESSION['values']['selectedAnswers'])) {
      $topic=0; if(isset($_REQUEST["t_id"])) $topic=abs(intval($_REQUEST["t_id"]));
                      
      $myQuiz->setQuestions();
      $myQuiz->setSelectedAnswers();
      $myQuiz->setAnswers();
      $myQuiz->updateStatistic();
      $topics->setTopicID($topic);
      $numOfQu=$topics->getNumOfQu();
      $percentage=$topics->getRawToPass();
      $myQuiz->setTopicID($topic); 
      $myQuiz->setQuestionLimit($numOfQu);
      $myQuiz->setRawToPass($percentage);
      $myQuiz->evaluateQuiz();
    } else {
      // kein Test bearbeitet
    }
    break;
  case "requestCert":
    $topic=0; if(isset($_REQUEST["t_id"])) $topic=abs(intval($_REQUEST["t_id"]));
    $progress = new progress();
    $progress->setTopic($topic);
    $progress->getProgress();
    $topics->setTopicID($topic);
    $percentage=$topics->getRawToPass();
    $haspassed = false;
    foreach ($progress->progress as $entry) {
      if ($entry['number'] > 0) {
       $currentperc = 100 * $entry['correct'] / (1.0 * $entry['number']);
       if ($currentperc >= $percentage) {
         $haspassed = true;
       }
      }
    }
    if ($haspassed) {
      // A paper/PDF certificate for passing the test has been requested.
      echo "<br />".Class_Quiz_12_ExplainCert;
      echo "<br />\n".
        "<table>\n".
				"<tr>\n".
				"<td align=\"center\">\n".
        "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">\n".
        "<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\" />\n".
        "<input type=\"image\" src=\"https://www.cacert.org/images/payment2a.png\" class=\"linkimage\" name=\"submit\" alt=\"Make 5 EUR donation with PayPal\" />\n".
        "<input type=\"hidden\" name=\"encrypted\" value=\"-----BEGIN PKCS7-----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-----END PKCS7-----\n".
        "\" />\n".
        "</form>\n".
				"</td>\n".
				"<td align=\"center\">\n".
				"<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">\n".
				"<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">\n".
				"<input type=\"hidden\" name=\"hosted_button_id\" value=\"4859538\">\n".
				"<input type=\"image\" src=\"http://www.cacert.org/images/payment2a.png\" border=\"0\" name=\"submit\" alt=\"Make 10 EUR donation with PayPal\">\n".
				"<img alt=\"\" border=\"0\" src=\"https://www.paypal.com/en_AU/i/scr/pixel.gif\" width=\"1\" height=\"1\">\n".
				"</form>\n".
				"</td>\n".
				"</tr>\n".
				"<tr>\n".
				"<td>".Class_Quiz_13_Donate5."</td>\n".
				"<td>".Class_Quiz_14_Donate10."</td>\n".
				"</tr>\n".
				"</table>\n";
    } else {
      // Test wurde nie bestanden
      echo "<br />" . Class_Quiz_09;
    }
    break;
  }  
}
else echo "<h5 class='centered'>".Global_01."</h5>";

?>

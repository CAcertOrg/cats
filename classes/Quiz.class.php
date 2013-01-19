<?php

class Quiz 
{
   var  $topicID;
   var  $questionLimit;
   var  $questionList;
   var  $answerList;
   var  $maxNumberOfAns;
   var  $selectedAnswers;
   var  $correct;
   var  $wrongQuestions;
   var  $lp_id;
   var  $rawToPass;
   var  $question;
   var  $percentTest;
  
    function Quiz(){
     $this->topicID=0;
     $this->questionLimit=0;
     $this->questionList= array();
     $this->answerList= array();
     $this->maxNumberOfAns=0;
     $this->selectedAnswers= array();
     $this->correct=array();
     $this->wrongQuestions=array();
     $this->lp_id;
     $this->rawToPass;
     $this->question=new Question();
     $this->percentTest=0;
    }
    
    function getQuestionLimit() { 
    return  $this->questionLimit;
    }
    
    function setQuestionLimit($numOfQu){
    $this->questionLimit= $numOfQu;
    }
    
    function setTopicID($id) {
     $this->topicID=$id;
    }
    
    function getTopicID(){
     return $this->topicID;
    }
    
    
    function getAnswerList () {
      return $this->answerList;
    }
    
    function setRawToPass($percentage){
    $this->rawToPass=$percentage;
    }
    
    function generateQuestions(){ // Fragen werden random aus DB gelesen
    $sqlGetQu=" SELECT q_id,qt_id,t_id,question,description FROM questions WHERE t_id =".intval($this->topicID)." AND active=".intval(1)." ORDER BY RAND()LIMIT ".intval($this->questionLimit)."";
    $queryGetQu = mysql_query($sqlGetQu); 
    $number=mysql_num_rows($queryGetQu);
    if($number== $this->questionLimit){
      $i=1; // zähler
        while($questions =mysql_fetch_array($queryGetQu ,MYSQL_BOTH  ))  
        {   
          
          $this->questionList[$i]['q_id']=$questions['q_id']; // in arra speichern
          $this->questionList[$i]['qt_id']=$questions['qt_id'];
          $this->questionList[$i]['t_id']=$questions['t_id'];
          $this->questionList[$i]['question']=stripslashes($questions['question']);
          $this->questionList[$i]['description']=$questions['description'];
          $sqlGetNumber="SELECT count(a_id)as number FROM answers WHERE q_id=".intval($questions['q_id'])." GROUP BY q_id";
          $queryGetNumber = mysql_query($sqlGetNumber); 
            while($number =mysql_fetch_array( $queryGetNumber ,MYSQL_BOTH  ))  
            { 
            $this->questionList[$i]['numberOfAnswers']=$number['number'];
            } 
              if($this->questionList[$i]['description']==1) {
                // beschreibung in Session speichern falls vorhanden 
                $sql_desc="SELECT description FROM question_description WHERE q_id=".intval($questions['q_id'])."";
                $query_desc=mysql_query($sql_desc); 
                $desc = mysql_fetch_assoc($query_desc);
                $this->questionList[$i]['description_text']=stripslashes($desc['description']);
              }
          $i++;
        }
        $_SESSION['values']['questionList']=$this->questionList;
      }
      else{
        echo "<h5>".Class_Quiz_01." </h5>"; 
        $value ="notEnoughQuestions"; 
        return $value;
      }
    }
    
  
    
    function getQuestionList()  {
      return $this->questionList;
    }
  
    
    function setQuestions() {
    $this->questionList=$_SESSION['values']['questionList'];
    }
    
  
    function getDBAnswers() { // Antworten zu den Frage aus DB holen
        for($i=1;$i<=$this->questionLimit;$i++){
          $value= $this->questionList[$i]['q_id'];
          $sqlGetAns="SELECT a_id,answer,correct  FROM answers WHERE q_id=".intval($value)."  ORDER BY RAND()";
          $queryGetAns = mysql_query($sqlGetAns); 
          $j=1; // Zähler
           while($answers =mysql_fetch_array($queryGetAns ,MYSQL_BOTH  )) {    
            $this->answerList[$value][$j]['q_id']= $value;
            $this->answerList[$value][$j]['a_id']=$answers['a_id']; // in arra speichern
            $this->answerList[$value][$j]['answer']=stripslashes($answers['answer']);
            $this->answerList[$value][$j]['correct']=$answers['correct'];
            $j++;
          }
        }
       $_SESSION ['values'] ['answerList']= $this->answerList;
    }
    
    function setAnswers(){
      $this->answerList=$_SESSION ['values']['answerList'];
    }
   
   function setSelectedAnswers (){
       $this->selectedAnswers=$_SESSION ['values']['selectedAnswers']; 
    }
    
   function showQuiz() {
    echo "<form action='index.php?site=start_test&amp;action=evaluate' method='post'>";  
    echo "<fieldset>";
    echo " <legend>".Class_Quiz_02."</legend>";
    echo "<table class='table_show_quiz'>";
    for($i=1;$i<=$this->questionLimit;$i++) {
      $value= $this->questionList[$i]['q_id']; // Value den Wert der q_id geben
      $question=str_replace("\n", "<br>", $this->questionList[$i]['question']);
      echo "<tr>";
      echo"<td class='nr' valign='top' >".Global_08." $i: </td>";
  
        if($this->questionList[$i]['qt_id']!=4) { 
          echo"<td class='question' colspan='3'>$question </td> "; 
          echo"</tr>";
       } // wenn der Typ nicht 4 ist anzeigen
     
       if($this->questionList[$i]['qt_id']==1) $this->SingleSelection($i,$value);
       if($this->questionList[$i]['qt_id']==2) $this->MultipleChoice($i,$value);
       if($this->questionList[$i]['qt_id']==3) $this->SingleSelection($i,$value); // Kann die selbe Maske verwendet werden
       if($this->questionList[$i]['qt_id']==4) $this->FillInTheBlanks($i,$value,$question);
      }
      echo "<tr>";
      echo "<td class='evaluate' colspan='4'>";
      echo"<input type='hidden' name='t_id' value='$this->topicID'/>";
      //echo"<input type='hidden' name='questionList' value='$questionList'/>";
      //echo"<input type='hidden' name='answerList' value='$answerList'/>";
      echo" <input name='submit' class='Button_right' type='submit' value='".Button_16."' /> ";
      echo "</td>";
      echo "</tr>";
      echo "</table>";
      echo "</fieldset>";
      echo"</form>";
   }
    
    function SingleSelection($i,$value){  
        for ($j=1;$j<=$this->questionList[$i]['numberOfAnswers'];$j++){ // Solange Schleife durchlaufen wie die maximale Anzahl der Antworten ist
            $answer=$this->answerList[$value][$j]['answer'];
            $answerNumber=$this->answerList[$value][$j]['a_id'];
              if($answer!=null) {                        // Wenn es eine Antwort gibt soll diese angezeigt werden
                echo "<tr>";
                echo "<td class='nr' valign='top' ></td>";
                echo"<td class='choice' valign='top'><input type='radio' value='$answerNumber' name='selectedAnswers[$value]' /></td>";
                if ($answer=='true') echo" <td class='answer' valign='top'>".Class_Answer_09."</td>";
                else if ($answer=='false') echo" <td class='answer' valign='top'>".Class_Answer_10."</td>";
                else   echo" <td class='answer' valign='top'>$answer</td>";
                echo "<td class='symbol'></td>"; 
                echo "</tr>";
              }
        }
        echo "<tr class='padding'><td colspan='4' /></tr>";
    }
    
   function MultipleChoice($i,$value){
        for ($j=1;$j<=$this->questionList[$i]['numberOfAnswers'];$j++){ // Solange Schleife durchlaufen wie die maximale Anzahl der Antworten ist
            $answer=$this->answerList[$value][$j]['answer'];
            $answerNumber=$this->answerList[$value][$j]['a_id'];
            if($answer!=null){                         // Wenn es eine Antwort gibt soll diese angezeigt werden
              echo "<tr>";
              echo "<td class='nr' valign='top' ></td>";
              echo "<td class='choice' valign='top'><input type='checkbox' class='quiz_options' value='$answerNumber' name='selectedAnswers[$value][]' /></td>";
              echo " <td class='answer' valign='top'> $answer </td>";
              echo "<td class='symbol'></td>"; 
              echo "</tr>";
            } 
        } 
        echo "<tr class='padding'><td colspan='4' /></tr>";
    }
    
   function randomizeArray($answerList,$value) {
    $max=count($answerList[$value]); // setze Maximum
    $index=range(1,$max);  // Kreiire Array 
    shuffle($index); // würfle array
    $copy= $answerList; // kopie erstellen
      for($i=0;$i<$max;$i++){
        $k=$index[$i];
        $answerList[$value][$i+1]=$copy[$value][$k]; // zuweisen
      }
   $_SESSION ['values'] ['answerList']= $answerList;
   return $answerList;  
   }
   
   function FillInTheBlanks($i,$value,$question) {
      
        echo '<td class="answer" valign="top" colspan="2">';
        $correctAns=$this->question->getCorrectAnswerFillInTheBlanks($question); // korrekte Antworen ermitteln
        $numberOfAnswers=$this->questionList[$i]['numberOfAnswers'];
       for ($l=0;$l<count($correctAns);$l++){
         $addCorrect = array( 'q_id'  => $value, 'a_id' => $correctAns[$l+1]['answer'],'answer' =>$correctAns[$l+1]['answer'],'correct'=>1,'blank'=>$correctAns[$l+1]['blank']);
         $numberOfAnswers=$numberOfAnswers+1; // Anzahl der Antworten erhöhen
         $this->answerList[$value][$numberOfAnswers]= $addCorrect ; // an richtiger Stelle einfügen
        }       
        $this->answerList=$this->randomizeArray($this->answerList,$value);
        
        $addSlashes= preg_quote($question, '[^]'); // Slash hinzufügen wenn KLammer gefunden wird
        $array=explode('\\',$addSlashes); // String teilen 
           for($k=0;$k<count($array);$k++){
            if((strstr($array[$k],'['))){
              echo"<select  name='selectedAnswers[$value][$k]' > ";
              for ($j=1;$j<=$numberOfAnswers;$j++){ // Solange Schleife durchlaufen wie die maximale Anzahl der Antworten ist
                $answer=$this->answerList[$value][$j]['answer'];
                $answerNumber=$this->answerList[$value][$j]['a_id'];
                //echo $this->answerList[$value][$j]['a_id'];
                echo"<option value='$answerNumber'>$answer</option>";
              }
                echo"</select>";
           }
         
           else if((strstr($array[$k],']'))){
            $array[$k]=str_replace("]",'', $array[$k]); // Klammer entfernen
            echo $array[$k];
          }
          else echo $array[$k];
      }
     echo "</td>";
     echo "<td class='symbol'></td>"; 
     echo "</tr>";
    echo "<tr class='padding'><td colspan='4' /></tr>";
    }
    
   
    
    function evaluateQuiz() { 
   
      echo"<div>";
      echo "<fieldset>";
     
      echo "<legend>".Class_Quiz_03."</legend>\n";
      echo "<table class='table_show_quiz'>";
      for($i=1;$i<=count($this->questionList);$i++){
        $value= $this->questionList[$i]['q_id']; // Value den Wert der q_id geben
	$question=str_replace("\n", "<br>", $this->questionList[$i]['question']);
        echo "\n<tr>";
        echo"<td class='nr' valign='top'  >".Global_08." $i : </td>";
        echo"<td class='question' colspan='3' >";
        if($this->questionList[$i]['qt_id']!=4){
          echo" $question </td> ";        
          echo "</tr>";
        }
        $this->topicID=$this->questionList[$i]['t_id'];
        switch($this->questionList[$i]['qt_id']){
          case 1: {$this->evaluateSingleSelection($i,$value); 
                   
                   break;}
          case 2: {$this->evaluateMultipleChoice($i,$value);
                   
                   break;}
          case 3: { $this->evaluateSingleSelection($i,$value); // Kann die selbe Maske verwendet werden
                   
                    break;}
          case 4:{  //$this->getDBAnswers();
                    $this->evaluateFillInTheBlanks($i,$value,$question);
                   
                   break;}
        }
      }
      
      echo "</table>";
      echo "</fieldset>";
      echo "</div>";
                
      $this->updateStatistic();
      $this->getTestResult();  
      $this->createLearnProgress(); 
      
  }
  
    function evaluateSingleSelection($i,$value){
      for ($j=1;$j<=$this->questionList[$i]['numberOfAnswers'];$j++) { // Solange Schleife durchlaufen wie die maximale Anzahl der Antworten ist
        $answer=$this->answerList[$value][$j]['answer'];
        $answerNumber=$this->answerList[$value][$j]['a_id'];
        if($answer!=null) {                        // Wenn es eine Antwort gibt soll diese angezeigt werden
          echo "\n<tr>";
          echo "<td class='nr' valign='top' ></td>";
          echo "<td class='choice' valign='top'>";
          // Auswahl des Benutzers
          if(isset($this->selectedAnswers[$value]) && $this->selectedAnswers[$value]==$this->answerList[$value][$j]['a_id']) {
            echo"<input type='radio' value='$answerNumber' name='userChoice[$value]' class='quiz_options' checked='checked' disabled='disabled' />";
          } else {
            echo"<input type='radio' value='$answerNumber' name='userChoice[$value]'class='quiz_options' disabled='disabled' />";
          }
          echo "</td>";
          //richtige Antworten
          echo "<td class='choice' valign='top'>";
          if($this->answerList[$value][$j]['correct']==1) {
	  	echo"<input type='radio'class='quiz_options_correct' value='$answerNumber' disabled='disabled' name='correct[$value]' checked='checked' />";
		$show_class="answer correct";
          } else {
	  	echo"<input type='radio' class='quiz_options_correct'  disabled='disabled' value='$answerNumber' name='correct[$value]' />";
		$show_class="answer false";
	  }
          echo "</td>";
          if ($answer=='true') echo" <td class='$show_class' valign='top'>".Class_Answer_09."</td>";
          else if ($answer=='false') echo" <td class='$show_class' valign='top'>".Class_Answer_10."</td>";
          else echo"<td class='$show_class' valign='top'>$answer</td>";
            
          echo "<td class ='evaluate'></td>";
          echo"</tr>";
        }
         
        if(isset($this->selectedAnswers[$value]) && isset($this->answerList[$value][$j]['correct']) &&
           $this->selectedAnswers[$value]==$this->answerList[$value][$j]['a_id'] && $this->answerList[$value][$j]['correct']==1) {
          $correct[]=1;
        }
      }
      $this->showDescription($i);
        
      if(!isset($correct)) $correct[]=0;
      $this->checkAnswers($correct,$value);  
    }
  
    function evaluateMultipleChoice($i,$value) {  
      for ($j=1;$j<=$this->questionList[$i]['numberOfAnswers'];$j++){ // Solange Schleife durchlaufen wie die maximale Anzahl der Antworten ist
        for($k=0;$k<$this->questionList[$i]['numberOfAnswers'];$k++){ // markieren welche Antworten der Benutzer ausgewählt hat
          if(isset($this->selectedAnswers [$value][$k]) && $this->selectedAnswers [$value][$k]!=null){ // wenn die Antwort nicht null ist
            if($this->selectedAnswers [$value][$k]==$this->answerList[$value][$j]['a_id'])$checked [$j]=1; 
            else if(!isset($checked[$j]) || !$checked [$j]) $checked [$j]=0;
          } 
        }  
      }
      for ($j=1;$j<=$this->questionList[$i]['numberOfAnswers'];$j++){ // antworten die der Benutzer ausewählt hat ausgeben
        echo "\n<tr>";
        echo "<td class='nr' valign='top' ></td>";
        echo "<td class='choice' valign='top'>";
        $answer=$this->answerList[$value][$j]['answer'];
        $answerNumber=$this->answerList[$value][$j]['a_id'];
        if (!isset($checked[$j])) $checked[$j] = 0;
        if($checked[$j]==1) echo"<input type='checkbox' class='quiz_options' disabled='disabled' value='$answerNumber' checked='checked' name='userChoice[$value]' />";
        else if ($checked[$j]==0) echo"<input type='checkbox' class='quiz_options' disabled='disabled' value='$answerNumber'  name='userChoice[$value]' />";               
        echo "</td>";
        //richtige Antworten ausgeben
        echo "<td class='choice' valign='top'>";
        if($this->answerList[$value][$j]['correct']==1) {
		echo"<input type='checkbox'class='quiz_options_correct' value='$answerNumber' disabled='disabled' name='correct[$value]' checked='checked' />";
		$show_class = "answer correct";
        } else {
		echo"<input  type='checkbox'  class='quiz_options_correct'  disabled='disabled' value='$answerNumber' name='correct[$value]' />";
		$show_class = "answer false";
	}
        echo "</td>";
        echo"<td class='$show_class' valign='top'> $answer </td>"; 
        echo "<td class ='evaluate'></td>";
        echo"</tr>";
        if(($this->answerList[$value][$j]['correct']==1) && ($checked [$j]==1)){ //Prüfung auf Richtigkeit
          $correct[$j]=1; 
          unset($this->answerList[$value][$j]); 
        } else if(($this->answerList[$value][$j]['correct']==1)&& ($checked [$j]==0))$correct[$j]=0;
        else if(($this->answerList[$value][$j]['correct']==0) && ($checked [$j]==1))$correct[$j]=0;
      }
      $this->showDescription($i);
      $this->checkAnswers($correct,$value);
          
    }
          
   function evaluateFillInTheBlanks($i,$value,$question){
    
      
      $addSlashes= preg_quote($question, '[^]'); // Slash hinzufügen wenn KLammer gefunden wird
      $array=explode('\\',$addSlashes); // String teilen 
      // Was Benutzer markiert hat 
      for($k=0;$k<count($array);$k++){
        if((strstr($array[$k],'['))){
          $array[$k]=str_replace("[",'', $array[$k]); // Klammer entfernen
          for ($j=1;$j<=count($this->answerList[$value]);$j++){ // antworten die der Benutzer ausewählt hat ausgeben
            $answer=$this->answerList[$value][$j]['answer']; // Amtwort wird zugewiesen
            if($this->selectedAnswers[$value][$k]==$this->answerList[$value][$j]['a_id']){
                echo " <input name='[$i]' readonly='readonly'  size='20' value='$answer' />";
                if(isset($this->answerList[$value][$j]['blank']) && $this->answerList[$value][$j]['blank']==$k) $correct[]=1;
                else $correct[]=0;
                break;
            } 
          }
        } else if((strstr($array[$k],']'))){
          $array[$k]=str_replace("]",'', $array[$k]); // Klammer entfernen
          echo $array[$k];
        } else echo $array[$k];
      }
      echo "</td>";
      echo "</tr>";
        
      echo "\n<tr>";
      echo "<td class='nr' valign='top' ></td>";
      echo "<td class='question' colspan='3'>";   
    
         // Was richtig ist
        $addSlashes= preg_quote($question, '[^]'); // Slash hinzufügen wenn KLammer gefunden wird
        $array=explode('\\',$addSlashes); // String teilen
        //echo" <div id=\"quiz_fill_in_the_blank\" >";
     
          for($k=0;$k<count($array);$k++){
            if((strstr($array[$k],'['))){
              $array[$k]=str_replace("[",'', $array[$k]); // Klammer entfernen
              echo " <input name='[$i]' readonly='readonly'  size='20' value='$array[$k]' />";
            } else if((strstr($array[$k],']'))) {
              $array[$k]=str_replace("]",'', $array[$k]); // Klammer entfernen
              echo $array[$k];
            } else echo $array[$k];
          }
          echo "</td>";
          echo "</tr>";
           
          $this->showDescription($i);
          $this->checkAnswers($correct,$value);  
        }
          
function checkAnswers($correct,$value) {
  $check = in_array(0, $correct);  // Prüfen ob im Array der Wert 0 ist, denn dann wurde mindestens eine Antwort falsch beantwortet
  echo "\n<tr>";
  if(!$check)echo"<td class='symbol' colspan='7'><img src='images/correct.png' alt='' /></td>";
  else {
    $this->wrongQuestions[]=$value;
    echo"<td class='symbol'  colspan='7'><img src='images/wrong.png' alt='' /></td>";
  }
  echo "</tr>";
}
    
     function updateStatistic() {
      for($i=1;$i<=$this->questionLimit;$i++) {
        $sql="SELECT count  FROM statistics WHERE q_id=".intval($this->questionList[$i]['q_id'])."";
        $query = mysql_query($sql); 
          while($count=mysql_fetch_array($query ,MYSQL_BOTH  )){ 
            $count=$count['count']; 
            $count=$count+1;
            $sql_update="UPDATE statistics SET count=".intval($count)." WHERE q_id=".intval($this->questionList[$i]['q_id'])."";
            $query_update = mysql_query($sql_update); 
          }
        }
    }
          
   function createLearnProgress() { // Lernprogress erstellen
      $timestamp = time();
      $date= date("Y-m-d H:i:s" ,$timestamp); // aktuelles Datum und Uhrzeit berechnen
      $correctAnswers=$this->questionLimit-count($this->wrongQuestions);
      $wrongAnswers=count($this->wrongQuestions);
      $sql="INSERT INTO learnprogress (user_id,root,date,t_id,number,correct,wrong,percentage) VALUES ('".mysql_real_escape_string($_SESSION['profile']['id'])."','".mysql_real_escape_string($_SESSION['profile']['root'])."','$date',".intval($this->topicID).",".intval($this->questionLimit).",".intval($correctAnswers).",".intval($wrongAnswers).",".mysql_real_escape_string($this->percentTest).")";
      $query = mysql_query($sql); 
      $this->lp_id = mysql_insert_id();
      $this->insertAnswersIncorrect();
    }
        
    function insertAnswersIncorrect(){
      foreach($this->wrongQuestions as $value){
        $sql="INSERT INTO answers_incorrect (lp_id,q_id) VALUES ( ".intval($this->lp_id).",".intval($value).")";
        $query = mysql_query($sql); 
      }   
    }
      
  function getTestResult(){
    $wrong=count($this->wrongQuestions);
    $correct=$this->questionLimit-$wrong;
    if($wrong==0)$percentTest=100;
    else if(($wrong>=$this->questionLimit) || ($this->questionLimit < 1))$percentTest=0;
    else $percentTest=($correct/$this->questionLimit)*100;
    
    $percentTest=round($percentTest, 2);
    $this->percentTest=$percentTest;
    if($this->rawToPass > 0 && $this->rawToPass <= $percentTest)$value="".Class_Quiz_08."";
    else $value="".Class_Quiz_09."";
    
    echo'<p class="centered"> '.Global_05." : <br />";
    global $questionlimit;
    $questionlimit =$this->questionLimit;
    echo" ".Class_Quiz_04." $correct / $this->questionLimit <br />";
    echo" ".Class_Quiz_05." <b>$this->rawToPass %</b> ";
    echo "<br /> ".Class_Quiz_06." <b>".$this->percentTest." % </b> ".Class_Quiz_07." <b>$value</b> <br /></p>";
    //createLearnProgress();
       
    if($this->rawToPass > 0 && $this->rawToPass <= $percentTest) {
      // Test has been passed, maybe a paper/PDF-certificate can be requested
      if ($_SERVER['SSL_CLIENT_S_DN_CN']=="CAcert WoT User") {
        // Sorry, we cannot issue certificates for anonymous users
        echo '<br /><p class="centered">'.Class_Quiz_10_AnonymousCert."</p>";
      } else {
        echo "<form class='info' action='index.php?site=start_test&amp;action=requestCert' method='post'>"; 
        echo "<input type='hidden' name='t_id' value='$this->topicID' />";
        echo "<input name='submit' class='Button_middle' type='submit' value='".Class_Quiz_11_RequestCert."' />"; 
        echo "</form>";
      }
    }
  }   
    
  function showDescription($i){
    if(isset($_SESSION['values']['questionList'][$i]['description_text'])){
      // Ausgabe der Beschreibung
      echo "\n<tr>";
      echo "<td class='nr'></td>";
      echo"<td class='answer description' colspan='4'>".$_SESSION['values']['questionList'][$i]['description_text']."</td>";
      echo "<td class ='evaluate'></td>";
      echo "</tr>";
    }
  }
}

?>

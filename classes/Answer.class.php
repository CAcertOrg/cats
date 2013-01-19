<?php

class Answer {
  var $answerList;
  var $type;
  var $changedAnswers;
  var $answersCorrect;
  var $missing;
  var $action;
   
  function Answer(){  // Konstruktor
    $this->answerList=0;
    $this->type=0;
    $this->changedAnswers=0;
    $this->answersCorrect=0;
    $this->missing=0;
    $this->answerList = array();
    $this->action="index.php?site=collect_question&amp;action=setAnswers";
  }
   
  function setChangedAnswers($changed_answers){
    $this->changedAnswers=$changed_answers;
  }
   
  function setQuestionType($type) {
    $this->type=$type;
  }
   
  function setMissing() {
    $this->missing=true;
  }
   
  function setAnswerType($type) {
    $this->type=$type;
  }
    
  function setType(){
    switch ($this->type) {
    case 1 : {     // Einfachauswahl
      $this->formHead();
      $this->ShowFormSingleSelection();
      break;   
    }
    case 2 : {    // Mehrfachauswahl
      $this->formHead();
      $this->ShowFormMultipleChoice();
      break;
    }
    case 3 : {  //Richtig/Falsch
      $this->formHead();
      $this->ShowFormCorrectWrong();
      break;
    }
    case 4 : {  //Lückentext mit Auswahl
                  
      $this->ShowFormFillInTheBlanks();
      break;
    }
    }
  }
    
  function showAnswers() {
    echo"<form action='index.php?site=topic&amp;action=updateAnswers&amp;q_id=".$_SESSION['values']['question']['q_id']."&amp;type=".$this->type."' method='post'>";
    echo "<fieldset >";
    echo " <legend>".Class_Answer_01." </legend> ";
    echo "<table class='table_show_answers'>";
     
    for ($i=0;$i<count($this->answerList);$i++){
      echo "<tr>";
      echo "<td class='leftColumn'>";
      if  ($this->answerList[$i]['correct']==1)echo "<a  class='showStatus' href='?site=topic&amp;action=updateAnswers&amp;q_id=".$_SESSION['values']['question']['q_id']."&amp;a_id=".$this->answerList[$i]['a_id']."'><img src='images/correct_small.png' class='linkimage' alt='' /></a>";
      else  echo "<a class='showStatus' href='?site=topic&amp;action=updateAnswers&amp;q_id=".$_SESSION['values']['question']['q_id']."&amp;a_id=".$this->answerList[$i]['a_id']."'><img src='images/wrong_small.png' class='linkimage' alt='' /></a>";
      echo "</td>";
      echo" <td class='answers'><textarea name='change[$i]'  readonly='readonly'   class='TextField' rows='1' cols='79' >".stripslashes($this->answerList[$i]['answer'])."</textarea> </td>";
      echo"</tr>";
    }
    echo "<tr >";
    echo "<td class='leftColumn'></td>";
    if($this->type!=3)echo"<td class='Button_row'><input type='submit' class='Button_rightColumn' name='editAnsw' value='".Button_13."'/></td>";
    echo "</tr>";   
    echo "</table>";
    echo "</fieldset>";
    echo"</form>";
  }
   
  function setAnswersCorrect($correctAnswers){
    $this->answersCorrect=$correctAnswers;
  }
    
  function setQuestionID($q_id){
    $this->quID= $q_id;
  }
    
  function getAnswers(){
    $sql="SELECT a_id, answer, correct FROM answers WHERE q_id=".intval($_SESSION['values']['question']['q_id'])."";
    $query= mysql_query($sql); 
    $i=0; // zähler
    while($answers =mysql_fetch_array($query ,MYSQL_BOTH  )){     
      $this->answerList[$i]['a_id']=$answers['a_id']; // in arra speichern
      $this->answerList[$i]['answer']=$answers['answer'];
      $this->answerList[$i]['correct']=$answers['correct'];
      $i++;
    }
    $_SESSION['values']['answerList']=$this->answerList;
  }
   
  function setAnswerList(){
    $this->answerList=$_SESSION ['values']['answerList'];
  }
   
  function changeCorrect($a_id){
    switch ($this->type){ 
    case 1 : { // Einfachauswahl nur eine Antwort darf richtig sein 
      for ($i=0;$i<count($this->answerList);$i++){
        if($this->answerList[$i]['a_id']==$a_id){
          $this->answerList[$i] ['correct']=1;
        }
        else $this->answerList [$i] ['correct']=0;
      }
      $_SESSION ['values']['answerList']=$this->answerList;
      break;
    }
    case 2: { // Mehrfachauswahl mehrere Antworten können richtig sein
      $copy=$this->answerList;
      for ($i=0;$i<count($this->answerList);$i++){
        if($copy [$i]['a_id']==$a_id){
          if($copy[$i]['correct']==1) $copy [$i] ['correct']=0;
          else $copy [$i] ['correct']=1;
        }
      }
      for ($i=0;$i<count($this->answerList);$i++){
        if($copy[$i]['correct']==1)$check[$i]=1;
        else $check[$i]=0;
      }
                  
      $check_answers_true =  in_array(1,$check);
      $check_answers_false=  in_array (0,$check);
      if(($check_answers_true) && ($check_answers_false)) $this->answerList=$copy;
      else echo " <h4>".Class_Answer_08."</h4> "; 
      break;
    }
    case 3: { // Richtig Falsch 
      for ($i=0;$i<count($this->answerList);$i++){
        if($this->answerList[$i]['a_id']==$a_id){
          if( $this->answerList[$i] ['correct']==1) $this->answerList[$i] ['correct']=0;
          else $this->answerList[$i] ['correct']=1;
        }
        else{
          if( $this->answerList[$i] ['correct']==1) $this->answerList[$i] ['correct']=0;
          else $this->answerList[$i] ['correct']=1;
        }   
      }
      break;
    }
    }
  }
   
  function updateChangedAnswers() {
    $this->answerList=$_SESSION['values']['answerList'];
    for ($i=0;$i<count($this->answerList);$i++){
      $help = strcmp($this->answerList [$i] ['answer'],$this->changedAnswers[$i] ); // Vergleich der Antworten
      if($help!=0) { // wenn ein Unterschied besteht dann Update
        $this->answerList [$i] ['answer']=$this->changedAnswers[$i]; // Zur späteren korrekten Anzeige Wert überschreiben
        $sql="UPDATE answers SET answer='".mysql_real_escape_string($this->changedAnswers[$i])."', correct='".intval($this->answerList [$i] ['correct'])."' WHERE a_id=".intval($this->answerList [$i] ['a_id'])."";
        $query = mysql_query($sql);
      }
    }
  }
   
  function updateTruthFalse(){
    for ($i=0;$i<count($this->answerList);$i++){
      $sql="UPDATE answers SET answer='".mysql_real_escape_string($this->answerList [$i] ['answer'])."', correct='".intval($this->answerList [$i] ['correct'])."' WHERE a_id=".intval($this->answerList [$i] ['a_id'])."";
      $query = mysql_query($sql); 
    }       
  }
    
  function delAllAnswers($questionArray) {
    for ($i=0;$i<count($questionArray);$i++){
      $q_id=$questionArray[$i+1]['q_id'];
      $this->delAnswers ($q_id);
    } 
  }
    
  function delAnswers ($q_id){
    $sql="DELETE FROM answers WHERE q_id=".intval($q_id)."";
    $query = mysql_query($sql);
    if (!$query){
      $error=mysql_errno() ;
    }  
  }
     
  function addAnswer() {
    $addAnswer = array( 'id'  => 0, 'answer' => '','correct' => 0);
    $this->answerList[] = $addAnswer;
  }

  function minusAnswer(){
    if(count($this->answerList)>2){ // Prüfen ob mindestens 2 Antwortmöglichkeiten
      $delAnswer = array_pop($this->answerList);
    }
  }
  
    
  function formHead(){
    echo "<form  action='".$this->action."' method='post'>";   
    echo "<fieldset >";
    echo"<legend>".Class_Answer_02." </legend>";
    echo "<table class='table_show_answers'>";
    echo "<tr>";
    echo"<td class='leftColumn'>".Global_03." </td>";
    echo"<td class='answers'>".Class_Answer_03." </td>";
    echo "</tr>";
  }
     
  
     
  function ShowFormSingleSelection(){
    for($i=0;$i<count($this->answerList);$i++){
      echo "<tr>";
      echo"<td class='leftColumn'>";
      if (isset($this->answerList[$i]['id'])) {
        printf('<input type="hidden" name="id[]" value="%s" />',
               $this->answerList[$i]['id']);
       } else {
        printf('<input type="hidden" name="id[]" value="" />');
       }
      if ($this->missing) {
        $extrastyle = ' marked';
      } else {
        $extrastyle = '';
      }
      if ($this->answerList[$i]['correct'] == 1) {
        printf("<input class='left_answer_small%s' type='radio' checked='checked' value='%s' name='correct[]' />", $extrastyle, $i);
      } else {
        printf('<input class="left_answer_small%s" type="radio" value="%s" name="correct[]" />', $extrastyle, $i);
      }
      echo "</td>";
      printf("<td class='answers'><textarea name='answer[]' class='TextField%s' rows='1' cols='79' >%s</textarea></td>", $extrastyle, stripslashes($this->answerList[$i]['answer']));
      echo"</tr>";
    }
    $_SESSION ['values']['answerList']=$this->answerList;
    echo "<tr>";  
    echo"<td class='leftColumn'></td>";
    echo"<td class='Button_row'><input type='submit' class='Button_left' name='addAnsw' value='".Button_14."'/>";     
    echo"<input type='submit' class='Button_rightColumn' name='minAnsw' value='".Button_15."'/></td>";      
    echo "</tr>";
    echo "<tr>";
    echo"<td class='leftColumn'></td>";
    echo" <td class='Button_row'><input name='submit' class='Button_rightColumn' type='submit' value='".Button_11."'/> </td>"; 
    echo "</tr>";
    echo"</table>";
    echo"</fieldset>";
    echo"</form>";          
  }  
    
  function ShowFormMultipleChoice(){
      
    $i = 0;
    foreach( $this->answerList as $answer ){
      echo "<tr><td class='leftColumn'>";
      if (isset($this->answerList[$i]['id'])) {
        printf('<input type="hidden" name="id[]" value="%s" />',
               $this->answerList[$i]['id']);
      } else {
        printf('<input type="hidden" name="id[]" value="" />');
      }
      if ($this->missing == true) {
        $extrastyle = ' marked';
      } else {
        $extrastyle = '';
      }
      if ($this->answerList[$i]['correct'] == 1) {
        printf("<input class='left_answer_small%s' type='checkbox' checked='checked' value='%s' name='correct[]' />", $extrastyle, $i);
      } else {
        printf("<input class='left_answer_small%s' type='checkbox' value='%s' name='correct[]' />", $extrastyle, $i);
      }
      echo "</td>";
      printf("<td class='answers'><textarea name='answer[]' class='TextField%s'   rows='1' cols='79' >%s</textarea></td>", $extrastyle, stripslashes($this->answerList[$i]['answer']));
      echo"</tr>";
      $i++;
    }    
    echo "<tr>";
    echo"<td class='leftColumn'></td>";
    echo"<td class='Button_row'><input name='addAnsw' class='Button_rightColumn' type='submit' value='".Button_14."'/> ";    
    echo"<input type='submit' class='Button' name='minAnsw' value='".Button_15."'/></td>";  
    echo"</tr>";    
    echo "<tr>";
    echo"<td class='leftColumn'></td>"; 
    echo"<td class='Button_row'><input name='submit' class='Button_rightColumn' type='submit' value='".Button_11."' /></td> "; 
    echo "</tr></table>";
    echo "</fieldset>";
    echo"</form>";
  }  
    
  function ShowFormCorrectWrong(){
    $answerPossible=array("".Class_Answer_09."", "".Class_Answer_10."");
    $i = 0;
    foreach( $this->answerList as $answer ) {
      echo "<tr><td class='leftColumn'>";
      printf('<input type="hidden" name="id[]" value="%s" />',
             $this->answerList[$i]['id']);
      if ($this->missing==true) {
        $extrastyle = ' marked';
      } else {
        $extrastyle = '';
      }
      if ($this->answerList[$i]['correct']==1) {
        printf("<input class='left_answer_small%s' type='radio' checked='checked' value='%s' name='correct[]' />", $extrastyle, $i);
      } else {
        printf("<input class='left_answer_small%s' type='radio' value='%s' name='correct[]' />", $extrastyle, $i);
      }
      echo "</td>";
      printf("<td class='answers'><textarea name='answer[]' class='TextField'   rows='1' cols='79' >%s</textarea></td>", stripslashes($answerPossible[$i]));
      echo "</tr>";
      $i++;
    }
     
    echo "<tr>";
    echo"<td class='leftColumn'></td>";
    echo" <td class='Button_row'><input name='submit' class='Button_rightColumn' type='submit' value='".Button_11."'/> </td>";
    echo "</tr>";
    echo"</table>";
    echo "</fieldset>";
    echo"</form>";
  }
    
  function ShowFormFillInTheBlanks(){
    echo "<form action='index.php?site=collect_question&amp;action=setAnswers&amp;questionId=".$_SESSION['values']['question']['q_id']."' method='post'>";  
    echo "<fieldset  >";
    echo"<legend>".Antworten." </legend>";
    echo "<table class='table_show_answers'>";
    $i = 0;
    foreach($this->answerList as $answer ){ 
      echo "<tr>";
      echo"<td class='leftColumn'>";
      printf('<input type="hidden" name="id[]" value="%s" />',
             $this->answerList[$i]['id']);
      echo"</td>";
      if($this->missing==true){
        echo" <td class='answers'><textarea name='answer[]'   class='TextField marked' rows='1' cols='79' >".stripslashes($this->answerList[$i]['answer'])."</textarea> </td>";
      }
      else {
        echo" <td class='answers'><textarea name='answer[]'   class='TextField' rows='1' cols='79' >".stripslashes($this->answerList[$i]['answer'])."</textarea> </td>";
      }
      $i++;
      echo"</tr>";
    }
    echo "<tr>";
    echo"<td class='leftColumn'></td>";
    echo" <td class='Button_row'><input type='submit' class='Button_left' name='addAnsw' value='".Button_14."'/>";      
    echo"<input type='submit' class='Button' name='minAnsw' value='".Button_15."'/></td>";
    echo "</tr>";     
    echo "<tr>";
    echo"<td class='leftColumn'></td>";
    echo"  <td class='Button_row'><input name='submit' class='Button_rightColumn' type='submit' value='".Button_11."'/></td> ";
    echo"</tr>";
    echo"</table>";
    echo "</fieldset>";
    echo"</form>";
  }
    
  function controlAnswers(){
    for($i=0;$i<count( $this->answerList);$i++){
      for($j=1;$j<=count($this->answersCorrect);$j++){
        $compare=$this->answersCorrect[$j]['answer'];
        $help=strcmp($this->answerList[$i]['answer'], $compare) ;
        if($help==0){
          $this->answerList[$i]['answer']=''; 
          $foundIncorrect[]=1;
        } 
      }   
    }
    if(count($foundIncorrect)>0) {
      return false;
    }
    else return true;
  }
    
  function checkNumberOfAnswers(){
    for($i=0;$i<count( $this->answerList);$i++){
      $help=strcmp($this->answerList[$i]['answer'],'');
      if($help!=0)$check[]=1;
    }
    if(count($check)>=2)return true;
    else return false;
  }
    
  function checkAnswer(){ 
    if(($this->type==4) && ($this->controlAnswers()==true)||$this->type!=4){
      if(($this->pruefungCorrect()==true) || ($this->type==4)){ // pruefung ob eine Frage als richtig markiert wurde außer bei Lückentext 
        if($this->checkNumberOfAnswers()==true) {
          return 1;
        }
        else {
          echo"<h5><br />".Class_Answer_04."<br /></h5>";
          if($this->type==4)echo"<h5>".Class_Answer_04."<br /></h5>"; 
           
          $this->setMissing();
          $this->setType();  
        
        }
      }
      else{
        if( $this->type !=3)echo"<h5>".Class_Answer_05." <br /></h5>";
        else echo"<h5>".Class_Answer_06."</h5> ";
        
        $this->setMissing(); 
        $this->setType();   // wenn Antwort nicht ausgefüllt dann zurück zur Maske
         
        
      }
    }else  {
      echo"<h5>".Class_Answer_07."<br /></h5>";
     
      $this->setMissing();
      $this->setType();}
    return 0;
      
  }
    
    
  function saveAnswer(){ // Fehlt noch Prüfung nach Fragetyp etc // correct wird noch nicht gescheit angezeigt
    if(($this->type==4) && ($this->controlAnswers()==true)||$this->type!=4){
      if(($this->pruefungCorrect()==true) || ($this->type==4)){ // pruefung ob eine Frage als richtig markiert wurde außer bei Lückentext 
        if($this->checkNumberOfAnswers()==true) {
          $sql_del="DELETE FROM answers WHERE q_id=".intval($_SESSION['values']['question']['q_id'])."";
          $ok_del= mysql_query($sql_del); 
          for ($i=0;$i<count($this->answerList);$i++){
            $answer=$this->answerList[$i]['answer'];
            $correct=$this->answerList[$i]['correct'];
            if($answer!=''){ // wenn in antwort was drin steht
              if($answer == Class_Answer_09)$answer='true';
              else if($answer == Class_Answer_10) $answer='false';
              $sql="INSERT INTO answers (q_id,answer,correct) VALUES (".intval($_SESSION['values']['question']['q_id']).",'".mysql_real_escape_string($answer)."',".intval($correct).")";
              $ok= mysql_query($sql); 
            }
          } 
          unset ($_SESSION ['values']['answerList']);
          
          return true;
        }
        else {
          echo"<h5><br />".Class_Answer_04."<br /></h5>";
          if($this->type==4)echo"<h5>".Class_Answer_04."<br /></h5>"; 
           
          $this->setMissing();
          $this->setType();  
        
        }
      }
      else{
        if( $this->type !=3)echo"<h5>".Class_Answer_05." <br /></h5>";
        else echo"<h5>".Class_Answer_06."</h5> ";
        
        $this->setMissing(); 
        $this->setType();   // wenn Antwort nicht ausgefüllt dann zurück zur Maske
         
        
      }
    }else  {
      echo"<h5>".Class_Answer_07."<br /></h5>";
     
      $this->setMissing();
      $this->setType();}
    return false;
      
  }
    
  function pruefungCorrect(){
    $this->answerList=$_SESSION['values']['answerList'];
    for ($i=0;$i<=count($this->answerList);$i++) {
      if($this->answerList[$i]['correct']==1){
        return true; // wenn mindestens eine Frage als korrekt markiert ist dann speichere
      } 
    }
    return false;
  }
    
  function updateAnswers($q_id) {
    for($i=0;$i<count($this->answerList);$i++){
      $sql="INSERT INTO answers (q_id,answer,correct) VALUES (".intval($q_id).",'".mysql_real_escape_string($this->answerList[$i]['answer'])."','".intval($this->answerList[$i]['correct'])."')";
      $ok= mysql_query($sql); 
    }
  }
  } 
   
?>

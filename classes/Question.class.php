<?php
class Question 
{

  var $id;
  var $type;
  var $topic;
  var $allTopics;
  var $questionText; 
  var $typeName;
  var $numberOfQuestions;
  var $answer;
  var $description;
  var $descriptionText;
  
    function Question(){
        $this->id=0;
        $this->type=0;
        $this->topic=0;
        $this->allTopics=array();
        $this->questionText="";
        $this->typeName="";
        $this->numberOfQuestions=array();
        $this->answer= new Answer();
        $this->description=0;
        $this->descriptionText="";

    }
    
    function getID() {
      return (int) $this->id;   
    }
  
    function setID($id) {
      $this->id =$id ;  
    }
    
    function setTopic($topic){
      $this->topic = $topic;
      $_SESSION['values']['t_id']=$this->topic;
    }
    
    function getTopic(){
     return $this->topic;
    }
    
    function setAllTopics($topics){
      $this->allTopics=$topics;
    }
    
    function getQuestionText()  {
     return $this->questionText; 
    }
    
    function getAllQuestions() {
      return $this->questionList;
    }
    
    function setUpdateQuestion($quText,$topic) {
      $help = strcmp($this->questionText, $quText);
      $help1 = strcmp($this->topic, $topic);
        if(($help==0) && ($help1==0)){ 
          return 'none';
        } 
        else {
      $this->questionText = trim($quText);
      $this->topic=$topic;
    
      if($this->type==4) {
      $this->answer->setQuestionID($this->id);
      $this->answer->getAnswers();
      $correctAns=$this->getCorrectAnswerFillInTheBlanks($this->questionText);
      $this->answer->setAnswersCorrect($correctAns);
   
      if($this->answer->controlAnswers()==true)$this->updateQuestion();
      else return 'conflict' ;
      }
      else $this->updateQuestion();
      
      }
    }
  
    function setQuestion($quText){
    $this->questionText = trim($quText); 
    }
  
    function getQuestion(){
      return $this->questionText;
    }
        
     function setActive(){
      $sql="UPDATE questions set active=".intval(1)." WHERE q_id=".intval($this->id)." ";
      $ok= mysql_query($sql);
    }
   
    function setInactive(){
      $sql="UPDATE questions set active=".intval(0)." WHERE q_id=".intval($this->id)." ";
      $ok= mysql_query($sql);
    }
    
    function setDescription($description){
    $_SESSION['values']['question']['description']=1;
    $_SESSION['values']['question']['descriptionText']=$description;
    }
    
    function setSession(){
     $_SESSION ['values']['question']['q_id']=$this->id;
     $_SESSION ['values']['question']['questionText']=$this->questionText;
     $_SESSION ['values']['question']['t_id']=$this->topic;
     $_SESSION ['values']['question']['qt']=$this->type;
     $_SESSION ['values']['question']['description']=$this->description;
     $_SESSION ['values']['question']['descriptionText']=$this->descriptionText;
            
    }
    
    
    function unsetSession(){
    unset($_SESSION ['values']['question']);
    }
    
    function delAllQuestions(){
      for ($i=1;$i<=count($this->questionList);$i++){
        $q_id=$this->questionList[$i]['q_id'];
        $this->delQuestion($q_id);
      }
    }
    
    function getNumberOfQuestions($topicarray){
      for ($i=1;$i<=count($topicarray);$i++){
        $sql="SELECT COUNT(q_id)as 'number' FROM questions WHERE t_id=".intval($topicarray[$i]['t_id']) ." ";
        $query = mysql_query($sql); 
        while($numberofQuestions=mysql_fetch_array($query ,MYSQL_BOTH  )){  
          $this->numberofQuestions[$i]=$numberofQuestions['number']; // in arra speichern
        }
      }
      return $this->numberofQuestions;
    }
    
    function getLearnpathCount($topicarray){
      for ($i=1;$i<=count($topicarray);$i++){
        $sql="SELECT COUNT(lp_id)as 'number' FROM learnprogress WHERE t_id=".intval($topicarray[$i]['t_id']) ." ";
        $query = mysql_query($sql); 
          while($numberOfLp=mysql_fetch_array($query ,MYSQL_BOTH  )) {   
            $numberOfTests[$i]=$numberOfLp['number']; // in arra speichern
          }
      }
      return $numberOfTests;
    }
   
    function setType($type) {
      $accepted = array('1', '2', '3', '4');      
        if( in_array($type, $accepted) )  {             // Wenn  type in array dann zuweisen
        $this->type = $type;
        return true;  
        }
      return false;
    }

     function getCorrectAnswerFillInTheBlanks($question) { 
      $addSlashes= preg_quote( $question, '[^]'); // Slash hinzufügen wenn KLammer gefunden wird
      $array=explode('\\',$addSlashes); // String teilen
       $questionText= $question;
        if(substr_count($question,"[")==substr_count($question,"]")) { // gleiche anzahl von Klammer auf und zu
          for($i=1;$i<=substr_count($question,"[");$i++){ // Wird solange durchlaufne wie Klammern vorhanden sind
            $beginPos = strpos($questionText, "["); // Anfangspunkt festlegen
            $endPos=strpos($questionText, "]"); // Endpunkt festlegen
            $length=(($endPos+1)-$beginPos) ; // Länge der Strings ermitteln
            $answer=substr ($questionText,$beginPos,$length );// den String zwischen den Klammern suchen
            $questionText=str_replace($answer,'()', $questionText); // gespeicherten Wert aus string löschen
            $answer=str_replace("]",'', $answer); // Klammer entfernen
            $key = array_search($answer, $array);  
            $answer=str_replace("[",'', $answer); // Klammer entfernen     
            $value[$i]['answer']=$answer;
            $value[$i]['blank']=$key;  
            } 
          } 
        return($value);
    }
    
   function returnTypeName($type){
  // if($type==0)$type=$_SESSION ['values']['question']['qt'];
   $sql=sprintf("SELECT `qt_desc` as `type` FROM `questiontype_v2` WHERE `qt_id`='%d' AND `lang`='%s'", intval($type), mysql_real_escape_string($_SESSION['profile']['language']));
   $query = mysql_query($sql);
   $type = mysql_fetch_assoc($query);
   $this->typeName=$type['type'];
   return $this->typeName;
  }
  
   function getType()  {
   return $this->type;
   }
   
   function checkQuestion(){
   
   if(($_SESSION ['values']['question']['questionText'])!=null && $_SESSION ['values']['question']['qt']!=null ){ 
    if($_SESSION ['values']['question']['qt']==4) $value =$this->getCorrectAnswerFillInTheBlanks($_SESSION ['values']['question']['questionText']);
      if(count ($value)>0 && $_SESSION ['values']['question']['qt']==4 || $_SESSION ['values']['question']['qt']!=4){
    
       return 1;
      }else return 3;      
    }
    else return 0; 
   }
   
   function saveQuestion(){
      if($_SESSION ['values']['question']['qt']==4) $value =$this->getCorrectAnswerFillInTheBlanks($_SESSION ['values']['question']['questionText']);
          if(count ($value)>0 && $this->type==4 || $this->type!=4){
            $sql  = 'INSERT INTO questions (question,qt_id,t_id,active,description)VALUES ("'.mysql_real_escape_string($_SESSION ['values']['question']['questionText']).'","'.intval($_SESSION ['values']['question']['qt']).'","'.intval($_SESSION ['values']['question']['t_id']).'","'.intval(0).'","'.intval($_SESSION['values']['question']['description']).'")'; // frage bis sie komplett ist inaktiv setzen
            $ok= mysql_query($sql); 
              if (!$ok){
                 $error=mysql_errno();
                 if($error=='1062') return 2;
               }
             else {
              $questionId = mysql_insert_id();
              
                if($_SESSION['values']['question']['description']==1){
                  $sql_desc  = 'INSERT INTO question_description (q_id,description)VALUES ("'.intval($questionId).'","'.mysql_real_escape_string($_SESSION['values']['question']['descriptionText']).'" )'; // frage bis sie komplett ist inaktiv setzen
                  $ok_desc= mysql_query($sql_desc); 
                 
                }
                
              $this->id = (int) $questionId; // ID zuweisen
              $_SESSION['values']['question']['q_id']=(int) $questionId;
              $this->createStatistic();
              
              }
            return 1;
            
      }else return 3;
             
    }
  
    function loadQuestion() {
      $sql ='SELECT question,t_id,qt_id,description FROM questions WHERE q_id='.intval($this->id).'';  
      $query = mysql_query($sql);
        if(!$query){  // Wenn Fehler
          $error=mysql_errno() ;
        }
        while($question =mysql_fetch_array($query,MYSQL_BOTH  )){ // Prüfen ob es nicht ne bessere Art und Weise gibt als while
          $this->questionText=$question['question'];
          $this->topic=$question['t_id'];
          $this->type=$question['qt_id'];
          $this->description=$question['description'];
          
            // beschreibung aus db holen
            if($this->description==1){
              $sql_desc="SELECT description FROM question_description WHERE q_id=".intval($this->id)."";
              $query_desc=mysql_query($sql_desc); 
              $desc = mysql_fetch_assoc($query_desc);
              $this->descriptionText=stripslashes($desc['description']);
            }
        }
        $this->returnTypeName($this->type);
        $this->setSession();
      }
    
    function showQuestionTable(){
      echo"<table class='table table_standard'>"; 
      echo "<tr>";
      echo "<td class='th th_buttons'>".Global_06."</td>";
      echo"<td class='th th_question'>".Global_08."</td>";
      echo"<td class='th th_questiontype'>".Global_12." </td>";
      echo "<td class='th th_buttons'> </td>";
      echo "<td class='th th_buttons'> </td>";
      echo "<td class='th th_buttons'> </td>";
      echo "</tr>";   
        for ($i=1;$i<=count($this->questionList);$i++){ // Solange bis $ größer gleich Anzahl der Werte im Array     
          echo "<tr>";
          echo"<td class='td'>". $this->questionList[$i]['q_id']."</td>"; // array Werte ausgeben
           if($this->questionList[$i]['active']==0) echo"<td class='td_inactive'>".stripslashes($this->questionList[$i]['question'])."</td>";
           else echo"<td class='td'>".stripslashes($this->questionList[$i]['question'])."</td>";
           echo"<td class='td'>".$this->returnTypeName($this->questionList[$i]['qt_id'])."</td>";
           echo"<td class='td'><a href='?site=topic&amp;action=showDetails&amp;q_id=".$this->questionList[$i]['q_id']."'><img src='images/edit.png' class='linkimage' title='".Class_Question_01."' alt='".Class_Question_01."' /></a></td>";
           if($this->questionList[$i]['active']!=0)    echo" <td class='td'><a href='?site=topic&amp;action=setQuestionInactive&amp;q_id=".$this->questionList[$i]['q_id']."'><img src='images/setInactive.png' class='linkimage' title='".Class_Question_02."' alt='".Class_Question_02."'/></a></td>";
             if($this->questionList[$i]['active']==0)  echo" <td class='td'>  <a href='?site=topic&amp;action=setQuestionActive&amp;q_id=".$this->questionList[$i]['q_id']."'><img src='images/setActive.png' class='linkimage' title='".Class_Question_03."' alt='".Class_Question_03."' /></a></td>";
               echo" <td class='td'> <a href='?site=topic&amp;action=delQuestion&amp;q_id=".$this->questionList[$i]['q_id']."'><img src='images/wrong.png' class='linkimage' title='".Class_Question_04."' alt='".Class_Question_04."' /></a></td>";
              
               echo "</tr>";   
        }    
      echo"</table>";
      echo"<br />";   
    }
    
    function showStatisticQuestionTable(){
      echo"<table class='table table_standard'>"; 
      echo "<tr>";
      echo"<td class='th th_question'>".Global_08."  </td>";
      echo"<td class='th th_questiontype'>".Global_12." </td>";
      echo"<td class='th th_count'>".Global_11." </td>";
      echo"<td class='th th_count'>".Global_03."</td>";
      echo "<td class='th th_buttons'> </td>";
      echo "<td class='th th_buttons'> </td>";
      echo "<td class='th th_buttons'> </td>";
      echo "</tr>";   
        for ($i=1;$i<=count($this->questionList);$i++){  // Solange bis $ größer gleich Anzahl der Werte im Array
          echo "<tr>";
              if($this->questionList[$i]['active']==0) echo"<td class='td_inactive'>".stripslashes($this->questionList[$i]['question'])."</td>";
              else  echo"<td class='td'>".stripslashes($this->questionList[$i]['question'])."</td>";
                echo"<td class='td'>".$this->returnTypeName($this->questionList[$i]['qt_id'])."</td>";
                echo"<td class='td'> ".$this->questionList[$i]['count']."</td>";
                 if($this->questionList[$i]['count']>0){
                 $correct=$this->questionList[$i]['count']-$this->questionList[$i]['incorrect'];
                 $percentage=($correct/$this->questionList[$i]['count'])*100;
                 $percentage = round( $percentage,2); // nur 2 Nachkommastellen anzeigen
                 }
                 else $percentage='-';
               echo"<td class='td'>   $percentage %</td>";
               echo"<td class='td'> <a href='?site=topic&amp;action=showDetails&amp;q_id=".$this->questionList[$i]['q_id']."'><img src='images/edit.png' class='linkimage' title='".Class_Question_05."' alt='".Class_Question_05."' /></a></td>";
               echo"<td class='td'> <a href='?site=topic&amp;action=showDetails&amp;q_id=".$this->questionList[$i]['q_id']."'><img src='images/edit.png' class='linkimage' title='".Class_Question_05."' alt='".Class_Question_05."' /></a></td>";
                 if($this->questionList[$i]['active']!=0)echo" <td class='td'> <a href='?site=topic&amp;action=setQuestionInactive&amp;q_id=".$this->questionList[$i]['q_id']."'><img src='images/setInactive.png' class='linkimage' title='".Class_Question_02."' alt='".Class_Question_02."' /></a></td>";
                 if($this->questionList[$i]['active']==0) echo" <td class='td'>  <a href='?site=topic&amp;action=setQuestionActive&amp;q_id=".$this->questionList[$i]['q_id']."'><img src='images/setActive.png' class='linkimage' title='".Class_Question_03."' alt='".Class_Question_03."' /></a></td>";
              echo"<td class='td'><a href='?site=topic&amp;action=delQuestion&amp;q_id=".$this->questionList[$i]['q_id']."'><img src='images/wrong.png' class='linkimage' title='".Class_Question_04."' alt='".Class_Question_04."' /></a></td>";
              echo "</tr>";
        }                                        
            echo"</table>";
            
    }
    
    function setAllQuestions(){
    $sqlGetQu=" SELECT q_id,qt_id,question,active FROM questions WHERE t_id =".intval($this->topic)."  ORDER BY q_id";
    $queryGetQu = mysql_query($sqlGetQu)OR die(mysql_error()); 
    $number=mysql_num_rows($queryGetQu ) ;
      if($number==0) return 0;//echo" Keine Fragen in der Datenbank vorhanden <br /> <br /> <br />";
      else{
        $i=1; // zähler
        while($questions =mysql_fetch_array($queryGetQu ,MYSQL_BOTH  )){    
        $this->questionList[$i]['q_id']=$questions['q_id']; // in arra speichern
        $this->questionList[$i]['qt_id']=$questions['qt_id'];
        $this->questionList[$i]['question']=$questions['question'];
        $this->questionList[$i]['active']=$questions['active'];
        $i++; 
        }
      } 
    }
    
    function  setInactiveQuestion($q_id){
    $sql="UPDATE questions set active=".intval(0)." WHERE q_id=".intval($q_id)." ";
    $ok= mysql_query($sql);
      if (!$ok){
       $error=mysql_errno() ;
       
      }  
     }
   
    function setStatisticQuestions(){ 
    $sqlGetQu="SELECT * FROM questions   LEFT JOIN statistics ON ( questions.q_id = statistics.q_id )  WHERE t_id='".intval($this->topic)."'";
    $queryGetQu = mysql_query($sqlGetQu); 
    $number=mysql_num_rows($queryGetQu ) ;
      if($number==0){
       echo '<div class="h8 centered">'.Class_Question_05.'</div><br /><br /><br />';
       return 0;
       }
      else {
        $i=1; // zähler
        while($questions =mysql_fetch_array($queryGetQu ,MYSQL_BOTH  )){ 
          $this->questionList[$i]['q_id']=$questions['q_id']; // in arra speichern
          $this->questionList[$i]['qt_id']=$questions['qt_id'];
          $this->questionList[$i]['question']=$questions['question'];
          $this->questionList[$i]['active']=$questions['active'];
          $this->questionList[$i]['count']=$questions['count'];
          $sql_getIncorrect="SELECT Count(q_id) AS 'incorrect' FROM answers_incorrect where q_id=".intval($questions['q_id'])."";
          $queryGetInc = mysql_query($sql_getIncorrect); 
          $row = mysql_fetch_assoc($queryGetInc);
          $this->questionList[$i]['incorrect']=$row['incorrect'];
          $i++; 
        }
        return 1;
      }  
    }
   
    function showQuestionDetails(){
    echo"<form action='index.php?site=topic&amp;action=updateQuestion&amp;q_id=".$_SESSION ['values']['question']['q_id']."' method='post'>"; 
    echo "<fieldset >";
    echo " <legend>".Class_Question_06."  </legend> ";
    echo "<table class='table_show_question'>";
    echo "<tr>";
    echo"<td class='name'> ".Global_06." </td>";
    echo"<td class='left_point'> :  </td>";
    echo' <td class="text"><textarea readonly="readonly" class="TextField" name="q_id" rows="1" cols="79" >'.stripslashes($_SESSION ['values']['question']['q_id']).'</textarea> </td>';
    echo"</tr>";
    
    echo"<tr>";
    echo"<td class='name'>".Global_09."</td>";
    echo"<td class='left_point'> :  </td>";
    echo"<td class='text'><select size='1' class='dropdown_right' name='topic' > ";
      for ($i=1;$i<=count($this->allTopics);$i++){
        if($_SESSION ['values']['question']['t_id']==$this->allTopics[$i]['t_id'])echo '<option selected="selected" value="'.$this->allTopics[$i]['t_id'].'">'.stripslashes($this->allTopics[$i]['topic'])."</option>";
        else echo '<option value="'.$this->allTopics[$i]['t_id'].'">'.stripslashes($this->allTopics[$i]['topic']).'</option>';
      }
    echo"</select> </td>";
    echo"</tr>";
    
    echo "<tr>";
    echo"<td class='name'>".Global_12." </td>";
    echo"<td class='left_point'> :  </td>";
    echo" <td class='text'><textarea name='type_name' readonly='readonly'  class='TextField' rows='1' cols='79' >".stripslashes($this->returnTypeName($_SESSION ['values']['question']['qt']))."</textarea> </td>";
    echo"</tr>";
    
    echo"<tr>";
    echo"<td class='name'>  ".Global_08." </td>";
    echo"<td class='left_point'> :  </td>";
    echo" <td class='text'><textarea name='question' class='TextField_big' rows='2' cols='79' >".stripslashes($_SESSION ['values']['question']['questionText'])."</textarea> </td>";
    echo"</tr>";
    
    if($_SESSION ['values']['question']['description']==1){
    echo"<tr>";
    echo"<td class='name'>  ".Global_20." </td>";
    echo"<td class='left_point'> :  </td>";
    echo" <td class='text'><textarea name='descriptionText' class='TextField_big' rows='2' cols='79' >".stripslashes($_SESSION ['values']['question']['descriptionText'])."</textarea> </td>";
    echo"</tr>";
    }
      else {
          echo "<tr>";
          echo"<td class='name'>".Global_20." </td>";
          echo"<td class='left_point'>  </td>";
          echo "<td class='text'> </td>";
          echo "</tr>";
          
         
          echo"<tr>";
          echo"<td class='name'><input  class='left_answer_small marked'   type='checkbox'  value='1' name='description' /></td>"; 
          echo"<td class='left_point'></td>";
          echo" <td class='text'><textarea name='descriptionText'   class='TextField_big'   rows='1' cols='79' ></textarea> </td>";
          echo "</tr>";
      }
   echo"<tr>";
   echo"<td class='name'></td>";
   echo"<td class='left_point'></td>";
   echo" <td class='Button_row'> <input name='submit' class='Button_rightColumn' type='submit' value='".Button_12."'/></td>";
   echo"</tr>";
   echo"</table>"; 
   echo "</fieldset>";
   
   echo"</form>";
   
   }
  function showQuestionInfos(){
    echo"<form action='index.php?site=topic&amp;action=updateQuestion&amp;q_id=$this->id' method='post'>"; 
    echo "<fieldset >";
    echo "<legend> ".Class_Question_06."  </legend> ";
    echo "<table class='table_show_question'>";
    
    echo "<tr>";
    echo"<td class='name'>".Global_09."</td>";
    echo"<td class='left_point'> :  </td>";
    
    for ($i=1;$i<=count($this->allTopics);$i++){
      if($_SESSION ['values']['question']['t_id']==$this->allTopics[$i]['t_id'])echo" <td class='text'><textarea name='topic' class='TextField'  readonly='readonly'  rows='2' cols='81' >".stripslashes($this->allTopics[$i]['topic'])."</textarea></td>";
    }

    echo"</tr>";
    
    echo "<tr>";
    echo"<td class='name'>  ".Global_08." </td>";
    echo"<td class='left_point'> :  </td>";
    echo"<td class='text'> <textarea name='question' class='TextField_big' readonly='readonly' rows='2' cols='79' >".stripslashes($_SESSION ['values']['question']['questionText'])."</textarea> </td>";
    echo"</tr>";
    echo "<tr>";
    echo"<td class='name'>".Global_12." </td>";
    echo"<td class='left_point'> :  </td>";
    echo"<td class='text'><textarea name='type_name' class='TextField'  readonly='readonly'  rows='2' cols='81' >".stripslashes($this->returnTypeName($_SESSION ['values']['question']['qt']))."</textarea></td>";
    echo"</tr>";
    
    
    if($_SESSION ['values']['question']['descriptionText']){
    echo"<tr>";
    echo"<td class='name'>".Global_20." </td>";
    echo"<td class='left_point'>:</td>";
    echo" <td class='text'><textarea name='descriptionText' readonly='readonly'  class='TextField_big'   rows='1' cols='79' >".stripslashes($_SESSION ['values']['question']['descriptionText'])."</textarea> </td>";
    echo "</tr>";
    }
    
   echo"</table>";
   echo "</fieldset>";
   echo"</form>";
  
  }
  
    function  delQuestion($q_id){
      if($q_id){
      $sql= "DELETE FROM questions WHERE q_id=".intval($q_id)."";
      $ok= mysql_query($sql);
       // statistiken bereingien 
      $sql_del_statistics="DELETE FROM statistics WHERE q_id=".intval($q_id)."";
      $ok_statistics=mysql_query( $sql_del_statistics);
      // answers_incorrect bereinigen
      $sql_del_aIncorrect="DELETE FROM answers_incorrect WHERE q_id=".intval($q_id)."";
      $ok_aIncorrect=mysql_query( $sql_del_aIncorrect);
      //Beschreibung löschen
      $sql_del_desc="DELETE FROM question_description WHERE q_id=".intval($q_id)."";
      $ok_desc=mysql_query( $sql_del_desc);
      } 
    }
   
    function updateQuestion (){ 
      $sql=" UPDATE questions SET question='".mysql_real_escape_string($this->questionText)."',t_id=".intval($this->topic)." WHERE q_id= ".intval($this->id)." ";
      $queryUpdate = mysql_query($sql);
    }
   
    function createStatistic(){
      $sql="INSERT INTO statistics (q_id,count) VALUES (".intval($this->id).",".intval(0).")";
      $query = mysql_query($sql); 
    }  
    
    function updateDescription($q_id,$descriptionText){
      $sql=" UPDATE question_description SET description='".mysql_real_escape_string($descriptionText)."' WHERE q_id=".intval($q_id)." ";
      $queryUpdate = mysql_query($sql);
    }
    
    function saveDescription($q_id,$descriptionText){
      $sql="INSERT INTO question_description (q_id,description) VALUES (".intval($q_id).",'".mysql_real_escape_string($descriptionText)."')";
      $query = mysql_query($sql); 
      
      $sql_update=" UPDATE questions SET description='".intval(1)."' WHERE q_id=".intval($q_id)." ";
  
      $query_update = mysql_query($sql_update);
      $_SESSION ['values']['question']['descriptionText']=$descriptionText;
      $_SESSION ['values']['question']['description']=1;
    }
    
     function delDescription($q_id,$descriptionText){

      $sql=" DELETE FROM question_description WHERE q_id=".intval($q_id)."";
      $query = mysql_query($sql); 
      
      $sql_update=" UPDATE questions SET description='".intval(0)."' WHERE q_id=".intval($q_id)." ";
      $query_update = mysql_query($sql_update);
    }
}
?>

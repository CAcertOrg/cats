<?php

class Topic
{
  var $table;
  var $topicName;
  var $topics;
  var $topicID;
  var $rawToPass;
  var $numOfQu;
  var $error;
  var $question;

  
  function Topic(){
      $this->table='topics';
      $this->topicName='';
      $this->topics = array();
      $this->topicID=0;
      $this->rawToPass=0;
      $this->numOfQu=0;
      $this->error='';
      $this->question=new Question ();
    }
    
    function setTopicName($topicName){
      $this->topicName=$topicName;
    }
  
    function setNumOfQu($numOfQu){
      $this->numOfQu=$numOfQu;
        if(is_numeric($this->numOfQu)==true && $this->numOfQu>0) return 0; 
      else return 1;
    }
    
      function setrawToPass($rawToPass){
        $this->rawToPass=$rawToPass;
          if(is_numeric($this->rawToPass)==true && $this->rawToPass<=100 && $this->rawToPass>0) return 0;
            else return 1;
      }
     
     function setError($error){
     $this->error=$error;
     }
                
    function setTopic($t_id){
      $this->topicID=$t_id;
      $sql ="SELECT topic,numOfQu,percentage FROM topics WHERE t_id='".intval($t_id)."'";  // fehlt noch dass Variable genommen wird
      $query = mysql_query($sql)OR die(mysql_error());
        while($topic = mysql_fetch_array( $query,MYSQL_BOTH )){
          $this->topicName= $topic['topic'];
          $this->rawToPass=$topic['percentage'];
          $this->numOfQu=$topic['numOfQu'];
        }
        $this->setSession();
      }
     
    function setInactiveTopic() {
      $sql="UPDATE topics SET active=".intval(0)." WHERE t_id=".intval($this->topicID)."";
      $ok= mysql_query($sql)OR die(mysql_error());
        if (!$ok) {
          $error=mysql_errno() ;   
      }  
    }
    
    function setActiveTopic(){
      $sql="UPDATE topics SET active=".intval(1)." WHERE t_id=".intval($this->topicID)."";
      $ok= mysql_query($sql)OR die(mysql_error());
      if (!$ok){
        $error=mysql_errno() ; 
      }  
    } 
    function getNumOfQu (){
      $sql ="SELECT numOfQu FROM topics WHERE t_id=".intval($this->topicID)."";  // fehlt noch dass Variable genommen wird
      $query = mysql_query($sql)OR die(mysql_error());
      $numOfQu = mysql_fetch_assoc($query);
      return $numOfQu ['numOfQu'];
    }
      
    function getrawToPass (){
      $sql ="SELECT percentage FROM topics WHERE t_id=".intval($this->topicID)."";  // fehlt noch dass Variable genommen wird
      $query = mysql_query($sql)OR die(mysql_error());
      $rawToPass  = mysql_fetch_assoc($query);
      return $rawToPass ['percentage'];
    }
      
    function setTopicID($t_id){
      $this->topicID=$t_id;
    }

    function getTopicID(){
      return $this->topicID;
     }
     
    function getTopicName(){
      return  $this->topicName ;
    }
    
    function saveTopic(){
      if($this->topicName!=null && $this->numOfQu!=null &&$this->rawToPass!=null){
      $sql  = 'INSERT INTO topics (topic,active,numOfQu,percentage)VALUES ("'.mysql_real_escape_string($this->topicName).'","'.intval(1).'",'.intval($this->numOfQu).','.intval($this->rawToPass).') '; 
     $ok= mysql_query($sql); 
      if (!$ok){
       $error=mysql_errno() ;
        if($error=='1062') return "existing";
      }
      return "none";   
      }
      else return "missing"; 
    }

    function getActiveTopic(){
      $sql ='SELECT * FROM topics WHERE active="'.intval(1).'"';  
      $query = mysql_query($sql)OR die(mysql_error());
        if(!$query){  // Wenn Fehler
          $error=mysql_errno() ;
        }
        else{
          $i=1;
          while($topic =mysql_fetch_array($query,MYSQL_BOTH  )){   
            $this->topics[$i]['t_id']=$topic['t_id']; // in arra speichern
            $this->topics[$i]['topic']=$topic['topic'];
            $this->topics[$i]['rawToPass']=$topic['percentage'];
            $this->topics[$i]['numOfQu']=$topic['numOfQu'];
            $i++;
          }
        }
    }
    
     function getTopic(){
      $sql ='SELECT * FROM topics';  // fehlt noch dass Variable genommen wird
      $query = mysql_query($sql)OR die(mysql_error());
      if(!$query) {  // Wenn Fehler
        $error=mysql_errno() ;
      }
      else{
        $i=1;
        while($topic =mysql_fetch_array($query,MYSQL_BOTH  )){   
          $this->topics[$i]['t_id']=$topic['t_id']; // in arra speichern
          $this->topics[$i]['topic']=$topic['topic'];
          $this->topics[$i]['rawToPass']=$topic['percentage'];
          $this->topics[$i]['numOfQu']=$topic['numOfQu'];
          $this->topics[$i]['active']=$topic['active'];
          $i++;
        }
      }
    }
    
    
    function getTopicArray(){ // Liefert das Array mit den Topics zurück
      return $this->topics;
    }
    
    function setSession(){
    $_SESSION['values']['topic']['t_id']= $this->topicID;
    $_SESSION['values']['topic']['topicName']= $this->topicName;
    $_SESSION['values']['topic']['numOfQu']=$this->numOfQu;
    $_SESSION['values']['topic']['rawToPass']=$this->rawToPass;
    }
    
    function unsetSession(){
     unset($_SESSION['values']['topic']);
    }
    
    function showTopicTable($number){ // Topics in Tabelle anzeigen
      echo"<table class='table table_standard '>"; 
      echo "<tr>";
      echo"<td class='th th_topicName'>".Class_Topic_01." </td>";
      echo"<td class='th th_number'>".Class_Topic_02." </td>";
      echo"<td class='th th_numOfQu'> ".Class_Topic_03." </td>";
      echo"<td class='th th_count'>".Class_Topic_04." </td>";
      echo" <td class='th th_buttons'></td>";
      echo" <td class='th th_buttons'></td>";
      echo" <td class='th th_buttons'></td>";
      echo"</tr>\n";
     
        for ($i=1;$i<=count($this->topics);$i++){ // Solange bis $ größer gleich Anzahl der Werte im Array
          echo "<tr>";
          if($this->topics[$i]['active']==0) echo"<td class='td_inactive'><a href=\"".$_SERVER['PHP_SELF']."?site=topic&amp;action=getQuestions&amp;t_id=".$this->topics[$i]['t_id']."\">".stripslashes($this->topics[$i]['topic'])."</a></td>";
          else  echo"<td class='td_topics'><a href=\"".$_SERVER['PHP_SELF']."?site=topic&amp;action=getQuestions&amp;t_id=".$this->topics[$i]['t_id']."\">".stripslashes($this->topics[$i]['topic'])."</a></td>";
          echo"<td class='td'>".$number[$i]."</td>"; // array Werte ausgeben
          echo"<td class='td'>".$this->topics[$i]['numOfQu']." </td>";
          echo"<td class='td'>".$this->topics[$i]['rawToPass']." %</td>";
          echo"<td class='td'> <a href='?site=topic&amp;action=editTopic&amp;t_id=".$this->topics[$i]['t_id']."'><img src='images/edit.png' class='linkimage' title='".Class_Topic_05."' alt='".Class_Topic_05."' /></a></td>";
          if($this->topics[$i]['active']==0)echo"<td class='td'> <a href='?site=topic&amp;action=setTopicAvtive&amp;t_id=".$this->topics[$i]['t_id']."'><img src='images/setActive.png' class='linkimage' title='".Class_Topic_06."' alt='".Class_Topic_06."'/></a></td>";
          else echo"<td class='td'> <a href='?site=topic&amp;action=setTopicInactive&amp;t_id=".$this->topics[$i]['t_id']."'><img src='images/setInactive.png' class='linkimage' title='".Class_Topic_07."' alt='".Class_Topic_07."'/></a></td>";
          echo"<td class='td'> <a href='?site=topic&amp;action=delTopic&amp;t_id=".$this->topics[$i]['t_id']."'><img src='images/wrong.png' class='linkimage' title='".Class_Topic_08."' alt='".Class_Topic_08."' /></a></td>";
         
          echo "</tr>\n";   
        } 
      echo"</table>";
        
    }
    
    function newForm(){
      echo "<form action='index.php?site=topic&amp;action=save' method='post'>";  
      $this->showForm();
    }
    
      function updateForm(){
      echo "<form action='index.php?site=topic&amp;action=updateTopic&amp;t_id=$this->topicID' method='post'>";  
      $this->showForm();
    }
    
    
    function showForm(){ // Form anzeigen um eine Formular zu erstellen
      if($this->error=='rawToPass')echo '<h5 class="centered">'.Class_Topic_09."</h5>";
      else if($this->error=='existing')echo '<h5 class="centered">'.Class_Topic_10."</h5>";
      else if($this->error=='numOfQu')echo '<h5 class="centered">'.Class_Topic_11."</h5>";
     
      echo "<fieldset >";   
      echo " <legend>".Button_01." </legend> ";
      echo"<table class='table_new_topic'>";
      echo"<tr>";
      echo"<td class='name'>".Class_Topic_01."</td>";
      echo"<td class='left_point'> :  </td>";
      if ($_SESSION['values']['topic']['topicName']==null && $this->error) {
        echo "<td class='text'><textarea class='TextField marked' name='new_topic' rows='1' cols='79' ></textarea></td>";
      } else {
        echo "<td class='text'><textarea class='TextField' name='new_topic' rows='1' cols='79'>".stripslashes($_SESSION['values']['topic']['topicName'])."</textarea></td>";
      }
      echo"</tr>";
      echo"<tr>";
      echo" <td class='name'>".Class_Topic_03."</td>";
      echo"<td class='left_point'> :  </td>";
      if ($_SESSION['values']['topic']['numOfQu']==null && $this->error) {
        echo "<td class='text'><textarea class='TextField marked' name='questPerQuiz' rows='1' cols='79'></textarea></td>";
      } else {
        echo "<td class='text'><textarea class='TextField' name='questPerQuiz' rows='1' cols='79'>".$_SESSION['values']['topic']['numOfQu']."</textarea></td>";
      }
      echo"</tr>";
      echo"<tr>";
      echo"<td class='name'>".Class_Topic_12."</td>";
      echo"<td class='left_point'> :  </td>";
      if ($_SESSION['values']['topic']['rawToPass']==null && $this->error) {
        echo "<td class='text'><textarea class='TextField marked' name='rawToPass' rows='1' cols='79'></textarea></td>";
      } else {
        echo "<td class='text'><textarea   class='TextField' name='rawToPass' rows='1' cols='79'>".$_SESSION['values']['topic']['rawToPass']."</textarea></td>";
      }
      echo"</tr>";
      echo"<tr>";
      echo"<td class='name'></td>";
      echo"<td class='left_point'></td>";
      echo" <td class='Button_row' ><input name='submit' class='Button_rightColumn' type='submit' value='".Button_11."' /></td> "; 
      echo"</tr>";
      echo"</table>";
      echo "</fieldset>";
      echo"</form>";
    }
        
    function delTopic(){
    // Frage ID's des Topics aus DB lesen
    $sqlGetQu=" SELECT q_id,qt_id,question,active FROM questions WHERE t_id =".intval($this->topicID)."  ORDER BY q_id";
    $queryGetQu = mysql_query($sqlGetQu)OR die(mysql_error()); 
    $number=mysql_num_rows($queryGetQu ) ;
      if($number!=0){
        while($questions =mysql_fetch_array($queryGetQu ,MYSQL_BOTH  )){ 
         // Antworten der Fragen löschen   
         $sql_answers="DELETE FROM answers WHERE q_id=".intval($questions['q_id'])."";
         $query_answers = mysql_query($sql_answers);
            if (!$query_answers )$error=mysql_errno() ;
        }
      }
     
      // Fragen löschen 
      $sql_question="DELETE FROM questions WHERE t_id=".intval($this->topicID)."";
      $ok_question=mysql_query($sql_question)OR die(mysql_error());
      
      // Thema löschen
      $sql= "DELETE FROM topics WHERE t_id=".intval($this->topicID)."";
      $ok= mysql_query($sql)OR die(mysql_error());
      
      // Lernfortschritte ebenfalls löschen
      $sql_del_lp="DELETE FROM learnprogress WHERE t_id=".intval($this->topicID).""; 
      $ok_del_lp= mysql_query(  $sql_del_lp)OR die(mysql_error());
        if (!$ok) {
         $error=mysql_errno() ;
       } 
      
    }
    
    function updateTopic(){
      $sql=" UPDATE topics SET topic='".mysql_real_escape_string($this->topicName)."',numOfQu=".intval($this->numOfQu).",percentage= ".intval($this->rawToPass)." WHERE t_id=". intval($this->topicID)."";
      $ok= mysql_query(  $sql);
    }
}
?>

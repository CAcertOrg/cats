<?php
class Progress
{
  var $topic;
  var $progress;
  var $lp_id;
  var $incorrect_answers;
  var $percentArray;
  var $maximum;

    function Progress() {
      $this->progress=array();
      $this->incorrect_answers=array();
      $this->maximum=5;
      $this->topic=0;
      $this->lp_id=0;
      $this->percentArray=array();
    }
  
    function setTopic($t_id){
      $this->topic=$t_id;
    }
    
    function setLp_id($lp_id){
    $this->lp_id=$lp_id;
    }
  
     function setData($value){
       $this->progress=$value;
     }
    function getProgress(){
     $sql= "SELECT lp_id,date,number,correct,wrong FROM learnprogress WHERE user_id='".mysql_real_escape_string($_SESSION['profile']['id'])."' AND t_id='".mysql_real_escape_string($this->topic)."' AND root ='".mysql_real_escape_string($_SESSION['profile']['root'])."' order by date";
     $query = mysql_query($sql)  OR die(mysql_error()); 
     $i=1;
      while($progress =mysql_fetch_array($query,MYSQL_BOTH  )){   
        $this->progress[$i]['lp_id']=$progress['lp_id'];
        $this->progress[$i]['date']=$progress['date'];
        $this->progress[$i]['number']=$progress['number']; // in arra speichern
        $this->progress[$i]['correct']=$progress['correct'];
        $this->progress[$i]['wrong']=$progress['wrong'];
        $i++;
      }
    
    }
  
    function count() {
     $numberOfTests=count($this->progress);
     return $numberOfTests;
    }
  
    function showTable() {
      if(count($this->progress)==0) echo "<div class='h8'>".Global_07."</div>";
      else {
        echo"<br /> <br />";
        echo"<table class='table table_progress'>"; 
        echo "<tr>";
        echo"<td class='th th_pos'>".Global_10."</td>";
        echo"<td class='th th_pos_date'>".Global_04."</td>";
        echo"<td class='th th_count'>".Class_Progress_01."</td>";
        echo"<td class='th th_count'>".Global_03."</td>";
        echo "<td class='th th_buttons'></td>";
        echo"</tr>";
          for ($i=1;$i<=count($this->progress);$i++){ 
          echo "<tr>";
           echo"<td class='td'>$i</td>";
          echo"<td class='td'>".$this->progress[$i]['date']."</td>";
          echo"<td class='td'>".$this->progress[$i]['number']."</td>";
          if ($this->progress[$i]['number'] > 0) {
            $percent=($this->progress[$i]['correct']/$this->progress[$i]['number'])*100;
          } else {
            $percent = 0;
          }
          $percent=round ($percent,2);
          echo"<td class='td'>$percent %</td>";
          echo"<td class='td'> <a href='?site=progress&amp;action=showIncorrectAnswers&amp;lp_id=".$this->progress[$i]['lp_id']."&amp;t_id=$this->topic'><img src='images/details.png' class='linkimage' alt='' /></a></td>";
          echo "</tr>";   
          }   
        echo"</table>";
        }
    }
    
   function checkProgressData(){
      if(count($this->progress)==0) echo "<div class='h8'>".Global_07."</div>";
      else {
        $percentArray=array();
        $limit=count($this->progress);
          if($limit>$this->maximum){
            $k=($limit-$this->maximum)+1;
            $limit=($k+$this->maximum)-1;
            echo '<h5 class="centered">'.Class_Progress_02." ".Class_Progress_03." $this->maximum ".Class_Progress_04.".</h5>";
          } else $k=1;
          $j=0;
            
      for ($i=$k;$i<=$limit;$i++){ 
        if ($this->progress[$i]['number'] > 0) {
          $percent=($this->progress[$i]['correct']/$this->progress[$i]['number'])*100;
        } else {
          $percent=0;
        }
        $this->percentArray[$j][]=$this->progress[$i]['date'];
        $this->percentArray[$j][]=$percent; 
        $j++;
      }
      }
    }
    
    function showBalken(){
    
      $this->checkProgressData();
      $this->percentArray= serialize($this->percentArray);
      $this->percentArray=base64_encode ($this->percentArray);
      $titley=Global_15;
      $titlex=Global_04;
      echo "  <div id=\"learnprogress\">\n"; 
      echo "<img src='includes/graph_bib/bar.php?data=$this->percentArray&amp;learnpath=true&amp;titley=$titley&amp;titlex=$titlex' alt='' />";
      echo "</div>\n"; 
      
    }
    function showGraph(){
      $this->checkProgressData();
      $this->percentArray= serialize($this->percentArray);
      $this->percentArray=base64_encode ($this->percentArray);
      $titley=Global_15;
      $titlex=Global_04;
        echo "  <div id=\"learnprogress\">\n"; 
        echo "<img src='includes/graph_bib/curve.php?percentArray=$this->percentArray&amp;learnpath=true&amp;titley=$titley&amp;titlex=$titlex' alt='' />";
        echo "</div>\n"; 
      
    }
    
    function showPie(){
      echo "  <div id=\"learnprogress\">\n"; 
      echo "<img src='includes/graph_bib/pie.php' alt='' />";
      echo "</div>\n";
    }
   
    
    function getIncorrectAnswers()
    {
      $sql="SELECT q_id FROM answers_incorrect WHERE lp_id=".intval($this->lp_id)."";
      $query = mysql_query($sql);
      $i=1;
      while($incorrect_answers =mysql_fetch_array($query,MYSQL_BOTH  ))  
            {   
              $this->incorrect_answers[$i]['q_id']=$incorrect_answers['q_id'];
              $i++;
            }
      $this->showIncorrectAnswers();
    }
    
    function showIncorrectAnswers(){  
      echo "<form action='?site=progress&amp;action=showTable&amp;t_id=$this->topic' method='post'>";  
      echo "<fieldset  >";
      echo " <legend class='table_show_incorrect'>".Class_Progress_08." </legend> ";
      echo "<table class='table_show_incorrect'>";
    
    
        for ($i=1;$i<=count($this->incorrect_answers);$i++){
        echo"<tr>";
          echo "<td class='nr_incorrect' valign='top'> $i.) </td>";
          $sql="SELECT question,qt_id FROM questions WHERE q_id=".intval($this->incorrect_answers[$i]['q_id'])."";
          $query = mysql_query($sql);
          while($question =mysql_fetch_array($query,MYSQL_BOTH  )) {  
          if( $question['qt_id']==4){
          $questionText=$this->getFIBQuestion( $question['question']);
        
          echo"<td class='question_incorrect' valign='top'>".$questionText."</td>";
         
          }
          else{
            echo "<td class='question_incorrect' valign='top'>". $question['question']."</td>";
            }
          } 
          echo"</tr>";  
        } 
       if($this->progress [$this->lp_id]['wrong']>count($this->incorrect_answers)) {
         $number=$this->progress [$this->lp_id]['wrong']-count($this->incorrect_answers);
         echo"<tr>";
         echo "<td class='nr_incorrect' valign='top'>  </td>";
         echo"<td class='question_incorrect' valign='top' >".Class_Progress_06." $number  ".Class_Progress_07."</td>";
         echo"</tr>";
        }
      echo"<tr>";
      echo "<td class='nr_incorrect'>  </td>";
      echo"<td class='Button_row' > <input name='submit' class='Button_rightColumn' type='submit' value='".Global_02."'/></td> ";
      echo"</tr>";
      echo"</table>";
      echo "</fieldset>";
      echo "</form>";     
    }  
    
    function getFIBQuestion($question){
          $addSlashes= preg_quote( $question, '[^]'); // Slash hinzufügen wenn KLammer gefunden wird
          $array=explode('\\',$addSlashes); // String teilen
          $questionText= $question;
          if(substr_count($question,"[")==substr_count($question,"]")) { // gleiche anzahl von Klammer auf und zu
          for($i=1;$i<=substr_count($question,"[");$i++){ // Wird solange durchlaufne wie Klammern vorhanden sind
            $beginPos = strpos($questionText, "["); // Anfangspunkt festlegen
            $endPos=strpos($questionText, "]"); // Endpunkt festlegen
            $length=(($endPos+1)-$beginPos) ; // Länge der Strings ermitteln
            $answer=substr ($questionText,$beginPos,$length );// den String zwischen den Klammern suchen
            $questionText=str_replace($answer,'(xxx)', $questionText); // gespeicherten Wert aus string löschen
            $answer=str_replace("]",'', $answer); // Klammer entfernen
            $key = array_search($answer, $array);  
            $answer=str_replace("[",'', $answer); // Klammer entfernen     
           
            } 
          } 
          return $questionText;
    }
 }       
?>

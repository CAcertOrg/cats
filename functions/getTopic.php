<?php
  function getTopicProgress($t_id){
    
     // Wertprüfung
    $t_id=abs(intval($t_id));
    
    echo '<form action="index.php?site=progress&amp;action=showProgress&amp;action=showTable" method="post">';
    $button=Function_getTopic_01;
    $topic=new Topic;
    $topic->getActiveTopic();
    $arrayTopic = $topic->getTopicArray();
    echo " <div id=\"inner_box_top\">\n"; // In der Mitte der Inhalt
    showForm($t_id,$button,$arrayTopic );
  }
    
  function getTopicStatistic($t_id){
     // Wertprüfung
    $t_id=abs(intval($t_id));
    echo '<form action="index.php?site=statistic&amp;action=getStatisticQuestions" method="post">';  
    $button=Function_getTopic_02;
    $topic=new Topic;
    $topic->getTopic();
    $arrayTopic = $topic->getTopicArray();
    echo "<div>\n"; // In der Mitte der Inhalt
    showForm($t_id,$button,$arrayTopic );
  }
    
  function getTopicStartTest($t_id){
     // Wertprüfung
    $t_id=abs(intval($t_id));
    
    echo '<form action="index.php?site=start_test&amp;action=getQuestions" method="post">'; 
    $button=Function_getTopic_03;
    $topic=new Topic;
    $topic->getActiveTopic();
    $arrayTopic = $topic->getTopicArray();
    echo " <div id=\"inner_box_top\">\n"; // In der Mitte der Inhalt
    showForm($t_id,$button,$arrayTopic );    
    }
  
  function showForm($t_id,$button,$arrayTopic ){
    
    // Dateien einbinden 
    require_once($_SESSION['_config']['filepath']."classes/Topic.class.php");
    require_once($_SESSION['_config']['filepath']."includes/db_connect.inc");
    
    // Wertprüfung
    $t_id=abs(intval($t_id));
  
    
    echo"<label> <select class='dropdown_site' size='1' name='t_id' > ";
      for ($i=1;$i<=count($arrayTopic);$i++){
        if($t_id==$arrayTopic[$i]['t_id']) echo"<option selected='selected' value='".stripslashes($arrayTopic[$i]['t_id'])."'>".stripslashes($arrayTopic[$i]['topic'])."</option>";
          else echo"<option value='".stripslashes($arrayTopic[$i]['t_id'])."'>".stripslashes($arrayTopic[$i]['topic'])."</option>";
      }
    echo"</select></label>";
    echo' <label><input name="submit" class="Button" type="submit" value="' .$button.'"/></label> '; 
    echo"</div></form>";
    echo "<br />";  
  }
?>

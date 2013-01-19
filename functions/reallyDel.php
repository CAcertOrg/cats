<?php
  function reallyDelTopic($t_id){
    // WErtprüfung
    $t_id=abs(intval($t_id));
    
    echo"<form action='index.php?site=topic&amp;action=delTopic&amp;t_id=$t_id' method='post'>"; 
    echo "<fieldset >";
    echo " <legend>".Function_reallyDel_01."  </legend> ";
    echo "<label class='del'>".Function_reallyDel_02."</label>";
    echo "<br />";
    echo "<label class='del'>".Function_reallyDel_03." </label>";
    echo "<input name='submit' class='Button_right' type='submit' value='".Global_13."' />"; 
    echo "<input name='submit' class='Button_right' type='submit' value='".Global_14."' />"; 
    echo "</fieldset>";
    echo "</form>";
  }
  
  function reallyDelQuestion($q_id,$t_id){
   // Wertprüfung
    $t_id=abs(intval($t_id));
    $q_id=abs(intval($q_id));
    
    echo"<form action='index.php?site=topic&amp;action=delQuestion&amp;q_id=$q_id&amp;t_id=$topic_id' method='post'>"; 
    echo "<fieldset >";
    echo " <legend>".Function_reallyDel_01."</legend> ";
    echo "<label class='del'> ".Function_reallyDel_04."</label>";
    echo" <input name='submit' class='Button_right' type='submit' value='".Global_13."' />"; 
    echo" <input name='submit' class='Button_right' type='submit' value='".Global_14."' />"; 
    echo "</fieldset>";
    echo "</form>";
  }

?>

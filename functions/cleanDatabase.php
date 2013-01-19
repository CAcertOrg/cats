<?php
  function cleanDatabase(){  // Alle Fragen die keine Antworten besitzen werden gelöscht
    $sql_1="delete from statistics where q_id in (SELECT q_id from questions where active = ".abs(intval(0))." and not exists (select 1 from answers where questions.q_id=answers.q_id))";
    $query_1 = mysql_query($sql_1) OR die(mysql_error());
   
    $sql_2="delete from answers_incorrect where q_id in (SELECT q_id from questions where active =".abs(intval(0))." and not exists (select 1 from answers where questions.q_id=answers.q_id))";
    $query_2 = mysql_query($sql_2) OR die(mysql_error());
    
    $sql_3="delete from questions where active = ".abs(intval(0))." and not exists (select 1 from answers where questions.q_id=answers.q_id)";
    $query_3 = mysql_query($sql_3) OR die(mysql_error());
  }
?>

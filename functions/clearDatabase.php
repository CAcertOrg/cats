<?php
  function clearDatabase(){  // Alle Fragen die keine Antworten besitzen werden gelöscht

    $sql="SELECT q_id FROM questions WHERE active='".intval(0)."'";
    $query = mysql_query($sql) OR die(mysql_error());
   
   
      while($q_id= mysql_fetch_array( $query,MYSQL_BOTH )){
      $q_id= $q_id['q_id'];
      $sql_number="SELECT a_id FROM answers WHERE q_id='".intval($q_id)."' ";
      $query_number = mysql_query( $sql_number);
      $menge=mysql_num_rows($query_number);
        if($menge ==0){
          $sql_del="DELETE FROM questions WHERE q_id='".intval($q_id)."'";
          $query_del = mysql_query($sql_del);
          
          // statistiken bereingien 
          $sql_del_statistics="DELETE FROM statistics WHERE q_id='".intval($q_id)."'";
          $ok_statistics=mysql_query( $sql_del_statistics);
          
          // answers_incorrect bereinigen
         $sql_del_aIncorrect="DELETE FROM answers_incorrect WHERE q_id='".intval($q_id)."'";
         $ok_aIncorrect=mysql_query( $sql_del_aIncorrect);
         
           //Beschreibung löschen
          $sql_del_desc="DELETE FROM question_description WHERE q_id='".intval($q_id)."'";
          $ok_desc=mysql_query( $sql_del_desc); 
        }
     } 
    
  }
?>

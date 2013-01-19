<?php
 // Bereich für alle User zugänglich
 if($_SESSION['profile']['loggedin']==1){  
 
  // Objekte erzeugen
  $topic=new Topic();
  $progress=new Progress(); 
  
  // Überprüfung / Wertzuweisung
  $action=''; if(isset($_GET['action'])) $action=strval($_GET['action']);
  $topic=0; if(isset($_REQUEST["t_id"]))$topic=abs(intval($_REQUEST["t_id"]));
  
  // Übeprüfung auf buchstaben (keine Zahlen zugelassen)
  if(!ctype_alpha($action)) unset($action);
  
    // als Tabelle zeigen
    if($action == "showTable"){ 
      $progress->setTopic($topic);
      $progress->getProgress();
      $progress->showTable();
      }
      
       // als Liniendiagramm anzeigen
       if($action == "showGraph") { 
        $progress->setTopic($topic);
        $progress->getProgress();
        $progress->showGraph();
       }
       
       // als Balkendiagramm anzeigen
        if($action == "showBalken"){ 
        $progress->setTopic($topic);
        $progress->getProgress();
        $progress->showBalken();  
       }
       
         if($action == "showIncorrectAnswers"){
         
          // Überprüfung / Wertzuweisung
          $lp_id=0; if($_REQUEST["lp_id"])$lp_id=abs(intval($_REQUEST["lp_id"]));
         
          $progress->setTopic($topic);
          $progress->getProgress();
          $progress->setLp_id($lp_id);
          $progress->getIncorrectAnswers();
         }      
 }
else echo "<h5 class='centered'>".Global_01.'</h5>';

?>

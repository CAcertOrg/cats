<?php

 function getlang(){

  if(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='DE'){
   include_once ("lang/german.php");
  } elseif(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='FR'){
   include_once ("lang/french.php");
  } elseif(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='NL'){
   include_once ("lang/dutch.php");
  } elseif(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='ES'){
   include_once ("lang/spanish.php");
  } elseif(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='CZ'){
   include_once ("lang/czech.php");
  }
  else{
   include_once ("lang/english.php");
  }

 }

 function switchlang(){
  if(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='EN')  include_once ("lang/english.php");
  elseif(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='FR')  include_once ("lang/french.php");
  elseif(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='NL')  include_once ("lang/dutch.php");
  elseif(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='ES')  include_once ("lang/spanish.php");
  elseif(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='CZ')  include_once ("lang/czech.php");
  else  include_once ("lang/german.php");
 }


?>

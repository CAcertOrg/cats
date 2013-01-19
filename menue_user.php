<?php
  echo ' <div id="menu_right">'; // In der Mitte der Inhalt 
  if(isset($_SESSION['profile']['loggedin']) && $_SESSION['profile']['loggedin']==1) {
    echo '<a class="login" href="?site=login&amp;id=logout">'.Menue_03."</a>";
  } else {
    echo '<a class="login" href="https://'.$_SESSION['_config']['securehostname'].'/'.$_SESSION['_config']['folder'].'index.php?site=login">'.Menue_02.'</a>';
  }
  if(isset($_SESSION['profile']['language']) && $_SESSION['profile']['language']=='DE') {
    echo ' <a class="help" href="doku/user_DE.pdf">'.Menue_01.'</a>';
  } else {
    echo' <a class="help" rel="help" href="doku/user_EN.pdf">'.Menue_01.'</a>';
  }
  if (isset($_SESSION['profile']['loggedin']) && $_SESSION['profile']['loggedin']==1) {
    echo' <a class="help" href="?site=showCertificateInfo">Info</a>';  
  }
  echo "</div>";
  
  echo ' <div id="menue_left">'; // In der Mitte der Inhalt 
  if(isset($_SESSION['profile']['loggedin']) && $_SESSION['profile']['loggedin']==1 ){
    echo'<a href="?site=start_test">'.Menue_06.'</a>';
    echo'<a href="?site=progress">'.Menue_04.'</a>';
  }
  echo "</div>\n";
?>

<?php

  echo ' <div id="menu_right">'; 
  if($_SESSION['profile']['loggedin']==1)echo '<a class="login" href="?site=login&amp;id=logout">'.Menue_03.'</a>';
  else echo '<a class="login" href="?site=login">'.Menue_02.'</a>';
  if($_SESSION['profile']['language']=='DE')echo ' <a class="help" rel="help" href="doku/admin_DE.pdf">'.Menue_01.'</a>';
  else echo ' <a class="help" rel="help" href="doku/admin_EN.pdf">'.Menue_01.'</a>';
  if($_SESSION['profile']['loggedin']==1)echo ' <a class="help" href="?site=showCertificateInfo">Info</a>';  
  echo '</div>';
      
  echo ' <div id="menue_left">'; 
  if($_SESSION['profile']['loggedin']==1){
    echo '<a href="?site=topic">'.Menue_07.'</a>';
    echo '<a href="?site=statistic">'.Menue_05.'</a>';
    echo '<a href="?site=start_test">'.Menue_06.'</a>';
    echo '<a href="?site=progress">'.Menue_04.'</a>';
  }
  echo "</div>\n";
?>

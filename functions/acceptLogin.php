<?php

 function showCertificateInfos(){
  echo "<fieldset>";   
  echo '<legend class="info">'.accept_Login_02.'</legend>';
  echo "<h3>".accept_Login_03."</h3>";
  echo "<h6><label class='left_info'>".accept_Login_04."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$_SERVER['SSL_CLIENT_S_DN_CN']."<br /><br />";
  echo "<label class='left_info'>".accept_Login_05."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$_SERVER['SSL_CLIENT_M_SERIAL']."<br /><br />";
  echo "<label class='left_info'>".accept_Login_06." </label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$_SERVER['SSL_CLIENT_S_DN_Email']."<br /><br /></h6>";
  echo " <h3>".accept_Login_07."</h3>";
  echo "<h6><label class='left_info'>".accept_Login_04."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$_SERVER['SSL_CLIENT_I_DN_CN']."<br /><br />";
  echo "<label class='left_info'>".accept_Login_08."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$_SERVER['SSL_CLIENT_I_DN_O']."<br /><br />";
  echo "<label class='left_info'>".accept_Login_09."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$_SERVER['SSL_CLIENT_I_DN_OU']."<br /><br /></h6>";
  echo " <h3>".accept_Login_13." </h3>";
  echo "<h6><label class='left_info'>".accept_Login_10."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$_SERVER['SSL_CLIENT_V_START']."<br /><br />";
  echo "<label class='left_info'>".accept_Login_11."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$_SERVER['SSL_CLIENT_V_END']."<br /><br /></h6>";
  echo "</fieldset>";              
 }
 
 function acceptLogin(){
  echo '<form class="info" action="index.php?site=accept_login" method="post"><div>';
  echo '<h4>'.accept_Login_01.'<br /></h4>';
  showCertificateInfos();
  echo '<h4>'.accept_Login_12.'<br /></h4>';
  echo ' <input name="submit" class="Button_info_left" type="submit" value="'.Global_13.'" />'; 
  echo ' <input name="submit" class="Button_info_right" type="submit" value="'.Global_14.'" />';
  echo "</div></form>";
 }

?>

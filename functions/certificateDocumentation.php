<?php
 function showCdForm(){
  echo "<fieldset>";   
  echo '<legend class="info centered"> </legend> ';
  
  echo "<table class='cDOptionTable'>";
  echo "<tr>";
  
  if($_SESSION['userInformation']['post']==1 )echo "<td class='td_cDTable_point' valign='top'> <input type='radio' name='perPost' checked='no' value='no' /></td>";
  else echo "<td class='td_cDTable_point' valign='top'> <input type='radio' name='perPost' checked='yes' value='no' /></td>";

  echo "<td class='td_cDTable_field' >".certificateDocu_02."</td>";
  echo "</tr>";
  
  
  echo "<tr>";
  echo "<td class='td_cDTable_point' valign='top'> <input type='radio' name='perPost'  value='yes_mail' /></td>";
  echo "<td class='td_cDTable_field'  >".certificateDocu_03."</td>";
  echo "</tr>";
  
  echo "<tr>";
  if($_SESSION['userInformation']['post']==1)echo "<td class='td_cDTable_point' valign='top'> <input type='radio' name='perPost' checked='yes' value='yes_post' /></td>";
  else echo "<td class='td_cDTable_point' valign='top'> <input type='radio' name='perPost'  value='yes_post' /></td>";
  echo "<td class='td_cDTable_field' >".certificateDocu_04."</td>";
  echo "</tr>";
  
  echo"<tr>";
  echo"<td class='td_cDTable_point'></td>";
  echo"<td class='td_cDTable_field'>";
  echo "<table class='cDTable'>";
  
  echo "<tr>";
  echo "<td class='td_cDTable_text'>".certificateDocu_05."</td>";
  echo "<td class='td_cDTable_point'> :</td>";
  if($_SESSION['userInformation']['firstname']==null && $_SESSION['userInformation']['post']==1)echo "<td class='td_cDTable_field' ><input name='firstname' class='marked' value='".$_SESSION['userInformation']['firstname']."' size='40' /></td>";
  else echo "<td class='td_cDTable_field'><input name='firstname' value='".$_SESSION['userInformation']['firstname']."' size='40' /></td>";
  echo "</tr>";
  
  echo "<tr>";
  echo "<td class='td_cDTable_text'>".certificateDocu_06."</td>";
  echo "<td class='td_cDTable_point'> :</td>";
  if($_SESSION['userInformation']['surename']==null && $_SESSION['userInformation']['post']==1)echo "<td class='td_cDTable_field'> <input name='surename' class='marked'  value='".$_SESSION['userInformation']['surename']."' size='40' /></td>";
  else echo "<td class='td_cDTable_field'> <input name='surename' value='".$_SESSION['userInformation']['surename']."' size='40' /></td>";
  echo "</tr>";
  
  echo "<tr>";
  echo "<td class='td_cDTable_text'>".certificateDocu_07."</td>";
  echo "<td class='td_cDTable_point'> :</td>";
  if($_SESSION['userInformation']['street']==null && $_SESSION['userInformation']['post']==1)echo "<td class='td_cDTable_field'> <input name='street'  class='marked' value='".$_SESSION['userInformation']['street']."' size='40' /> ";
  else echo "<td class='td_cDTable_field'> <input name='street'  value='".$_SESSION['userInformation']['street']."' size='40' /> ";
  
  if($_SESSION['userInformation']['housenumber']==null && $_SESSION['userInformation']['post']==1)echo "<input name='housenumber' class='marked' value='".$_SESSION['userInformation']['housenumber']."' size='5' /></td>";
  else echo "<input name='housenumber'  value='".$_SESSION['userInformation']['housenumber']."' size='5' /></td>";
  echo "</tr>";
  
  echo "<tr>";
  echo "<td class='td_cDTable_text'> ".certificateDocu_08."</td>";
  echo "<td class='td_cDTable_point'> :</td>";
  if($_SESSION['userInformation']['zipcode']==null && $_SESSION['userInformation']['post']==1) echo "<td class='td_cDTable_field'> <input name='zipcode' class='marked' value='".$_SESSION['userInformation']['zipcode']."' size='40' /></td>";
  else echo "<td class='td_cDTable_field'> <input name='zipcode' value='".$_SESSION['userInformation']['zipcode']."' size='40' /></td>";
  echo "</tr>";
  
  echo "<tr>";
  echo "<td class='td_cDTable_text'> ".certificateDocu_09."</td>";
  echo "<td class='td_cDTable_point'> :</td>";
  if($_SESSION['userInformation']['city']==null && $_SESSION['userInformation']['post']==1) echo "<td class='td_cDTable_field'><input name='city' class='marked' value='".$_SESSION['userInformation']['city']."' size='40' /></td>";
  else echo "<td class='td_cDTable_field'><input name='city' value='".$_SESSION['userInformation']['city']."' size='40' /></td>";
  echo "</tr>";
  
  echo "<tr>";
  echo "<td  class='td_cDTable_text'>".certificateDocu_10."</td>";
  echo "<td class='td_cDTable_point'> :</td>";
  if($_SESSION['userInformation']['state']==null && $_SESSION['userInformation']['post']==1)echo "<td class='td_cDTable_field'><input name='state' class='marked' value='".$_SESSION['userInformation']['state']."' size='40' /></td>";
  else echo "<td class='td_cDTable_field'><input name='state' value='".$_SESSION['userInformation']['state']."' size='40' /></td>";
  echo "</tr>";
  
  echo "<tr>";
  echo "<td class='td_cDTable_text'>  ".certificateDocu_11."</td>";
  echo "<td class='td_cDTable_point'> :</td>";
  if($_SESSION['userInformation']['country']==null && $_SESSION['userInformation']['post']==1)echo "<td class='td_cDTable_field'><input name='country' class='marked value='".$_SESSION['userInformation']['country']."' size='40' /></td>";
  else echo "<td class='td_cDTable_field'><input name='country' value='".$_SESSION['userInformation']['country']."' size='40' /></td>";
  echo "</tr>";
  echo"</table>";
  echo"</td>";

  echo"</table>";
  
   
  echo "</fieldset>";              
 }
 
 function cD(){
  echo "<form class='certificateDocu' action='index.php?site=certificateDocumentation' method='post'>"; 
  echo "<h4>".certificateDocu_01." <br /></h4> ";
  showCdForm();
  echo" <input name='submit' class='Button_middle' type='submit' value='".Button_11."' />";
  echo "</form>";
 }

?>

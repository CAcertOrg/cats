<?php
  // Formular der Frage-Erstellung

  function showQuestionForm($arrayTopic){
    // Wertprüfung
    $error=''; if(isset($_SESSION['values']['error'])) $error=strval($_SESSION['values']['error']);

    echo "<form class='collect_question' action='index.php?site=collect_question&amp;action=save_question&amp;set=1' method='post'>";
    echo "<fieldset>";
    echo " <legend>".Collect_Question_03." </legend>";
    echo "<table class='table_show_question'>";
    echo "<tr>";
    echo"<td class='name'>".Global_09."</td>";
    echo"<td class='left_point'> :  </td>";
    echo "<td class='text'>";
      if(!isset($_SESSION['values']['question']['t_id']) && $error=='missing') {
        echo"<select size='1' class='dropdown_right marked' name='t_id' > ";
      } else { echo"<select size='1' class='dropdown_right' name='t_id' > "; }
          for ($i=1;$i<=count($arrayTopic);$i++){
            if($_SESSION['values']['t_id']==$arrayTopic[$i]['t_id']){
              echo"<option  value='".$arrayTopic[$i]['t_id']."' selected='selected'>".stripslashes($arrayTopic[$i]['topic'])."</option>";
            }
              else echo"<option value='".$arrayTopic[$i]['t_id']."'>".stripslashes($arrayTopic[$i]['topic'])."</option>";
          }
      echo"</select>";
      echo"</td>";
      echo "</tr>";

      echo "<tr>";
      echo"<td class='name'>".Global_12."</td> ";
      echo"<td class='left_point'> :  </td>";
      echo "<td class='text'>";

      $sql_qtypes=sprintf("SELECT `qt_id`, `qt_desc` AS `type` FROM `questiontype_v2` WHERE `lang`='%s'", mysql_real_escape_string($_SESSION['profile']['language']));
      $query_qtypes = mysql_query($sql_qtypes) or die(mysql_error());

        if(!isset($_SESSION['values']['question']['qt']) && $error=='missing')echo"<select size='1' class='dropdown_right marked' name='qt' > ";
          else   echo"<select size='1' class='dropdown_right' name='qt' > ";
            while($qtypes =mysql_fetch_array($query_qtypes ,MYSQL_BOTH  )){
              if($qtypes['qt_id']==$_SESSION['values']['question']['qt']) echo"<option  value='".$qtypes['qt_id']."' selected='selected'>".$qtypes['type']."</option>";
              else echo"<option  value='".$qtypes['qt_id']."'>".$qtypes['type']."</option>";
            }
        if(!$_SESSION['values']['question']['qt']) echo"<option  value='' selected='selected'></option>";
        echo"</select>";
        echo"</td>";
        echo "</tr>";

          echo "<tr>";
        echo"<td class='name'>".Global_08." </td>";
        echo"<td class='left_point'> :  </td>";
        echo "<td class='text'>";

          if(!isset($_SESSION['values']['question']['questionText']) && $error=='missing')echo" <textarea name='questionText' class='TextField_big marked' rows='2' cols='81' >$questionText</textarea> ";
          else {
            echo" <textarea name='questionText' class='TextField_big' rows='2' cols='81' >";
            if (isset($_SESSION['values']['question']['questionText'])) echo $_SESSION['values']['question']['questionText'];
            echo "</textarea> ";
          }

          if(isset($new) && ($new==true)) echo" <input name='new' type='hidden' value='true' /> ";

          echo"</td>";
          echo"</tr>";

          echo "<tr>";
          echo"<td class='name'>".Global_20." </td>";
          echo"<td class='left_point'>  </td>";
          echo "<td class='text'></td>";
          echo "</tr>";


          echo"<tr>";
          echo"<td class='name'><input  class='left_answer_small marked'   type='checkbox'  value='1' name='description' /></td>";
          echo"<td class='left_point'></td>";
          echo" <td class='text'><textarea name='descriptionText'   class='TextField_big' rows='1' cols='79' ></textarea> </td>";
          echo "</tr>";

          echo"<tr>";
          echo"<td class='name'></td>";
          echo"<td class='left_point'></td>";
          echo" <td class='Button_row'> <input name='submit' class='Button_rightColumn' type='submit' value='".Button_11."' /> </td>";
          echo"</tr>";
          echo"</table>";
          echo "</fieldset>";
          echo"</form>";
  }
?>

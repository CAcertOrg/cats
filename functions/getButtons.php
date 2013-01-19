<?php
/**
 * Gets the buttons for the right navigation
 */
function getButtons () {
  // get topic id
  $t_id=0;
  if (isset($_POST['t_id'])) {
    $t_id=$_POST['t_id'];
  } elseif (isset($_REQUEST['t_id'])) {
    $t_id=$_REQUEST['t_id'];
  } elseif (isset($_SESSION['values']['topic']['t_id'])) {
    $t_id=$_SESSION['values']['topic']['t_id'];
  }

  // get action
  $action="";
  if (isset($_SESSION['values']['action'])) {
    $action=$_SESSION['values']['action'];
  }

  // get value
  $value="";
  if (isset($_SESSION['values']['interaction'])) {
    $value=$_SESSION['values']['interaction'];
  }

  // check whether a user is logged in
  if (isset($_SESSION['profile']['loggedin']) && $_SESSION['profile']['loggedin'] == 1) {
    switch (isset($_SESSION['values']['site']) ? $_SESSION['values']['site'] : 0) {
    case "topic" : // site value is topic
      echo '<div id="inner_box_top">';
      // only admins will see this
      if (isset($_SESSION['profile']['admin']) && $_SESSION['profile']['admin'] == 1) {
        echo '<br />';
        if ($action != 'showDetails' && $action != 'getQuestions') {
          printf('<a class="link_topic" ' .
                 'href="?site=topic&amp;action=new_topic">%s</a><br />',
                 Button_01);
        }
        if ($action == 'new_topic' || $action == 'getQuestions' ||
            $action == 'showDetails') {
          printf('<a class="link_topic" href="?site=topic">%s</a>',
                 Button_02);
        }
        if ($action == 'showDetails') {
          // get topic id from session, again? already done in line 12
          $t_id = $_SESSION['values']['topic']['t_id'];
          printf('<br /><a class="link_topic" ' .
                 'href="?site=topic&amp;action=getQuestions&amp;t_id=%d">' .
                 '%s</a><br />', $t_id, Button_03);
        }
        if ($action == 'getQuestions') {
          // write topic id to session, why is this done in a view function?
          $_SESSION['values']['topic']['t_id']=$t_id ;
          printf('<br /><a class="link_topic" ' .
                 ' href="?site=collect_question&amp;t_id=%d&amp;new=true">' .
                 '%s</a>', $t_id, Button_04);
        }
      }
      echo "</div>\n";
      break;
    case "progress": // site value is progress
      if (!$action && !$value) {
        // unset topic if action and value are both not true
        $t_id = 0;
        if (isset($SESSION['values']['topic'])) unset($SESSION['values']['topic']);
      }
      // get the topic?
      include ("getTopic.php");
      // store topic id in session
      $_SESSION['values']['topic']['t_id'] = $t_id;
      if (!$action && !$value) {
        // unset topic again if action and value are both not true
        unset ($_SESSION ['values']['topic']);
      }
      getTopicProgress($t_id); // Auswahlfenster anzeigen
      if ($action == 'showProgress') {
        echo "<div id=\"inner_box_bottom\">\n"; // In der Mitte der Inhalt
        printf('<a class="link_topic active" ' .
               'href="?site=progress&amp;action=showTable&amp;t_id=%d">' .
               '%s</a><br />', $t_id, Button_05);
        printf('<a class="link_topic" ' .
               'href="?site=progress&amp;action=showGraph&amp;t_id=%d">' .
               '%s</a><br />', $t_id, Button_06);
        printf('<a class="link_topic" ' .
               'href="?site=progress&amp;action=showBalken&amp;t_id=%d">' .
               '%s</a><br />', $t_id, Button_07);
        echo "</div>\n";
      } elseif ($action != null) {
        echo "<div id=\"inner_box_bottom\">\n";
        printf('<a class="link_topic%s" ' .
               'href="?site=progress&amp;action=showTable&amp;t_id=%d">' .
               '%s</a><br />', ($action == 'showTable') ? ' active' : '',
               $t_id, Button_05);
        printf('<a class="link_topic%s" ' .
               'href="?site=progress&amp;action=showGraph&amp;t_id=%d">' .
               '%s</a><br />', ($action == 'showGraph') ? ' active' : '',
               $t_id, Button_06);
        printf('<a class="link_topic%s" ' .
               'href="?site=progress&amp;action=showBalken&amp;t_id=%d">' .
               '%s</a><br />', ($action == 'showBalken') ? ' active' : '',
               $t_id, Button_07);
        echo "</div>\n";
      } 
      break;
    case "start_test": // site value is start_test
      if(!$action && !$value){
        // unset topic id
        unset($t_id);
        if (isset($_SESSION ['values']['topic'])) unset($_SESSION ['values']['topic']);
      }
      // get the topic?
      include("getTopic.php");
      getTopicStartTest(isset($t_id) ? $t_id : 0);
      break;
    case "statistic": // site value is statistic
      // only admins will see this
      if (isset($_SESSION['profile']['admin']) && $_SESSION['profile']['admin'] == 1) {
        if(!$action && !$value){
          // unset topic id
          $t_id = 0;
          if (isset($SESSION ['values']['topic'])) unset($SESSION ['values']['topic']);
        }
        
        echo "<div id=\"inner_box_top\">\n"; // In der Mitte der Inhalt
        printf('<br /><a class="link_topic" href="?site=statistic&amp;action=userInfo">%s</a><br />', Button_18);
        // get the topic?
        include ("getTopic.php");
        getTopicStatistic($t_id);
        if ($t_id) {
          if ($action == 'topTen' || $value=='topTen') {
            $classpart = ' active';
            $value = 'topTen';
          } else {
            $classpart = '';
          }
          printf('<br /><a class="link_topic%s" ' .
                 'href="?site=statistic&amp;action=topTen&amp;t_id=%d">%s</a>',
                 $classpart, $t_id, Button_08);
          if ($action == 'flopTen' || $value=='flopTen') {
            $classpart = ' active';
            $value = 'flopTen';
          } else {
            $classpart = '';
          }
          printf('<br /><a class="link_topic%s" ' .
                 'href="?site=statistic&amp;action=flopTen&amp;t_id=%d">' .
                 '%s</a>', $classpart, $t_id, Button_09);
          printf('<br /><a class="link_topic%s" ' .
                 'href="?site=statistic&amp;action=showPassed&amp;t_id=%d">' .
                 '%s</a>', ($action == 'showPassed') ? ' active' : '',
                 $t_id, Button_17);
          printf('<br /><a class="link_topic%s" ' .
                 'href="?site=statistic&amp;action=showStatisticTest' .
                 '&amp;t_id=%d">%s</a>',
                 ($action == 'showStatisticTest') ? ' active' : '',
                 $t_id, Button_19);
        }
        echo "</div>\n"; // end of div inner_box_top
        // check condition again so that div inner_box_top is always closed
        if ($t_id) {
          if ($action && $action!= 'getStatisticQuestions' &&
              $action!='showPassed' && $action !='showStatisticTest') {
            echo "<div id=\"inner_box_bottom\">\n";
            printf('<br /><a class="link_topic%s" ' .
                   'href="?site=statistic&amp;action=showGraph&amp;value=%s' .
                   '&amp;t_id=%d">%s</a><br/>',
                   ($action == 'showGraph') ? ' active' : '',
                   $value, $t_id, Button_06);
            printf('<a class="link_topic%s" ' .
                   'href="?site=statistic&amp;action=showBar&amp;value=%s' .
                   '&amp;t_id=%d">%s</a><br/>',
                   ($action = 'showBar') ? ' active' : '',
                   $value, $t_id, Button_07);
            echo "</div>\n";
          }
        }
      }
      break;
    case "showCertificateInfo": // site value is showCertificateInfo
      // do nothing for showCertificateInfo
      break;
    }
  }
}
?>


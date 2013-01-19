<?php


function getFalseAnswers($q_id) {
  //Initialisierung
  $number=0;
  $sql_incorrectAnswers="SELECT count(q_id) as anzahl FROM  answers_incorrect WHERE q_id=".intval($q_id)."";
  $query_incorrectAnswers= mysql_query ($sql_incorrectAnswers) OR die(mysql_error());
  while($incorrectAnswers =mysql_fetch_array($query_incorrectAnswers,MYSQL_BOTH  )){
    $number=$incorrectAnswers['anzahl'];
    return $number;
  }
  }

function showBar($value){
  $value= serialize($value);
  $value=base64_encode ($value);
  $titley=Global_15;
  $titlex=Global_18;
  $title='statistic';
  echo "  <div id=\"learnprogress\">\n";
  echo "<img src='includes/graph_bib/bar.php?data=$value&amp;titley=$titley&amp;titlex=$titlex' alt='' />";
  echo "</div>\n";
}

function showPie($value){
  $value= serialize($value);
  $value=base64_encode ($value);

  echo "  <div id=\"learnprogress\">\n";
  echo "<img src='includes/graph_bib/pie.php?data=$value' alt='' />";
  echo "</div>\n";
}

function showGraph($value){
  $value= serialize($value);
  $value=base64_encode ($value);
  $titley=Global_15;
  $titlex=Global_17;
  $title='statistic';
  echo "  <div id=\"learnprogress\">\n";
  echo "<img src='includes/graph_bib/curve.php?percentArray=$value&amp;title=$title&amp;titley=$titley' alt='' />";
  echo "</div>\n";
}

function getQuestions($t_id){
  $sql="  SELECT questions.q_id, count FROM questions JOIN statistics ON questions.q_id = statistics.q_id AND t_id =".intval($t_id)." AND count>0 ORDER BY count DESC";
  $query=mysql_query($sql);
  $i=0;
  while($qu =mysql_fetch_array($query ,MYSQL_BOTH  )){
    $question[$i]['q_id']= $qu['q_id'];
    $question[$i]['count']= $qu['count'];
    $i++;
  }
  for($i=0;$i<count($question);$i++){
    $sqlGetIncorrect="SELECT count(q_id) as anzahl FROM  answers_incorrect WHERE q_id=".intval($question[$i]['q_id'])."";
    $queryGetIncorrect= mysql_query ($sqlGetIncorrect)OR die(mysql_error());
    while($incorrect=mysql_fetch_array($queryGetIncorrect,MYSQL_BOTH  )) {
      $quest[$i]['q_id']=$question[$i]['q_id'];
      $quest[$i]['count']=$question[$i]['count'];
      $quest[$i]['countCorrect']=$question[$i]['count']-$incorrect['anzahl'];
      $quest[$i]['countIncorrect']=$incorrect['anzahl'];
      if( $quest[$i]['countCorrect']!= $quest[$i]['count']){
        $quest[$i]['percentagCorrect']=($quest[$i]['countCorrect']/$question[$i]['count'])*100;
        $quest[$i]['percentagCorrect'] = round($quest[$i]['percentagCorrect'],2); // nur 2 Nachkommastellen anzeigen
      }
      else  $quest[$i]['percentagCorrect']=100;
    }
  }
  return $quest;
}

function getQuestionNames($questions){
  for($i=0;$i<count($questions);$i++){
    $sqlGetName="SELECT question from questions where q_id=".intval($questions[$i]['q_id'])."";
    $queryGetName= mysql_query ($sqlGetName)OR die(mysql_error());
    while($name=mysql_fetch_array($queryGetName,MYSQL_BOTH  ))   {
      $questions[$i]['question']= stripslashes($name[question]);
    }
  }
  return $questions;
}

function getTopQuestions($quest){
  tableHead();
  function cmp($a, $b) {
    if($a["count"]>$b["count"]) return -1 ;
    else  return 1 ;
  }
  usort($quest, "cmp");
  if(count($quest)<10) $limit=count($quest);
  else $limit=10;
  getData($limit,$quest);
}

function getTopQuestionValues($quest){
  function cmpTopQ($a, $b) {
    if($a['count']>$b['count']) return -1 ;
    else  return 1 ;
  }
  usort($quest, "cmpTopQ");
  if(count($quest)<10) $limit=count($quest);
  else $limit=10;
  for($i=0;$i<$limit;$i++){
    $j=$i+1;
    $quest[$i][]=$quest[$i]['percentagCorrect']; // wert
  }

  return  $quest;
}

function getStatisticInfoPie($t_id){

  $sql= "SELECT percentage FROM topics WHERE t_id=".intval($t_id)."";
  $query= mysql_query($sql);
  $value = mysql_fetch_assoc($query);
  $percentageToPass=$value['percentage'];


  // durchgefallen
  $sql2= "SELECT count(lp_id)as failed FROM learnprogress WHERE t_id=".intval($t_id)." and  percentage <= $percentageToPass";
  $query2=mysql_query($sql2);
  $value2 = mysql_fetch_assoc($query2);
  $failed=$value2['failed'];
  if(!$failed)$failed=0;


  // bestandende Tests
  $sql3= "SELECT count(user_id)as passed FROM learnprogress WHERE t_id=".intval($t_id)." and  percentage >= $percentageToPass ";
  $query3=mysql_query($sql3);
  $value3=mysql_fetch_assoc($query3);
  $passed=$value3['passed'];
  if(!$passed)$passed=0;



  $value = array(array(Statistic_04, $passed),array(Statistic_05, $failed));
  return $value;
}


function getTopTenValues($quest){
  function cmp($a, $b) {
    if($a["percentagCorrect"]>$b["percentagCorrect"]) return -1 ;
    else  return 1 ;
  }
  usort($quest, "cmp"); // nach percentageCorrect absteigend sortieren
  if(count($quest)<10) $limit=count($quest);
  else $limit=10;
  for($i=0;$i<$limit;$i++){
    $j=$i+1;
    $question[$i]['q_id']=$quest[$i]['q_id']; // wert
    $question[$i][]=$quest[$i]['percentagCorrect']; // wert
  }

  return  $question;
}


function getFlopTenValues($quest){
  function cmp($a, $b) {
    if($a["percentagCorrect"]>$b["percentagCorrect"]) return 1 ;
    else  return -1 ;
  }
  usort($quest, "cmp");
  if(count($quest)<10) $limit=count($quest);
  else $limit=10;
  for($i=0;$i<$limit;$i++){
    $j=$i+1;
    $question[$i]['q_id']=$quest[$i]['q_id']; // wert
    $question[$i][]=$quest[$i]['percentagCorrect']; // wert
  }
  return  $question;
}

function tableHead(){
  echo "<br />";
  echo"<table class='tabel table_standard '>";
  echo "<tr>";
  echo"<td class='th th_pos'>".Global_10."</td>";
  echo"<td class='th th__pos'>".Global_06."</td>";
  echo"<td class='th th_question'>".Global_08." </td>";
  echo"<td class='th th_count'>".Global_11."</td>";
  echo "<td class='td_statistic_header_count'>".Global_03."</td>";
  echo"</tr>";
}

function getData($limit,$quest){
  for($i=0;$i<$limit;$i++) {
    $j=$i+1;
    $qu= new Question();
    $topics= new Topic();
    $qu-> setID($quest[$i]['q_id']);
    $qu->loadQuestion();
    $qu_text=$qu->getQuestion();
    echo "<tr>";
    echo"<td class='td'>$j</td>";
    echo"<td class='td'>".$quest[$i]['q_id']."</td>";
    echo"<td class='td'>".stripslashes($qu_text)."</td>"; // array Werte ausgeben
    echo"<td class='td'> ".  $quest[$i]['count']."</td>";
    echo"<td class='td' > ". $quest[$i]['percentagCorrect']."%</td>";
    echo "</tr>";
  }
}

function getTopTenCorrect($quest){
  tableHead();
  function cmp($a, $b) { // nach percentageCorrect sortieren
    if($a["percentagCorrect"]>$b["percentagCorrect"]) return -1 ;
    else  return 1 ;
  }
  usort($quest, "cmp"); // nach percentageCorrect absteigend sortieren
  if(count($quest)<10) $limit=count($quest);
  else $limit=10;
  getData($limit,$quest);
  echo "</table>";
}

function getFlopTenCorrects($quest){
  tableHead();
  function cmp($a, $b) { // nach percentageCorrect sortieren
    if($a["percentagCorrect"]>$b["percentagCorrect"]) return 1 ;
    else  return -1 ;
  }
  usort($quest, "cmp"); // nach percentageCorrectaufsteigen sortieren
  if(count($quest)<10) $limit=count($quest);
  else $limit=10;
  getData($limit,$quest);
}

function getUserInfo(){
  // registrierte Benutzer
  $sql="SELECT count(CN_name) as number FROM user";
  $query = mysql_query($sql);
  $num = mysql_fetch_assoc($query);
  $number=$num['number'];

  // Admin Benutzer
  $sqlAdmin="SELECT count(user_id) as numberAdmin FROM user WHERE admin='".intval(1)."'";
  $queryAdmin = mysql_query($sqlAdmin) OR die(mysql_error());
  if(empty($queryAdmin))  $numberAdmin=0;
  else{
    $numAdmin = mysql_fetch_assoc($queryAdmin);
    $numberAdmin=$numAdmin['numberAdmin'];
  }
  // Benutzer Class I Zertifikat
  $sqlRoot="SELECT count(CN_name) as numberRoot1 FROM user WHERE root='".mysql_real_escape_string("CA Cert Signing Authority")."'";
  $queryRoot = mysql_query($sqlRoot);
  $numRoot = mysql_fetch_assoc($queryRoot);
  $numberRoot1=$numRoot['numberRoot1'];

  // Benutzer Class III Zertifikat
  $numberRoot3=$number-$numberRoot1;

  // Benutzer Post zusendung
  $sqlPost="SELECT count(CN_name) as numberPost FROM user WHERE sendCert='".mysql_real_escape_string("post")."'";
  $queryPost = mysql_query($sqlPost);
  $numPost = mysql_fetch_assoc($queryPost);
  $numberPost=$numPost['numberPost'];

  // Benutzer Email zusendung
  $sqlMail="SELECT count(CN_name) as numberMail FROM user WHERE sendCert='".mysql_real_escape_string("email")."'";
  $queryMail = mysql_query($sqlMail);
  $numMail = mysql_fetch_assoc($queryMail);
  $numberMail=$numMail['numberMail'];

  // Benuter, die kein Zertifikat möchten
  $numberNo=$number-($numberMail+$numberPost);

  // Spracheinstellung der Benutzer "DE"
  $sqlDE="SELECT count(CN_name) as numberDE FROM user WHERE lang='".mysql_real_escape_string("DE")."'";
  $queryDE = mysql_query($sqlDE);
  $numDE = mysql_fetch_assoc($queryDE);
  $numberDE=$numDE['numberDE'];

  // Spracheinstellung der Benutzer "FR"
  $sqlFR="SELECT count(CN_name) as numberFR FROM user WHERE lang='".mysql_real_escape_string("FR")."'";
  $queryFR = mysql_query($sqlFR);
  $numFR = mysql_fetch_assoc($queryFR);
  $numberFR=$numFR['numberFR'];

  // Spracheinstellung der Benutzer "EN"

  $numberEN=$number-$numberDE-$numberFR;

  echo "<fieldset >";
  echo "<legend class='info'> ".Statistic_06."</legend> ";
  echo "<h3>".Statistic_07."</h3>";
  echo "<h6><label class='left_info'>".Statistic_08."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$number."<br />";
  echo "<label class='left_info'>".Statistic_09."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$numberAdmin."<br /></h6>";

  echo "<h3>".Statistic_10."</h3>";
  echo "<h6><label class='left_info'>".Statistic_11."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$numberRoot1."<br />";
  echo "<label class='left_info'>".Statistic_12."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$numberRoot3."<br /></h6>";

  echo "<h3>".Statistic_13."</h3>";
  echo "<h6><label class='left_info'>".Statistic_14."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$numberDE."<br />";
  echo "<label class='left_info'>".Statistic_24."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$numberFR."<br />";
  echo "<label class='left_info'>".Statistic_15."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$numberEN."<br /></h6>";

  echo "<h3>".Statistic_16."</h3>";
  echo "<h6><label class='left_info'>".Statistic_17."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$numberPost."<br />";
  echo "<label class='left_info'>".Statistic_18."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$numberMail."<br />";
  echo "<label class='left_info'>".Statistic_19."</label>";
  echo"<label class='left_point'> :  </label>";
  echo "".$numberNo."<br /></h6>";

  echo "</fieldset>";
}

function getStatisticTest($t_id){


  // min Prozentzahl ermittlen
  $sqlTopic= "SELECT percentage FROM topics";
  $queryTopic= mysql_query($sqlTopic);
  $perc = mysql_fetch_assoc($queryTopic);
  $percentage=$perc['percentage'];

  // alle Daten ermitteln
  $sql="SELECT DISTINCT date from learnprogress WHERE t_id='".intval($t_id)."' ORDER BY date ASC ";
  $query= mysql_query($sql);
  $find=mysql_num_rows($query) ;
  if($find==0){
    echo '<div class="h8 centered">'.Global_07."</div>";
  } else {
    echo "<fieldset >";
    echo "<legend class='info'> ".Statistic_20."</legend> ";

    while($timestamp =mysql_fetch_array($query ,MYSQL_BOTH  )){
      $time=$timestamp['date']; // in arra speichern
      $sqlnum="SELECT count(lp_id)as number FROM learnprogress WHERE t_id='".intval($t_id)."' and date='$time'";
      $querynum=mysql_query($sqlnum);
      $num = mysql_fetch_assoc($querynum);
      $count=$num['number'];

      $sqlPassed="SELECT count(lp_id)as pass FROM learnprogress WHERE percentage >= '".intval($percentage)."' and date='$time'";
      $queryPassed=mysql_query($sqlPassed);
      if(empty($queryPassed))  $passed=0;
      else{
        $numPassed = mysql_fetch_assoc($queryPassed);
        $passed=$numPassed['pass'];
      }
      echo "<h3>".$time."</h3>";
      echo "<h6><label class='left_info'>".Statistic_22."</label>";
      echo"<label class='left_point'> :  </label>";
      echo "".$count."<br /><br />";
      echo "<label class='left_info'>".Statistic_23."</label>";
      echo"<label class='left_point'> :  </label>";
      echo "".$passed."</h6><br /><br />";
    }
  }

  echo "</fieldset>";
}

?>

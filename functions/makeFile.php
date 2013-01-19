<?php

  // Variable festlegen
  $_SESSION['_config']['filepath'] = "C:\\Programme\\xampp\\htdocs\\Online_Test_neu\\";
  
  // Einbindinden der Datei
  require_once($_SESSION['_config']['filepath']."includes/db_connect.inc");

  // Datum für Dateiname
  $timestamp = time();
  $date = date("Y_m_d",$timestamp);

  
   // Dateiname
  $file1=$_SESSION['_config']['filepath']."\\export\\$date.csv."; 
  $file2=$_SESSION['_config']['filepath']."\\export\\$date viaPost.csv."; 
  $file3=$_SESSION['_config']['filepath']."\\export\\$date email.csv."; 
  
  // Datei öffnen zum schreiben, wenn Datei bereits existiert leeren der Datei
  $file1 = fopen ($file1, "w"); 
  $file2 = fopen ($file2, "w"); 
  $file3 = fopen ($file3, "w"); 
  
  // min. Prozentzahl, Name, und ID der topics aus db holen
  $sql1= "SELECT percentage,topic,t_id  FROM topics";
  $query1= mysql_query($sql1); 
    while($data1 =mysql_fetch_array($query1 ,MYSQL_BOTH  )){  
     $percentageToPass=$data1['percentage'];
     $topic=$data1['topic'];
     $t_id=$data1['t_id'];
   
      // Auswahl der Benutzer_id und des Roots derjenigen, die bestanden haben
      $sql2="SELECT DISTINCT learnprogress.user_id,learnprogress.root FROM learnprogress,user WHERE t_id=$t_id and percentage >= $percentageToPass and learnprogress.user_id=user.user_id";
      $query2= mysql_query($sql2);
        while($data2=mysql_fetch_array($query2 ,MYSQL_BOTH  )){  
          // Werte in Datei schreiben
          fwrite($file1, "".$topic.",".$data2['user_id'].",".$data2['root']."\n");
       
        // min. Prozentzahl, Name, und ID der topics aus db holen
        $sql3= "SELECT CN_name,firstname,lastname,street,housenumber,zipcode,city,state,country FROM user,user_address WHERE sendCert='post' AND user_address.user_id='".$values['user_id']."' AND  user_address.root='".$values['root']."' AND user.user_id='".$values['user_id']."' AND  user.root='".$values['root']."' LIMIT 1";
        $query3= mysql_query($sql3);
        $num_rows = mysql_num_rows($query3);
    
          if($num_rows>0){ // wenn es überhaupt Datensätze gibt
            $data3 =mysql_fetch_assoc($query3 );
            $CN_name=$data3['CN_name'];
            $firstname=$data3['firstname'];
            $lastname=$data3['lastname'];
            $street=$data3['street'];
            $housenumber=$data3['housenumber'];
            $zipcode=$data3['zipcode'];
            $city=$data3['city'];
            $state=$data3['state'];
            $country=$data3['country'];
     
            // Werte in Datei schreiben
            fwrite($file2, "".  $CN_name.",".$firstname.",".$lastname.",".$street.",".$housenumber.",".$zipcode.",".$city.",".$state.",".$country."\n");
          }
          else {
            $sql4= "SELECT CN_name,email FROM user WHERE sendCert='email' AND user.user_id='".$values['user_id']."' AND  user.root='".$values['root']."' LIMIT 1";
            $query4= mysql_query($sql4);
            $num_rows = mysql_num_rows($query4);
      
              if($num_rows>0){
                $data4=mysql_fetch_assoc($query4 );
                $CN_name=$data4['CN_name'];
                $email=$data4['email'];
                fwrite($file3, "".$CN_name.",".$email."\n");
              }
          }
      }
    }
  
  // Dateien schließen  
  fclose($file1);
  fclose($file2);
  fclose($file3);

  
  
 


?>
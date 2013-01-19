<?php
  $dataArray=array();
  $dataArray=$_GET[percentArray];
  $dataArray=base64_decode ($dataArray);
  $dataArray= unserialize($dataArray);
  $learnpath=$_GET['learnpath'];
  $title=$_GET['title'];
  $titley=$_GET['titley'];
  $titlex=$_GET['titlex'];
  
  require_once 'phplot.php';  // here we include the PHPlot code 
  $plot =& new PHPlot(550,400);// here we define the variable
  $plot->SetDataColors(array('#11568C','#00BE00','#FFFF00'));
  $plot->SetDataValues($dataArray);
  $plot->SetLineWidths('3');
  $plot->SetXTickLabelPos('none');
  $plot->SetXTickPos('none');
     if($title=='statistic'){
      $plot->SetXTitle('ID');
    }
     else  $plot->SetXTitle($titlex);
  $plot->SetYTitle($titley);
  $plot->SetPrecisionY(0);
  $plot->SetYTickIncrement(10);
  $plot->SetPlotAreaWorld(0, 0, NULL,110);
    if($learnpath!=null) {
     $plot->SetxLabelAngle(90);
    }
  $plot->DrawGraph();
?>


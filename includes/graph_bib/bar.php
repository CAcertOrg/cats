<?php
  $dataArray=array();
  $dataArray=$_GET[data];
  $dataArray=base64_decode ($dataArray);
  $dataArray= unserialize($dataArray);
  $title=$_GET['title'];
  $learnpath=$_GET['learnpath'];
  $titley=$_GET['titley'];
  $titlex=$_GET['titlex'];
   
  require_once 'phplot.php';  // here we include the PHPlot code 
  $plot =& new PHPlot(550,400);
  $plot->SetDataColors(array('#11568C','#00BE00','#FFFF00'));
  $plot->SetPlotType('bars');
  $plot->SetDataType('text-data');
  $plot->SetDataValues($dataArray);
    if($title=='statistic'){
      $plot->SetXTitle('ID');
    }
    else  $plot->SetXTitle($titlex);
  
  $plot->SetYTitle($titley);
  $plot->SetXTickLabelPos('none');
  $plot->SetXTickPos('none');
  $plot->SetPrecisionY(0);
  $plot->SetYTickIncrement(10);
  $plot->SetPlotAreaWorld(0, 0, NULL,110);
    if($learnpath!=null) {
     $plot->SetxLabelAngle(90);
    }
  $plot->SetXTickLabelPos('none');
  $plot->SetXTickPos('none');
  $plot->DrawGraph();
?>

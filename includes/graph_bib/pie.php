<?php
  $dataArray=array();
  $dataArray=$_GET[data];
  $dataArray= base64_decode ($dataArray);
  $dataArray= unserialize($dataArray);
 
  require_once 'phplot.php';  // here we include the PHPlot code 
  $plot =& new PHPlot(550,400);
  
  $plot->SetDataColors(array('#00BE00','#11568C','#FFFF00'));
  $plot->SetImageBorderType('plain');
  $plot->SetDataType('text-data-single');
  $plot->SetDataValues($dataArray);
  $plot->SetPlotType('pie');
  foreach ($dataArray as $row)
  $plot->SetLegend(implode(': ', $row));
  $plot->DrawGraph();
?>

<?php

 function PostToHost($host, $path, $referer, $data_to_send) {

  $fp = fsockopen("ssl://".$host, 443, $errno, $errstr);

 // printf("Open!\n");
  fputs($fp, "POST $path HTTP/1.0\r\n");
  fputs($fp, "Host: $host\r\n");
  fputs($fp, "Referer: $referer\r\n");
  fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
  fputs($fp, "Content-length: ". strlen($data_to_send) ."\r\n");
  fputs($fp, "Connection: close\r\n\r\n");
  fputs($fp, $data_to_send);
  // printf("Sent!\n");
  while(!feof($fp)) {
      $res[] = fgets($fp);
  }
 
// printf("Done!\n");
 fclose($fp);
 return $res;

}
?>

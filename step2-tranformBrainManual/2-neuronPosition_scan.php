<?php
$cmd="find /disk4/work/201707_output/ |grep Resample_4_4_4.am\$";
//$cmd="find /disk4/work/201707_output/ |grep 0728 |grep Resample_4_4_4.am\$";
//$cmd="find /disk4/work/201707_output/ |grep 50_04 |grep Resample_4_4_4.am\$";

$result=shell_exec($cmd);
$tmpArr=explode("\n",trim($result));
for($i=0;$i<count($tmpArr);$i++){
 $brain=trim($tmpArr[$i]);
 if (substr($brain,-2,2)=="am"){
  $matrixFile=substr($brain,0,-18).".matrix5";
  //if (!is_file($matrixFile)){
   $cmd="php 2-neuronPosition.php ".$brain;
   echo $cmd."\n";
   exec($cmd);
  //}
 }
}

?>
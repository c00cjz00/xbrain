<?php

$recordFile="z1.error";
$tmpArr=file($recordFile);
for($i=0;$i<count($tmpArr);$i++){
 $tmp=trim($tmpArr[$i]);   
 if ($tmp!="") $$tmp=1;
}
    
$cmd="find /disk4/work/201707_output/ |grep Resample_4_4_4_brain.am\$";
//$cmd="find /disk4/work/201707_output/ |grep 0728 |grep Resample_4_4_4.am\$";
//$cmd="find /disk4/work/201707_output/ |grep 50_04 |grep Resample_4_4_4.am\$";

$result=shell_exec($cmd);
$tmpArr=explode("\n",trim($result));
for($i=0;$i<count($tmpArr);$i++){
 $brain=trim($tmpArr[$i]);
 $neuron=basename($brain,"_Resample_4_4_4_brain.am");
 if ((substr($brain,-2,2)=="am") && !isset($$neuron)){
  //if (!is_file($matrixFile)){
   $cmd="php generate_niiFile.php ".$brain;    
   echo $cmd."\n";
  // exec($cmd);
  //}
 }
}

?>
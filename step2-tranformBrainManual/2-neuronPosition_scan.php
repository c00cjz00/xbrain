<?php
/*** 
Example: 
php 2-neuronPosition_scan.php  
***/

$preFile="demo/pngXbrain.record";
$preBasename="_Resample_4_4_4.am";
$cmd="find /disk4/work/201707_output/ |grep ".$preBasename."\$";

if (is_file($preFile)){
 $tmpArr=file($preFile);
 for($i=0;$i<count($tmpArr);$i++){
  $smpArr=explode(" ",trim($tmpArr[$i]));
  if (count($smpArr)==3){
   $n=$smpArr[0].$preBasename; $n1=$smpArr[1]; $n2=$smpArr[2];
   $tmp1=$n."_1"; $$tmp1=$n1;
   $tmp2=$n."_2"; $$tmp2=$n2;
  } 
 }	 
}


$result=shell_exec($cmd);
$tmpArr=explode("\n",trim($result));
for($i=0;$i<count($tmpArr);$i++){
 $brainFile=trim($tmpArr[$i]);
 if (substr($brainFile,-2,2)=="am"){
  $brain=basename($brainFile,".am"); 
  $n=basename($brainFile); 
  $dir=dirname($brainFile);
  $matrixFile=$dir."/".$brain.".transformMatrix";	 
  if (!is_file($matrixFile)){
   $stdFile="demo/Std.am";
   $n1=0; $n2=0;
   $tmp1=$n."_1"; $tmp2=$n."_2";
   if (isset($$tmp1) && ($$tmp2)){
    $n1=$$tmp1; $n2=$$tmp2; 
   }
   $cmd="php 2-neuronPosition.php ".$brainFile." ".$n1." ".$n2." ".$stdFile;
   echo $cmd."\n";
   exec($cmd);
  }
 }
}

?>
<?php
$cmd="find /disk4/gitHub/output/ |grep Resample_4_4_4.am";
$result=shell_exec($cmd);
$tmpArr=explode("\n",$result);
$start=$argv[1]; $end=$start+60;
if ($end>count($tmpArr)) $end=count($tmpArr);
for($i=$start;$i<$end;$i++){
 $tmp=trim($tmpArr[$i]);
 $checkFile=substr($tmp,0,-3)."innerBrain_lineset_affine_warp1.am"; 
 if (is_file($tmp) && !is_file($checkFile)){
  $cmd="./cmd.sh ".$tmp." 1";
  echo $cmd."\n";
  exec($cmd);
 }
}

 
?>
       
<?php
/*** 
Example: 
php affineRegister_fullBrain2StdBrain_scan.php  
***/

$cmd="find /disk4/work/201707_output/ | grep matrix5\$";
outputDir=
$inputHead=

$result=shell_exec($cmd);
$tmpArr=explode("\n",trim($result));
for($i=0;$i<count($tmpArr);$i++){
 $matrix=trim($tmpArr[$i]);

 $inputHead=substr($matrix,0,-8)."_Resample_4_4_4.am";
 $inputBrain=substr($matrix,0,-8)."_Resample_4_4_4_brain.am";
 $headMatrix=substr($matrix,0,-8)."_Resample_4_4_4_affine.matrix";
 $brainMatrix=substr($matrix,0,-8)."_Resample_4_4_4_brain_affine.matrix";
 if (is_file($matrix) && is_file($inputHead) && is_file($inputBrain) && !is_file($brainMatrix)){
  $cmd="php affineRegister.php ".$inputHead." novgl ".$matrix;
  echo $cmd."\n";
  exec($cmd);
 }
 $dir=realpath(dirname($inputHead));
 $brain=substr(basename($inputHead),0,-3);
 $a1=$dir."/".$brain."_affine_1.png";$as1=$dir."/".$brain."_affine_1s.png";
 $a2=$dir."/".$brain."_affine_2.png";$as2=$dir."/".$brain."_affine_2s.png";
 $a3=$dir."/".$brain."_affine_3.png";$as3=$dir."/".$brain."_affine_3s.png";
 $a4=$dir."/".$brain."_brain_affine_1.png";$as4=$dir."/".$brain."_brain_affine_1s.png";
 $a5=$dir."/".$brain."_brain_affine_2.png";$as5=$dir."/".$brain."_brain_affine_2s.png";
 $a6=$dir."/".$brain."_brain_affine_3.png";$as6=$dir."/".$brain."_brain_affine_3s.png";
 if (!is_file($as6)){
  $cmd="php snapshot.php ".$inputHead;
  echo $cmd."\n";
//  exec($cmd);
 }       
}

?>
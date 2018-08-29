<?php
/*** 
Example: 
php snapshot.php
or  
php snapshot.php \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.am \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.am \
../../demoData/stdBrain/Std_fullBrain.am \
../../demoData/stdBrain/Std_innerBrain.am
***/

## Configure ##
$dirBin=dirname(__FILE__);
include(dirname($dirBin)."/config.php");

## Input data ##
$fullBrainFile="../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.am"; 
$innerBrainFile="../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.am"; 
$std_fullBrainFile="../../demoData/stdBrain/Std_fullBrain.am";
$std_innerBrainFile="../../demoData/stdBrain/Std_innerBrain.am";

if (isset($argv[1])) $fullBrainFile=$argv[1]; 
if (isset($argv[2])) $innerBrainFile=$argv[2]; 
if (isset($argv[3])) $std_fullBrainFile=$argv[3]; 
if (isset($argv[4])) $std_innerBrainFile=$argv[4]; 
$saveDir=dirname($fullBrainFile);
$matrix_fullBrain=$saveDir."/".substr(basename($fullBrainFile),0,-3).".affineMatrix";
$matrix_innerBrain=$saveDir."/".substr(basename($innerBrainFile),0,-3).".affineMatrix";
$fullBrain=basename($fullBrainFile,".am");
$innerBrain=basename($innerBrainFile,".am");


if (is_file($matrix_fullBrain) && is_file($fullBrainFile) && is_file($innerBrainFile) && is_file($matrix_innerBrain)){
 $a1=$saveDir."/".$fullBrain."_affine_1.png";$as1=$saveDir."/".$fullBrain."_affine_1s.png";
 $a2=$saveDir."/".$fullBrain."_affine_2.png";$as2=$saveDir."/".$fullBrain."_affine_2s.png";
 $a3=$saveDir."/".$fullBrain."_affine_3.png";$as3=$saveDir."/".$fullBrain."_affine_3s.png";  
 $a4=$saveDir."/".$innerBrain."_affine_1.png";$as4=$saveDir."/".$innerBrain."_affine_1s.png";
 $a5=$saveDir."/".$innerBrain."_affine_2.png";$as5=$saveDir."/".$innerBrain."_affine_2s.png";
 $a6=$saveDir."/".$innerBrain."_affine_3.png";$as6=$saveDir."/".$innerBrain."_affine_3s.png";
 echo $as3."\n";
 if (!is_file($as3)){
  $mArr=file($matrix_fullBrain); $m=trim($mArr[1]);     
$amiraHx="# Amira Script
load $dirBin/snapshot.hx
viewer 0 setBackgroundMode 0
viewer 0 setBackgroundColor 0.251 0.251 0.259
seperateWindow
[ load $fullBrainFile ] setLabel brain; brain fire;
brain setTransform $m
[ load $std_fullBrainFile ] setLabel std; std fire;

seperateWindow
LSM_affine brain std $a1 $a2 $a3
remove -All
merageWindow
exit
";
  $prgfile_hx = tempnam("/tmp", "warping_");                    
  $fp = fopen($prgfile_hx, "w");
  fwrite($fp, $amiraHx);
  fclose($fp);
  echo "vglrun ".$amiraBin53." ".$prgfile_hx."\n";
  exec("vglrun ".$amiraBin53." ".$prgfile_hx);
  unlink($prgfile_hx);
 }
 if ((!is_file($as1)) && (is_file($a1))) {
  $cmd1="php5 s0-LSMConvert.php ".$a1." ".$as1." 1050 1250x250";
  $cmd2="php5 s0-LSMConvert.php ".$a1." ".$a1." 1050";
  exec($cmd1);exec($cmd2);
 }
 if ((!is_file($as2)) && (is_file($a2))) {        
  $cmd1="php5 s0-LSMConvert.php ".$a2." ".$as2." 1050 1250x250";
  $cmd2="php5 s0-LSMConvert.php ".$a2." ".$a2." 1050";
  exec($cmd1);exec($cmd2);
 }
 if ((!is_file($as3)) && (is_file($a3))) {
  $cmd1="php5 s0-LSMConvert.php ".$a3." ".$as3." 1050 1250x250";
  $cmd2="php5 s0-LSMConvert.php ".$a3." ".$a3." 1050";
  exec($cmd1);exec($cmd2);
 }
 
 if (!is_file($as6)){
  $mArr=file($matrix_innerBrain); 
  if (isset($mArr[2]) && (trim($mArr[2])!="")){
   $m=trim($mArr[2]);     
  }else{
   $m=trim($mArr[1]);         
  }
$amiraHx="# Amira Script
load $dirBin/snapshot.hx
viewer 0 setBackgroundMode 0
viewer 0 setBackgroundColor 0.251 0.251 0.259
seperateWindow
[ load $innerBrainFile ] setLabel brain; brain fire;
brain setTransform $m
[ load $std_innerBrainFile ] setLabel std; std fire;

seperateWindow
LSM_affine brain std $a4 $a5 $a6
remove -All
merageWindow
exit

";
  $prgfile_hx = tempnam("/tmp", "warping_");                    
  $fp = fopen($prgfile_hx, "w");
  fwrite($fp, $amiraHx);
  fclose($fp);
  echo "vglrun ".$amiraBin53." ".$prgfile_hx."\n";
  exec("vglrun ".$amiraBin53." ".$prgfile_hx);
  unlink($prgfile_hx);
 }
 if ((!is_file($as4)) && (is_file($a4))) {
  $cmd1="php5 s0-LSMConvert.php ".$a4." ".$as4." 1050 1250x250";
  $cmd2="php5 s0-LSMConvert.php ".$a4." ".$a4." 1050";
  exec($cmd1);exec($cmd2);
 }

 if ((!is_file($as5)) && (is_file($a5))) {        
  $cmd1="php5 s0-LSMConvert.php ".$a5." ".$as5." 1050 1250x250";
  $cmd2="php5 s0-LSMConvert.php ".$a5." ".$a5." 1050";
  exec($cmd1);exec($cmd2);
 }
 if ((!is_file($as6)) && (is_file($a6))) {
  $cmd1="php5 s0-LSMConvert.php ".$a6." ".$as6." 1050 1250x250";
  $cmd2="php5 s0-LSMConvert.php ".$a6." ".$a6." 1050";
  exec($cmd1);exec($cmd2);
 }
}



?>

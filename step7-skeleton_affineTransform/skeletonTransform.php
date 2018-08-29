<?php
### command ###
/*
php php skeletonTransform.php
or
php skeletonTransform.php \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_lineset.am  \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.affineMatrix
*/

## Configure ##
$dirBin=dirname(__FILE__);
include(dirname($dirBin)."/config.php");

## Input data ##
$linesetFile="../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_lineset.am";
$matrixFile="../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.affineMatrix"; 

## input parameter ##
if (isset($argv[1])) $linesetFile=$argv[1]; 
if (isset($argv[2])) $matrixFile=$argv[2]; 
$saveDir=dirname($linesetFile);
if (is_file($linesetFile)){
 $linesetTransformFile=$saveDir."/".basename($linesetFile,".am")."_affineTmp.am";
 $linesetTransformReleaseFile=$saveDir."/".basename($linesetFile,".am")."_affine.am";
 echo  $linesetTransformReleaseFile."\n"; 
 if (!is_file($linesetTransformReleaseFile)){  
 
  $cmd="php s1-transformLinset.php ".$linesetFile." ".$linesetTransformFile." ".$matrixFile; echo $cmd."\n"; exec($cmd);
  $cmd="php s2-linesetFormat.php ".$linesetTransformFile." ".$linesetTransformReleaseFile; echo $cmd."\n"; exec($cmd);
 }
}

?>
 
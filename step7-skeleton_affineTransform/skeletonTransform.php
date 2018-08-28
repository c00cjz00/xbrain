<?php
### command ###
/*
php skeletonTransform.php \
.../../demoData/linesetFile/20170728_33_02_innerBrain_lineset.am \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain.affineMatrix
*/

## Configure ##
$dirBin=dirname(__FILE__);
include(dirname($dirBin)."/config.php");

## Input data ##
$linesetFile="../../demoData/linesetFile/20170728_33_02.am";
$matrixFile="../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain.affineMatrix"; 

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
 
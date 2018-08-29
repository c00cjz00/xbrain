<?php
/*** 
Example: 
php generate_niiFile.php
or
php generate_niiFile.php  \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.am \
../../demoData/stdBrain/Std_innerBrain.am
***/

## Configure ##
$dirBin=dirname(__FILE__);
include(dirname($dirBin)."/config.php");

## Input data ##
$innerBrainFile="../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.am"; 
$std_innerBrainFile="../../demoData/stdBrain/Std_innerBrain.am";

if (isset($argv[1])) $innerBrainFile=$argv[1]; 
if (isset($argv[2])) $std_innerBrainFile=$argv[2]; 
$saveDir=dirname($innerBrainFile);
$matrix_innerBrain=$saveDir."/".substr(basename($innerBrainFile),0,-3).".affineMatrix";

$matrix="";
if (is_file($matrix_innerBrain)){
 $tmpArr=file($matrix_innerBrain); 
 if (substr($tmpArr[0],0,1)=="#"){  $matrixTmp=trim($tmpArr[1]);  }else{  $matrixTmp=trim($tmpArr[0]);  }
 if ($matrixTmp!="") { $tmp2Arr=explode(" ",$matrixTmp); if (count($tmp2Arr)==16) $matrix=$matrixTmp;  } 
}

## output ##
$innerBrainFile_nii=$saveDir."/".basename(substr($innerBrainFile,0,-3))."_affine.nii";
$innerBrainFile_doc=$saveDir."/".basename(substr($innerBrainFile,0,-3))."_affine.box";


## Main script ##
echo $innerBrainFile_nii."\n";
if (is_file($innerBrainFile) && is_file($std_innerBrainFile) && !is_file($innerBrainFile_nii.".gz")){
 if (!is_file($innerBrainFile_nii)){  
$amiraHx="# Amira Script
source $dirBin/generate_niiFile.hx
niiGeneration $saveDir $innerBrainFile $std_innerBrainFile $innerBrainFile_doc $matrix
#sleep 10000
exit
";
  $prgfile_hx = tempnam("/tmp", "warping_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $amiraHx); fclose($fp); echo $prgfile_hx;

  exec("vglrun ".$amiraBin." ".$prgfile_hx);
  unlink($prgfile_hx);
  sleep(5);
  exec("gzip ".$saveDir."/*nii");
 }
}
?>

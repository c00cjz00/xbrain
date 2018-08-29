<?php
/***
Example:
php affineRegister.php
or
php affineRegister.php \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4.am \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain.am \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4.manualMatrix \
../../demoData/stdBrain/Std_fullBrain.am \
../../demoData/stdBrain/Std_innerBrain.am \
0 ## 1 -> full brain 直接使用 manual matrix 不再對位
***/


## Configure ##
$dirBin=dirname(__FILE__);
include(dirname($dirBin)."/config.php");

## Input data ##
$fullBrainFile="../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4.am"; 
$innerBrainFile="../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain.am"; 
$matrix_manual="";
$matrixFile="../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4.manualMatrix"; 
$std_fullBrainFile="../../demoData/stdBrain/Std_fullBrain.am";
$std_innerBrainFile="../../demoData/stdBrain/Std_innerBrain.am";
$isDirectUsingManualMatrix=0;
if (isset($argv[1])) $fullBrainFile=$argv[1]; 
if (isset($argv[2])) $innerBrainFile=$argv[2]; 
if (isset($argv[3])) $matrixFile=$argv[3];
if (is_file($matrixFile)){
 $tmpArr=file($matrixFile); 
 if (substr($tmpArr[0],0,1)=="#"){  $matrixTmp=trim($tmpArr[1]);  }else{  $matrixTmp=trim($tmpArr[0]);  }
 if ($matrixTmp!="") { $tmp2Arr=explode(" ",$matrixTmp); if (count($tmp2Arr)==16) $matrix_manual=$matrixTmp;  } 
}

if (isset($argv[4])) $std_fullBrainFile=$argv[4]; 
if (isset($argv[5])) $std_innerBrainFile=$argv[5]; 
if (isset($argv[6])) $isDirectUsingManualMatrix=$argv[6]; 


## Outut data ##
$saveDir=dirname($fullBrainFile);
$matrix_fullBrain=$saveDir."/".substr(basename($fullBrainFile),0,-3).".affineMatrix";
$matrix_innerBrain=$saveDir."/".substr(basename($innerBrainFile),0,-3).".affineMatrix";


## Main script ##
echo $std_innerBrainFile."\n";
echo $std_fullBrainFile."\n";
echo $innerBrainFile."\n";
echo $fullBrainFile."\n";


if (is_file($fullBrainFile) && is_file($innerBrainFile) && is_file($std_fullBrainFile) && is_file($std_innerBrainFile) && ($matrix_manual!="")){
 if (!is_file($matrix_innerBrain)){  
$amiraHx="# Amira Script
source $dirBin/affineRegister.hx
affineRegistration $saveDir $fullBrainFile $isDirectUsingManualMatrix $innerBrainFile $std_fullBrainFile $std_innerBrainFile $matrix_manual
#sleep 10000
exit
";
  $vgl="1";
  $prgfile_hx = tempnam("/tmp", "warping_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $amiraHx); fclose($fp); echo $prgfile_hx;
  if ($vgl==""){
   exec($amiraBin." -no_gui ".$prgfile_hx);
  }else{
   exec("vglrun ".$amiraBin." ".$prgfile_hx);
  }     
  unlink($prgfile_hx);
  //exec($amiraBin." ".$gui.$prgfile_hx); unlink($prgfile_hx);    
 }
}
?>

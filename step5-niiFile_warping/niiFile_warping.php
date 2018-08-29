<?php
/*** 
Example:
php php niiFile_warping.php
or 
php niiFile_warping.php \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine.nii.gz \
1
***/

## Configure ##
$dirBin=dirname(__FILE__);
include(dirname($dirBin)."/config.php");
$cmtkDir=dirname($dirBin)."/../cmtk/bin";
date_default_timezone_set("Asia/Taipei"); $date= date("YmdHis");
$key="/tmp/".$date;  
  
## Input data ##
$innerBrainFile_nii="../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine.nii.gz"; 
$level=1;

## input parameter ##
if (isset($argv[1])) $innerBrainFile_nii=$argv[1]; 
if (isset($argv[2])) $level=$argv[2]; 

## others ##
$saveDir=dirname($innerBrainFile_nii);
//$innerBrainFile_doc=$saveDir."/".basename(substr($innerBrainFile_nii,0,-11))."_affine.nii";
$std_innerBrainFile_nii=$saveDir."/".basename(substr($innerBrainFile_nii,0,-14))."_affine_std.nii.gz";

## Outut dir ##
$afiine_matrix=$saveDir."/0-affine";
$nonrigid_matrix=$saveDir."/0-nonrigid";
$nonrigid_level="level-0".$level.".list";

## vglrun
$vgl="vglrun "; 

## Main script ##
if (is_file($innerBrainFile_nii)){
 if (!is_file($afiine_matrix."/registration")){ 
  $cmd=$cmtkDir."/registration -i -v --dofs 3 --accuracy 1 -o ".$afiine_matrix." ".$std_innerBrainFile_nii." ".$innerBrainFile_nii;
  echo $cmd."\n";  exec($cmd); sleep(1);
 } 
 if (is_file($afiine_matrix."/registration") && !is_file($nonrigid_matrix."/".$nonrigid_level."/registration.gz")){ 
  $outputfile=$key."_output";  $pidfile=$key."_pid";
  $cmd="php killWarp.php ".$level." ".$key;
  exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));   
  $cmd=$cmtkDir."/warp --time ".$key." -v --fast --registration-metric nmi --energy-weight 0 --ic-weight 0 --output-intermediate --jacobian-weight 0.05 -e 0.05 -g 160 -a 0.001 --refine 6 --coarsest 8 --threads 7 -o ".$nonrigid_matrix." ".$afiine_matrix;
  echo $cmd."\n"; exec($cmd); sleep(1);
  //unlink($outputfile);   unlink($pidfile); 
 }
 if (is_file($afiine_matrix."/registration") && is_file($nonrigid_matrix."/".$nonrigid_level."/registration.gz")){ 

  for($i=$level;$i>0;$i--){
   $levelTmp=$i;
   $nonrigid_levelTmp="level-0".$levelTmp.".list";
   
   ## Outut data ##
   $outputBrain_Nifti=substr($innerBrainFile_nii,0,-7)."_warp".$levelTmp.".nii";
   
   if (!is_file($outputBrain_Nifti.".gz") && !is_file($outputBrain_Nifti)){
    $cmd=$cmtkDir."/reformatx  --outputtype ushort -o ".$outputBrain_Nifti." --nn --ushort --floating ".$innerBrainFile_nii." ".$std_innerBrainFile_nii." ".$nonrigid_matrix."/".$nonrigid_levelTmp;
    echo $cmd."\n"; exec($cmd); sleep(1);
   }
  }
 }
}  
/*
## gunzip data
for($i=$level;$i>0;$i--){
 $levelTmp=$i; 
 $nonrigid_levelTmp="level-0".$levelTmp.".list";
 ## Outut data ##
 $outputBrain_Nifti=substr($innerBrainFile_nii,0,-4)."_warp".$levelTmp.".nii";
 if (is_file($outputBrain_Nifti.".gz")){
  $cmd="gunzip ".$saveDir."/*nii.gz"; exec($cmd);
  sleep(1);
 }
}

## amira format data
## Main script ##
for($i=$level;$i>0;$i--){
 ## Outut data ##
 $levelTmp=$i; 
 $nonrigid_levelTmp="level-0".$levelTmp.".list";
 $outputBrain_Nifti=substr($innerBrainFile_nii,0,-4)."_warp".$levelTmp.".nii";
 #$outputNeuron_Nifti=substr($innerBrainFile_nii,0,-4)."_warp".$levelTmp."_seg001.nii";
 if (is_file($innerBrainFile_nii) && is_file($std_innerBrainFile_nii) && is_file($outputBrain_Nifti)){
  $f1=substr($innerBrainFile_nii,0,-4).".am";
  $f3=substr($std_innerBrainFile_nii,0,-4).".am";
  $f5=substr($outputBrain_Nifti,0,-4).".am";
 $amiraHx="# Amira Script
 source ".$dirBin."/amirazip.hx; 
 amirazip ".$innerBrainFile_nii." ".$f1."
 amirazip ".$std_innerBrainFile_nii." ".$f3."
 amirazip ".$outputBrain_Nifti." ".$f5."
 exit
 ";
  $prgfile_hx = tempnam("/tmp", "warping_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $amiraHx); fclose($fp); echo $prgfile_hx;
  if ($vgl==""){
   echo "allen\n";
   echo $amiraBin." -no_gui ".$prgfile_hx."\n";
   exec($amiraBin." -no_gui ".$prgfile_hx); 
  }else{
   echo "peter\n";
   echo "vglrun ".$amiraBin." ".$prgfile_hx."\n";
   exec("vglrun ".$amiraBin." ".$prgfile_hx);
  }
  unlink($prgfile_hx);
  sleep(1);
  if (is_file($f1) && is_file($f2) && is_file($f3) && is_file($f4) && is_file($f5)){
  //unlink($innerBrainFile_nii); unlink($inputNeuron_Nifti); unlink($std_innerBrainFile_nii); 
  #unlink($outputNeuron_Nifti); 
  //unlink($outputBrain_Nifti); 
  }
 }
}
//if (is_file($innerBrainFile_nii)) unlink($innerBrainFile_nii);
#if (is_file($inputNeuron_Nifti))  unlink($inputNeuron_Nifti);
//if (is_file($std_innerBrainFile_nii))  unlink($std_innerBrainFile_nii);

*/
?>


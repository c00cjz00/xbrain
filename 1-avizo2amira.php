<?php
########### configure ############
$amiraBin="/package/Amira/6.2.0/bin/start";

###########  amiraHX  ############
$script="";
if (!isset($argv[1])) { 
 echo "enter neuronFile\n"; exit();
} else {
 $tmpFile=realpath($argv[1]);
}
if (substr($tmpFile,-3,3)==".gz") {
 $neuronFileA=substr($tmpFile,0,-3);
 if (!is_file($neuronFileA)){
  $cmd="gunzip -c ".$tmpFile." > ".$neuronFileA;
  exec($cmd);
 }

 $neuronFileB=substr($neuronFileA,0,-3).".4_4_4.am";
 if (!is_file($neuronFileB) && is_file($neuronFileA)){
  $script.="
avizo2amira \"$neuronFileA\" \"$neuronFileB\"
  ";
 }
}

if ($script!=""){
 $amiraHx="# Amira Script
 proc avizo2amira {neuronFile saveFile} {
  [ load \$neuronFile ] setLabel neuron
  neuron fire
  create HxResample Resample
  Resample data connect neuron
  Resample fire
  Resample filter setIndex 0 4
  Resample mode setValue 1
  Resample voxelSize setValue 0 2
  Resample voxelSize setValue 1 2
  Resample voxelSize setValue 2 2
  Resample applyTransformToResult 1
  Resample action touch
  Resample action setValue hit 1
  Resample fire
  neuron.resampled parameters setValue Filename \$saveFile
  neuron.resampled parameters setValue SaveInfo \"AmiraMesh ZIP\"
  neuron.resampled save
  exit
  }
 ".$script."
 ";
 
 ###########  Running amiraHX  ############
 $prgfile_hx = tempnam("/tmp", "warping_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $amiraHx); fclose($fp);
 exec("vglrun ".$amiraBin." -no_gui ".$prgfile_hx);
 unlink($prgfile_hx);
 exec("rm ".$neuronFileA);
}

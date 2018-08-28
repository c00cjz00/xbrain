<?php
//include(dirname(__FILE__)."/config.php");
//$dirBin=dirname(__FILE__);
$linesetFile=trim($argv[1]);
$linesetTransformFile=trim($argv[2]);
$matrixFile=$argv[3];
if (is_file($linesetFile) && is_file($matrixFile) && !is_file($linesetTransformFile)){
  skeletonTranform($linesetFile,$linesetTransformFile,$matrixFile);
}

function skeletonTranform($linesetFile,$linesetTransformFile,$matrixFile){
  include(dirname(__FILE__)."/../config.php");  
  $tArr=file($matrixFile);
  if (substr(trim($tArr[0]),0,1)=="#"){ $t=explode(" ",trim($tArr[1]));  }else{   $t=explode(" ",trim($tArr[0]));  }
  $amira_hx="# Amira Script
  [ load $linesetFile ] setLabel lineset
  lineset setTransform $t[0] $t[1] $t[2] $t[3] $t[4] $t[5] $t[6] $t[7] $t[8] $t[9] $t[10] $t[11] $t[12] $t[13] $t[14] $t[15]
  lineset applyTransform
  lineset parameters setValue Filename $linesetTransformFile
  lineset parameters setValue SaveInfo \"AmiraMesh ascii Lineset\"
  lineset save
#  lineset exportData \"Amira ascii Lineset\" $linesetTransformFile
  exit
  ";
  $prgfile_hx = tempnam("/tmp/flycircuit_tmp", "snap_");
  $fp = fopen($prgfile_hx, "w");
  fwrite($fp, $amira_hx);
  fclose($fp);
  chmod($prgfile_hx, 0755);
  //$amiraBin="/package/amira53/bin/start";
  echo "vglrun ".$amiraBin."  ".$prgfile_hx."\n";
  exec("vglrun ".$amiraBin."  ".$prgfile_hx);

  unlink($prgfile_hx);

}
?>

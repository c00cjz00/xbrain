<?php
## command ##
/*
php skeleton_streamxform.php \
../../demoData/linesetFile/20170728_33_02_innerBrain_lineset_affine.am \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain_affine.box \
1
*/

## Configure ##
$dirBin=dirname(__FILE__);
include(dirname($dirBin)."/config.php");

## Input data ##
$linesetFile_affine="../../demoData/linesetFile/20170728_33_02_innerBrain_lineset_affine.am";
$boxFile="../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain_affine.box";
$level=1;
   


## input parameter ##
if (isset($argv[1])) $linesetFile_affine=$argv[1]; 
if (isset($argv[2])) $boxFile=$argv[2]; 
if (isset($argv[3])) $level=$argv[3]; 

## others ##
$saveDir=dirname($boxFile);
$afiine_matrix=$saveDir."/0-affine";
$nonrigid_matrix=$saveDir."/0-nonrigid";
$levelDir=$saveDir."/0-nonrigid/level-0".$level.".list";  

## output ##
$linesetFile_affine_warp=substr($linesetFile_affine,0,-3)."_warp".$level.".am";
echo $linesetFile_affine_warp."\n";
if (is_file($linesetFile_affine) && !is_file($linesetFile_affine_warp) && is_dir($levelDir)){


 $BArr=file($boxFile); $B0Arr=explode(" ",trim($BArr[2])); $B2Arr=explode(" ",trim($BArr[2]));
 $tmpArr=position($linesetFile_affine); 
 $otherArr=$tmpArr[0]; $positionArr=$tmpArr[1]; $pointArr=$tmpArr[2];
 $record=implode("\n",$otherArr)."\n";
 $streamTmp="";
  
 for($i=0;$i<count($pointArr);$i++){
  $point=trim($pointArr[$i]);
  $pArr=explode(" ",$point);
  $x=$pArr[0]-$B0Arr[0];
  $y=$pArr[1]-$B0Arr[2];
  $z=$pArr[2]-$B0Arr[4];
  $streamTmp.=$x." ".$y." ".$z."\n";
 }
 $prgfile_hx = tempnam("/tmp", "warping_");
 $fp = fopen($prgfile_hx, "w");
 fwrite($fp, $streamTmp);
 fclose($fp);                 
 $cmd="cat ".$prgfile_hx." | ".$dirBin."/../../cmtk/bin/streamxform -- --inverse ".$levelDir;
 echo $cmd."\n";

 $pointArr=explode("\n",trim(shell_exec($cmd)));
 for($i=0;$i<count($pointArr);$i++){
  $point=trim($pointArr[$i]);
  $pArr=explode(" ",$point);
  $x=$pArr[0]-$B0Arr[0]+$B2Arr[0]+$B0Arr[0];
  $y=$pArr[1]-$B0Arr[2]+$B2Arr[2]+$B0Arr[2];
  $z=$pArr[2]-$B0Arr[4]+$B2Arr[4]+$B0Arr[4];
  //$x=$pArr[0]; $y=$pArr[1]; $z=$pArr[2];                  
  $record.=$x." ".$y." ".$z."\n";            
 }
 $record.="@2\n".implode("\n",$positionArr);
 //echo $record;
 $fp = fopen($linesetFile_affine_warp, "w"); 
 fwrite($fp, $record);
 fclose($fp);
 sleep(1);
}    
  

function position($lineset){
  $otherArr=array();
  $positionArr=array();
  $pointArr=array();
  $lineArr=file($lineset);
  $linNum=count($lineArr);
  $start=0;
  for($i=0;$i<$linNum;$i++){
    $line=trim($lineArr[$i]);
    if (($start==1)&&($line!="") && (substr($line,0,1)!="@")) array_push($positionArr,$line);
    if (($start==2)&&($line!="") && (substr($line,0,1)!="@")) array_push($pointArr,$line);

    if ($start==0) array_push($otherArr,$line);



    if (substr($line,0,2)=="@2") $start=1;
    if (substr($line,0,2)=="@1") $start=2;

  }
  return array($otherArr,$positionArr,$pointArr);
}

?>

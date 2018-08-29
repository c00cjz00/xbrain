<?php
$dirBin=dirname(__FILE__);
include(dirname($dirBin)."/config.php");
 
//$dataDir=$imgSource;
//$resultDir=$resultSource;
$linesetTransformFile=$argv[1];
$linesetTransformReleaseFile=$argv[2];

if (is_file($linesetTransformFile) && !is_file($linesetTransformReleaseFile)){
    $tmpArr=position($linesetTransformFile);
    $otherArr=$tmpArr[0];
    $positionArr=$tmpArr[1]; //linking
    $pointArr=$tmpArr[2]; // x y z
    $tmp="";
    for($i=0;$i<count($positionArr);$i++){
	if ($positionArr[$i]==-1){
	$tmp.=$positionArr[$i]."\n";
	}else{
	$tmp.=$positionArr[$i]." ";
	}
    }
    $linking=trim($tmp);
    $xyz="";
    for($i=0;$i<count($pointArr);$i++){
	$xyzArr=explode(" ",trim($pointArr[$i]));
//	$xyz.=round($xyzArr[0],4)."\t".round($xyzArr[1],4)."\t".round($xyzArr[2],4)."\n";
	$xyz.=(floor(100*$xyzArr[0])/100)." ".(floor(100*$xyzArr[1])/100)." ".(floor(100*$xyzArr[2])/100)."\n";
    }
    $result=trim(implode("\n",$otherArr))."\n";

    $xyz=trim($xyz);
    $result.="@1\n";
    $result.=$xyz."\n";
    $result.="@2\n";
    $result.=trim($linking)."\n";

    $fp = fopen($linesetTransformReleaseFile, "w");
    fwrite($fp, $result);
    fclose($fp);
    echo $linesetTransformReleaseFile."\n";
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

//    if (($line!="") && (!ereg("@3",$line))){
  if (($line!="")){
    if (($start==1)&&($line!="") && (substr($line,0,1)!="@")) array_push($positionArr,$line);
    if (($start==2)&&($line!="") && (substr($line,0,1)!="@")) array_push($pointArr,$line);
    
    if ($start==0) {
		$key=0;
		if ((substr($line,-2,2)=="@1") && (substr($line,0,2)!="@1")){
			$key=1;
			//$line=substr($line,0,-2)."@2";
		}elseif ((substr($line,-2,2)=="@2") && (substr($line,0,2)!="@2")){
			$key=2;
			//$line=substr($line,0,-2)."@1";
		}elseif ((substr($line,-2,2)=="@3") && (substr($line,0,2)!="@3")){
		  $key=3;
		}	
		if ($key==1){
			$tmp=substr($line,0,-2)."@2";
			array_push($otherArr,$tmp);

		}elseif ($key==2){
			$tmp=substr($line,0,-2)."@1";
			array_push($otherArr,$tmp);
                }elseif ($key==3){
                
		}else{
			if ((substr($line,0,2)=="@2") || (substr($line,0,2)=="@1")){
			}else{
				array_push($otherArr,$line);
			}
		}
	}
    
        
  //  if (substr($line,0,2)=="@2") $start=1;
   // if (substr($line,0,2)=="@1") $start=2;
    if (substr($line,0,2)=="@3") $start=3;
    
    if (substr($line,0,2)=="@2") $start=2;
    if (substr($line,0,2)=="@1") $start=1;
                
    }
  }
  return array($otherArr,$positionArr,$pointArr);
}





?>


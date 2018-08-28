<?php
/*** 
Example: 
php tranformBrainManual.php
or  
php tranformBrainManual.php ../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4.am ../../demoData/stdBrain/Std_fullBrain.am 22 2
***/
$brainFile="../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4.am"; 
$stdFile="../../demoData/stdBrain/Std_fullBrain.am";
$n1=22; $n2=1; 

if (isset($argv[1])) $brainFile=$argv[1]; 
if (isset($argv[2])) $stdFile=$argv[2];
if (isset($argv[3])) $n1=$argv[3]; 
if (isset($argv[4])) $n2=$argv[4];


$brain=basename($brainFile,".am"); 
$dir=dirname($brainFile);
$matrix=$dir."/".$brain.".manualMatrix";
if (!is_file($brainFile) || !is_file($stdFile)){
 echo "brain or std file 不存在\n"; exit();
}
if (is_file($matrix)){
 echo "已經轉換過囉\n"; 
 echo $matrix."\n";
 exit();
}

$rotation="";$rotation2="";
if (($n1!=0) && ($n2!=0)) {
 if ($n2==2){
  $degree=$n1*10;
  if ($degree>180) {
   $degree=180-$degree;
  }elseif ($degree<=180) {
   $degree=180-$degree;        
  }
  $rotation="brain rotate -ly 180; brain rotate -lz ".$degree.";";
  echo $rotation."\n";
$rotation2="    
brain setRotation -center 1280 1280 1280 0 1 0 180
";
 }else{
  $degree=$n1*10;
  if ($degree>180) {
   $degree=180-$degree;
  }elseif ($degree<=180) {
   $degree=180-$degree;   
  }
  $rotation="brain rotate -lz ".$degree.";";
  echo $rotation."\n";
$rotation2="    
brain setRotation -center 1280 1280 1280 0 0 1 ".$degree."
";
 }
}


$hx="# Amira Script
echo $brain
echo \"$rotation\"
[ load $stdFile ] setLabel std
[ load $brainFile ] setLabel brain
create HxTransformEditor TransformEditor
TransformEditor attach brain
$rotation2
[ load ../../demoData/stdBrain/purpleLSM.am ] setLabel purpleLSM
purpleLSM setMinMax 14000 65535
purpleLSM fire
create HxVolren VolrenStd
VolrenStd data connect std
VolrenStd color0 connect purpleLSM
VolrenStd alphaScale0 setMinMax 0 1
VolrenStd alphaScale0 setValue 0.8
VolrenStd commonMode setState item 0 0 item 1 0
VolrenStd shading setValue 0
VolrenStd fire
            
[ load ../../demoData/stdBrain/greenLSM.am ] setLabel greenLSM
greenLSM setMinMax 14000 65535
greenLSM fire
create HxVolren VolrenBrain
VolrenBrain data connect brain
VolrenBrain color0 connect greenLSM
VolrenBrain alphaScale0 setMinMax 0 1
VolrenBrain alphaScale0 setValue 0.8
VolrenBrain commonMode setState item 0 0 item 1 0
VolrenBrain shading setValue 0
VolrenBrain fire


remove affineRegister
create HxAffineRegistration \"affineRegister\"
affineRegister model connect brain
affineRegister reference connect std
affineRegister reference2 disconnect
affineRegister reference3 disconnect
affineRegister fire
affineRegister optimizer setIndex 0 0
affineRegister optimizer setIndex 1 0
affineRegister extensiveSearch setValue 0 0
affineRegister extensiveSearch setToggleVisible 0 1
affineRegister step setMinMax 0 -3.40282346638529e+38 3.40282346638529e+38
affineRegister step setValue 0 394.200012207031 
affineRegister step setMinMax 1 -3.40282346638529e+38 3.40282346638529e+38
affineRegister step setValue 1 0.16666667163372
affineRegister nLevelsGradient setMinMax 0 -3.40282346638529e+38 3.40282346638529e+38
affineRegister nLevelsGradient setValue 0 1
affineRegister nLevelsGradient setMinMax 1 -3.40282346638529e+38 3.40282346638529e+38
affineRegister nLevelsGradient setValue 1 9.99999974737875e-05
affineRegister coarsestResolution setMinMax 0 1 985
affineRegister coarsestResolution setValue 0 8
affineRegister coarsestResolution setMinMax 1 1 489
affineRegister coarsestResolution setValue 1 8
affineRegister coarsestResolution setMinMax 2 1 131
affineRegister coarsestResolution setValue 2 3
affineRegister metric setIndex 0 0
affineRegister histogramRangeRef setMinMax 0 -3.40282346638529e+38 3.40282346638529e+38
affineRegister histogramRangeRef setValue 0 0
affineRegister histogramRangeRef setMinMax 1 -3.40282346638529e+38 3.40282346638529e+38
affineRegister histogramRangeRef setValue 1 4095
affineRegister histogramRangeMod setMinMax 0 -3.40282346638529e+38 3.40282346638529e+38
affineRegister histogramRangeMod setValue 0 0
affineRegister histogramRangeMod setMinMax 1 -3.40282346638529e+38 3.40282346638529e+38
affineRegister histogramRangeMod setValue 1 4095
affineRegister histogramBins setMinMax 0 -16777216 16777216
affineRegister histogramBins setValue 0 255
affineRegister histogramBins setMinMax 1 -16777216 16777216
affineRegister histogramBins setValue 1 255
#affineRegister thresholdModelOutsideReference setMinMax 0 1
#affineRegister thresholdModelOutsideReference setButtons 0 
#affineRegister thresholdModelOutsideReference setEditButton 1
#affineRegister thresholdModelOutsideReference setIncrement 0.1
#affineRegister thresholdModelOutsideReference setValue 0.2
#affineRegister thresholdModelOutsideReference setSubMinMax 0 1
affineRegister options setValue 0 1
affineRegister options setToggleVisible 0 1
#affineRegister localizers setValue 0 0
#affineRegister localizers setToggleVisible 0 1
affineRegister transform setValue 0 1
affineRegister transform setToggleVisible 0 1
affineRegister transform setValue 1 1
affineRegister transform setToggleVisible 1 1
affineRegister transform setValue 2 0
affineRegister transform setToggleVisible 2 1
affineRegister transform setValue 3 0
affineRegister transform setToggleVisible 3 1
#affineRegister disableRotation setValue 0 0 
#affineRegister disableRotation setToggleVisible 0 1
affineRegister register setValue 1




echo \"nsave brain\"

proc nsave {basename} { 
set doc $matrix
set transform_value [ \$basename getTransform ]
set outfile [open \$doc w]
echo \$outfile
puts \$outfile \"\$transform_value\"
close \$outfile
}                                


";

$prgfile_hx = tempnam("/tmp", "warping_");
$fp = fopen($prgfile_hx, "w");
fwrite($fp, $hx);
fclose($fp);
echo $prgfile_hx."\n";
exec("vglrun /package/amira55/bin/start ".$prgfile_hx);
unlink($prgfile_hx);


?>
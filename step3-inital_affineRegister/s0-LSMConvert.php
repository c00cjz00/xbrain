<?php
$png=$argv[1];
$pngCrop=$argv[2];
#$border=$argv[3];
$maxY=$argv[3];
if (isset($argv[4])){
$resize="-resize ".$argv[4];
}else{
$resize="";
}

$cmd="convert -trim $png info:-";
$rArr=explode(" ",trim(shell_exec($cmd)));
$r1Arr=explode("x",$rArr[2]);
$lengthX=$r1Arr[0];$lengthY=$r1Arr[1]; 
if ($maxY>200){
$border=($maxY-$lengthY)/2;
}else{
$border=$maxY;
}
$border=1;
$r2Arr=explode("+",$rArr[3]);
$shiftX=$r2Arr[1];$shiftY=$r2Arr[2];

$cmd="convert -crop ".($lengthX+($border*2))."x".($lengthY+($border*2))."+".($shiftX-$border)."+".($shiftY-$border)." ".$resize." ".$png." ".$pngCrop;
echo $cmd."\n";
exec($cmd);
?>
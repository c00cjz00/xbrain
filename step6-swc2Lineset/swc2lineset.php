<?php
/*** 
Example:
php php swc2lineset.php
or 
php swc2lineset.php \
../../demoData/swcFile/20170804_4_07.swc \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_lineset.am 
*/


## Configure ##
$dirBin=dirname(__FILE__);
include(dirname($dirBin)."/config.php");

## Input data ##
$swcFile="../../demoData/swcFile/20170728_33_02.swc"; 
$linesetFile="../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_lineset.am";


## input parameter ##
if (isset($argv[1])) $swcFile=$argv[1]; 
if (isset($argv[2])) $linesetFile=$argv[2]; 
## Input data ##
if (!is_file($linesetFile)){
$amiraHx="# Amira Script
source swc2lineset.hx
swc2lineset $swcFile $linesetFile
exit
";
$prgfile_hx = tempnam("/tmp", "warping_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $amiraHx); fclose($fp); echo $prgfile_hx;
exec("vglrun ".$amiraBin." ".$prgfile_hx);
 unlink($prgfile_hx);
}
?>

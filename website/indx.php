<?php
$recordFile="pngXbrain.record";
$tmpArr=file($recordFile);
for($i=0;$i<count($tmpArr);$i++){
 $tmp=trim($tmpArr[$i]);
 $smpArr=explode(" ",$tmp);
 if (count($smpArr)==3){
  $neuron=$smpArr[0];
  $n="clock_".$neuron;  $c1=$smpArr[1]; $$n=$c1;
  $n="clockwise_".$neuron;  $c2=$smpArr[2];  $$n=$c2;
 }
}
 
$file="pngXbrain.txt";
$tmpArr=file($file);
if (isset($_POST["Submit"])) {	
 $record="";
 for($i=0;$i<count($tmpArr);$i++){
  $tmp=trim($tmpArr[$i]);
  if (substr($tmp,-11,11)=="_LSM_6s.png"){	
   $neuron=substr($tmp,0,-11);
   $n="clock_".$neuron;  $c1=$_POST[$n]; $$n=$c1;
   $n="clockwise_".$neuron;  $c2=$_POST[$n];  $$n=$c2;
   $record.=$neuron." ".$c1." ".$c2."\n";
  }
 }
 $fp = fopen($recordFile, "w");
 fwrite($fp, trim($record));
 fclose($fp); 
}




?>
<form id="form" name="form" method="post" action="index.php">
<br>
<?php
for($i=0;$i<count($tmpArr);$i++){
 $tmp=trim($tmpArr[$i]);
 if (substr($tmp,-11,11)=="_LSM_6s.png"){
  $neuron=substr($tmp,0,-11);
  $png1h="pngXbrain/".$neuron."_LSM_1.png"; $png1hs="pngXbrain/".$neuron."_LSM_1s.png";
  $png2h="pngXbrain/".$neuron."_LSM_2.png"; $png2hs="pngXbrain/".$neuron."_LSM_2s.png";
  $png3h="pngXbrain/".$neuron."_LSM_3.png"; $png3hs="pngXbrain/".$neuron."_LSM_3s.png";
  $png1h_affine="pngXbrain/".$neuron."_Resample_4_4_4_affine_1.png"; $png1hs_affine="pngXbrain/".$neuron."_Resample_4_4_4_affine_1s.png";
  $png2h_affine="pngXbrain/".$neuron."_Resample_4_4_4_affine_2.png"; $png2hs_affine="pngXbrain/".$neuron."_Resample_4_4_4_affine_2s.png";
  $png3h_affine="pngXbrain/".$neuron."_Resample_4_4_4_affine_3.png"; $png3hs_affine="pngXbrain/".$neuron."_Resample_4_4_4_affine_3s.png";

  $png1b="pngXbrain/".$neuron."_LSM_4.png"; $png1bs="pngXbrain/".$neuron."_LSM_4s.png";
  $png2b="pngXbrain/".$neuron."_LSM_5.png"; $png2bs="pngXbrain/".$neuron."_LSM_5s.png";
  $png3b="pngXbrain/".$neuron."_LSM_6.png"; $png3bs="pngXbrain/".$neuron."_LSM_6s.png";
  $png1b_affine="pngXbrain/".$neuron."_Resample_4_4_4_brain_affine_1.png"; $png1bs_affine="pngXbrain/".$neuron."_Resample_4_4_4_brain_affine_1s.png";
  $png2b_affine="pngXbrain/".$neuron."_Resample_4_4_4_brain_affine_2.png"; $png2bs_affine="pngXbrain/".$neuron."_Resample_4_4_4_brain_affine_2s.png";
  $png3b_affine="pngXbrain/".$neuron."_Resample_4_4_4_brain_affine_3.png"; $png3bs_affine="pngXbrain/".$neuron."_Resample_4_4_4_brain_affine_3s.png";
             

?>
  <?=($i+1);?>. <?=$neuron;?><br>
Option1: 
  <select name="clock_<?=$neuron;?>">
  <?php
  for($j=0;$j<=36;$j++){
   $n="clock_".$neuron;  
   if ($j==0)  {
	$c="";
   }else{
	$c=($j*10)." degree";	   
   }
   if (isset($$n) && ($$n==$j)) {
	$select=" selected=\"selected\"";
    echo '"<option value="'.$j.'" selected="selected">'.$c.'</option>"';
   }else{
    echo '"<option value="'.$j.'"">'.$c.'</option>"';
   }
  }
  ?>    
  </select>
 
  
Option2: 
  <select name="clockwise_<?=$neuron;?>">
  <?php
  for($j=0;$j<=2;$j++){
   $n="clockwise_".$neuron;  
   $c="";
   if ($j==1) $c="";

   if ($j==1) $c="clockwise";
   if ($j==2) $c="counterclockwise";
   
   if (isset($$n) && ($$n==$j)) {
	$select=" selected=\"selected\"";
    echo '"<option value="'.$j.'" selected="selected">'.$c.'</option>"';
   }else{
    echo '"<option value="'.$j.'"">'.$c.'</option>"';
   }
  }
  ?>  
 </select>

<input type="submit" name="Submit" value="Submit" /><br>
<img src="<?=$png1hs;?>">&nbsp;<img src="<?=$png2hs;?>">&nbsp;<img src="<?=$png3hs;?>"><br><br>
<img src="<?=$png1bs;?>">&nbsp;<img src="<?=$png2bs;?>">&nbsp;<img src="<?=$png3bs;?>"><br><br>

<?php
if (is_file($png3hs_affine)){
?>
<img src="<?=$png1hs_affine;?>">&nbsp;<img src="<?=$png2hs_affine;?>">&nbsp;<img src="<?=$png3hs_affine;?>"><br><br>

<?php
}
?>
<br>
<?php
if (is_file($png3bs_affine)){
?>
<img src="<?=$png1bs_affine;?>">&nbsp;<img src="<?=$png2bs_affine;?>">&nbsp;<img src="<?=$png3bs_affine;?>"><br><br>
<?php
}
?>

<br><br><br>

  

<?php    
 }   
}
?>
</form>

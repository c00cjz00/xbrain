<?php
$level=$argv[1]; $query="warp --time ".trim($argv[2]); 
$limitTime=30; $key=0;
sleep(3);
for ($i=0;$i<1000;$i++){
 if ($i>=1) sleep($limitTime); 
 $key=killProcess($query,$level,$limitTime)+$key;
 echo $i." ".$key."---\n";
 if ($key>=3) break; 
}




function killProcess($query,$level,$limitTime){
 $key=0;
 $cmd="ps -ef |grep '".$query."'";
 echo $cmd."\n";
 $tmp=shell_exec($cmd); 
 if (trim($tmp)=="") $key=1;
 $tmpArr=explode("\n",trim($tmp));
 for($i=0;$i<count($tmpArr);$i++){
  $smp=trim($tmpArr[$i]);
  $smpArr=explode("grep",$smp);
  if ((count($smpArr)==1) && eregi("nonrigid",$smp)){
   $smpArr=explode("pts",$smp);
   if (count($smpArr)==2){
    $smp0Arr=explode(" ",trim($smp));
    $rmpArr=explode(" -o ",trim($smp));
    $rmpArr=explode(" ",trim($rmpArr[1]));
    $registration=$rmpArr[0]."/level-0".$level.".list/registration.gz";
    //echo $registration." --alen\n";
    $smp1Arr=explode(" ",trim($smp),2);
    $smp2Arr=explode(" ",trim($smp1Arr[1]),2);
    $smp3Arr=explode(" ",trim($smp2Arr[1]),2);
    $smp4Arr=explode(" ",trim($smp3Arr[1]),2);
    $smp5Arr=explode(" ",trim($smp4Arr[1]),2);
    $pid1=trim($smp2Arr[0]);
    $pid2=trim($smp3Arr[0]);
    $pid3=trim($smp4Arr[0]);
    $qmp=trim($smp5Arr[0]);
    $qmpArr=explode(":",$qmp);
    $execTime=$qmpArr[0]*60+$qmpArr[1];
    //$diffTime=$time-$execTime;
    //echo $diffTime." ".$time." ".$execTime."\n";
    //echo $diffTime." > ".$limitTime."\n\n";
    //echo "pid ".$pid1."\n";
    //if ($diffTime>$limitTime){
    if (is_file($registration)){
     sleep(1);
     $cmd="kill -9 ".$pid1;
     echo $cmd."\n";
     exec($cmd);
     $key=3;
     break;
    }
    echo $registration."-------allen\n\n";
   }
  }
  if (!isset($registration)){
   $key=1;
  }  
 }
 return $key;
}
//echo $cmd."\n";
?>

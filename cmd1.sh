#!/bin/sh
#example: ./cmd.sh /disk4/gitHub/output/20170804_4_07/20170804_4_07_Resample_4_4_4.am 1
## configure
tmp=$(basename "$1")
fileBasename=${tmp%.*}
fileDirName=$(dirname "$1")
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
warpLevel="$2"
## 請修改 @@
stdFullBrain="/disk4/gitHub/demoData/stdBrain/Std_fullBrain.am"
stdInnserBrain="/disk4/gitHub/demoData/stdBrain/Std_innerBrain.am"


## others
fullBrainFile="$fileDirName/$fileBasename.am"
innerBrainFile="$fileDirName/$fileBasename""_innerBrain.am"
swcFile="$fileDirName/$fileBasename""_innerBrain.swc"
linesetFile="$fileDirName/$fileBasename""_innerBrain_lineset.am"
manualMatrixFile="$fileDirName/$fileBasename.manualMatrix"
innerBrainFile_affine_nii="$fileDirName/$fileBasename""_innerBrain_affine.nii.gz"
linesetFile_affine="$fileDirName/$fileBasename""_innerBrain_lineset_affine.am"
innerBrain_affineMatrix="$fileDirName/$fileBasename""_innerBrain.affineMatrix"
innerBrain_affineBox="$fileDirName/$fileBasename""_innerBrain_affine.box"

landmarkFile="$fileDirName/$fileBasename""_innerBrain_landmark.txt"


echo $fullBrainFile
echo $innerBrainFile
echo $swcFile
echo $linesetFile
echo $manualMatrixFile
echo $DIR

### 步驟二
## 手動對位腦程式
echo cd $DIR/step2-tranformBrainManual
echo php tranformBrainManual.php $fullBrainFile $stdFullBrain 0 0
cd $DIR/step2-tranformBrainManual 
php tranformBrainManual.php $fullBrainFile $stdFullBrain 0 0

### 步驟三.1
## 利用帶入外腦的對位的結果, 對腦內腦程式
echo cd $DIR/step3-inital_affineRegister; 
echo php affineRegister.php $fullBrainFile $innerBrainFile $manualMatrixFile $stdFullBrain $stdInnserBrain 1;
cd $DIR/step3-inital_affineRegister
php affineRegister.php $fullBrainFile $innerBrainFile $manualMatrixFile $stdFullBrain $stdInnserBrain 1

### 步驟三.2
## 拍圖
echo cd $DIR/step3-inital_affineRegister
echo php snapshot.php $fullBrainFile $innerBrainFile $stdFullBrain $stdInnserBrain
cd $DIR/step3-inital_affineRegister
php snapshot.php $fullBrainFile $innerBrainFile $stdFullBrain $stdInnserBrain


### 步驟四
## 產生非線性對位所需要的nii格式檔案
echo cd $DIR/step4-generate_niiFile; 
echo php generate_niiFile.php  $innerBrainFile $stdInnserBrain 
cd $DIR/step4-generate_niiFile
php generate_niiFile.php  $innerBrainFile $stdInnserBrain


### 步驟五
## 進行內腦nii檔案 非線性對位
echo cd $DIR/step5-niiFile_warping
echo php niiFile_warping.php $innerBrainFile_affine_nii $warpLevel
cd $DIR/step5-niiFile_warping
php niiFile_warping.php $innerBrainFile_affine_nii $warpLevel

### 步驟六 (可省略)
## swc 2 lineset format
#echo cd $DIR/step6-swc2Lineset
#echo php swc2lineset.php $swcFile $linesetFile 
#cd $DIR/step6-swc2Lineset
#php swc2lineset.php $swcFile $linesetFile 

### 步驟七
## lineset線性轉換
#echo cd $DIR/step7-skeleton_affineTransform
#echo php skeletonTransform.php $linesetFile  $innerBrain_affineMatrix
#cd $DIR/step7-skeleton_affineTransform
#php skeletonTransform.php $linesetFile  $innerBrain_affineMatrix

### 步驟八
## lineset 非線性轉換
#echo cd $DIR/step8-skeleton_streamxform
#echo php skeleton_streamxform.php $linesetFile_affine $innerBrain_affineBox $warpLevel
#cd $DIR/step8-skeleton_streamxform
#php skeleton_streamxform.php $linesetFile_affine $innerBrain_affineBox $warpLevel


### 步驟九
## landmark 線性與非線性轉換  
#echo cd $DIR/step9-landmark_affineTransform_streamxform
#echo php landmark_affineTransform_streamxform.php $landmarkFile $innerBrain_affineMatrix $warpLevel
#cd $DIR/step9-landmark_affineTransform_streamxform
#php landmark_affineTransform_streamxform.php $landmarkFile $innerBrain_affineMatrix $warpLevel

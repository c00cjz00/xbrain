### 步驟0
位置 gitHub/xbrain

## 原始資料
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.am ## 內腦
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.am ## 外腦
../../output/20170804_4_07/20170804_4_07.swc ## 神經骨幹
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_landmark.txt ## 座標點
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.manualMatrix ## 手動對位結果 (若有請從第三步驟開始執行)

### 步驟一
## 檔案與倍率轉換
cd step1-avizo2amira
php 1-avizo2amira.php ../../output/20170804_4_07/20170804_4_07.am ../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.am 4[resampleSize]
php 1-avizo2amira.php ../../output/20170804_4_07/20170804_4_07_innerBrain.am ../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.am 4[resampleSize]
## 輸出
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.am
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.am

### 步驟二
## 手動對位腦程式
cd step2-tranformBrainManual
php tranformBrainManual.php \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.am \
../../demoData/stdBrain/Std_fullBrain.am \
22 2
## 輸出
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.manualMatrix

### 步驟三.1
## 利用帶入外腦的對位的結果, 對腦內腦程式
cd step3-inital_affineRegister
php affineRegister.php \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.am \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.am \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.manualMatrix \
../../demoData/stdBrain/Std_fullBrain.am \
../../demoData/stdBrain/Std_innerBrain.am \
1 
## 輸出
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.affineMatrix
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.affineMatrix

### 步驟三.2
## 拍圖
cd step3-inital_affineRegister
php snapshot.php \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4.am \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.am \
../../demoData/stdBrain/Std_fullBrain.am \
../../demoData/stdBrain/Std_innerBrain.am
## 輸出
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine_3.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine_3s.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine_2.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine_2s.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine_1.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine_1s.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_affine_3.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_affine_3s.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_affine_2.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_affine_2s.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_affine_1.png
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_affine_1s.png

### 步驟四
## 產生非線性對位所需要的nii格式檔案
cd step4-generate_niiFile
php generate_niiFile.php  \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.am \
../../demoData/stdBrain/Std_innerBrain.am
## 輸出
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine_std.nii.gz
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine.nii.gz
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine.box


### 步驟五
## 進行內腦nii檔案 非線性對位
cd step5-niiFile_warping
php niiFile_warping.php \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine.nii.gz \
1
## 輸出
../../output/20170804_4_07/0-affine
../../output/20170804_4_07/0-nonrigid
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine_warp1.nii.gz

### 步驟六 (可省略)
## swc 2 lineset format
cd step6-swc2Lineset
php swc2lineset.php \
../../demoData/swcFile/20170804_4_07.swc \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_lineset.am 
## 輸出
../../output/20170804_4_07/20170804_4_07.swc > 20170804_4_07_Resample_4_4_4_innerBrain_lineset.am

### 步驟七
## lineset線性轉換
cd step7-skeleton_affineTransform
php skeletonTransform.php \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_lineset.am  \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.affineMatrix
## 輸出
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_lineset_affine.am

### 步驟八
## lineset 非線性轉換
cd step8-skeleton_streamxform
php skeleton_streamxform.php \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_lineset_affine.am  \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_affine.box \
1
## 輸出
../../output/20170804_4_07/20170804_4_07_innerBrain_lineset_affine_warp1.am

### 步驟九
## landmark 線性與非線性轉換
cd step9-landmark_affineTransform_streamxform
php landmark_affineTransform_streamxform.php \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_landmark.txt \
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.affineMatrix \
1
## 輸出
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_landmark.txt.am
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_landmark.txt_affine.am
../../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain_landmark.txt_affine_warp.am






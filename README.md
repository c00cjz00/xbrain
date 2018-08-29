### 步驟0
## 原始資料
20170728_33_02_Resample_4_4_4_innerBrain.am ## 內腦
20170728_33_02_Resample_4_4_4.am ## 外腦

### 步驟一
## 檔案與倍率轉換
cd step1-avizo2amira
php avizo2amira.php [neuron.gz/neuron]
## 輸出
amira file format / resampled file

### 步驟二
## 手動對位腦程式
php tranformBrainManual.php \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4.am \
../../demoData/stdBrain/Std_fullBrain.am \
22 2
## 輸出
20170728_33_02_Resample_4_4_4.manualMatrix

### 步驟三.1
## 利用帶入外腦的對位的結果, 對腦內腦程式
php affineRegister.php \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4.am \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain.am \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4.manualMatrix \
../../demoData/stdBrain/Std_fullBrain.am \
../../demoData/stdBrain/Std_innerBrain.am
## 輸出
20170728_33_02_Resample_4_4_4.affineMatrix
20170728_33_02_Resample_4_4_4_innerBrain.affineMatrix

### 步驟三.2
## 拍圖
php snapshot.php \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4.am \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain.am \
../../demoData/stdBrain/Std_fullBrain.am \
../../demoData/stdBrain/Std_innerBrain.am
## 輸出
20170728_33_02_Resample_4_4_4_innerBrain_affine_3.png
20170728_33_02_Resample_4_4_4_innerBrain_affine_3s.png
20170728_33_02_Resample_4_4_4_innerBrain_affine_2.png
20170728_33_02_Resample_4_4_4_innerBrain_affine_2s.png
20170728_33_02_Resample_4_4_4_innerBrain_affine_1.png
20170728_33_02_Resample_4_4_4_innerBrain_affine_1s.png
20170728_33_02_Resample_4_4_4_affine_3.png
20170728_33_02_Resample_4_4_4_affine_3s.png
20170728_33_02_Resample_4_4_4_affine_2.png
20170728_33_02_Resample_4_4_4_affine_2s.png
20170728_33_02_Resample_4_4_4_affine_1.png
20170728_33_02_Resample_4_4_4_affine_1s.png

### 步驟四
## 產生非線性對位所需要的nii格式檔案
php generate_niiFile.php  \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain.am \
../../demoData/stdBrain/Std_innerBrain.am
## 輸出
20170728_33_02_Resample_4_4_4_innerBrain_affine_std.nii.gz
20170728_33_02_Resample_4_4_4_innerBrain_affine.nii.gz
20170728_33_02_Resample_4_4_4_innerBrain_affine.box


### 步驟五
## 進行內腦nii檔案 非線性對位
php niiFile_warping.php \
/disk4/work/201707_output/20170730_43_01_Resample_4_4_4_brain.am \
1
## 輸出
0-affine
0-nonrigid
20170728_33_02_Resample_4_4_4_innerBrain_affine_warp1.nii.gz

### 步驟六 (可省略)
## swc 2 lineset format
php swc2lineset.php \
../../demoData/swcFile/20170728_33_02.swc \
.../../demoData/linesetFile/20170728_33_02_innerBrain_lineset.am
## 輸出
20170728_33_02.swc > 20170728_33_02_innerBrain_lineset.am

### 步驟七
## lineset線性轉換
php skeletonTransform.php \
.../../demoData/linesetFile/20170728_33_02_innerBrain_lineset.am \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain.affineMatrix
## 輸出
20170728_33_02_innerBrain_lineset_affine.am

### 步驟八
## lineset 非線性轉換
php skeleton_streamxform.php \
../../demoData/linesetFile/20170728_33_02_innerBrain_lineset_affine.am \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain_affine.box \
1
## 輸出
20170728_33_02_innerBrain_lineset_affine_warp1.am

### 步驟九
## landmark 線性與非線性轉換
php landmark_affineTransform_streamxform.php \
../../demoData/linesetFile/20170728_33_02_innerBrain_point.txt \
../../demoData/20170728_33_02/20170728_33_02_Resample_4_4_4_innerBrain.affineMatrix \
1
## 輸出
20170728_33_02_innerBrain_point.txt.am
20170728_33_02_innerBrain_point.txt.am_affine
20170728_33_02_innerBrain_point.txt.am_affine_warp






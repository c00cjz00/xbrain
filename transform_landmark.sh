#!/bin/sh
#example: ./transform_landmark.sh ../output/20170804_4_07/20170804_4_07_Resample_4_4_4_innerBrain.affineMatrix /tmp/landmark.txt
## configure
matrixFile="$1"
landmarkFile="$2"

### 步驟十
## landmark 線性與非線性轉換  
echo cd $DIR/step10-userLandmark_affineTransform_streamxform/
echo php landmark_affineTransform_streamxform.php $matrixFile $landmarkFile
#php landmark_affineTransform_streamxform.php $matrixFile $landmarkFile


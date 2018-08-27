#!/bin/sh
#example: ./cmd.sh ../20170425/Gad1-Fa-800660.am 100 1 vgl
inputBrain="$(cd "$(dirname "$1")"; pwd)/$(basename "$1")"
lenExt=$2 #brain bounding box length extension
lenMin=$3 #brain bounding box length extension

level=$4 # warping level
gui=$5 # vgl/novgl
#matrixFile=0
if [ $# -eq 6 ]
then
matrixFile="$(cd "$(dirname "$6")"; pwd)/$(basename "$6")"
fi
              

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

echo cd $DIR/affineRegister; cd $DIR/affineRegister 
echo php affineRegister.php $inputBrain $lenExt $lenMin $gui $matrixFile; php affineRegister.php $inputBrain $lenExt $lenMin $gui $matrixFile
echo cd $DIR/warping; cd $DIR/warping;
echo php warp_after_affineRegistration.php $inputBrain $lenExt $level $gui;  php warp_after_affineRegistration.php $inputBrain $lenExt $level $gui
echo cd $DIR; cd $DIR
echo cd $DIR/skeletonTransform; cd $DIR/skeletonTransform
echo php skeletonTransform.php $inputBrain $lenExt $level; php skeletonTransform.php $inputBrain $lenExt $level;
echo cd $DIR; cd $DIR
echo cd $DIR/streamxform; cd $DIR/streamxform;
echo php streamxform.php $inputBrain $lenExt $level; php streamxform.php $inputBrain $lenExt $level;
echo cd $DIR; cd $DIR



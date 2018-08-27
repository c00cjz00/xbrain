# Amira Script
proc getHistogram {brain} {
 remove Histogram
 global thePlot
 set range [ $brain getRange ]
 set thresholdMax [lindex $range 1]
 create HxHistogram Histogram
 Histogram data connect $brain
 Histogram fire
 Histogram range setState item 1 1 item 3 $thresholdMax
 Histogram numBins setMinMax 1 $thresholdMax
 Histogram numBins setButtons 1
 Histogram numBins setIncrement 1
 Histogram numBins setValue $thresholdMax
 Histogram numBins setFormat %.0f
 Histogram action setValue hit 1
 Histogram fire

 Histogram histogramOptions setState item 0 0 item 1 0 item 2 0
 Histogram action hit
 Histogram fire
}

proc thresholdDetect {brain minValue maxValue rValue} {
 global thePlot

 Histogram range setState item 1 $minValue item 3 $maxValue
 Histogram action setValue hit 1
 Histogram fire
 set mean [ Histogram getMeanInRange ]
 set deviation [ Histogram getDeviationInRange ]
 set rmsd [ Histogram getRMSInRange ]

 if {$rValue==1} {
  set returnValue $mean
 } elseif {$rValue==2} {
  set returnValue $deviation
 }
 return $returnValue
}


proc boxingMax {brain} {
viewer 0 setAutoRedraw 1
remove lineset box
set xLen 1025
set yLen 525
set dim [ $brain getDims ]
set x [lindex $dim 0]
set y [lindex $dim 1]
set centerX [expr (($x-1)/2.0)]
set centerY [expr (($y-1)/2.0)]
set x1 [expr ($centerX-($xLen))]
set x2 [expr ($centerX+($xLen))]
set y1 [expr ($centerY-($yLen))]
set y2 [expr ($centerY+($yLen))]
create HxLineSet lineset
lineset addPoint $x1 $y1 0
lineset addPoint $x1 $y2 0
lineset addPoint $x2 $y1 0
lineset addPoint $x2 $y2 0
create HxBoundingBox box
box data connect lineset
box fire

# Create viewers
theMain setTopLevelConsole 1
theMain setTopLevelPanel 1
#viewer 0 setSize 800 600
viewer 0 setSize 2200 1500
viewer 0 setPosition 10 10

#viewer setVertical 0
#viewer 0 setBackgroundMode 0
#viewer 0 setBackgroundColor 0 0 0
viewer 0 setCameraOrientation 2.41759e-06 1.61172e-06 1 3.14159
viewer 0 setCameraPosition 944.006 513.004 1151.63
viewer 0 setCameraFocalDistance 1151.63
viewer 0 setCameraNearDistance 1150.47
viewer 0 setCameraFarDistance 1152.79
viewer 0 setCameraType orthographic
viewer 0 setCameraHeight 1419.66
viewer 0 redraw

viewer 0 viewAll
viewer 0 redraw
set a [ viewer 0 getCameraHeight ]
set b [expr ($a*0.62)]
viewer 0 setCameraHeight $b
viewer 0 redraw
remove lineset box
viewer 0 redraw
}




#Function tranlate to 1 1 3.875
proc 3875c {input} {
set brainDims [ $input getDims ]
set brainDimsX [lindex $brainDims 0]
set brainDimsY [lindex $brainDims 1]
set brainDimsZ [lindex $brainDims 2]
if {$brainDimsZ > 75} {
set scaleValue 1
} else {
set scaleValue 1  
#set scaleValue 1.9
}
set c31 [expr ($brainDimsX-1)]
set c41 [expr ($brainDimsY-1)]
set c51 [expr ($scaleValue*3.875*($brainDimsZ-1))]
$input setBoundingBox 0 $c31 0 $c41 0 $c51
}

#Function tranlate to 1 1 1
proc 111c {input} {
set brainDims [ $input getDims ]
set brainDimsX [lindex $brainDims 0]
set brainDimsY [lindex $brainDims 1]
set brainDimsZ [lindex $brainDims 2]
set c31 [expr ($brainDimsX-1)]
set c41 [expr ($brainDimsY-1)]
set c51 [expr ($brainDimsZ-1)]
$input setBoundingBox 0 $c31 0 $c41 0 $c51
}




#Function seperate window
proc seperateWindow {} {
theMain setTopLevelConsole 1
theMain setTopLevelPanel 1
viewer 0 setSize 800 600
#viewer 0 setSize 2048 1536
viewer 0 setPosition 10 10
}

proc seperateWindow850 {} {
theMain setTopLevelConsole 1
theMain setTopLevelPanel 1
viewer 0 setSize 850 600
#viewer 0 setSize 2048 1536
viewer 0 setPosition 10 10
}

proc seperateWindow2048 {} {
theMain setTopLevelConsole 1
theMain setTopLevelPanel 1
#viewer 0 setSize 800 600
viewer 0 setSize 2048 1536
viewer 0 setPosition 10 10
}

#Function merage window
proc merageWindow {} {
theMain setTopLevelConsole 0
theMain setTopLevelPanel 0
viewer 0 setSize 800 600
}

#Function standardPosition
proc standardPosition {} {
viewer 0 setCameraType 1
viewer 0 setCameraPosition -2.01193 -42.999 776.032
viewer 0 setCameraOrientation -0.169832 -0.0173756 0.98532 6.28111
viewer 0 setCameraFocalDistance 776.046
viewer 0 setAutoRedraw 1
viewer 0 redraw
}

proc drawLine {Xmax Ymax Zmax} {
        set Xmin 0
        set Xmax $Xmax
        set Ymin 0
        set Ymax $Ymax
        set Zmax $Zmax

        set Xcenter [expr (($Xmax+$Xmin)/2)]
        set distance [expr (1024/8)]
        set lineX1 [expr ($Xcenter-($distance*3))]
        set lineX2 [expr ($Xcenter-($distance*2))]
        set lineX3 [expr ($Xcenter-($distance*1))]
        set lineX4 [expr ($Xcenter-($distance*0))]
        set lineX5 [expr ($Xcenter+($distance*1))]
        set lineX6 [expr ($Xcenter+($distance*2))]
        set lineX7 [expr ($Xcenter+($distance*3))]

        # AmiraMesh 3D ASCII 2.0
        create HxLineSet Line0
        Line0 hideIcon
        Line0 addPoint $lineX1 $Ymin $Zmax
        Line0 addPoint $lineX1 $Ymax $Zmax
        Line0 addPoint $lineX2 $Ymin $Zmax
        Line0 addPoint $lineX2 $Ymax $Zmax
        Line0 addPoint $lineX3 $Ymin $Zmax
        Line0 addPoint $lineX3 $Ymax $Zmax
        Line0 addPoint $lineX4 $Ymin $Zmax
        Line0 addPoint $lineX4 $Ymax $Zmax
        Line0 addPoint $lineX5 $Ymin $Zmax
        Line0 addPoint $lineX5 $Ymax $Zmax
        Line0 addPoint $lineX6 $Ymin $Zmax
        Line0 addPoint $lineX6 $Ymax $Zmax
        Line0 addPoint $lineX7 $Ymin $Zmax
        Line0 addPoint $lineX7 $Ymax $Zmax
        Line0 addLine 0 1
        Line0 addLine 2 3
        Line0 addLine 4 5
        Line0 addLine 6 7
        Line0 addLine 8 9
        Line0 addLine 10 11
        Line0 addLine 12 13

        # AmiraMesh 3D ASCII 2.0
        set pp 20
        set XP1 [expr ($Xcenter-($distance*3.5)-$pp)]
        set XP2 [expr ($Xcenter-($distance*2.5)-$pp)]
        set XP3 [expr ($Xcenter-($distance*1.5)-$pp)]
        set XP4 [expr ($Xcenter-($distance*0.5)-$pp)]
        set XP5 [expr ($Xcenter+($distance*0.5)-$pp)]
        set XP6 [expr ($Xcenter+($distance*1.5)-$pp)]
        set XP7 [expr ($Xcenter+($distance*2.5)-$pp)]
        set XP8 [expr ($Xcenter+($distance*3.5)-$pp)]
        set YPmin [expr ($Ymin-65)]
        set YPmax [expr ($Ymax+10)]


        create HxLineSet Line1
        Line1 hideIcon
        Line1 addPoint $XP1 $YPmin $Zmax
        Line1 addPoint $XP2 $YPmin $Zmax
        Line1 addPoint $XP3 $YPmin $Zmax
        Line1 addPoint $XP4 $YPmin $Zmax
        Line1 addPoint $XP5 $YPmin $Zmax
        Line1 addPoint $XP6 $YPmin $Zmax
        Line1 addPoint $XP7 $YPmin $Zmax
        Line1 addPoint $XP8 $YPmin $Zmax

        create HxLineSet Line2
        Line2 hideIcon
        Line2 addPoint $XP1 $YPmax $Zmax
        Line2 addPoint $XP2 $YPmax $Zmax
        Line2 addPoint $XP3 $YPmax $Zmax
        Line2 addPoint $XP4 $YPmax $Zmax
        Line2 addPoint $XP5 $YPmax $Zmax
        Line2 addPoint $XP6 $YPmax $Zmax
        Line2 addPoint $XP7 $YPmax $Zmax
        Line2 addPoint $XP8 $YPmax $Zmax

        create HxDisplayLineSet LineSetView0
        LineSetView0 hideIcon
        LineSetView0 data connect Line0
        LineSetView0 setLineWidth 5
        LineSetView0 fire


        create HxDisplayVertices VertexView1
        VertexView1 hideIcon
        VertexView1 data connect Line1
        VertexView1 fire
        #VertexView1 color setIndex 0 0
        VertexView1 drawStyle setValue 2
        VertexView1 pointSize setMinMax 1 10
        VertexView1 pointSize setValue 1
        VertexView1 options setValue 0 1
        VertexView1 options setValue 1 0
        VertexView1 options setValue 2 0
        VertexView1 fontSize setMinMax 5 50
        VertexView1 fontSize setValue 50
        VertexView1 setTextColor 1 1 1
        VertexView1 pointStarts1
        VertexView1 fire

        create HxDisplayVertices VertexView2
        VertexView2 hideIcon
        VertexView2 data connect Line2
        VertexView2 fire
        #VertexView2 color setIndex 0 0
        VertexView2 drawStyle setValue 2
        VertexView2 pointSize setMinMax 1 10
        VertexView2 pointSize setValue 1
        VertexView2 options setValue 0 1
        VertexView2 options setValue 1 0
        VertexView2 options setValue 2 0
        VertexView2 fontSize setMinMax 5 50
        VertexView2 fontSize setValue 50
        VertexView2 setTextColor 1 1 1
        VertexView2 pointStarts1
        VertexView2 fire

}

	
proc bViewer {brain color_one vStatus} {
	$brain setTransform
	set tmp Volren$brain
	remove $tmp
	set tmp color$brain
	remove $tmp
	remove Result ResultSmooth Annotation colorstandard1 colorstandard2 Registration Save2File modules_allen.scro modules_doc.scro standard1 standard2 Line0 Line1 Line2
	
	remove Voltex_sample color_one OrthoSlice Volren Volren2 Volren3 Voltex Voltex2 Voltex3 colorcropBrain VolrencropBrain cropBrain standard3
	
	viewer 0 redraw
	
	#sample data  information
	#set hideNewModules 0
	
	set c [$brain parameters Content getValue]
	set c1 [lindex $c 0]
	set c2 [split $c1 x]
	set c3 [lindex $c2 0]
	set c4 [lindex $c2 1]
	set c5 [lindex $c2 2]
	set c31 [expr ($c3-1)]
	set c41 [expr ($c4-1)]
	set c51 [expr (1.0*3.875*($c5-1))]
	echo $c31
	echo $c41
	echo $c51
	#$brain setBoundingBox 0 $c31 0 $c41 0 $c51
        3875c $brain 
	
	#drawLine $c31 $c41 $c51
	set sample_range [ $brain getRange ]
	set sample_range_max [lindex $sample_range 1]
	set hideNewModules 1
	
	
	[ load $color_one ] setLabel color_one
	color_one hideIcon
	if {$sample_range_max > 255} {
	{color_one} setMinMax 300 1300
	set alpha_value 0.5
	} else {
	{color_one} setMinMax 20 70
	set alpha_value 0.5
	}
	color_one fire
	
	
	set hideNewModules 0
	create HxVoltex {Voltex_sample}
	Voltex_sample data connect $brain
	Voltex_sample colormap connect color_one
	Voltex_sample alphaScale setMinMax 0 1
	Voltex_sample alphaScale setButtons 0
	Voltex_sample alphaScale setIncrement 0.1
	Voltex_sample alphaScale setValue $alpha_value
	Voltex_sample alphaScale setSubMinMax 0 1
	Voltex_sample downsample setValue 0 2
	Voltex_sample downsample setValue 1 2
	Voltex_sample downsample setValue 2 1
	Voltex_sample doIt hit
	Voltex_sample fire
	
	
	
	set hideNewModules 0
	create HxOrthoSlice {OrthoSlice}
	OrthoSlice hideIcon
	OrthoSlice setIconPosition 298 40
	OrthoSlice data connect $brain
	{OrthoSlice} fire
	set sliceNumber_max [ OrthoSlice sliceNumber getMaxValue ]
	set sliceNumber_center [expr ($sliceNumber_max/2)]
	OrthoSlice sliceOrientation setValue 0
	{OrthoSlice} fire
	OrthoSlice options setValue 0 0
	OrthoSlice options setValue 1 0
	OrthoSlice options setValue 2 0
	OrthoSlice mappingType setValue 0 0
	OrthoSlice linearRange setMinMax 0 -1.00000001384843e+024 1.00000001384843e+024
	OrthoSlice linearRange setValue 0 0
	OrthoSlice linearRange setMinMax 1 -1.00000001384843e+024 1.00000001384843e+024
	OrthoSlice linearRange setValue 1 4095
	OrthoSlice contrastLimit setMinMax 0 -1.00000001384843e+024 1.00000001384843e+024
	OrthoSlice contrastLimit setValue 0 7
	OrthoSlice colormap setDefaultColor 1 0.8 0.5
	OrthoSlice colormap setDefaultAlpha 1.000000
	#OrthoSlice colormap connect glow.col
	OrthoSlice sliceNumber setMinMax 0 $sliceNumber_max
	OrthoSlice sliceNumber setButtons 1
	OrthoSlice sliceNumber setIncrement 1
	OrthoSlice sliceNumber setValue $sliceNumber_center
	OrthoSlice transparency setValue 0
	OrthoSlice setFrameWidth 0
	OrthoSlice setFrameColor 1 0.5 0
	OrthoSlice frame 1
	OrthoSlice fire
	
	OrthoSlice fire
	OrthoSlice setViewerMask 65535
	
	
	viewer 0 setAutoRedraw 0
	viewer 0 setCameraType 1
	viewer 0 setCameraPosition 517.374 515.142 1788.13
	viewer 0 setCameraOrientation 0.435322 -0.704421 -0.560612 6.27784
	viewer 0 setCameraFocalDistance 1561.46
	viewer 0 setAutoRedraw 1
	viewer 0 setCameraType orthographic

        viewer 0 viewAll
        set a [ viewer 0 getCameraHeight ]
        set b [expr ($a*0.50)]
        viewer 0 setCameraHeight $b
        viewer 0 setAutoRedraw 1
	

	if { $vStatus == 1 } {
	viewer rotate 88 x
	viewer 0 redraw
	} else {
	drawLine $c31 $c41 $c51
	viewer 0 redraw
	}

}


proc LSM_affine {brain std snapshot_1 snapshot_2 snapshot_3} {
 create HxBoundingBox box2;  box2 data connect $brain;  box2 fire;
 getHistogram $brain
 set mean1 [thresholdDetect $brain 0 65535 1]
 #set mean2 [thresholdDetect $brain $mean1 65535 1]
 set mean2 [thresholdDetect $brain 0 65535 1]
 #set mean2 mean1
 remove purpleLSM; [ load purpleLSM.am ] setLabel purpleLSM;  purpleLSM setMinMax $mean2 65535;  purpleLSM  fire;
 remove VolrenLSM
 create HxVolren VolrenLSM
 VolrenLSM data connect $brain
 VolrenLSM color0 connect purpleLSM
 VolrenLSM alphaScale0 setMinMax 0 1
 VolrenLSM alphaScale0 setValue 1
 VolrenLSM commonMode setState item 0 0 item 1 0 
 VolrenLSM shading setValue 0
 VolrenLSM fire

 remove greenLSM; [ load greenLSM.am ] setLabel greenLSM;  greenLSM setMinMax $mean2 65535;  greenLSM  fire;
 remove VolrenLSM2
 create HxVolren VolrenLSM2
 VolrenLSM2 data connect $std
 VolrenLSM2 color0 connect greenLSM
 VolrenLSM2 alphaScale0 setMinMax 0 1
 VolrenLSM2 alphaScale0 setValue 1
 VolrenLSM2 commonMode setState item 0 0 item 1 0
 VolrenLSM2 shading setValue 0
 VolrenLSM2 fire


 viewer 0 setCameraType 0
 #XYviewer
 viewer 0 viewAll
 viewer 0 redraw
 viewer 0 snapshot -alpha $snapshot_1

 # XZ
 viewer 0 rotate -90 x
 viewer 0 viewAll
 viewer 0 redraw
 viewer 0 snapshot -alpha $snapshot_2

 # YZ
 viewer 0 rotate 90 z
 viewer 0 viewAll
 viewer 0 redraw
 viewer 0 snapshot -alpha $snapshot_3


}


proc LSM_affine_warp {brain std warp snapshot_1 snapshot_2 snapshot_3 snapshot_4 snapshot_5 snapshot_6} {
 create HxBoundingBox box2;  box2 data connect $brain;  box2 fire;
 getHistogram $brain
 set mean1 [thresholdDetect $brain 0 65535 1]
 set mean2 [thresholdDetect $brain $mean1 65535 1]
 remove purpleLSM; [ load purpleLSM.am ] setLabel purpleLSM;  purpleLSM setMinMax $mean2 65535;  purpleLSM  fire;
 remove VolrenLSM
 create HxVolren VolrenLSM
 VolrenLSM data connect $brain
 VolrenLSM color0 connect purpleLSM
 VolrenLSM alphaScale0 setMinMax 0 1
 VolrenLSM alphaScale0 setValue 1
 VolrenLSM commonMode setState item 0 0 item 1 0 
 VolrenLSM shading setValue 0
 VolrenLSM fire

 remove greenLSM; [ load greenLSM.am ] setLabel greenLSM;  greenLSM setMinMax $mean2 65535;  greenLSM  fire;
 remove VolrenLSM2
 create HxVolren VolrenLSM2
 VolrenLSM2 data connect $std
 VolrenLSM2 color0 connect greenLSM
 VolrenLSM2 alphaScale0 setMinMax 0 1
 VolrenLSM2 alphaScale0 setValue 1
 VolrenLSM2 commonMode setState item 0 0 item 1 0
 VolrenLSM2 shading setValue 0
 VolrenLSM2 fire

 viewer 0 setCameraType 0
 #XYviewer
 viewer 0 viewAll
 viewer 0 redraw
 viewer 0 snapshot -alpha $snapshot_1

 # XZ
 viewer 0 rotate -90 x
 viewer 0 viewAll
 viewer 0 redraw
 viewer 0 snapshot -alpha $snapshot_2

 # YZ
 viewer 0 rotate 90 z
 viewer 0 viewAll
 viewer 0 redraw
 viewer 0 snapshot -alpha $snapshot_3

 #reset
 viewer 0 rotate -90 z
 viewer 0 rotate 90 x


 remove VolrenLSM
 create HxVolren VolrenLSM
 VolrenLSM data connect $warp
 VolrenLSM color0 connect purpleLSM
 VolrenLSM alphaScale0 setMinMax 0 1
 VolrenLSM alphaScale0 setValue 1
 VolrenLSM commonMode setState item 0 0 item 1 0
 VolrenLSM shading setValue 0
 VolrenLSM fire

 viewer 0 setCameraType 0
 #XYviewer
 viewer 0 viewAll
 viewer 0 redraw
 viewer 0 snapshot -alpha $snapshot_4

 # XZ
 viewer 0 rotate -90 x
 viewer 0 viewAll
 viewer 0 redraw
 viewer 0 snapshot -alpha $snapshot_5

 # YZ
 viewer 0 rotate 90 z
 viewer 0 viewAll
 viewer 0 redraw
 viewer 0 snapshot -alpha $snapshot_6



}


#[ load /flycircuit_3/release/data2014/Gad1-F-400773_seg001.am ] setLabel neuron
# thresholdMin neuron

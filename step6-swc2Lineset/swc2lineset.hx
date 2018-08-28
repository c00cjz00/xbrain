# Amira Script

proc swc2lineset {swcFile linesetFile} {
set hideNewModules 0
#set swcFile 20170729_46_03_Resampled-brain.swc
#set linesetFile 20170729_46_03_Resampled-brain.am

[ load $swcFile ] setLabel swc
swc fire

set hideNewModules 0
create CastHxSpatialGraphToHxLineSet {SpatialGraphToLineSet}
SpatialGraphToLineSet data connect swc
SpatialGraphToLineSet fire

set hideNewModules 0
[ {SpatialGraphToLineSet} action hit; {SpatialGraphToLineSet} fire; {SpatialGraphToLineSet} getResult ] setLabel {LineSet}
LineSet fire

LineSet parameters setValue Filename $linesetFile
LineSet parameters setValue SaveInfo "AmiraMesh ascii Lineset"
LineSet save

}

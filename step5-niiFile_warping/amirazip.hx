# Generated by Amira 6.3.0

proc amirazip {inputFile saveFile} {
set hideNewModules 0
[ load $inputFile ] setLabel Input; Input fire;           
Input parameters setValue Filename $saveFile
Input parameters setValue SaveInfo "AmiraMesh ZIP"
Input save
}
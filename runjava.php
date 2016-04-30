<?php
$bp=130;
$hr=74;
$sp=98;
$rr=11;
$name="Bharathi";
$age=21;$sex="male";
$pt = shell_exec('java -cp .;libs\1.jar;libs\2.jar;libs\3.jar;libs\4.jar;libs\5.jar;libs\6.jar;libs\7.jar;libs\8.jar;libs\mysql.jar classification.TestData '.$name.' '.$age.' '.$sex.' '.$hr.' '.$rr.' '.$bp.' 450 '.$sp.'');
echo $pt;
//javac -cp lib\mysql.jar classification\*.java geneticalgorithm\*.java

?>
<?php
	function summary_pac($id,$name){
	$host='localhost';
	$uname='root';
	$pwd='';
	$db="project";
	$pid=$id;
	//echo "hi";
	$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
	mysql_select_db($db,$con) or die("db selection failed");
	$previd=0;
	$one=0;
	//echo "hi";
	$query=mysql_query("SELECT pid,name,sex FROM patprofile WHERE pid='$id'") or die(mysql_error());
	while($row=mysql_fetch_array($query))
	{
		//$pid=$row['pid'];
		$name=$row['name'];
		$sex=$row['sex'];
		//$name=$row['name'];
		$hr=0;
		$br=0;
		$bpsys=0;
		$bpdia=0;
		$ecg=0;
		$spo2=0;
		$time=0;
		$did=0;
		$ts=mysql_query("SELECT time FROM timestamp WHERE pid='$id' ORDER BY time DESC")or die(mysql_error());
			$two=0;
			while($res=mysql_fetch_array($ts))
			{
				if($two==1){
				$time=$res['time'];
				break;
				}
				$two++;
			}
	//	echo "Last inserted ".$time."<br>";
		$q2=mysql_query("SELECT * FROM project WHERE pid='$pid' AND name='$name' AND time>'$time' ORDER BY time");
		$nrows=mysql_num_rows($q2);
		if($nrows==10){
			$q2=mysql_query("SELECT * FROM project WHERE pid='$pid' AND name='$name' AND time>'$time' ORDER BY time") or die (mysql_error());
			//$ten=0;
		
		//if(mysql_num_rows($q2)==10)
			while($inner=mysql_fetch_array($q2))
			{
				$hr+=$inner['hr'];
				//echo "inner HR ".$hr."<br>";
				$br+=$inner['br'];
				$bpsys+=$inner['bp_systole'];
				$bpdia+=$inner['bp_diastole'];
				$ecg+=$inner['ecg'];
				$spo2+=$inner['spo2'];
				$did=$inner['did'];
			}
	//		echo "hello<br>";
			$hr/=10;
			$br/=10;
			$bpsys/=10;
			$bpdia/=10;
			$ecg/=10;
			$spo2/=10;
			/*echo "To be inserted in summary<br>";
			echo $pid."<br>";
			echo $hr."<br>";
			echo $br. "<br>";
			echo $bpsys. "<br>";
			echo $bpdia. "<br>";
			echo $ecg. "<br>";
			echo $spo2. "<br>";
			echo $did. "<br>";*/
			$ins=mysql_query("INSERT INTO summary VALUES('$pid','$name','$hr','$br','$bpsys','$bpdia','$ecg','$spo2','$time','$did')") or die(mysql_error());
$pt = shell_exec('java -cp .;libs\1.jar;libs\2.jar;libs\3.jar;libs\4.jar;libs\5.jar;libs\6.jar;libs\7.jar;libs\8.jar;libs\mysql.jar classification.TestData '.$name.' '.$age.' '.$sex.' '.$hr.' '.$rr.' '.$bpsys.' '.$ecg.' '.$spo2);
			//echo $pt;
			//if($ins)
				//echo "Summary generated<br>";
		//echo "Success<br>";
		//$one++;
	}
	}
}
?>
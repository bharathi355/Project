<?php
	include "generatesummary.php";
	include "call_clustering.php";
		
//	include "db.php";
$host='localhost';
$uname='root';
$pwd='';
$db="project";
	$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
	mysql_select_db($db,$con) or die("db selection failed");
	
	$pid=$_REQUEST['p_id'];
	$name=$_REQUEST['name'];
	$hr=$_REQUEST['hr'];
	$br=$_REQUEST['br'];
	$systole=$_REQUEST['systole'];
	$diastole=$_REQUEST['diastole'];
	$ecg=$_REQUEST['ecg'];
	$spo2=$_REQUEST['spo2'];
	$lon=$_REQUEST['lon'];
	$lat=$_REQUEST['lat'];
	//$acti=$_REQUEST['acti'];
	//$_REQUEST['did'];
	$did="";
	/*
	
	$pid=8027;
	$name="Bharathi A";
	$age="21";
	$sex="male";
	$hr="80";
	$br="13";
	$systole="150";
	$diastole="120";
	$ecg="-470";
	$spo2="90";	
	$did="3";	//$pid=$id;
	$did=""; */
	$lat.=" , ".$lon;
	$query=mysql_query("SELECT did FROM patprofile WHERE pid='$pid'") or die(mysql_error());
	while($s=mysql_fetch_array($query))
	{
		$did=$s['did'];
		break;
	}
	$flag['code']=0;
	//if($hr>0&&$age>0&&$age<120&&$br>0&&$spo2>0&&$systole>0){
		$ecg=intval($ecg);
		if($ecg<0)
			$ecg*=-1;
		$ecg=strval($ecg);
		$r=mysql_query("insert into project (pid, name,hr, br,bp_systole,bp_diastole,ecg,spo2,location,did) values('$pid','$name','$hr','$br','$systole','$diastole','$ecg','$spo2','$lat','$did')") or die(mysql_error());
		if($r){
			$flag['code']=1;	
		}
		$cnt=mysql_query("SELECT * FROM project WHERE pid='$pid'");
		$cnt1=mysql_num_rows($cnt);
		if($cnt1%10==0)
		{
			$time="";
			$ts=mysql_query("SELECT time FROM project WHERE pid='$pid' ORDER BY time DESC")or die(mysql_error());
			while($res=mysql_fetch_array($ts))
			{
				$time=$res['time'];
				break;
			}
			$ins=mysql_query("INSERT INTO timestamp VALUES('$pid','$time')")or die(mysql_error());
			if($ins)
			{
			}
		}
		
	print(json_encode($flag));
	
	$age="";
	$sex="";
	$getdetails=mysql_query("SELECT sex,age FROM patprofile WHERE pid='$pid'") or die(mysql_error());
	while($val=mysql_fetch_array($getdetails))
	{
		$age=$val['age'];
		$sex=$val['sex'];
		break;
	}
	mysql_close($con);
	
	summary_pac($pid,$name);
	init_clusters($pid,$sex,$age);
	//}
	//else
		//print(json_encode($flag));
	
	?>
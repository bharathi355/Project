<?php
//	include "call_clustering.php";
	
//	include "db.php";
	$host='localhost';
$uname='root';
$pwd='';
$db="project";
	$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
	mysql_select_db($db,$con) or die("db selection failed");
	//$pid="";
	$que=mysql_query("SELECT (pid) FROM patprofile ORDER BY pid DESC")or die(mysql_error());
	
	while($ro=mysql_fetch_array($que))
	{
		$pid=$ro['pid'];
		break;
	}
	$pid+=1;
	
	//$getid=mysql_query("SELECT max(pid) ")
	//$id="";
	//$id=$_REQUEST['p_id'];
	$name=$_REQUEST['name'];
	$age=$_REQUEST['age'];
	$sex=$_REQUEST['sex'];
	$email=$_REQUEST['email'];
	$phone=$_REQUEST['phone'];
	$city=$_REQUEST['city'];
	/*$name="ulty";
	$age="18";
	$sex="male";
	$email="ulty";
	$phone="9999";
	$city="chennai";*/
	$did="";//$_REQUEST['did'];
	$query=mysql_query("SELECT did FROM doctor WHERE city='$city'") or die(mysql_error());
	if(mysql_num_rows($query)>0)
	{
		$cnt=mysql_num_rows($query);
		$val=1;
		$ran=rand(1,$cnt);
		while($res=mysql_fetch_array($query))
		{
			if($val==$ran)
			{
				$did=$res['did'];
				break;
			}
			$val++;
		}
	}
	else
	{
		$query=mysql_query("SELECT did FROM doctor") or die(mysql_error());
		$ran=rand(1,mysql_num_rows($query));
		$val=1;
		while($res=mysql_fetch_array($query))
		{
			if($val==$ran)
			{
				$did=$res['did'];
				break;
			}
			$val++;
		}
	}
	$flag['code']=0;
	//$pid="";
		$r=mysql_query("insert into patprofile (pid,name,age,sex,email,phone,did,city) values('$pid','$name','$age','$sex','$email','$phone','$did','$city')") or die(mysql_error());
		if($r){
			$flag['code']=1;
			$flag['pid']=$pid;
		}
		//create an exclusive training dataset for this patient
		
	$mailmsg="Hello ".$name.".Your credentials<br>"."Name: ".$name."\nPatient id: ".$pid."\nUse these to login using your app\n";
	//mail($email,"Remote Healthcare credentials",$mailmsg); //Email the credentials
	print(json_encode($flag));
	mysql_close($con);
	
	//summary_pac($id);
	//init_clusters($id,$sex,$age);
	?>
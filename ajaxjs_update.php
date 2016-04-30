<?php
// Start the session
session_start();
if(!isset($_SESSION['pid'])&&!isset($_SESSION['viewprofile']))
	header('Location: logout.php');
?>
<?php
error_reporting(E_ALL ^ E_WARNING);
$host='localhost';
$uname='root';
$pwd='';
$db="project";
$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
mysql_select_db($db,$con) or die("db selection failed");
$name=$_POST['name'];
$age=$_POST['age'];
$email=$_POST['email'];
$phone=$_POST['phone']; 
if(isset($_SESSION['pid']))
	$pid=$_SESSION['pid'];
else if(isset($_SESSION['viewprofile']))
	$pid=$_SESSION['viewprofile'];
if($name!="garb"&&$age!="garb"&&email!="garb"&&phone!="garb")
{
	$query=mysql_query("UPDATE patprofile SET name='$name',age='$age',email='$email',phone='$phone' WHERE pid='$pid'") or die(mysql_error());
	$query1=mysql_query("UPDATE project SET name='$name',age='$age',email='$email',phone='$phone' WHERE pid='$pid'") or die(mysql_error());
	if($query)
	{
	if(mysql_affected_rows($query)==0)
			echo "fail";
		else
			echo "success";
	}
	else
		echo "fail";
}
else if($name!="garb"&&$age!="garb"&&email!="garb")
{
	$query=mysql_query("UPDATE patprofile SET name='$name',age='$age',email='$email' WHERE pid='$pid'") or die(mysql_error());
	$query1=mysql_query("UPDATE project SET name='$name',age='$age',email='$email' WHERE pid='$pid'") or die(mysql_error());
if($query)
	{
		if(mysql_affected_rows($query)==0)
			echo "fail1";
		else
			echo "success";
	}
	else
		echo "fail2";
}
else if($name!="garb"&&$age!="garb")
{
	$query=mysql_query("UPDATE patprofile SET name='$name',age='$age' WHERE pid='$pid'") or die(mysql_error());
	$query1=mysql_query("UPDATE project SET name='$name',age='$age' WHERE pid='$pid'") or die(mysql_error());
	if($query)
	{
		if(mysql_affected_rows($query)==0)
			echo "fail1";
		else
			echo "success";
	}
	else
		echo "fail2";
}
else if($name!="garb")
{
	$query=mysql_query("UPDATE patprofile SET name='$name' WHERE pid='$pid'") or die(mysql_error());
	$query1=mysql_query("UPDATE project SET name='$name' WHERE pid='$pid'") or die(mysql_error());
	if($query)
	{
		if(mysql_affected_rows($query)==0)
			echo "fail1";
		else
			echo "success";
	}
	else
		echo "fail2";
}
else if($age!="garb"&&$email!="garb"&&$phone!="garb")
{
	$query=mysql_query("UPDATE patprofile SET age='$age',email='$email',phone='$phone' WHERE pid='$pid'") or die(mysql_error());
	$query1=mysql_query("UPDATE project SET age='$age',email='$email',phone='$phone' WHERE pid='$pid'") or die(mysql_error());
	if($query)
	{
		if(mysql_affected_rows($query)==0)
			echo "fail1";
		else
			echo "success";
	}
	else
		echo "fail2";
}
else if($age!="garb"&&$email!="garb")
{
	$query=mysql_query("UPDATE patprofile SET age='$age',email='$email' WHERE pid='$pid'") or die(mysql_error());
	$query1=mysql_query("UPDATE project SET age='$age',email='$email' WHERE pid='$pid'") or die(mysql_error());
	if($query)
	{
		if(mysql_affected_rows($query)==0)
			echo "fail1";
		else
			echo "success";
	}
	else
		echo "fail2";
}
else if($age!="garb")
{
	$query=mysql_query("UPDATE patprofile SET age='$age' WHERE pid='$pid'") or die(mysql_error());
	$query1=mysql_query("UPDATE project SET age='$age' WHERE pid='$pid'") or die(mysql_error());
	if($query)
	{
		if(mysql_affected_rows($query)==0)
			echo "fail1";
		else
			echo "success";
	}
	else
		echo "fail2";
}
else if($email!="garb"&&$phone!="garb")
{
	$query=mysql_query("UPDATE patprofile SET email='$email',phone='$phone' WHERE pid='$pid'") or die(mysql_error());
	$query1=mysql_query("UPDATE project SET email='$email',phone='$phone' WHERE pid='$pid'") or die(mysql_error());
	if($query)
	{
		if(mysql_affected_rows($query)==0)
			echo "fail1";
		else
			echo "success";
	}
	else
		echo "fail2";
}
else if($email!="garb")
{
	$query=mysql_query("UPDATE patprofile SET email='$email' WHERE pid='$pid'") or die(mysql_error());
	$query1=mysql_query("UPDATE project SET email='$email' WHERE pid='$pid'") or die(mysql_error());
	if($query)
	{
		if(mysql_affected_rows($query)==0)
			echo "fail1";
		else
			echo "success";
	}
	else
		echo "fail2";
}
else if($phone!="garb")
{
	$query=mysql_query("UPDATE patprofile SET phone='$phone' WHERE pid='$pid'") or die(mysql_error());
	$query1=mysql_query("UPDATE project SET phone='$phone' WHERE pid='$pid'") or die(mysql_error());
	if($query)
	{
		if(mysql_affected_rows($query)==0)
			echo "fail1";
		else
			echo "success";
	}
	else
		echo "fail2";
}
?>
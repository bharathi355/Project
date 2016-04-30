<?php
// Start the session
session_start();
?>
<?php
$host='localhost';
	$uname='root';
	$pwd='';
	$db="project";

$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
	mysql_select_db($db,$con) or die("db selection failed");
$non_empty=$_POST['non_empty'];
$did=$_SESSION["did"];
if($non_empty==1)
{
	$pid=$_POST['pid'];
	//$query=mysql_query("SELECT pid FROM project WHERE pid LIKE'%$pid%' AND did='$did'") or die(mysql_error());
	$query1=mysql_query("SELECT pid,name FROM patprofile WHERE pid LIKE'%$pid%' AND did='$did'") or die(mysql_error());
	if(mysql_num_rows($query1)>0)
	{
		
			//$_SESSION['searchname']=$_POST['name'];
			$_SESSION['searchid']=$_POST['pid'];
		echo "pid=".$_SESSION['searchid'];
	}
	else
		echo "Invalid Credentials";
}
else if($non_empty==3)
{
	$pid=$_POST['pid'];
	$name=$_POST['name'];
	//$query=mysql_query("SELECT pid FROM project WHERE pid LIKE '%$pid%' AND did='$did'") or die(mysql_error());
	$query=mysql_query("SELECT pid,name FROM patprofile WHERE pid LIKE '%$pid%' AND did='$did'") or die(mysql_error());
	if(mysql_num_rows($query)>0)
	{
		$_SESSION['searchid']=$_POST['pid'];
		$_SESSION['searchname']=$_POST['name'];
	echo "$pid=".$_SESSION['searchid']." name=".$_SESSION['pid'];
	}
	else
		echo "Invalid Credentials";
}
else if($non_empty==2)
{
	$name=$_POST['name'];
	$query=mysql_query("SELECT pid,name FROM patprofile WHERE name LIKE '%$name%' AND did='$did'") or die(mysql_error());
	if(mysql_num_rows($query)>0)
	{
		$_SESSION['searchname']=$_POST['name'];
		echo "name=".$_SESSION['searchname'];
	}
	else
		echo "Invalid Credentials";

}


?>
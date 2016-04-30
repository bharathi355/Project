<?php
// Start the session
session_start();
?>
<?php
$pid=$_POST['pid'];
$_SESSION['viewprofile']=$pid;
$host='localhost';
$uname='root';
$pwd='';
$db="project";
$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
	mysql_select_db($db,$con) or die("db selection failed");
$query=mysql_query("SELECT name FROM patprofile WHERE pid='$pid'");
while($row=mysql_fetch_array($query))
{
	$_SESSION['profilename']=$row['name'];
	break;
}
	
if(isset($_SESSION['viewprofile'])&&isset($_SESSION['profilename']))
{
	echo "done";
}
else
	echo "fail";
?>

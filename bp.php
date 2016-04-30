<?php
//	include "db.php";
	include_once "eliminate_outliers_bp.php";
		
	function update_bp($pid)
	{
	$host='localhost';
		$uname='root';
		$pwd='';
		$db="project";		$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
		mysql_select_db($db,$con) or die("db selection failed");
		$agensex=mysql_query("SELECT distinct age,sex FROM patprofile WHERE pid='$pid'",$con);
		$age=0;
		$sex=0;
		$cur_class="normal";
		while($result5=mysql_fetch_assoc($agensex))
		{
			$age=$result5['age'];
			$sex=$result5['sex'];
		}
		$bp_1=array(0,0,0,0,0);
		$centers=mysql_query("SELECT bp_vlow,bp_low,bp_normal,bp_high,bp_vhigh FROM centers WHERE pid='$pid'")or die(mysql_error());
		
		while($result6=mysql_fetch_array($centers))
		{
			$bp_1[0]=$result6['bp_vlow'];
			$bp_1[1]=$result6['bp_low'];
			$bp_1[2]=$result6['bp_normal'];
			$bp_1[3]=$result6['bp_high'];
			$bp_1[4]=$result6['bp_vhigh'];
		}
		$values=mysql_query("SELECT bp_systole FROM summary WHERE pid='$pid' ORDER BY time DESC")or die(mysql_error());
		$count=array(0,0,0,0,0);
		$min=0;
		$clust="";
		$newcenters=array(0,0,0,0,0);
		$values1=array(0,0,0,0,0);
		while($result7=mysql_fetch_assoc($values))
		{
			////echo "Value of bp ".$result7['bp_systole']."<br>";
			$mindis=100;
			for($i=0;$i<5;$i++)
			{
				$x=pow((intval($bp_1[$i])-intval($result7['bp_systole'])),2);
				$dis=sqrt($x); //calculate eucledian distance
				////echo $dis." Distance<br>";
				if($dis<$mindis)
				{
					$min=$i;
					$mindis=$dis;
				}
			}
			$count[$min]++;
			$values1[$min]+=$result7['bp_systole'];
			if($min==0)
				$clust="very low";
			else if($min==1)
				$clust="low";
			else if($min==2)
				$clust="normal";
			else if($min==3)
				$clust="high";
			else if($min==4)
				$clust="very high";
			//break;

		}
		for($i=0;$i<5;$i++)
		{
			////echo "Values ".$i." ".$values1[$i]."<br>";
			////echo "Count  ".$i." ".$count[$i]."<br>";
		}
	////echo "New centers for BP<br>";
		for($i=0;$i<5;$i++)
		{
			if($count[$i]!=0)
				$newcenters[$i]=$values1[$i]/$count[$i];
			else
				$newcenters[$i]=$bp_1[$i];
			//echo $newcenters[$i]." ";
		}
		//echo "<br>Current BP class is ".$clust;
		$bp_to_replace=$newcenters[$min];
		//$update_query=mysql_query("UPDATE clustering_bp SET cur_class='$clust' WHERE pid='$pid'");	
		$update_query=mysql_query("UPDATE centers SET bp_vlow='$newcenters[0]' WHERE pid='$pid'")or die(mysql_error());
		$update_query=mysql_query("UPDATE centers SET bp_low='$newcenters[1]' WHERE pid='$pid'")or die(mysql_error());
		$update_query=mysql_query("UPDATE centers SET bp_normal='$newcenters[2]' WHERE pid='$pid'")or die(mysql_error());
		$update_query=mysql_query("UPDATE centers SET bp_high='$newcenters[3]' WHERE pid='$pid'")or die(mysql_error());
		$update_query=mysql_query("UPDATE centers SET bp_vhigh='$newcenters[4]' WHERE pid='$pid'")or die(mysql_error());
		
		//function for replacement of training data
			replace_outliers_bp($pid,$age,$sex,$cur_class,$bp_to_replace);
	}
	?>
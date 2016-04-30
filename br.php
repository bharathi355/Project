<?php
//	include "db.php";
	include_once "eliminate_outliers_br.php";
		
	function update_br($pid)
	{
		$host='localhost';
		$uname='root';
		$pwd='';
		$db="project";
		$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
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
		$br_1=array(0,0,0,0,0);
		$centers=mysql_query("SELECT br_vlow,br_low,br_normal,br_high,br_vhigh FROM centers WHERE pid='$pid'")or die(mysql_error());
		
		while($result6=mysql_fetch_array($centers))
		{
			$br_1[0]=$result6['br_vlow'];
			$br_1[1]=$result6['br_low'];
			$br_1[2]=$result6['br_normal'];
			$br_1[3]=$result6['br_high'];
			$br_1[4]=$result6['br_vhigh'];
		}
		$values=mysql_query("SELECT br FROM summary WHERE pid='$pid' ORDER BY time DESC")or die(mysql_error());
		$count=array(0,0,0,0,0);
		$min=0;
		$clust="";
		$newcenters=array(0,0,0,0,0);
		$values1=array(0,0,0,0,0);
		while($result7=mysql_fetch_assoc($values))
		{
			////echo "Value of br ".$result7['br']."<br>";
			$mindis=100;
			for($i=0;$i<5;$i++)
			{
				////echo intval($result7['br'])." this";
				$x=pow((intval($br_1[$i])-intval($result7['br'])),2);
				$dis=sqrt($x); //calculate eucledian distance
				//echo $dis." Distance<br>";
				if($dis<$mindis)
				{
					$min=$i;
					$mindis=$dis;
				}
			}
			//echo "Closest to ".$min;
			$count[$min]++;
			$values1[$min]+=$result7['br'];
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
			//echo "Values ".$i." ".$values1[$i]."<br>";
			//echo "Count  ".$i." ".$count[$i]."<br>";
		}
		//echo "New centers for BR<br>";
		
		for($i=0;$i<5;$i++)
		{
			if($count[$i]!=0)
				$newcenters[$i]=$values1[$i]/$count[$i];
			else
				$newcenters[$i]=$br_1[$i];
			//echo $newcenters[$i]." ";
		}
		//echo "<br>Current BR class is ".$clust;
		$br_to_replace=$newcenters[$min];
		//$update_query=mysql_query("UPDATE clustering_BR SET cur_class='$clust' WHERE pid='$pid'");	
		$update_query=mysql_query("UPDATE centers SET br_vlow='$newcenters[0]' WHERE pid='$pid'")or die(mysql_error());
		if(!$update_query)
			//echo "Error 2<br>";
		$update_query=mysql_query("UPDATE centers SET br_low='$newcenters[1]' WHERE pid='$pid'")or die(mysql_error());
			if(!$update_query)
			//echo "Error 2<br>";
		$update_query=mysql_query("UPDATE centers SET br_normal='$newcenters[2]' WHERE pid='$pid'")or die(mysql_error());
			if(!$update_query)
			//echo "Error 2<br>";
		$update_query=mysql_query("UPDATE centers SET br_high='$newcenters[3]' WHERE pid='$pid'")or die(mysql_error());
			if(!$update_query)
			//echo "Error 2<br>";
		$update_query=mysql_query("UPDATE centers SET br_vhigh='$newcenters[4]' WHERE pid='$pid'")or die(mysql_error());
			if(!$update_query)
			//echo "Error 2<br>";
		//function for replacement of training data
		//echo "<br>Hi<br>";
			replace_outliers_br($pid,$age,$sex,$cur_class,$br_to_replace);
			
	}
	?>
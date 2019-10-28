<?php
    
    ini_set('session.gc_maxlifetime', 7200);
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 0);
    
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$sql="SELECT ai.AIntuitionID  
			FROM `tdbAIntuitionReports` airep
			JOIN tdbAIntuition ai ON airep.`AIntuitionID` = ai.`AIntuitionID`
			GROUP BY ai.AIntuitionID";
			
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$sql1 = "SELECT AIntuitionReportID  
					FROM `tdbAIntuitionReports` airep
					JOIN tdbAIntuition ai ON airep.`AIntuitionID` = ai.`AIntuitionID`
					WHERE airep.AIntuitionID = ".$row["AIntuitionID"].
					" ORDER BY airep.createdDate DESC";
		// echo $sql1 . "<br />";
		$result1=mysql_query($sql1);
		
		$date = $lastUpdate;
		$date = strtotime($date);
		$date = strtotime('+1 day', $date); // or +3 hours
		$date = date('YmdHis', $date);
		while($row1=mysql_fetch_array($result1)){
			
			$date = strtotime($date);
			$date = strtotime('-1 day', $date); // or -3 hours			
			$date = date('YmdHis', $date);

			$sql2 = "UPDATE `tdbAIntuitionReports` SET `createdDate`= '$date' WHERE `AIntuitionReportID` = ".$row1["AIntuitionReportID"]."";
			// echo $sql2 . "<br />";
			$result2=mysql_query($sql2);
		}			
	}
?>
<?php 

	 // Include need file(s):
	include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
			
		$employeeProfileID= $_GET['employeeProfileID'];
	
		$category = explode(";", $category);
	
		$sql = "SELECT ho.orgLev, ho.empID, ho.holdingID, ho.roleName FROM tdbHoldingOrganigram ho WHERE ho.empID = '$employeeProfileID'";
		$res = mysql_query($sql); // Send a MySQL query.
			
		$row = mysql_fetch_assoc($res); // Fetch a result row as an associative array.
			
			$employeeName = displayEmployeeName($row['empID']);
			$roleName = $row['roleName'];
			$holdingID = $row['holdingID'];
			$levelName = displayClient($row['holdingID']);
			$levelOrganigram = $row['orgLev'];
			
	$employeeNameAI = $_POST['employeeNameAI'];
	$roleNameAI = $_POST['roleNameAI'];
	$levelNameAI = $_POST['levelNameAI'];
	$levelOrganigramAI = $_POST['levelOrganigramAI'];
	$category  = json_encode($_POST["category"]);
	
	

	$sql = "INSERT INTO tdbAIntuitionHoldingOrganigram (employeeName, roleName, levelName, levelOrganigram, category, employeeID)
			VALUES('$employeeNameAI', '$roleNameAI', '$levelNameAI', '$levelOrganigramAI', '$category', '$employeeProfileID')";
	$res = mysql_query($sql); // Send a MySQL query.
	echo "<b class=\"red\" style=\"margin: 50px 0 0 450px;\">Data Saved!</b>";
				
?>
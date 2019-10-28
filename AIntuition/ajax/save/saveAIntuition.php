<?php session_start(); // start session.

	 // Include need file(s):
	include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$userID = $_SESSION["userID"];
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
	
	// Choose AIntuitionCategoryID and COUNT of tdbAIntuitionSubCategory of AIntuitionCategoryID:
	
	$AIntuitionCategoryID = $_POST['AIntuitionCategoryID'];
	
	$querySubCategory = "SELECT * FROM `tdbAIntuitionSubCategory` WHERE AIntuitionCategoryID = '$AIntuitionCategoryID'";
	$rezSubCategory = mysql_query($querySubCategory);
		
	$rowSubCategory = mysql_fetch_array($rezSubCategory);
	$AIntuitionSubCategoryID = $rowSubCategory['AIntuitionSubCategoryID'];
	$AIntuitionCategoryID = $rowSubCategory['AIntuitionCategoryID'];
	$nameSubCategory = $rowSubCategory['nameSubCategory'];
		
	// GET VALUE FROM SUBCATEGORY:
	$listOfSubCategory = $_POST['listOfSubCategory'];									
		
	$querySubCount = "SELECT *, COUNT(AIntuitionSubCategoryID) AS subCount FROM `tdbAIntuitionSubCategory` WHERE AIntuitionCategoryID = '$AIntuitionCategoryID'";
	$rezSubCount = mysql_query($querySubCount);

		
	$rowSubCount = mysql_fetch_array($rezSubCount);
	$subCount = $rowSubCount['subCount'];
			
	$AIntuitionSubCategoryID = $_POST['listOfSubCategory'];		
	
	// GET VALUE FOR PRIVATE OR DUTY:
	$privateDuty = $_POST['privates'];

	
	// VALIDATION HOLDING AND BA / BU:
	if($_POST['holdingIntuitionArea'] == 'holding'){
	
		$AIntuitionParameters = array("holding");
		
		$AIntuitionParameters = json_encode($AIntuitionParameters);
	
	} else {
		$businessArea = json_decode($_POST['businessArea']);
		$businessUnit = json_decode($_POST['businessUnit']);
		
		$holding = array("holding"=>array( "businessArea"=>$businessArea, "businessUnit"=>$businessUnit));
		$AIntuitionParameters = json_encode($holding);
	}
	
	
	// VALIDATION FREQUENCY:
	$frequency = $_POST['frequency'];
	
	if($frequency == 'Hour'){
		$validationfrequency = $_POST['validationForHour'];
	} else if($frequency == 'Day'){
		$validationfrequency = $_POST['validationForDay'];
	} else if($frequency == 'Month'){
		$validationfrequency = $_POST['validationForMonth'];
	} else{
		echo "";
	}
	
	$totalFrequency = array($frequency => $validationfrequency);
	$totalFrequency = json_encode($totalFrequency);
	
	// Format AIntuition Expiration Date:
	$AIntuitionExpirationDate = $_POST["AIntuitionExpirationDate"];
	if($AIntuitionExpirationDate !=""){
		$date = DateTime::createFromFormat('d/m/Y', $AIntuitionExpirationDate);
		$AIntuitionExpirationDate = $date->format('Y-m-d');
	}
	
	
	$holdingIntuitionArea = $_POST['holdingIntuitionArea'];	
	$AIntuitionParametersSetup = $_POST['AIntuitionParametersSetup'];
	
	// Check validation for SubCategory:
	$validationQuery = "SELECT * FROM `tdbAIntuition` WHERE AIntuitionCategoryID = '$AIntuitionCategoryID' AND $listOfSubCategory IN(AIntuitionSubCategoryID) AND employeeID = '$employeeProfileID'";
	$validationRez = mysql_query($validationQuery);
	
	$validationRow = mysql_fetch_array($validationRez);
	
			$SubCategory = $validationRow['AIntuitionSubCategoryID'];
			$employeeID = $validationRow['employeeID'];
			
			if($listOfSubCategory == $SubCategory){
				echo "<script>alert('You already choose this Sub Category! Please, choose another!');</script>";
			} 
			
			 else{
				$sql = "INSERT INTO tdbAIntuition (employeeID, employeeName, roleName, levelName, levelOrganigram, AIntuitionCategoryID, AIntuitionSubCategoryID, AIntuitionParameters, AIntuitionParametersSetup, AIntuitionHandlingTypes, AIntuitionFrequency, AIntuitionExpirationDate, createdBy, createdDate, userID, lastUpdate)
			VALUES('$employeeProfileID', '$employeeNameAI', '$roleNameAI', '$levelNameAI', '$levelOrganigramAI', '$AIntuitionCategoryID', '$listOfSubCategory', '$AIntuitionParameters', '$AIntuitionParametersSetup', '$privateDuty', '$totalFrequency', '$AIntuitionExpirationDate', '$userID', '$lastUpdate', '$userID', '$lastUpdate')";
	$res = mysql_query($sql); // Send a MySQL query.
	
	// Insert into crontab
	$AIntuitionID = mysql_insert_id();
	$action = "saveCrontab";
	include_once ($_SERVER['DOCUMENT_ROOT']."/AIntuition/reports/AIntuitionCrontab.php");
	
	
	echo "<b class=\"red\" style=\"margin: 50px 0 0 450px;\" id=\"messageForSavedData\">Data Saved!</b>";
	echo "<script>$(\"#messageForSaveData\").fadeIn().delay(3000).fadeOut();</script>";
			}
		
?>
<table class="tableRowColoring" width="100%" cellpadding="0" cellspacing="0" id="saveTableData">	
		<tr class="table_header">
		  <th class="tableNewBorderWhite" align='center'>Name of Sub Category</th>	
		  <th class="tableNewBorderWhite" align='center'>Edit</th>
		  <th class="tableNewBorderWhite" align='center'>Remove</th>
  	  	</tr>
  	  	
  	  	<?php
  	  	$qAI = "SELECT * FROM tdbAIntuition WHERE employeeID = '$employeeProfileID' AND AIntuitionCategoryID = '$AIntuitionCategoryID'";
	    		$rAI = mysql_query($qAI);
				
				$rowAI = mysql_fetch_array($rAI);
				$AIntuitionID = $rowAI['AIntuitionID'];
				$AIntuitionSubCategoryID = $rowAI['AIntuitionSubCategoryID'];
	    					
	    			$q = "SELECT ai.*, aisc.* FROM tdbAIntuition ai INNER JOIN tdbAIntuitionSubCategory aisc ON ai.AIntuitionSubCategoryID = aisc.AIntuitionSubCategoryID WHERE ai.AIntuitionCategoryID = '$AIntuitionCategoryID' AND aisc.AIntuitionCategoryID = '$AIntuitionCategoryID' AND employeeID = '$employeeProfileID' ORDER BY ai.AIntuitionID DESC";
	    			$r = mysql_query($q); // Send a MySQL query.
	    			
	    			if(mysql_num_rows($r) > 0){ // Get number of rows in result.
	  
	    				while($row = mysql_fetch_array($r)){ // Fetch a result row as an associative array, a numeric array, or both.
	    					$AIntuitionID = $row['AIntuitionID'];
	    					$AIntuitionParameters = json_decode($row['AIntuitionParameters']);	
						
							$nameSubCategory = $row['nameSubCategory'];	
				
				
				echo"<tr id=\"showTableAIntuition\">";
				echo"<td class='tableNewBorder' align='center'>" . $nameSubCategory . "</td>"; 
				echo"<td class='tableNewBorder' align='center'><img style='cursor:pointer' src='/images/ui/buttons/btn_edit.png' onclick='updateAIntuitionForm($AIntuitionID, $AIntuitionCategoryID)'></td>";
 				echo"<td class='tableNewBorder' align='center'><img style='cursor:pointer' src='/images/ui/buttons/btn_delete.png' onclick='deleteAIntuition($AIntuitionID, $AIntuitionCategoryID)'></td>";

				  
				echo"</tr>"; 
	  	  	  	
	  	  	  }
		  
		  } else {
		  		
		  	echo"<tr><td colspan='7' align='center'><label class='red'>No Data</label></td></tr>";
		  }
  	  		
  	  	?>
  	  	
  	  </table>
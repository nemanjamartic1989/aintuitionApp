<?php 
 // Include need file(s):
include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
session_start(); // start session.


	$AIntuitionID = $_GET['AIntuitionID'];
	$employeeID = $_GET['employeeID'];
		
		// Get AIntuitionID from tdbAIntuition:	
		$queryAIntuition = "SELECT * FROM tdbAIntuition WHERE AIntuitionID = '$AIntuitionID'";
		$rezAIntuition = mysql_query($queryAIntuition);
		
		$rowAIntuition = mysql_fetch_assoc($rezAIntuition);
	
	$userID = $_SESSION["userID"];
	
	$employeeNameAI = $_POST['employeeNameAI'];
	$roleNameAI = $_POST['roleNameAI'];
	$levelNameAI = $_POST['levelNameAI'];
	$levelOrganigramAI = $_POST['levelOrganigramAI'];

	$AIntuitionCategoryID = $_POST['AIntuitionCategoryID'];
	
	$SubCategoryID = $_POST['listOfSubCategory'];		
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
	
	
	// Frequency:
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
	if($AIntuitionExpirationDate !== ""){
		$date = DateTime::createFromFormat('d/m/Y', $AIntuitionExpirationDate);
		$AIntuitionExpirationDate = $date->format('Y-m-d');
	}

	$holdingIntuitionArea = $_POST['holdingIntuitionArea'];
	
	$AIntuitionParametersSetup = $_POST['AIntuitionParametersSetup'];
 
	 $aIntuitionHoldingOrganigramID = $_POST['aIntuitionHoldingOrganigramID'];
	
	// Create query for update all AIntuition:
	$sql = "UPDATE tdbAIntuition SET employeeID = '$employeeID', employeeName = '$employeeNameAI', roleName = '$roleNameAI', levelName = '$levelNameAI',  levelOrganigram = '$levelOrganigramAI', AIntuitionCategoryID = '$AIntuitionCategoryID', AIntuitionSubCategoryID = '$SubCategoryID', AIntuitionParameters = '$AIntuitionParameters', AIntuitionParametersSetup = '$AIntuitionParametersSetup', AIntuitionHandlingTypes = '$privateDuty', AIntuitionFrequency = '$totalFrequency', AIntuitionExpirationDate = '$AIntuitionExpirationDate', createdBy = '$userID', createdDate = '$lastUpdate', userID = '$userID', lastUpdate = '$lastUpdate' WHERE AIntuitionID = '$AIntuitionID'";

	$res = mysql_query($sql); // Send a MySQL query.
	echo "<b id=\"updateDataAIntuition\" class=\"red\" style=\"margin: 50px 0 0 450px; display: none;\">Data Updated!</b>";
	
?>
<table class="tableRowColoring" width="100%" cellpadding="0" cellspacing="0">	
		<tr class="table_header">
		  <th class="tableNewBorderWhite" align='center'>Name of Sub Category</th>	
		  <th class="tableNewBorderWhite" align='center'>Edit</th>
		  <th class="tableNewBorderWhite" align='center'>Remove</th>
  	  	</tr>
  	  	
  	  	<?php
  	  	$qAI = "SELECT * FROM tdbAIntuition WHERE employeeID = '$employeeID' AND AIntuitionCategoryID = '$AIntuitionCategoryID'";
	    		$rAI = mysql_query($qAI);
				
				$rowAI = mysql_fetch_array($rAI);
				$AIntuitionID = $rowAI['AIntuitionID'];
				$AIntuitionSubCategoryID = $rowAI['AIntuitionSubCategoryID'];
	    					
	    			$q = "SELECT ai.*, aisc.* FROM tdbAIntuition ai INNER JOIN tdbAIntuitionSubCategory aisc ON ai.AIntuitionSubCategoryID = aisc.AIntuitionSubCategoryID WHERE ai.AIntuitionCategoryID = '$AIntuitionCategoryID' AND aisc.AIntuitionCategoryID = '$AIntuitionCategoryID' AND employeeID = '$employeeID' ORDER BY ai.AIntuitionID DESC";
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
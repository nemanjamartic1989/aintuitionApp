<?php session_start();

	include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
	
	$AIntuitionID = $_POST['AIntuitionID']; // Get AIntuitionID.
	$AIntuitionCategoryID = $_POST['AIntuitionCategoryID']; // Get AIntuitionCategoryID.
	
	// Get employeeID from tdbAIntuition:
	$queryEmployeeAI = "SELECT * FROM tdbAIntuition WHERE AIntuitionID = '$AIntuitionID'";
	$queryRezEmployeeAI = mysql_query($queryEmployeeAI);
	
	$rowRezEmployeeAI = mysql_fetch_array($queryRezEmployeeAI);
	
	$employeeID = $rowRezEmployeeAI['employeeID']; // Get employeeID.
	  
	$query = "DELETE FROM tdbAIntuition WHERE AIntuitionID = '$AIntuitionID'";
	$rez = mysql_query($query);

	echo "<p class=\"red\">Delete Successfully!</p>";
?>
<table class="tableRowColoring" width="100%" cellpadding="0" cellspacing="0" id="displayTableDataAfterDelete">	
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
	    					
	    			$q = "SELECT ai.*, aisc.* FROM tdbAIntuition ai INNER JOIN tdbAIntuitionSubCategory aisc ON ai.AIntuitionSubCategoryID = aisc.SubCategoryID WHERE ai.AIntuitionCategoryID = '$AIntuitionCategoryID' AND aisc.AIntuitionCategoryID = '$AIntuitionCategoryID' AND employeeID = '$employeeID' ORDER BY ai.AIntuitionID DESC";
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
<?php include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");?>

<fieldset><legend>List Of Client Category</legend>
	
	<label id="CategoryNameLabel">Client Category</label>
	
	<!-- Main list of Client Category -->
	<select id="listOfSubCategory4" name="listOfSubCategory" class="listOfSubCategory" onchange="listOfClientCategory(this.value)">
		<option value="">--</option>
		<?php 
		$queryClient = "SELECT * FROM `tdbAIntuitionSubCategory` WHERE AIntuitionCategoryID = 4";
		$rezClient = mysql_query($queryClient);
		$value = 0;
		
		if(mysql_num_rows($rezClient) > 0){
			while($rowClient = mysql_fetch_array($rezClient)){
				$AIntuitionSubCategoryID = $rowClient['AIntuitionSubCategoryID'];
				$AIntuitionCategoryID = $rowClient['AIntuitionCategoryID'];
				$nameSubCategory = $rowClient['nameSubCategory'];
				
				$value +=1;
				
					echo "<option value=\"$AIntuitionSubCategoryID\">$nameSubCategory</option>";
				
					
				
			}
		}
		
		$querySubClient = "SELECT *, COUNT(AIntuitionSubCategoryID) AS subCount FROM `tdbAIntuitionSubCategory` WHERE AIntuitionCategoryID = '$AIntuitionCategoryID'";
		$rezSubClient = mysql_query($querySubClient);

		
		$rowSubClient = mysql_fetch_array($rezSubClient);
				$subCount = $rowSubClient['subCount'];
		
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
			
		?>
	</select>
	
	<!-- Display Client Subcategory which choosed of certain Client Category -->
		
	<div id="displayFormForUpdate<?php echo $AIntuitionCategoryID;?>"></div> <!-- Display Form For Update -->
		
	<div id="displayHoldingBABUClient" class="displayHoldingABU<?php echo $AIntuitionCategoryID;?>"></div>
	<input type="button" id="saveAIntuition<?php echo $AIntuitionCategoryID;?>" onclick="saveAIntuition(<?php echo $employeeProfileID;?>, <?php echo $AIntuitionCategoryID;?>, <?php echo $AIntuitionSubCategoryID;?>);" style="margin: 50px 0 50px 900px;" value="Save"/>
	
	<b id="displayDataAfterAction<?php echo $AIntuitionCategoryID;?>" class="red"></b>
	
	<fieldset id="ListOfAIntuitionProfile">
		<legend>List of all created Profile for this AIntuition Category</legend>
<div style="max-height:200px; overflow-y: auto" id="displayDataAIntuition<?php echo $AIntuitionCategoryID;?>" class="displayDataAfterAction<?php echo $AIntuitionCategoryID;?>">
  	  
  	    <table class="tableRowColoring" width="100%" cellpadding="0" cellspacing="0" id="displayTableAIntuition<?php echo $AIntuitionCategoryID;?>">	
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
							
							// var_dump($AIntuitionHandlingTypes);
							
							//$AIntuitionHandlingTypes = json_decode($row['AIntuitionHandlingTypes']);    
				
				
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
  	  
  	  </div>
		
	<div id="showMessageUpdate"></div>
	<div id="showMessageDelete"></div>

</fieldset>
</fieldset>

	
	<?php include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php"); // Include need file(s).?>
	
	<?php 
	$aIntuitionHoldingOrganigramID = $_POST['aIntuitionHoldingOrganigramID'];
	$category = explode(";", $category);
	
	$q = "SELECT * FROM tdbAIntuitionHoldingOrganigram WHERE aIntuitionHoldingOrganigramID = '$aIntuitionHoldingOrganigramID'";
    			$r = mysql_query($q); // Send a MySQL query.
    			
    				$row = mysql_fetch_array($r); // Fetch a result row as an associative array, a numeric array, or both.
    					$aIntuitionHoldingOrganigramID = $row['aIntuitionHoldingOrganigramID'];
    					$employeeName = $row['employeeName'];
						$roleName = $row['roleName'];
						$levelName = $row['levelName'];
						$levelOrganigram = $row['levelOrganigram'];
						$category = json_decode($row['category']);
						$listCategory = implode("<br>", $category);	
			
	?>
	
	<fieldset id="ChooseCategoryForUpdateThisAIntuition"><legend>Update Category For A-Intuition: <?php echo "<b class=\"orange\">".$employeeName."</b>";?></legend>
		
		<!-- List for choose category: -->
		
		<div id="chooseCategory" style="float: left; margin: 0 0 0 50px;">
			<input type="checkbox" name="category" id="category1">Enterprise<br>	
			<input type="checkbox" name="category" id="category2">Product<br>
			<input type="checkbox" name="category" id="category3">Finance<br>
			<input type="checkbox" name="category" id="category4">Client<br>
			<input type="checkbox" name="category" id="category5">Partner<br>
			<input type="checkbox" name="category" id="category6">Competitor<br>
			<input type="checkbox" name="category" id="category7">GRC<br>
			<input type="checkbox" name="category" id="category8">IT Services<br>
			<input type="checkbox" name="category" id="category9">Optimization<br>	
		</div>
		
		<!-- Form for structure Of Holding Organigram: -->
		
		<div id="holdingOrganigramForm" style="float: right; padding: 0 100px 0 0;">
			<label>Employee Name:</label><input type="text" name="employeeNameAI" id="employeeNameAI" value="<?php echo $employeeName;?>" readonly 	 style="margin-left: 19px;"><br />
			<label>Role Name:</label><input type="text" name="roleNameAI" id="roleNameAI" value="<?php echo $roleName;?>" readonly style="margin-left: 52px;"><br />
			<label>Level Name:</label><input type="text" name="levelNameAI" id="levelNameAI" value="<?php echo $levelName;?>" readonly style="margin-left: 46px;"><br />
			<label>Level Organigram:</label><input type="text" name="levelOrganigramAI" id="levelOrganigramAI" value="<?php echo $levelOrganigram;?>" readonly style="margin-left: 10px;"><br />
		</div>
		
		<!-- Save or Cancel: -->
		 
		<div id="ExecutionForm" style="padding: 200px 0 0 450px;">
			<input type="button" id="updateAIntuition" onclick="updateAIntuition();" value="Update" />
			<input type="button" id="cancelUpdateAIntuition" onclick="cancelUpdateAIntuition();" value="Cancel" />
		</div>
		
		<div id="messageForUpdateData"></div>
		
	</fieldset>
	

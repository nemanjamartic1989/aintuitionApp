	
	<?php include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php"); // Include need file(s).?>
	
	<?php 
	$employeeID = $_POST['employeeID'];
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
						$categoryUpdate = json_decode($row['category']);
						$listCategory = implode("<br>", $category);	
						$employeeID = $row['employeeID'];
						
			
	?>
	
	<fieldset id="ChooseCategoryForUpdateThisAIntuition"><legend>Update Category For A-Intuition: <?php echo "<b class=\"orange\">".$employeeName."</b>";?></legend>
		
		<!-- List for choose category: -->
		
		<div id="chooseCategory" style="float: left; margin: 0 0 0 50px;">
			<input type="checkbox" name="categoryUpdate" id="categoryUpdate1" <?php if(in_array('Enterprise', $categoryUpdate)) echo "checked = 'checked'";?>>Enterprise<br>	
			<input type="checkbox" name="categoryUpdate" id="categoryUpdate2" <?php if(in_array('Product', $categoryUpdate)) echo "checked = 'checked'";?>>Product<br>
			<input type="checkbox" name="categoryUpdate" id="categoryUpdate3" <?php if(in_array('Finance', $categoryUpdate)) echo "checked = 'checked'";?>>Finance<br>
			<input type="checkbox" name="categoryUpdate" id="categoryUpdate4" <?php if(in_array('BPClient', $categoryUpdate)) echo "checked = 'checked'";?>>Client<br>
			<input type="checkbox" name="categoryUpdate" id="categoryUpdate5" <?php if(in_array('Partner', $categoryUpdate)) echo "checked = 'checked'";?>>Partner<br>
			<input type="checkbox" name="categoryUpdate" id="categoryUpdate6" <?php if(in_array('Competitor', $categoryUpdate)) echo "checked = 'checked'";?>>Competitor<br>
			<input type="checkbox" name="categoryUpdate" id="categoryUpdate7" <?php if(in_array('GRC', $categoryUpdate)) echo "checked = 'checked'";?>>GRC<br>
			<input type="checkbox" name="categoryUpdate" id="categoryUpdate8" <?php if(in_array('ITServices', $categoryUpdate)) echo "checked = 'checked'";?>>IT Services<br>
			<input type="checkbox" name="categoryUpdate" id="categoryUpdate9" <?php if(in_array('Optimization', $categoryUpdate)) echo "checked = 'checked'";?>>Optimization<br>	
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
			<input type="button" id="updateAIntuition" onclick="updateAIntuition(<?php echo $employeeID;?>);" value="Update" />
			<input type="button" id="cancelUpdateAIntuition" onclick="cancelUpdateAIntuition();" value="Cancel" />
		</div>
		
		<div id="messageForUpdateData"></div>
		
	</fieldset>
	

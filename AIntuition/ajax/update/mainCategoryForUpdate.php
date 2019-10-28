<?php session_start(); // session start.

			// Include need file(s):
			include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php"); 
	
		error_reporting(-1); // reports all errors
		ini_set("display_errors", "1"); // shows all errors
		ini_set("log_errors", 1);
			
			$employeeID = $_GET['employeeID'];
			$AIntuitionID = $_GET['AIntuitionID'];
			$AIntuitionCategoryID = $_GET['AIntuitionCategoryID'];
	
		// $category = explode(";", $category);
	
		$sql = "SELECT ho.orgLev, ho.empID, ho.holdingID, ho.roleName FROM tdbHoldingOrganigram ho WHERE ho.empID = '$employeeID'";
		$res = mysql_query($sql); // Send a MySQL query.
			
		$row = mysql_fetch_assoc($res); // Fetch a result row as an associative array.
			
			$employeeName = displayEmployeeName($row['empID']);
			$roleName = $row['roleName'];
			$holdingID = $row['holdingID'];
			$levelName = displayClient($row['holdingID']);
			$levelOrganigram = $row['orgLev'];
		
		// Get AIntuitionID from tdbAIntuition:	
		$queryAIntuition = "SELECT * FROM tdbAIntuition WHERE AIntuitionID = '$AIntuitionID'";
		$rezAIntuition = mysql_query($queryAIntuition);
		
		$rowAIntuition = mysql_fetch_array($rezAIntuition);

?>

<!-- SET MENU OF CATEGORY OF A-Iintuition FOR UPDATE -->
		<div id="listCategories">
			<fieldset id="menuAIintuition"><legend>Update Main Category: <?php echo "<b class=\"orange\">".$employeeName."</b>";?></legend>
				<div class="figPozicija" style="margin-bottom: 80px;padding-top:20px;border-spacing: 12px 0;">
					<?php 						
							
							$query = "SELECT * FROM tdbAIntuitionCategory";
							$result = mysql_query($query); // Send a MySQL query.
							
							if(mysql_num_rows($result) > 0){ // Get number of rows in result.
								while($rowCategory = mysql_fetch_array($result)){ // Fetch a result row as an associative array, a numeric array, or both.
									$AIntuitionCategoryID = $rowCategory['AIntuitionCategoryID'];
									$nameCategory = $rowCategory['nameCategory'];
									$name = trim(str_replace(' ','',$nameCategory));
									
					    				echo "<div id=\"".$name."MainCategory\" class=\"clientMask cursorP\" title=\"".$name."\"  onclick=\"show".$name."Update(".$AIntuitionID.");\" style=\"min-height:16px; padding: 3px 5px; margin: 5px 0;\"><img id=\"".$name."Img\" src=\"/images/ui/arrowDown.png\"></img>$name</div>
					  	<div id=\"".$name."\" style=\"display:none\"><div id=\"subCategory".$name."\" style=\"display: none;\"></div>
					  	</div>";
									
									
								}
				
								
							}
								
					?>
						
				    
				    <input type="button" id="backChooseCategory" onclick="backChooseCategory();" style="margin: 50px 0 50px 0;" value="Back"/>

				   
				</div>
				<div id="targetAIntuitionDiv" style="min-height: 135px;"></div>
				<div id="testDiv"></div>
				<div id="displayMessageCategory" class="red" style="margin:0 0 0 480px; display:none; padding-bottom: 200px;"><b>No Choose Category</b></div>
				
			</fieldset>
		</div>
		<script>
			
			var category = [];
		
			var category1 = $("#category1").is(":checked");
			var category2 = $("#category2").is(":checked");
			var category3 = $("#category3").is(":checked");
			var category4 = $("#category4").is(":checked");
			var category5 = $("#category5").is(":checked");
			var category6 = $("#category6").is(":checked");
			var category7 = $("#category7").is(":checked");
			var category8 = $("#category8").is(":checked");
			var category9 = $("#category9").is(":checked");
			
			if(category1 === true){
				$('#EnterpriseMainCategory').show();
				category.push("Enterprise");

			} else {
				$('#EnterpriseMainCategory').hide();
			}
			
			if(category2 === true){
				$('#ProductMainCategory').show();
				category.push("Product");

			} else {
				$('#ProductMainCategory').hide();
			}
			
			if(category3 === true){
				$('#FinanceMainCategory').show();
				category.push("Finance");

			} else {
				$('#FinanceMainCategory').hide();
			}
			
			if(category4 === true){
				$('#BPClientMainCategory').show(); 
				category.push("Client");
 
			} else {
				$('#BPClientMainCategory').hide();
			}
			
			if(category5 === true){
				$('#PartnerMainCategory').show(); 
				category.push("Partner");

			} else {
				$('#PartnerMainCategory').hide();
			}
			
			if(category6 === true){
				$('#CompetitorMainCategory').show();
				category.push("Competitor");
		
			} else {
				$('#CompetitorMainCategory').hide();
			}
			
			if(category7 === true){
				$('#GRCMainCategory').show();
				category.push("GRC");
		
			} else {
				$('#GRCMainCategory').hide();
			}
			
			if(category8 === true){
				$('#ITServicesMainCategory').show();
				category.push("ITServices");

			} else {
				$('#ITServicesMainCategory').hide();
			}
			
			if(category9 === true){
				$('#OptimizationMainCategory').show();
				category.push("Optimization");

			} else {
				$('#OptimizationMainCategory').hide();
			}
			
			if(category.length > 0){
				$("#displayMessageCategory").hide();
			} else {
				$("#displayMessageCategory").show();
				$('#saveAIntuition').hide();
			}
			
		</script>
<?php 
	// Include need file(s):
	include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$AIntuitionID = $_GET['AIntuitionID']; // Get AIntuitionID
	
	
	$q = "SELECT *, DATE_FORMAT(AIntuitionExpirationDate, '%d/%m/%Y') AS date FROM tdbAIntuition WHERE AIntuitionID = '$AIntuitionID'";
	
	$r = mysql_query($q);
	
	$row = mysql_fetch_array($r);
	
	$AIntuitionParametersSetup = $row['AIntuitionParametersSetup'];
	$AIntuitionParameters = $row['AIntuitionParameters'];
	$BABU = json_decode($AIntuitionParameters);
	$AIntuitionHandlingTypes = $row['AIntuitionHandlingTypes'];
	$AIntuitionFrequency = $row['AIntuitionFrequency'];
	$AIntuitionFrequency = json_decode($AIntuitionFrequency);
	$date = $row['date'];
	$AIntuitionCategoryID = $row['AIntuitionCategoryID'];
	$AIntuitionSubCategoryID = $row['AIntuitionSubCategoryID'];
	$employeeID = $row['employeeID'];
	
?>

<div id="containerUpdateForm">
	
<!-- Sub Category on disabled -->
<label>Sub Category</label>
<select id="listOfSubCategoryUpdate<?php echo $AIntuitionCategoryID;?>" name="listOfSubCategory<?php echo $AIntuitionCategoryID;?>" class="listOfSubCategoryUpdate<?php echo $AIntuitionCategoryID;?>" onchange="listOfClientCategoryUpdate(this.value, <?php echo $AIntuitionID;?>)" disabled>
		<option value="">--</option>
		<?php 
		
		$queryClient = "SELECT * FROM `tdbAIntuitionSubCategory` WHERE AIntuitionCategoryID = '$AIntuitionCategoryID'";
		$rezClient = mysql_query($queryClient);
		$value = 0;
		
		if(mysql_num_rows($rezClient) > 0){
			while($rowClient = mysql_fetch_array($rezClient)){
				$AIntuitionSubCategoryID = $rowClient['AIntuitionSubCategoryID'];
				$AIntuitionCategoryID = $rowClient['AIntuitionCategoryID'];
				$nameSubCategory = $rowClient['nameSubCategory'];
				
				$value +=1;
				
					// Get AIntuitionID from tdbAIntuition:	
		$queryAIntuition = "SELECT * FROM tdbAIntuition WHERE AIntuitionID = '$AIntuitionID'";
		$rezAIntuition = mysql_query($queryAIntuition);
		
		$rowAIntuition = mysql_fetch_array($rezAIntuition);
		$employeeID = $rowAIntuition['employeeID'];
		$SubCategoryID = $rowAIntuition['AIntuitionSubCategoryID'];
				?>
					<option value="<?php echo $AIntuitionSubCategoryID;?>" <?php if($SubCategoryID == $AIntuitionSubCategoryID) echo "selected='selected'";?>><?php echo $nameSubCategory;?></option>
				<?php	
				
					
				
			}
		}
		
			
		?>
	</select>
	<br /><br />
<?php  if(in_array('holding', $BABU)){
	 ?>
	 
							<label>Holding</label><input type="checkbox" id="holdingIntuitionAreaUpdate<?php echo $SubCategoryID;?>" name="holdingIntuitionArea<?php echo $SubCategoryID;?>" checked  value="holding" onchange="holdingUpdateCheck(<?php echo $SubCategoryID;?>);"/><br /><br />
	 <?php
} else if(!in_array('holding', $BABU)){
	?>
	
	
	<div id="holdingBABU"></div>
							<label>Holding</label><input type="checkbox" id="holdingIntuitionAreaUpdate<?php echo $SubCategoryID;?>" name="holdingIntuitionArea<?php echo $SubCategoryID;?>"  value="holding" onclick="holdingUpdateUncheck(<?php echo $SubCategoryID;?>);"/><br /><br />
	
	<!-- Display Business Area -->
	
	<fieldset id="fieldsetUpdateBA<?php echo $SubCategoryID;?>" style="max-width:300px; margin: 0 0 0 300px;">
	<legend>
		Business Area 
	</legend>
		<div style="overflow-y:scroll;height: 150px; width: 300px; display: block">
		<table id="tableBusinessArea<?php echo $SubCategoryID;?>">
			<tr>
				<td>
					
					<?php
					
						
					
						$queryBA = "SELECT * FROM tdbBusinessArea";
									$rezBA = mysql_query($queryBA);
									
									$valueBA = 0;
									
									if(mysql_num_rows($rezBA) > 0){
										while ($rowBA = mysql_fetch_array($rezBA)) {
											$businessAreaID = $rowBA['businessAreaID'];
											$businessAreaName = $rowBA['businessAreaName'];	 
											$valueBA += 1;
											
										
													?>
													<label id="labelBA" style="display: inline-block; width: 230px;"><?php echo $businessAreaName;?></label>
													<input type="checkbox" name="businessArea[]" class="businessArea" id="businessArea" 
													<?php 
													foreach ($BABU as $key => $value) {
											
														foreach ($value as $keys => $val) {
												
															foreach ($val as $k) {
																if($keys == 'businessArea'){ 
															if($businessAreaID == $k) echo "checked = 'checked'";
															
															} 
														}
													}											
												}
													?>  			
													
													value="<?php echo $businessAreaID;?>" onclick="businessAreaUpdate(<?php echo $AIntuitionID;?>, <?php echo $SubCategoryID;?>);"/><br>
													<?php
													
													
											?>
											<?php	
																	
										}
									}
					
									
					?> 
				</td>
			</tr>
		</table>	
		</div>
		<input type="hidden" value="<?php echo $businessAreaID;?>"/>
</fieldset>

	<!-- Display Business Unit for update -->

<fieldset id="fieldsetUpdateBU<?php echo $SubCategoryID;?>" style="margin: -185px 0 0 700px; max-width: 300px;">
	<legend>
		Business Unit 
	</legend>
		<div style="overflow-y:scroll;height: 150px; width: 300px; display: block">
		<table id="tableBusinessUnit<?php echo $SubCategoryID;?>">
			<tr>
				<td id="displayBusinessUnit<?php echo $SubCategoryID;?>">
					<?php 
					$validationQuery = "SELECT * FROM `tdbAIntuition` WHERE AIntuitionID = '$AIntuitionID'";
					
						$validationRez = mysql_query($validationQuery);
						
						$validationRow = mysql_fetch_array($validationRez);
						
						$holding = $validationRow['AIntuitionParameters'];
						
						$holding = json_decode($holding);
						
						$businessArea = array();
						foreach ($holding as $key => $value) {
						
						foreach ($value as $keys => $val) {
							
							foreach ($val as $ba) {
								if($keys == 'businessArea'){
									
									$businessArea[] = $ba;
								
								} 
							}
						}
						
						
					}
								$businessArea = implode(",", $businessArea);
								$queryBU = "SELECT * FROM  tdbBusinessUnit WHERE businessAreaID IN ($businessArea)";
									$rezBU = mysql_query($queryBU);
									
									$valueBU = 0;
									
									if(mysql_num_rows($rezBU)){
										while($rowBU = mysql_fetch_array($rezBU)){
											$businessUnitID = $rowBU['businessUnitID'];
											$businessUnitName = $rowBU['businessUnitName'];	
											$businessAreaID =  $rowBU['businessAreaID'];
											$valueBU += 1;
											?>
											<label id="labelBU"  style="display: inline-block; width: 230px;"><?php echo $businessUnitName;?></label><input type="checkbox" name="businessUnit" class="" id="businessUnit"
											<?php 
											foreach ($BABU as $key => $value) {
											
											foreach ($value as $keys => $val) {
												
												foreach ($val as $bu) {
													if($keys == 'businessUnit'){ 
													if($businessUnitID == $bu) echo "checked = 'checked'";
													} 
												}
											}
											
											
										}
											?>
											  value="<?php echo $businessUnitID;?>" onclick="businessUnit(<?php echo $businessUnitID;?>)"/><br>
											<?php 								
										}
									}
																		
									
?>
				</td>
			</tr>
		</table>	
		</div>
</fieldset>
	
	<?php
	}
?>

<!-- Check Status of AIntuition -->
<div id="statusFormUpdate" style="margin: 100px 0 0 0;">
	<fieldset id="statusAIntuition"><legend>Check status of this AIntuition</legend>
		<select name="AIntuitionParametersSetup" id="AIntuitionParametersSetup<?php echo $SubCategoryID;?>">
			<option>---</option>
			<option value="Decrease" <?php if($AIntuitionParametersSetup == 'Decrease') echo "selected = 'selected'";?>>Decrease</option>
			<option value="Increase" <?php if($AIntuitionParametersSetup == 'Increase') echo "selected = 'selected'";?>>Increase</option>
			<option value="Static" <?php if($AIntuitionParametersSetup == 'Static') echo "selected = 'selected'";?>>Static</option>
		</select>
	</fieldset>

<!-- Private or Duty -->
<fieldset><legend>AIntuition Handling Types</legend>
	
		<input type="radio" name="privates<?php echo $SubCategoryID;?>" id="privates1<?php echo $SubCategoryID;?>" value="Private" <?php if($AIntuitionHandlingTypes == 'Private') echo "checked = 'checked'";?>/>Private
		<input type="radio" name="privates<?php echo $SubCategoryID;?>" id="privates2<?php echo $SubCategoryID;?>" value="Duty" <?php if($AIntuitionHandlingTypes == 'Duty') echo "checked = 'checked'";?>/>Duty
	
	<br />	
		
</fieldset>

<!-- Update AIntuition Frequency -->
<fieldset><legend>AIntuition Frequency</legend>
	<label>Per:</label>
	<?php 
		foreach ($AIntuitionFrequency as $key => $value) {

		?>
		<input type="radio" name="frequency<?php echo $SubCategoryID;?>" id="frequency1<?php echo $SubCategoryID;?>" <?php if($key == 'Hour') echo "checked = 'checked'"?> onclick = "frequencyHour(1, <?php echo $SubCategoryID;?>);" value="Hour"/>Hourly
		<input type="radio" name="frequency<?php echo $SubCategoryID;?>" id="frequency2<?php echo $SubCategoryID;?>" <?php if($key == 'Day') echo "checked = 'checked'"?> onclick = "frequencyDay(2, <?php echo $SubCategoryID;?>);" value="Day"/>Daily
		<input type="radio" name="frequency<?php echo $SubCategoryID;?>" id="frequency3<?php echo $SubCategoryID;?>" <?php if($key == 'Month') echo "checked = 'checked'"?> onclick = "frequencyMonth(3, <?php echo $SubCategoryID;?>);" value="Month"/>Monthly
		<?php }?>
		
		<div id="showFrequency<?php echo $SubCategoryID;?>"></div><!-- Show frequency per month, day and hour -->
		
</fieldset>

<!-- Update AIntuition Expiration Date -->
<fieldset><legend>AIntuition Expiration Date</legend>
		
		<table> 
            <tr>
                <td>Date: </td>
                <td><input type="text" id="AIntuitionExpirationDateUpdate<?php echo $SubCategoryID;?>" name="AIntuitionExpirationDate<?php echo $SubCategoryID;?>" style="width: 130px; margin-right: 7px;" placeholder="--" value="<?php echo $date; ?>" readonly/></td>
               
            </tr> 
        </table>
		
		<!-- Button for UPDATE and CANCEL -->
		<div style="margin: 50px 95px 50px 500px; float:right;">
			<input type="button" id="updateAIntuition" onclick="updateAIntuition(<?php echo $AIntuitionID;?>, <?php echo $employeeID;?>, <?php echo $AIntuitionCategoryID;?>);"  value="Update"/>
		</div>
		
</fieldset>
</div> 
 
</div>

<script>

	// DATAPICKER FOR UPDATE - BEGIN
	
   $(function(){
            var dateToday = new Date(); 
	        var dateFormat = "dd/mm/yy", 
	        from = $("#AIntuitionExpirationDateUpdate<?php echo $SubCategoryID;?>").datepicker({
	                      dateFormat : "dd/mm/yy",
	                      defaultDate: "+1w",
	                      changeMonth: true,
	                      changeYear: true,
					      beforeShow: function (textbox, instance) {
							  var txtBoxOffset = $(this).offset();
							  var top = txtBoxOffset.top;
							  var left = txtBoxOffset.left;
							  var textBoxWidth = $(this).outerWidth();
							  setTimeout(function () {
								  instance.dpDiv.css({
								  top: top-190, 
								  left: left + textBoxWidth + 30
								  });
							  }, 10);
					      },
	                      minDate: 0,
                          maxDate: '+1Y',
	                      showOn: 'button',
	                      buttonImage: '/images/calendarImages/cal.gif',
	                      buttonImageOnly: true,
	                      buttonText: "Select date"
	        });
   

	});
	
	// DATAPICKER FOR UPDATE - END

</script>
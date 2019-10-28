<?php 
	session_start(); // session start.
    include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php"); 
			
	$employeeProfileID = $_GET['employeeProfileID'];
	$employeeName = displayEmployeeName($employeeProfileID);
	$categories=json_decode($_POST['categories'], TRUE);
	$categories=implode($categories,",");
    $sql="SELECT ac.AIntuitionCategoryID AS categoryID, nameCategory, AIntuitionSubCategoryID AS subCategoryID, nameSubCategory, holding, businessArea, businessUnit
          FROM tdbAIntuitionCategory AS ac
          JOIN  `tdbAIntuitionSubCategory` AS aisc ON ac.AIntuitionCategoryID = aisc.AIntuitionCategoryID
          WHERE ac.AIntuitionCategoryID IN (".$categories.")";	
    $result=mysql_query($sql);
	
	$categories=array();
	$subCategoriesByCategoryID=array();
	while($row=mysql_fetch_assoc($result))
	{
		$categories[$row['categoryID']]=$row['nameCategory'];
		$subCategoriesByCategoryID[$row['categoryID']][$row['subCategoryID']]=$row['nameSubCategory'];
	}
		
	$sql="SELECT ba.businessAreaID, businessAreaName, businessUnitID, businessUnitName
          FROM tdbBusinessArea AS ba
          JOIN tdbBusinessUnit AS bu ON ba.businessAreaID = bu.businessAreaID";
	$result=mysql_query($sql);
	$businessAreas=array();
	$businessUnitsByBusinessArea=array();
	while($row=mysql_fetch_assoc($result))
	{
		$businessAreas[$row['businessAreaID']]=$row['businessAreaName'];
		$businessUnitsByBusinessArea[$row['businessAreaID']][$row['businessUnitID']]=$row['businessUnitName'];
	} 
	
	$sql="SELECT AIntuitionID AS aintuitionID,  ai.AIntuitionCategoryID AS categoryID, ai.AIntuitionSubCategoryID AS subCategoryID, nameSubCategory AS subCategoryName
          FROM tdbAIntuition AS ai   
          JOIN tdbAIntuitionSubCategory AS aisc ON ai.AIntuitionSubCategoryID = aisc.AIntuitionSubCategoryID
          WHERE employeeID ='$employeeProfileID'";
    $result=mysql_query($sql);
	$categoriesData=array();
	while($row=mysql_fetch_array($result))
	{
		$categoriesData[$row['categoryID']][$row['aintuitionID']]=$row['subCategoryName'];
	}
?>	
<fieldset><legend>Main Category:<label class="orange"><?php echo $employeeName; ?></label></legend>
<?php					
    foreach($categories as $categoryID=>$categoryName)
	{
	?>
	<div id="openAndColseDiv<?php echo $categoryID; ?>Div" class="clientMask cursorP" title="Expand List" onclick="showList('openAndColseDiv<?php echo $categoryID; ?>');" style="min-height:16px; padding: 3px 5px; margin: 5px 0;"><img id="<?php echo $shortName; ?>Img" src="/images/ui/arrowDown.png"></img><?php echo $categoryName; ?></div>
	<div id="openAndColseDiv<?php echo $categoryID; ?>" style="display:none">
	<fieldset><legend>List Of <?php echo $categoryName; ?> Category</legend>
	<section style="display: table; width: 100%;">
	  <header style="display: table-row;">
	    <div style="display: table-cell;">
	    	<fieldset style="width: 299px; height: 142px;"><legend><?php echo $categoryName; ?> Category</legend>
				<select style="width: 299px;" id="selSubCategory<?php echo $categoryID;?>" onchange="subCategoryFormValidation(<?php echo $categoryID; ?>,this.value)" >
					<option value='--'>--</option>
					<?php
					foreach($subCategoriesByCategoryID[$categoryID] as $subCategoryID=>$subCategoryName)
					{
						echo "<option value='".$subCategoryID."'>".$subCategoryName."</option>";
					}
					
					?>
				</select>
				<div id="divSensibility<?php echo $categoryID; ?>"></div>
			</fieldset>
	    </div>
	    <div style="display: table-cell;" id="divBusinessArea<?php echo $categoryID; ?>">
	    	<fieldset id="fieldset<?php echo $categoryID;?>" style="overflow-y:scroll;height: 142px; width: 300px;display: block"><legend>Business Area</legend>
	             <table width="100%"  class="tableHover tableRowColoring" id="tblBusinessAreas<?php echo $categoryID; ?>">
	                 <tbody>
						<?php
						
						foreach($businessAreas as $businessAreaID=>$businessAreaName)
						{
							$businessUnits=json_encode($businessUnitsByBusinessArea[$businessAreaID]);
							echo "<tr>";
							echo "<td >".$businessAreaName."</td>";
							$checkID='checkBA'.$businessAreaID.'Cat'.$categoryID;
							echo "<td><input type='checkbox' id='$checkID' onclick='getBusinessUnits($categoryID, $businessAreaID, $businessUnits)' value='".$businessAreaID."'></td>";
							echo "</tr>";
						}
						?>
	                 </tbody>
	             </table>
			</fieldset>
	    </div>
	    <div style="display: table-cell;" id="divBusinessUnit<?php echo $categoryID; ?>">
	    	<fieldset style="overflow-y:scroll;height: 142px; width: 300px; display: block"><legend>Business Unit</legend>
				 <table width="100%"  class="tableHover tableRowColoring" id="tblBusinessUnits<?php echo $categoryID; ?>">
	               <tbody></tbody>
	             </table>
			</fieldset>
	    </div>
	  </header>
	</section>
	
	<fieldset><legend>Check status of this AIntuition</legend>
		<input type="checkbox" id="holding<?php echo $categoryID;?>" onclick="holding(<?php echo $categoryID; ?>)"  value="holding<?php echo $categoryID;?>">Holding
	</fieldset>

 	<fieldset><legend>Check status of this AIntuition</legend>
		<select id="AIntuitionStatus<?php echo $categoryID; ?>">
			<option value='--'>--</option>
			<option value='decrease'>Decrease</option>
			<option value='increase'>Increase</option>
			<option value='static'>Static</option>
		</select>
	</fieldset>
	
	<fieldset><legend>AIntuition Handling Types</legend>
		<input type="radio" checked="checked" name="handlingType<?php echo $categoryID;?>" value="private">Private
		<input type="radio" name="handlingType<?php echo $categoryID;?>"  value="duty">Duty
	</fieldset>
  	
  	
  	<fieldset><legend>AIntuition Frequency</legend>
		<table>
			<tr>
				<td style="width: 50%">
					<input type="radio" checked="checked" name="frequency<?php echo $categoryID;?>" onclick="frequency('hourly', <?php echo $categoryID; ?>);" value="hour">Hourly
					<input type="radio" name="frequency<?php echo $categoryID;?>" onclick="frequency('daily', <?php echo $categoryID; ?>);" value="day">Daily
					<input type="radio" name="frequency<?php echo $categoryID;?>" onclick="frequency('monthly', <?php echo $categoryID; ?>);" value="month">Monthly
				</td>
				<td style="width: 50%">
					<label id="label<?php echo $categoryID; ?>">Frequency Per Hour</label>
					<select id="frequencyValue<?php echo $categoryID;?>" name="frequencyValue<?php echo $categoryID;?>">
						<?php
							for($i=1;$i<=24; $i++)
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
						?>
					</select>
				</td>
			</tr>
		</table>
	</fieldset>
  
    <fieldset><legend>AIntuition Expiration Date</legend>
    	<input type="text" readonly="readonly" name="expirationDate" class="expirationDate" id="AIntuitionExpirationDate<?php echo $categoryID;?>" style="margin-right: 5px;" />
    </fieldset>

	<div>
		<table style="width: 100%">
			<tr>
				<td style="width: 50%" id="message<?php echo $categoryID;?>"></td>
				<td style="width: 50%; text-align: right">
					<input type='button'  id="saveButton<?php echo $categoryID; ?>" style="" value='Save' onclick="saveCategoryData(<?php echo $categoryID;?>, <?php echo $employeeProfileID; ?>)">
				</td>
			</tr>
		</table>
	</div>

    
	 <div style="max-height:200px; overflow-y: auto">
		<fieldset><legend>List of all created Profile for this AIntuition Category</legend>
			<table class="tableRowColoring" width="100%" cellpadding="0" cellspacing="0" id="table<?php echo $categoryID;?>">	
				<tbody>
				<tr class="table_header">
				  <th class="tableNewBorderWhite" align='center'>Name of Sub Category</th>	
				  <th class="tableNewBorderWhite" align='center'>Edit</th>
				  <th class="tableNewBorderWhite" align='center'>Remove</th>
		  	  	</tr>
		  	  	<?php
		  	  	foreach($categoriesData[$categoryID] as $aintuitionID=>$subCategoryName)
				{
					echo"<tr>";
					echo"<td class='tableNewBorder' align='center'>" . $subCategoryName . "</td>"; 
					echo"<td class='tableNewBorder' align='center'><img style='cursor:pointer'  src='/images/ui/buttons/btn_edit.png' onclick='editAintuition($aintuitionID, $categoryID, $employeeProfileID)'></td>";
 					echo"<td class='tableNewBorder' align='center'><img style='cursor:pointer' id='removeTr$aintuitionID' src='/images/ui/buttons/btn_delete.png' onclick='deleteAIntuition($aintuitionID, $categoryID)'></td>";
					echo"</tr>"; 
				}
		  	  	?>
		  	</tbody>
	  	  	</table>
		</fieldset>
    </div>
    
    
	</fieldset>
	</div>
	<?php	
	}	

?>
		    
<input type="button" id="backChooseCategory" onclick="backChooseCategory();" style="margin: 50px 118px 50px 0; float:right;" value="Back"/>
</fieldset>
<script>
$('.expirationDate').datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        beforeShow: function (textbox, instance) {
            var txtBoxOffset = $(this).offset();
            var top = txtBoxOffset.top;
            var left = txtBoxOffset.left;
            var textBoxWidth = $(this).outerWidth();
            setTimeout(function () {
                instance.dpDiv.css({
                    top: top - 190,
                    left: left + textBoxWidth + 30
                });
            }, 10);
        },
        minDate: 0,
        maxDate: '+3Y',
        showOn: "button",
        buttonImage: "/images/calendarImages/cal.gif",
        buttonImageOnly: true,
        buttonText: "Select Date"
    });
</script>	
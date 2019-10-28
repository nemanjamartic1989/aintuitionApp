
<style>
	 /*Holding BA, BU*/
	label#labelBA {
	  display: inline-block;
	  width: 230px;
	}
	
	label#labelBU {
	  display: inline-block;
	  width: 230px;
	}
	
	fieldset.fieldsetBA {
		margin: 0 0 0 150px;
		width: 300px;
	}
	
	fieldset.fieldsetBU {
		margin: -185px 0 0 600px;
		width: 300px;
	}
</style>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");

$id = $_POST['id'];

$q = "SELECT c.*, sc.* FROM tdbAIntuitionCategory c INNER JOIN tdbAIntuitionSubCategory sc ON c.AIntuitionCategoryID = sc.AIntuitionCategoryID WHERE sc.AIntuitionSubCategoryID = '$id'";

$r = mysql_query($q);

$row = mysql_fetch_array($r);

$AIntuitionCategoryID = $row['AIntuitionCategoryID'];
$nameOfCategory = $row['nameCategory'];
?>

<label id="SelectInutitionAreaLabel">Select Inutition Area</label><br /><br />
						<label id="holdingLabel">Holding</label><input type="checkbox" id="holdingIntuitionArea<?php echo $id;?>" name="holdingIntuitionArea<?php echo $id;?>" value="holding" onchange="holding<?php echo $nameOfCategory;?>(<?php echo $id;?>);"/>


<fieldset id="fieldsetBA<?php echo $id;?>" class="fieldsetBA">
	<legend>
		Business Area 
	</legend>
		<div style="overflow-y:scroll;height: 150px; width: 300px; display: block">
		<table id="tableBusinessArea<?php echo $id;?>">
			<tr>
				<td>
					<!-- <label> Service Providers: </label>  -->
					<?php
						$queryBA = "SELECT * FROM tdbBusinessArea";
									$rezBA = mysql_query($queryBA);
									
									$valueBA = 0;
									
									if(mysql_num_rows($rezBA) > 0){
										while ($rowBA = mysql_fetch_array($rezBA)) {
											$businessAreaID = $rowBA['businessAreaID'];
											$businessAreaName = $rowBA['businessAreaName'];	 
											$valueBA += 1;
											echo "<label id=\"labelBA\">$businessAreaName</label><input type=\"checkbox\" name=\"businessArea[]\" class=\"businessArea\" id=\"businessArea".$businessAreaID."\"  value=\"$businessAreaID\" onclick=\"businessArea(".$id.");\"/><br>";	
											
											
											
																
										}
									}
									
									
					?> 
				</td>
			</tr>
		</table>	
		</div>
		<input type="hidden" value="<?php echo $businessAreaID;?>"/>
</fieldset>

<fieldset id="fieldsetBU<?php echo $id;?>" class="fieldsetBU">
	<legend>
		Business Unit 
	</legend>
		<div style="overflow-y:scroll;height: 150px; width: 300px; display: block">
		<table id="tableBusinessUnit<?php echo $id;?>">
			<tr>
				<td id="displayBusinessUnit<?php echo $id;?>">

				</td>
			</tr>
		</table>	
		</div>
</fieldset>	 

<!-- <div id="business"></div> -->
<div id="displayStatus<?php echo $id;?>"></div>
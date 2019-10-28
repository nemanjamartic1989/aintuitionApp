<?php include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");?>
<style>

	label#labelBA {
	  display: inline-block;
	  width: 230px;
	}
	
	label#labelBU {
	  display: inline-block;
	  width: 230px;
	}
	
	#fieldsetBU {
		margin: -185px 0 0 0;
	}
</style>


<fieldset id="fieldsetBA" style="display:none;">
	<legend>
		Business Area 
	</legend>
		<div style="overflow-y:scroll;height: 150px; width: 300px; display: block">
		<table id="tableBusinessArea">
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
											echo "<label id=\"labelBA\">$businessAreaName</label><input type=\"checkbox\" name=\"businessArea[]\" class=\"businessArea\" id=\"businessArea".$businessAreaID."\"  value=\"$businessAreaID\" onclick=\"businessArea();\"/><br>";	
											
											
											
																
										}
									}
									
									
					?> 
				</td>
			</tr>
		</table>	
		</div>
		<input type="hidden" value="<?php echo $businessAreaID;?>"/>
</fieldset>

<fieldset id="fieldsetBU">
	<legend>
		Business Unit 
	</legend>
		<div style="overflow-y:scroll;height: 150px; width: 300px; display: block">
		<table id="tableBusinessUnit">
			<tr>
				<td id="displayBusinessUnit">
					
				</td>
			</tr>
		</table>	
		</div>
</fieldset>
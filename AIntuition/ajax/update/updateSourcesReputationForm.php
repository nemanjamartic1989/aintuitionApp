<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$SourcesReputationID = $_POST['SourcesReputationID'];
	
	$queryUpdateSourcesReputationForm = "SELECT * FROM tdbSourcesReputation WHERE SourcesReputationID = '$SourcesReputationID'";
	$resultUpdateSourcesReputationForm = mysql_query($queryUpdateSourcesReputationForm);
	
	$rowUpdateSourcesReputationForm = mysql_fetch_array($resultUpdateSourcesReputationForm);
	
	$UpdateCategories = $rowUpdateSourcesReputationForm['categories'];
	$UpdateCategories = json_decode($UpdateCategories);
	$UpdateSiteSource = $rowUpdateSourcesReputationForm['SiteSource'];
	$Source = json_decode($rowUpdateSourcesReputationForm['SiteSource']);
	
	foreach ($Source as $site => $language) {

	}

	
?>

<div id="SourcesReputationFormForUpdate">
	
	<div id="chooseSitesForReputationUpdate" style="float: left;">
		
		<div id="SitesSourcesForInsert" style="float: left;" class="input-group">
			
			<label>Source of the site:</label><input type="text" id="SiteSourceReputationUpdate" name="SiteSourceReputation" value="<?php echo $site;?>" 			style="margin: 0 0 0 23px;"  disabled="true"/><label id="showErrorMessageForSourceUpdate" style="display: none; color: red;">Please insert validate 			URL.</label></label><label id="showErrorMessageForLengthSourceUpdate"  style="display: none; color: red;">Length of caracter of source must be 			less than 100.</label> <br />
		
		</div>
	
		<br/>	
		
			<!-- Choose Language -->
			<div id="languageSourcesForChoose" style="margin: 30px 0 0 0;" class="input-group">
				<label>Choose Language:</label>
				<select id="languageSourcesUpdate" name="languageSources" style="margin: 0 0 0 20px;" disabled="true">
					<option value="<?php echo $language;?>"><?php echo $language;?></option>
					
				</select>
			</div>
	


<!-- <fieldset id="ListOfAssignedSitesLanguagesUpdate" style="width: 500px; margin: 20px 0 0 0; float: right;"><legend>List of assigned Languages to Sites:</legend>
				
				<table class="tableRowColoring" width="100%" cellpadding="0" cellspacing="0" id="displayTableSitesLanguagesUpdate" style="float: left">	
				<tr class="table_header">
				  <th class="tableNewBorderWhite" align='center'>Sites</th>
				  <th class="tableNewBorderWhite" align='center'>Languages</th>
				  <th class="tableNewBorderWhite" align='center'>Remove</th>	
		  	  	</tr>
		  	  	<?php  foreach ($Source as $key => $value) {
				
				echo "<tr id=\"showSitesLanguagesUpdate\"><td class=\"tableNewBorder\" name=\"sitesUpdate[]\" align=\"center\" id=\"sitesUpdate\">$key</td><td class=\"tableNewBorder\" name=\"languagesUpdate[]\" align=\"center\" id=\"languagesUpdate\">$value</td><td class=\"tableNewBorder\" align=\"center\"><img style=\"cursor:pointer\" src=\"/images/ui/buttons/btn_delete.png\"  id=\"removeSitesLanguagesUpdate\" onclick=\"removeRowSitesLanguages();\"></td></tr>";
				
				}
				?>
		  	  	</table>
				
		  	  	
			</fieldset> -->


	</div>
	
	<!-- CATEGORIES - begin -->
	
	<div id="showCategoriesSourcesReputationUpdate" style="float: right; width: 400px; margin: 0 300px 0 0;">
			
			
	  <table class="tableRowColoring" width="100%" cellpadding="0" cellspacing="0" id="displayTableSourcesReputationCategories" style="margin: 0 400px 0 0;">	
  	    <thead>
  	    	<tbody id="chooseSourcesCategories">
				<tr class="table_header">
				  <th class="tableNewBorderWhite" align='center'>Categories Name</th>	
				  <th class="tableNewBorderWhite" align='center'>Choose Categories</th>
		  	  	</tr>
	  	  	</tbody>
  	  	</thead>
  	  	<tbody id="">
  	  	<?php
	    					
	    	$queryCategory = "SELECT * FROM tdbAIntuitionCategory WHERE AIntuitionCategoryID IN (1, 2, 4, 5)";
		$rezultQuery = mysql_query($queryCategory);
		
		if(mysql_num_rows($rezultQuery) > 0){
			while($rowCategory = mysql_fetch_array($rezultQuery)){
				$AIntuitionCategoryID = $rowCategory['AIntuitionCategoryID'];
				$nameCategory = $rowCategory['nameCategory'];
				
				
				echo"<tr>";
				echo"<td class='tableNewBorder' align='center' id='nameCategories'>" . $nameCategory . "</td>"; 
				?>
				<td class='tableNewBorder' align='center' id='chooseCategories'><input type='checkbox' id='chooseCategorySources' name='chooseCategoriesSourcesUpdate[]' value="<?php echo $nameCategory;?>" <?php if(in_array($nameCategory, $UpdateCategories)) echo 'checked="checked"';?>/></td>
				<?php 
				
				

				  
				echo"</tr>"; 
	  	  	  	
	  	  	  }
		  
		  } else {
		  		
		  	echo"<tr><td colspan='7' align='center'><label class='red'>No Data</label></td></tr>";
		  }
  	  		
  	  	?>
  	  	</tbody>
  	  </table>
			
	<label id="showMessageErrorChooseCategorySources" class="red" style="display: none;">Please choose category!</label>
	
	</div>

	
	<!-- CATEGORIES - end -->	
	
<div id="updateSourcesReputationButton" style="margin-left:970px; padding: 0 0 0 0;">
	<input type="button" id="updateReputation" value="Update" onclick="updateSourcesReputation(<?php echo $SourcesReputationID;?>)"/>
	<input type="button" id="cancelReputation" value="Cancel" onclick="cancelSourcesReputation()"/>
</div>
	</div>


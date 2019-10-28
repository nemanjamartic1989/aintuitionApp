<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$chooseCategorySources = $_POST['chooseCategorySources'];
	$chooseSubCategoryReputation = $_POST['chooseSubCategoryReputation'];
	
	$querySubCategoryReputation = "SELECT * FROM  tdbAIntuitionSubCategory WHERE AIntuitionCategoryID = '$chooseCategorySources' AND AIntuitionSubCategoryID = '$chooseSubCategoryReputation'";
	$resultSubCategoryReputation = mysql_query($querySubCategoryReputation);
	
	$rowSubCategoryReputation = mysql_fetch_array($resultSubCategoryReputation);
	
	$nameSubCategory = $rowSubCategoryReputation['nameSubCategory'];
	
?>

<fieldset style="float: right; width: 500px;"><legend>Source of the site for parsing: <?php echo "<label class=\"orange\">".$nameSubCategory."</label>";?></legend>
	<div id="SitesSourcesForInsert" style="float: left;" class="input-group">
		<label>Source of the site:</label><input type="text" id="SiteSourceReputation" name="SiteSourceReputation" placeholder="Insert site source" style="margin: 0 0 0 23px;"/><label id="showErrorMessageForSource" style="display: none; color: red;">Please insert validate URL.</label><label id="showErrorMessageForLengthSource"  style="display: none; color: red;">Length of caracter of source must be less than 100.</label> <br />
		
	</div>
	
	<br/>	
		<!-- Choose Language -->
	<div id="languageSourcesForChoose" style="margin: 30px 0 0 0; float: left;" class="input-group">
		<label>Choose Language:</label>
		<select id="languageSources" name="languageSources" style="margin: 0 0 0 20px;">
			<option value="">---</option>
			<?php 
			$queryChooseLanguage = "SELECT * FROM tdbLanguages";
			$resultChooseLanguage = mysql_query($queryChooseLanguage); // Send a MySQL query.
			
			if(mysql_num_rows($resultChooseLanguage) > 0){ // Get number of rows in result.
			
				while($rowChooseLanguage = mysql_fetch_array($resultChooseLanguage)){ // Fetch a result row as an associative array, a numeric array, or both.
				
					$MentalLexiconLanguageID = $rowChooseLanguage['languageID'];
					$nameLanguage = $rowChooseLanguage['languageName'];
					//$nameLanguage = utf8_encode($nameLanguage);
					echo "<option value=\"".$nameLanguage."\">".$nameLanguage."</option>";
					
				}
	
			}
		?>
		</select>
	</div>
	<input type="button" id="addSiteReputation" value="Add site" style="float: right;" onclick="addSiteReputation()"/>
	
			<fieldset id="ListOfAssignedSitesLanguages" style="width: 500px; margin: 20px 0 0 0; display: none;"><legend>List of assigned Languages to Sites:</legend>
				
				<table class="tableRowColoring" width="100%" cellpadding="0" cellspacing="0" id="displayTableSitesLanguages" style="float: left;">	
				<tr class="table_header">
				  <th class="tableNewBorderWhite" align='center'>Sites</th>
				  <th class="tableNewBorderWhite" align='center'>Languages</th>
				  <th class="tableNewBorderWhite" align='center'>Remove</th>	
		  	  	</tr>
		  	  	</table>
				
		  	  	
			</fieldset>	
</fieldset>
<input type="button" id="saveReputation" value="Save" onclick="saveSourcesReputation()" style="float: right; margin: 150px 0 0 400px;"/>
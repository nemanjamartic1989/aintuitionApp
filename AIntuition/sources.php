<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
?>

<input type="button" onclick="sourcesForModules();" value="Sources For Modules" style="float:left;"/>
<input type="button" onclick="backToMainMenu();" value="Back to main menu" style="float:right;"/><br /><br />

<fieldset id="sourcesForm"><legend>Sources Form</legend>
	<div id="SourcesReputationFormForSave">
		
	<div id="FormForFillFieldSource">
		
	<div id="SitesSourcesForInsert" style="float: left; margin: 0 0 0 0;" class="input-group">
		<label class="inputLabel">Source of the site:</label><input type="text" id="SiteSourceReputation" name="SiteSourceReputation" placeholder="Insert site source"/><br /><label id="showErrorMessageForSource" style="display: none; color: red;">Please insert valid URL! Example: (http://www.site.com).</label><br />
		<label id="showMessageErrorInsertSiteSources" class="red" style="display: none;">Please insert URL of site!</label>
		<label id="showErrorMessageForLengthSource"  style="display: none; color: red;">Length of caracter of source must be less than 100.</label> 
		
	</div>
	
	<br/>	
		<!-- Choose Language -->
	<div id="languageSourcesForChoose" style="margin: 20px 0 0 0; float: left;" class="input-group">
		<label class="inputLabel">Choose Language:</label>
		<select id="languageSources" name="languageSources">
			<option value="">---</option>
			<?php 
			$queryChooseLanguage = "SELECT * FROM tdbLanguages";
			$resultChooseLanguage = mysql_query($queryChooseLanguage); // Send a MySQL query.
			
			if(mysql_num_rows($resultChooseLanguage) > 0){ // Get number of rows in result.
			
				while($rowChooseLanguage = mysql_fetch_array($resultChooseLanguage)){ // Fetch a result row as an associative array, a numeric array, or both.
				
					$MentalLexiconLanguageID = $rowChooseLanguage['languageID'];
					$nameLanguage = $rowChooseLanguage['languageName'];
					
					echo "<option value=\"".$nameLanguage."\">".$nameLanguage."</option>";
					
				}
	
			}
		?>
		</select><br /><label id="showMessageErrorlanguageForTranslateSources" class="red" style="display: none;">Please choose language!</label>
	</div>
	
	</div>
	
	<!-- CATEGORIES - begin -->
	
	<div id="showCategoriesSourcesReputation">
			
			
	  <table class="tableRowColoring" width="180%" cellpadding="0" cellspacing="0" id="displayTableSourcesReputationCategories">	
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
	    					
	    	$queryCategory = "SELECT * FROM tdbAIntuitionCategory";
		$rezultQuery = mysql_query($queryCategory);
		
		if(mysql_num_rows($rezultQuery) > 0){
			while($rowCategory = mysql_fetch_array($rezultQuery)){
				$AIntuitionCategoryID = $rowCategory['AIntuitionCategoryID'];
				$nameCategory = $rowCategory['nameCategory'];
				
				
				echo"<tr>";
				echo"<td class='tableNewBorder' align='center' id='nameCategories'>" . $nameCategory . "</td>"; 
				echo"<td class='tableNewBorder' align='center' id='chooseCategories'><input type='checkbox' id='chooseCategorySources' name='chooseCategoriesSources[]' value='".$nameCategory."'/></td>"; 	  
				echo"</tr>"; 
	  	  	  	
	  	  	  }
		  
		  } else {
		  		
		  	echo"<tr><td colspan='7' align='center'><label class='red'>No Data</label></td></tr>";
		  }
  	  		
  	  	?>
  	  	</tbody>
  	  </table>
					
	
	
	</div>

	<label id="showMessageErrorChooseCategorySources" class="red" style="display: none; float: right;">Please choose category!</label>
	
	<!-- CATEGORIES - end -->

	</div>
	
	<div id="divSaveSourcesForm">
		<input type="button" id="saveReputation" value="Save" onclick="saveSourcesReputation()"/>
	</div>

	<div id="updateMessageSourcesReputationForm"></div>
	<div id="displayTableSourcesReputation"></div>

<fieldset id="ListOfSourcesReputation" style="margin: 100px 0 0 0;">
		<legend>List of sources reputation</legend>
		<!-- Search option -->
		<div id="searchOptionSourceReputation" style="margin: 0 0 0 850px;">
  	  	  <label id="search">Search:</label><input type="text" id="searchDataSourcesReputation" name="searchDataSourcesReputation" onkeyup="searchDataSourcesReputation()" placeholder="Search data for sites sources..."/>
  	   </div>
  	  
  	  <br />
<div style="max-height:200px; overflow-y: auto" id="displaySourcesReputation">
  	  
  	    <table class="tableRowColoring" width="100%" cellpadding="0" cellspacing="0" id="displayTableSourcesReputation">	
  	    <thead id="tableSourceHeader">
  	    	<tbody id="headerSource">
				<tr class="table_header">
				  <th class="tableNewBorderWhite" align='center'>Category</th>
				  <th class="tableNewBorderWhite" align='center'>Source - Language</th>	
				  <th class="tableNewBorderWhite" align='center'>Edit</th>
				  <th class="tableNewBorderWhite" align='center'>Remove</th>
		  	  	</tr>
	  	  	</tbody>
  	  	</thead>
  	  	<tbody id="displayDataFilter">
  	  	<?php
	    					
	    	$q = "
	    			SELECT * FROM tdbSourcesReputation ORDER BY SourcesReputationID DESC";
					
	    			$r = mysql_query($q); // Send a MySQL query.
	    			
	    			if(mysql_num_rows($r) > 0){ // Get number of rows in result.
	    				while($row = mysql_fetch_array($r)){ // Fetch a result row as an associative array, a numeric array, or both.
	    					$SourcesReputationID = $row['SourcesReputationID'];
	    					$categories = $row['categories'];
	    					$categories = json_decode($categories);
							$Source = $row['SiteSource'];
							$Source = json_decode($Source);
							$Language = $row['nameLanguage'];
				
				
				echo"<tr id=\"displayData\">";
					?>
				<td class='tableNewBorder' align='center'><?php foreach ($categories as $value) {
						echo $value."<br>";
					}?></td>
				
			
				<td class='tableNewBorder' align='center'><?php foreach ($Source as $key => $value) {
						echo "[".$key."]"." - "."[".$value."]"."<br>";
					}?></td> 
				<?php 
				
				echo"<td class='tableNewBorder' align='center'><img style='cursor:pointer' src='/images/ui/buttons/btn_edit.png' onclick='updateSourcesReputationForm($SourcesReputationID)'></td>";
 				echo"<td class='tableNewBorder' align='center'><img style='cursor:pointer' src='/images/ui/buttons/btn_delete.png' onclick='deleteSourcesReputation($SourcesReputationID)'></td>";

				  
				echo"</tr>"; 
	  	  	  	
	  	  	  }
		  
		  } else {
		  		
		  	echo"<tr><td colspan='7' align='center'><label class='red'>No Data</label></td></tr>";
		  }
  	  		
  	  	?>
  	  	</tbody>
  	  </table>
  	  
  	  </div>

</fieldset>


</fieldset>


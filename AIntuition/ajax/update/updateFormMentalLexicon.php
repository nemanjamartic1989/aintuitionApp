<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$MentalLexiconID = $_POST["MentalLexiconID"];
	
	$queryUpdate = "SELECT * FROM tdbMentalLexicon WHERE MentalLexiconID = '$MentalLexiconID'";
	$resultUpdate = mysql_query($queryUpdate);
	
	$rowUpdate = mysql_fetch_array($resultUpdate);
	
	$WordForTranslate = $rowUpdate['WordForTranslate'];
	$MentalLexiconLanguage = $rowUpdate['languageID'];
	$AnswerTranslation = $rowUpdate['AnswerTranslation'];
	$categories = $rowUpdate['category'];
	
	$categories = json_decode($categories);
		
?>


<fieldset id="TranslateWordFormUpdate" style="width: 900px;float: left;"><legend>Mental Lexicon form for updating points to category:</legend>
	
	<div style="float: left;">
		
	<!-- Choose Language -->
	<label>Choose Language:</label>
	<select id="languageForTranslateUpdate" name="languageForTranslate" style="margin: 0 0 0 20px;" disabled="true">
		<option value="">---</option>
		<?php 
		$queryChooseLanguage = "SELECT * FROM tdbLanguages";
		$resultChooseLanguage = mysql_query($queryChooseLanguage); // Send a MySQL query.
		
		if(mysql_num_rows($resultChooseLanguage) > 0){ // Get number of rows in result.
		
			while($rowChooseLanguage = mysql_fetch_array($resultChooseLanguage)){ // Fetch a result row as an associative array, a numeric array, or both.
			
				$MentalLexiconLanguageID = $rowChooseLanguage['languageID'];
				$nameLanguage = $rowChooseLanguage['languageName'];
				?>
				
				<option value="<?php echo $MentalLexiconLanguageID;?>" <?php if($MentalLexiconLanguageID == $MentalLexiconLanguage) echo "selected = 'selected'";?>><?php echo $nameLanguage;?></option>
				
				<?php
			}

		}
	?>
	</select>
	<br /><br />
	
	
	<!-- Insert word to translate -->
	<label>Word for translate:</label><input type="text" id="wordForTranslateUpdate" name="wordForTranslate" value="<?php echo $WordForTranslate;?>"  style="margin: 0 0 0 18px;" readonly/><label id="showErrorMessageWordUpdate" class="red" style="display: none;">Only letters are allowed!</label>
	<br /><br />

	</div>

	<!-- CHOOSE CATEGORY AND ADING OPTIONS -->
<fieldset style="width: 500px; float: right;"><legend>Category</legend>
	<label>Choose Category:</label>
	<select id="chooseCategoryMentalLexiconUpdate" name="chooseCategoryMentalLexiconUpdate" style="margin: 0 0 0 20px;">
		<option value="">---</option>
	<?php 
		$queryChooseCategory = "SELECT * FROM tdbAIntuitionCategory WHERE AIntuitionCategoryID IN (1, 4, 5, 6)";
		$resultChooseCategory = mysql_query($queryChooseCategory); // Send a MySQL query.
		
		if(mysql_num_rows($resultChooseCategory) > 0){
			while($rowChooseCategory = mysql_fetch_array($resultChooseCategory)){
				$AIntuitionCategoryID = $rowChooseCategory['AIntuitionCategoryID'];
				$nameCategory = $rowChooseCategory['nameCategory'];
				?>
				
				<option value="<?php echo $nameCategory;?>" <?php if($nameCategory == $category || $nameCategory == $categoryPartner) echo "selected = 'selected'";?>><?php echo $nameCategory;?></option>
				
				<?php 
			}
		}
	?>
		<option value="Service Provider" <?php if($category == 'Service Provider') echo "selected = 'selected'"; ?>>Service Provider</option>
	</select>
	
	<!-- Choose Reseller or Supplier after click on Partner -->
	<select id="showPartnerSubTypeUpdate" name="showPartnerSubTypeUpdate" style="display: none; margin: 20px 0 0 127px;">
		<option value="">---</option>
		<option value="Reseller" <?php if($subType == 'Reseller') echo "selected = 'selected'";?>>Reseller</option>
		<option value="Supplier" <?php if($subType == 'Supplier') echo "selected = 'selected'";?>>Supplier</option>
	</select>
	
	<div id="sliderUpdate" style="margin: 20px 0 0 0;">
		<label for="fader">Points of Category:</label>
		<input type="range" min="1" max="5" value="<?php echo $QualityTranslate;?>" id="SliderQualityTranslateUpdate" name="SliderQualityTranslate"
			step="1" oninput="outputUpdate(value)" style="margin: 0 0 0 20px;"/>
		<output for="SliderQualityTranslate" id="volumeUpdate">3 </output>
		
		<input type="button" id="updateCategory" style="float: right;" onclick="updateCategoriesPoints();" value="Add Category"/>

		<fieldset id="ChoosedPointsOfCategory" style="width: 500px; margin: 20px 0 0 0;"><legend>Chosen Points of Category</legend>
			
			<table class="tableRowColoring" width="70%" cellpadding="0" cellspacing="0" id="displayTableUpdate" style="float: left">	
				<tr class="table_header">
				  <th class="tableNewBorderWhite" align='center'>Categories</th>
				  <th class="tableNewBorderWhite" align='center'>Points</th>
				  <th class="tableNewBorderWhite" align='center'>Remove</th>	
		  	  	</tr>
		  	  	<?php  foreach ($categories as $key => $value) {
				
				echo "<tr id=\"showCategoriesPointsUpdate\"><td class=\"tableNewBorder\" name=\"categoriesUpdate[]\" align=\"center\" id=\"categoriesUpdate\">$key</td><td class=\"tableNewBorder\" name=\"pointsUpdate[]\" align=\"center\" id=\"pointsUpdate\">$value</td><td class=\"tableNewBorder\" align=\"center\"><img style=\"cursor:pointer\" src=\"/images/ui/buttons/btn_delete.png\"  id=\"removeCategoriesPointsUpdateForm\" onclick=\"removeRowCategoriesPoints();\"></td></tr>";
				
				}
				?>
		  	  	</table>
		  	  	
		  	  	<fieldset id="legendCategoriesPoints" style="float: right; width: 100px;"><legend>Legend</legend>
		  	  		
		  	  		<div><label>1</label><div style="width: 10px; height: 10px; background-color: red; float: right;"></div></div>
		  	  		<div><label>2</label><div style="width: 10px; height: 10px; background-color: red; float: right;"></div></div>
		  	  		<div><label>3</label><div style="width: 10px; height: 10px; background-color: white; border: 1px solid black; float: right;"></div></div>
		  	  		<div><label>4</label><div style="width: 10px; height: 10px; background-color: green; float: right;"></div></div>
		  	  		<div><label>5</label><div style="width: 10px; height: 10px; background-color: green; float: right;"></div></div>

		  	  	</fieldset>
		  	  	
		</fieldset>
	</div>
</fieldset>

</fieldset>



<div id="buttonsMentalLexicon" style="margin: 0 0 0 970px;">
	<input type="button" id="updateMentalLexicon" onclick="updateMentalLexicon(<?php echo $MentalLexiconID;?>);" value="Update" style="margin-top: 105px;"/>
	<input type="button" id="cancelMentalLexiconForm" onclick="cancelMentalLexiconForm();" value="Cancel" style="margin-top: 105px;"/>
</div>

</div>



<script>

// On change functio after click on Partner or GRC:	
$(function(){
	  $('#chooseCategoryMentalLexiconUpdate').on('change', function(){
		  var val = $(this).val();
		  if(val === 'Partner') {
		    $('#showPartnerSubTypeUpdate').show();
		  } else if(val === 'GRC') {
		    $('#showGRCSubType').show(); 
		  } else {
		  	$('#showPartnerSubTypeUpdate').hide();
		  }
	  });
 });
 
</script>

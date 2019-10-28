<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
?>

<script>
	$(document).ready(function(){
				
			var settings = $('#tableSourcesForModules').dataTable({
					
		    "ajax":{
		    		'type':'POST',
		    		'url' :'/AIntuition/ajax/sources/sourcesForModules.php',
		    		"data": function (d) 
		    		{
	                	d.action = 'get'
	           		}
		    },
		    "columns": [
		      { "data": "Sources" },
		      { "data": "Modules" },
		      { "data": "edit"},
		      { "data": "delete" }
		    ],
		    "aoColumnDefs": [
		      { "bSortable": false, "aTargets": [-1] }
		    ],
		    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		    "oLanguage": {
		      "oPaginate": {
		        "sFirst":       " ",
		        "sPrevious":    " ",
		        "sNext":        " ",
		        "sLast":        " ",
		      },
		      "sLengthMenu":    "Records per page: _MENU_",
		      "sInfo":          "Total of _TOTAL_ records (showing _START_ to _END_)",
		      "sInfoFiltered":  "(filtered from _MAX_ total records)"
		    }
			});
			
			// SAVE SOURCES MODULES:
						
		$(document).on('click','#saveSourcesForModules', function(e){
	 		
	 	var sources = $("#SiteSourceReputationForModules").val();
	 	
	 	//var validUrl = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(sources);
	 	
	 	var language = $("#languageSourcesForModules").val();
	 	
	 	var modules=[];
			$("#displayTableSourcesModules input:checkbox:checked").each(function(){
			  	modules.push($(this).attr('value'));
			});
	 	
	 	var categories=[];
			$("#displayTableSourcesModulesCategories input:checkbox:checked").each(function(){
			  	categories.push($(this).attr('value'));
			});
	 	
	 	console.log(sources + "<br>" + language + "<br>" + modules + "<br>" + categories);
	 	
	 	// VALIDATION OF SOURCES - BEGIN
	 	
	 	if(sources == ''){
	 		
	 		$("#errorMessageValidationUrl").text("Please insert URL!");
	 		$("#errorMessageValidationUrl").css({"color": "red"});
	 		$("#errorMessageValidationUrl").fadeIn().delay(4000).fadeOut();
	 		
	 	}  else {
	 		
	 		if(language == ''){
	 			
	 			$("#errorMessageLanguages").text("Please choose language!");
	 			$("#errorMessageLanguages").css({"color": "red"});
	 			$("#errorMessageLanguages").fadeIn().delay(4000).fadeOut();
	 			
	 		} else {
	 			
	 			if(modules.length == 0){
	 				
	 				$("#errorMessageModules").text("Please choose modules!");
	 				$("#errorMessageModules").css({"color": "red"});
	 				$("#errorMessageModules").fadeIn().delay(4000).fadeOut();
	 				
	 			} else {
	 			
	 	var sendData={
	 					sources: sources, language: language, modules: modules, categories: categories, action:"save"
	 	             };
	 	            
	 			// var conf = confirm("Do you want to save this data?");
// 	 			
	 			// if(conf == true){
	 				
	  	var request   = $.ajax({
	        url:          '/AIntuition/ajax/sources/sourcesForModules.php',
	        type:         'POST',
	        data:         sendData
	    });	             
	      
	      request.done(function(output){
	      	
	      	$("#messageData" + type).text('Data Saved Successfully!');
	 		$("#messageData" + type).css({"color": "red", "margin-left": "500px"});
	 		//$("#messageActions" + type).fadeIn().delay(3000).fadeOut();
	 		//$("#messageActions" + type).empty();
	 		settings.api().ajax.reload(function(){}, false);
	      	 var data      = JSON.parse(output);
	      });
	     
	    
	      
	      request.fail(function(jqXHR, textStatus){
	       
	      });
	      
	      }
	      
	      }
	      
	      }
	      
	      // VALIDATION OF SOURCES - END
	  
  	 });
			
			});
</script>

<input type="button" onclick="backToMainMenu();" value="Back to main menu" style="float:right;"/><br /><br />

<fieldset id="sourcesForm"><legend>Sources For Modules Form</legend>
		
	<div id="formSourcesModules">
		
	<div id="sourcesModules_1" style="float:left;">
		
	<div id="SitesSourcesForInsert" style="float: left; margin: 0 0 0 0;" class="input-group">
		<label class="inputLabel">Source of the site:</label><input type="text" id="SiteSourceReputationForModules" name="SiteSourceReputationForModules" placeholder="Insert site source"/><br /><label id="errorMessageValidationUrl"></label><br />
		
	</div>
	
	<br/>	
		<!-- Choose Language -->
	<div id="" style="margin: 50px 0 0 0;" class="input-group">
		<label class="inputLabel">Choose Language:</label>
		<select id="languageSourcesForModules" name="languageSourcesForModules">
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
		</select><br /><label id="errorMessageLanguages"></label>
	</div>
	
	<!-- Choose Modules -->
	<div id="ModulesForChoose" style="margin: 50px 0 0 0; float: left;" class="input-group">
		<table class="tableRowColoring" width="180%" cellpadding="0" cellspacing="0" id="displayTableSourcesModules">	
  	    <thead>
  	    	<tbody id="chooseSourcesCategories">
				<tr class="table_header">
				  <th class="tableNewBorderWhite" align='center'>Modules Name</th>	
				  <th class="tableNewBorderWhite" align='center'>Choose Modules</th>
		  	  	</tr>
	  	  	</tbody>
  	  	</thead>
  	  	<tbody id="">
			<?php 
			$queryModules = "SELECT * FROM tdbModules";
		$resultModules = mysql_query($queryModules);
		
		if(mysql_num_rows($resultModules) > 0){
			while($rowModules = mysql_fetch_array($resultModules)){
				$ModulesID = $rowModules['ModulesID'];
				$name = $rowModules['name'];
				
				
				echo"<tr>";
				echo"<td class='tableNewBorder' align='center' id='nameModules'>" . $name . "</td>"; 
				echo"<td class='tableNewBorder' align='center' id='chooseModules'><input type='checkbox' id='chooseModules' name='chooseModules[]' value='".$ModulesID."'/></td>"; 
				
				
				

				  
				echo"</tr>"; 
	  	  	  	
	  	  	  }
		  
		  } else {
		  		
		  	echo"<tr><td colspan='7' align='center'><label class='red'>No Data</label></td></tr>";
		  }
		?>
		</tbody>
  	  </table>
  	  <br /><label id="errorMessageModules"></label>
	</div>
	
	</div>
	
	<!-- CATEGORIES - begin -->
	
	<div id="showCategoriesSourcesReputation" style="float: right;">
			
			
	  <table class="tableRowColoring" width="180%" cellpadding="0" cellspacing="0" id="displayTableSourcesModulesCategories">	
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
	
	<div id="buttonSourcesForModules">
		<input type="button" id="saveSourcesForModules" value="Save" style="margin: 300px 0 0 100px;"/>
	</div>
	
	<div id="divForDisplayingSourcesForModules">
		
	<table id="tableSourcesForModules" class="tableRowColoring tdbStockExchanges"  style="margin: 150px 0 0 0;" cellspacing="0" width="100%">
        <thead>
            <tr class="table_header">
                <th>Sources</th>
                <th>Modules</th>
				<th>Edit</th>
				<th>Remove</th>
            </tr>
        </thead>
	</table>
		
	</div>
	
</fieldset>


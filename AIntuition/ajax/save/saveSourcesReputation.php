<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$userID = $_SESSION["userID"]; // Get UserID.
	
	// GET DATA FOR INSERTING ITSELF IN DATABASE:
	$categoryReputation = $_POST['categoryReputation'];
	$SiteSourceReputation = $_POST['SiteSourceReputation'];
	$languageReputation = $_POST['languageReputation'];
	
	$categories = $_POST['categories'];
	$categories = json_encode($categories);
	
	// Data from table where are adding category and points:
	$sites = $_POST['sites'];
	$countSites = count($sites); // Count all elements in an array sites.
	
	$languages = $_POST['languages'];
		
		$sitesLanguages = array($SiteSourceReputation => $languageReputation); // Creates an array by using the elements from one sites array and one languages array.
		$sitesLanguages = json_encode($sitesLanguages); // Returns the JSON representation of a value.
		
		// SET UTF-8:
		$sitesLanguages = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
    		return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
		}, $sitesLanguages);		

	
	// VALIDATION:
	// if(filter_var($SiteSourceReputation, FILTER_VALIDATE_URL)){ // Check validation of URL (Source)
		if(strlen($SiteSourceReputation) < 100){ // Check condition if length of character of Source if most/less than 100.
	$querySourcesReputation = "INSERT INTO tdbSourcesReputation(categories, SiteSource, createdBy, createdDate, userID, lastUpdate) 
	VALUES('$categories', '$sitesLanguages', '$userID', '$lastUpdate', '$userID', '$lastUpdate')";
	
	$resultSourcesReputation = mysql_query($querySourcesReputation);
	
	// SEND CLAIM:
	$description = $SiteSourceReputation;
			
	$resolveDate=date('Y-m-d',strtotime("+7 day",strtotime($lastUpdate)));
	sendRiskClaim($resolveDate, $description, "Website Parsing Request", "", $userID, $lastUpdate);
		
				echo "<b class=\"red\" id=\"messageForSaveDataOfSourcesReputation\">Data Saved!</b>";
		
		} else {
			echo "<script>$(\"#showErrorMessageForLengthSource\").show();</script>"; 
		}
	// }	 else {
		// echo "<script>$(\"#showErrorMessageForSource\").show();</script>";
	// }
	



?>

<!-- VIEW ALL SOURCES REPUTATION -->
<fieldset id="ListOfSourcesReputationSave" style="margin: 50px 0 0 0;">
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

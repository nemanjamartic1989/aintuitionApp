<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
	
	$SourcesReputationID = $_POST['SourcesReputationID'];
	
	$queryDeleteSourcesReputation = "DELETE FROM tdbSourcesReputation WHERE SourcesReputationID = '$SourcesReputationID'";
	$resultDeleteSourcesReputation = mysql_query($queryDeleteSourcesReputation);
	
	echo "<b class=\"red\" id=\"messageForDeleteDataOfSourcesReputation\">Data Deleted!</b>";
?>

<fieldset id="ListOfSourcesReputationDelete" style="margin: 50px 0 0 0;">
		<legend>List of sources reputation</legend>
		
		<!-- Search option -->
		<div id="searchOptionSourceReputation" style="margin: 0 0 0 850px;">
  	  	  <label id="search">Search:</label><input type="text" id="searchDataSourcesReputation" name="searchDataSourcesReputation" onkeyup="searchDataSourcesReputation()" placeholder="Search data for sites sources..."/>
  	    </div>
  	  
  	    <br />
  	   
<div style="max-height:200px; overflow-y: auto;" id="displaySourcesReputation">
  	  
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
  	  	</tbody>
  	  </table>
  	  
  	  </div>

</fieldset>
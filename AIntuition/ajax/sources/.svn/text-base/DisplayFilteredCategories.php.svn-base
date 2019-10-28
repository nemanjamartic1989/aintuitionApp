<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");

$id = $_POST["id"];

					
	    	$q = "
	    			SELECT sr.*, c.* FROM tdbSourcesReputation sr  
	    			INNER JOIN tdbAIntuitionCategory c 
	    			ON sr.AIntuitionCategoryID = c.AIntuitionCategoryID
	    		    WHERE sr.AIntuitionCategoryID = '$id' ORDER BY sr.SourcesReputationID DESC";
					
	    			$r = mysql_query($q); // Send a MySQL query.
	    			
	    			if(mysql_num_rows($r) > 0){ // Get number of rows in result.
	    				while($row = mysql_fetch_array($r)){ // Fetch a result row as an associative array, a numeric array, or both.
	    					$SourcesReputationID = $row['SourcesReputationID'];
	    					$Category = $row['nameCategory'];
							$Source = $row['SiteSource'];
							$Source = json_decode($Source);
							$Language = $row['nameLanguage'];
				
				
				echo"<tr id=\"displayData\">";
				echo"<td class='tableNewBorder' align='center'>" . $Category . "</td>"; 
				
				?>
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

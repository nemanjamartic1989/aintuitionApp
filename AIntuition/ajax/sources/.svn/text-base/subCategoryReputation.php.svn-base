<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	
?>

	<label class="inputLabel">Choose Category:</label>
		<select id="chooseCategorySources" name="chooseCategorySources" onchange="categoryReputation()">
			<option value="">---</option>
<?php 
		
	 
		$queryCategory = "SELECT * FROM tdbAIntuitionCategory WHERE AIntuitionCategoryID IN (1, 2, 4, 5)";
		$rezultQuery = mysql_query($queryCategory);
		
		if(mysql_num_rows($rezultQuery) > 0){
			while($rowCategory = mysql_fetch_array($rezultQuery)){
				$AIntuitionCategoryID = $rowCategory['AIntuitionCategoryID'];
				$nameCategory = $rowCategory['nameCategory'];
				
				$categoryID[] = $AIntuitionCategoryID;
				
				echo "<option value=\"$AIntuitionCategoryID\">$nameCategory</option>";
			}
		}
		
		
				
			?>
</select>

<br /><br />



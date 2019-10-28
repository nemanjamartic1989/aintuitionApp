<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");

$id = $_POST["id"];
$sql="SELECT sr.*, c.* FROM tdbSourcesReputation sr  
	    			INNER JOIN tdbAIntuitionCategory c 
	    			ON sr.AIntuitionCategoryID = c.AIntuitionCategoryID
	    		    GROUP BY c.nameCategory";
$res=mysql_query($sql);
?>
<fieldset style="border: 1px solid #888;">
<div class="filterBox">	
<table border="0" width="100%">
	<tr class="whitebg">
		<td style="cursor: pointer" onclick="DisplayAllDataFilter()">
			<label>All</label>
		</td>
	</tr>
		<?php 
		if(mysql_num_rows($res) > 0){
			while($row = mysql_fetch_array($res)){
				$nameCategory = $row["nameCategory"];
				$id = $row['AIntuitionCategoryID'];
		?>
		<tr class="whitebg">
			<td style="cursor: pointer" onclick="DisplayFilteredCategoryData(<?php echo $id;?>)">
				<label><?php echo $nameCategory;?></label>
			</td>
		</tr>
		<?php 
			}
		}
		?>
</table>
</div>
</fieldset>
<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");

$id = $_POST["id"];
$sql="SELECT ml . * , mll . * 
					FROM tdbMentalLexicon ml
					INNER JOIN tdbLanguages mll ON ml.languageID = mll.languageID
					GROUP BY mll.languageName";
$res=mysql_query($sql);
?>
<fieldset style="border: 1px solid #888;">
<div class="filterBox">	
<table border="0" width="100%">
	<tr class="whitebg">
		<td style="cursor: pointer" onclick="DisplayAllMentalLexiconFilter()">
			<label>All</label>
		</td>
	</tr>
		<?php 
		if(mysql_num_rows($res) > 0){
			while($row = mysql_fetch_array($res)){
				$nameLanguage = $row["languageName"];
				$id = $row['languageID'];
		?>
		<tr class="whitebg">
			<td style="cursor: pointer" onclick="DisplayFilteredMentalLexiconLanguageData(<?php echo $id;?>)">
				<label><?php echo $nameLanguage;?></label>
			</td>
		</tr>
		<?php 
			}
		}
		?>
</table>
</div>
</fieldset>
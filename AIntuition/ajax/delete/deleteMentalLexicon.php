<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
	
	$MentalLexiconID = $_POST['MentalLexiconID'];
	
	$queryDeleteMentalLexicon = "DELETE FROM tdbMentalLexicon WHERE MentalLexiconID = '$MentalLexiconID'";
	$resultDeleteMentalLexicon = mysql_query($queryDeleteMentalLexicon);
	
	echo "<b class=\"red\" id=\"messageForDeleteData\">Data Deleted!</b>";
?>

<fieldset id="TemporaryListOfMentalLexiconDelete" style="margin: 50px 0 0 0;">
		<legend>Mental Lexicon Lists</legend>
		
		<!-- Search option -->
		<div id="searchOptionMentalLexicon" style="margin: 0 0 0 850px;">
  	  	  <label id="search">Search:</label><input type="text" id="searchDataMentalLexicon" name="searchDataMentalLexicon" onkeyup="searchDataMentalLexicon()" placeholder="Search word for translate..."/>
  	    </div>
  	    
  	     <br />
  	  <!-- Container for displaying data from Table tdbMentalLexicon -->
<div style="max-height:200px; overflow-y: auto" id="displayMentalLexicon">
  	  
  	    <table class="tableRowColoring" width="100%" cellpadding="0" cellspacing="0" id="displayTableMentalLexicon">	
		<tr class="table_header">
		  <th class="tableNewBorderWhite" align='center'>Word for translate</th>
		  <th class="tableNewBorderWhite" align='center'>Language<img id="typeFilterImg" title="Filter" src="/images/ui/buttons/filter.png" style="cursor: pointer;" onclick="DisplayMentalLexiconReputationType()"/> <div id="typeListMentalLexiconLanguage" style="position: absolute;margin: 2px 0px 0px 105px;z-index: 999999;"></div></th>	
		  <th class="tableNewBorderWhite" align='center'>Categories - Points</th>	
		  <th class="tableNewBorderWhite" align='center'>Edit</th>
		  <th class="tableNewBorderWhite" align='center'>Remove</th>
  	  	</tr>
  	  	
  	  	<tbody id="displayDataFilterMentalLexicon">
  	  	
  	  	<?php
	    					
	    			$q = "
	    			SELECT ml . * , mll . * 
					FROM tdbMentalLexicon ml
					INNER JOIN tdbLanguages mll ON ml.languageID = mll.languageID
					ORDER BY ml.MentalLexiconID DESC";
					
	    			$r = mysql_query($q); // Send a MySQL query.
	    			
	    			if(mysql_num_rows($r) > 0){ // Get number of rows in result.
	  
	    				while($row = mysql_fetch_array($r)){ // Fetch a result row as an associative array, a numeric array, or both.
	    					$MentalLexiconID = $row['MentalLexiconID'];
							$WordForTranslate = $row['WordForTranslate'];
							$nameLanguage = $row['languageName'];
							$categories = json_decode($row['category']);
				
				
				echo"<tr>";
				echo"<td class='tableNewBorder' align='center'>" . $WordForTranslate . "</td>"; 
				echo"<td class='tableNewBorder' align='center'>" . $nameLanguage . "</td>"; 
				?>
				<td class='tableNewBorder' align='center'><?php foreach ($categories as $key => $value) {
						echo $key." - ".$value."<br>";
					}?></td> 
				<?php 
				echo"<td class='tableNewBorder' align='center'><img style='cursor:pointer' src='/images/ui/buttons/btn_edit.png' onclick='updateMentalLexiconForm($MentalLexiconID)'></td>";
 				echo"<td class='tableNewBorder' align='center'><img style='cursor:pointer' src='/images/ui/buttons/btn_delete.png' onclick='deleteMentalLexicon($MentalLexiconID)'></td>";

				  
				echo"</tr>"; 
	  	  	  	
	  	  	  }
		  
		  } else {
		  		
		  	echo"<tr><td colspan='7' align='center'><label class='red'>No Data</label></td></tr>";
		  }
  	  		
  	  	?>
  	  	</tbody>
  	  </table>
  	  
  	  </div>
		
	<div id="showMessageUpdate"></div>
	<div id="showMessageDelete"></div>

</fieldset>
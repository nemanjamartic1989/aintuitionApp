<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");

$id = $_POST["id"];

		$q = "
	    			SELECT ml . * , mll . * 
					FROM tdbMentalLexicon ml
					INNER JOIN tdbLanguages mll ON ml.languageID = mll.languageID
					WHERE ml.languageID = '$id'
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
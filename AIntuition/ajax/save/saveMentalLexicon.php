<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$userID = $_SESSION["userID"]; // Get UserID.
	
	// GET DATA FOR INSERTING ITSELF IN DATABASE:
	$wordForTranslate = $_POST["wordForTranslate"];
	$languageForTranslate = $_POST['languageForTranslate'];
	$nameCategory = $_POST['chooseCategoryMentalLexicon'];
	$PartnerSubType = $_POST['showPartnerSubType'];
	

	// Data from table where are adding category and points:
	$categories = $_POST['categories'];
	$countCategories = count($categories);
	
	$points = $_POST['points'];
		
		$categoriesPoints = array_combine($categories, $points); // Creates an array by using the elements from one categories array and one points array.
		$categoriesPoints = json_encode($categoriesPoints); // Returns the JSON representation of a value.
 
	
	// CHECK CONDITION IF A Word To Translate and Language are same or different:
	$queryCheck = "SELECT * FROM tdbMentalLexicon";
	$resultCheck = mysql_query($queryCheck); // Send a MySQL query.
	
	if(mysql_num_rows($resultCheck) > 0){ // Get number of rows in result.
	
		while($rowCheck = mysql_fetch_array($resultCheck)){ // Fetch a result row as an associative array, a numeric array, or both.
		
			$word = $rowCheck['WordForTranslate'];
			$MentalLexiconLanguageID = $rowCheck['MentalLexiconLanguageID'];
			
			$words[] = $word;
			$language[] = $MentalLexiconLanguageID;
		}
	}
	
	// VALIDATION FORM:
	if(!empty($wordForTranslate) && !empty($languageForTranslate) && !empty($nameCategory)){ // Check condition if field in form is empty or not.
		if($countCategories > 0){ // Check condition if user is/not added category and points to list.
		if(!preg_match("/^[a-zA-Z\s]+$/",$wordForTranslate)){ // Check condition if in field word is not only letter.
				
			echo "<script>$('#showErrorMessageWord').show();</script>"; // Print error. Only letter allowed.
			echo "<script>$('#showErrorMessageWord').fadeIn().delay(3000).fadeOut();</script>";
			echo "<script>$('#messageForSavedData').hide();</script>";
		} else {
			echo "<script>$('#showErrorMessageWord').hide();</script>";
			if(in_array($wordForTranslate, $words)) {
				echo "<script>alert('You already choose this word!');</script>";
			} else {
				
				if(count($categories) === count(array_unique($categories))){ // Check if an array categories has duplicate values.
					
				// CREATE QUERY FOR INSERT DATA IN TABLE tdbMentalLexicon:	
				$queryMentalLexicon = "INSERT INTO tdbMentalLexicon(WordForTranslate, languageID, category, createdBy, createdDate, userID, lastUpdate)
				VALUES('$wordForTranslate', '$languageForTranslate', '$categoriesPoints', '$userID', '$lastUpdate', '$userID', '$lastUpdate')";
				$resultMentalLexicon = mysql_query($queryMentalLexicon); // Send a MySQL query.
				
				echo "<b class=\"red\" id=\"messageForSavedData\">Data Saved!</b>";
				} else {
					echo "<script>alert('You must choose only different categories!');</script>"; // Print message if array categories has duplicate values.
				}
			}
			
		}

		}else{
			echo "<script>alert('Please add category and point to list!');</script>"; // Print message if not added category to list!
		}
	} else {
			echo "<script>alert('Please fill out of field!');</script>"; // Print message if field is not complete.
		}
		
?>

<fieldset id="TemporaryListOfMentalLexiconSave" style="margin: 50px 0 0 0;">
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

</fieldset>

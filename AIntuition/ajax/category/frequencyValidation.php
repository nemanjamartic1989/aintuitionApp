<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$id = $_POST['id'];
	
	$hours = range(1, 24);
	$hourCount = count($hours);
	
	$days = range(1, 31);
	$dayCount = count($days);
	
	$months = range(1, 12);
	$monthCount = count($months);
	
	// Set List of Hours:
	echo "<div id=\"divHour$id\"><label>Frequency Per Hour</label><select id=\"validationForHour$id\" name=\"validationForHour$id\">";
	
	for($i = 0; $i < $hourCount; $i++){
		echo "<option value=\"$hours[$i]\">$hours[$i]</option>";
	}
	
	echo "</select></div>";
	
	// Set List of Days:
	echo "<div id=\"divDay$id\"><label>Frequency Per Day</label><select id=\"validationForDay$id\" name=\"validationForDay$id\">";
	
	for($j = 0; $j < $dayCount; $j++){
		echo "<option value=\"$days[$j]\">$days[$j]</option>";
	}
	
	echo "</select></div>";
	
	// Set List of Months:
	echo "<div id=\"divMonth$id\"><label>Frequency Per Month</label><select id=\"validationForMonth$id\" name=\"validationForMonth$id\">";
	
	for($k = 0; $k < $monthCount; $k++){
		echo "<option value=\"$months[$k]\">$months[$k]</option>";
	}
	
	echo "</select></div>";
?>
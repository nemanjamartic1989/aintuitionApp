<?php 

	include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
	
	$id = $_POST['aIntuitionHoldingOrganigramID'];
	
	$q = "SELECT * FROM tdbAIntuitionHoldingOrganigram";
	$r = mysql_query($q);
	
	$query = "DELETE FROM tdbAIntuitionHoldingOrganigram WHERE aIntuitionHoldingOrganigramID = '$id'";
	$rez = mysql_query($query);

	// if(mysql_affected_rows($rez) == 1){
		// echo "";
	// } else {
		// echo "";	
	// }
?>

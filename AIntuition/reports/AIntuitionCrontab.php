<?php
$dir = dirname(__DIR__);
include ($dir . "../../classes/init.php");

//set all AI in crontab
$db = new DB();
// $reports = $db->column("SELECT AIntuitionID FROM tdbAIntuition WHERE AIntuitionID IN(17,37)");
$reports = $db->column("SELECT AIntuitionID FROM tdbAIntuition");
foreach ($reports as $AIntuitionID) {
	$AIntuition = new AIntuition($AIntuitionID);
	
	$formatAIntuitionFrequency = $AIntuition->formatAIntuitionFrequency();
	
	// $formatAIntuitionFrequency = "*/10 * * * *";
	
	$createAIreport = $AIntuition->createAIReport($formatAIntuitionFrequency);
	
	// $removeAIReport = $AIntuition->removeAIReport($formatAIntuitionFrequency);	
}

?>
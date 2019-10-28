<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));
$db = new DB();
$countCompetitor = $db->single("SELECT COUNT(competitorID) FROM tdbCompetitor");
$AIntuition->insertAIReport($countCompetitor);
$AIntuitionMobileReports = $AIntuition->AIntuitionCalculatePercentagesHolding();
?>
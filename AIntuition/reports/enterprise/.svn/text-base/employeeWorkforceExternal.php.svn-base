<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$Employee = new Employee();
$countEmployee = $Employee->countEmployeeByType(1);
$AIntuition->insertAIReport($countEmployee);
// calculate all for this sub category
$AIntuitionMobileReports = $AIntuition->AIntuitionCalculatePercentagesHolding();
?>
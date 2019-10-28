<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));
$Employee = new Employee();

$cnt = array();
if(is_object($AIntuitionParameters)){
	$employeeReport = $Employee->countEmployeeByTypeAndBABU(0, $AIntuitionParameters->holding->businessArea, $AIntuitionParameters->holding->businessUnit);
	foreach ($employeeReport as $key => $value) {
		if(in_array($value["businessAreaID"], $AIntuitionParameters->holding->businessArea)){
			$cnt["businessArea"][$value["businessAreaID"]] += $value["cnt"];	
		}
		
		if(in_array($value["businessUnitID"], $AIntuitionParameters->holding->businessUnit)){
			$cnt["businessUnit"][$value["businessUnitID"]] += $value["cnt"];
		}
	}
	if(isset($cnt["businessArea"])){
		ksort($cnt["businessArea"]);	
	}
	if(isset($cnt["businessUnit"])){
		ksort($cnt["businessUnit"]);	
	}
}else{
	$cnt["holding"] = $Employee->countEmployeeByType(0);	
}
ksort($cnt);

if(!isset($cnt["holding"])){
	$AIntuition->insertAIReport(json_encode($cnt));
	$AIntuitionMobileReports = $AIntuition->AIntuitionCalculatePercentagesBABU();	
}else{
	$AIntuition->insertAIReport($cnt["holding"]);
	$AIntuitionMobileReports = $AIntuition->AIntuitionCalculatePercentagesHolding();
}	
?>
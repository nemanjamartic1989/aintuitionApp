<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));
$assetLevel = new AssetLevel();
$getAssetsExpitedAmort = $assetLevel->getAssetsExpitedAmort();

$cnt = array();
if(is_object($AIntuitionParameters)){
	foreach ($getAssetsExpitedAmort as $key => $value) {
		$assetBABU = $assetLevel->assetBABU($value["type"],$value["asset"]);
		$getAssetsExpitedAmort[$key]["businessArea"] = $assetBABU["businessArea"];
		$getAssetsExpitedAmort[$key]["businessUnit"] = $assetBABU["businessUnit"];
	}
	foreach ($getAssetsExpitedAmort as $key => $value) {
		foreach ($value["businessArea"] as $value1) {
			if(in_array($value1, $AIntuitionParameters->holding->businessArea)){
				$cnt["businessArea"][$value1] += 1;	
			}
		}
		
		foreach ($value["businessUnit"] as $value2) {
			if(in_array($value2, $AIntuitionParameters->holding->businessUnit)){
				$cnt["businessUnit"][$value2] += 1;
			}
		}
	}
	ksort($cnt["businessArea"]);
	ksort($cnt["businessUnit"]);
}else{
	$cnt["holding"] = count($getAssetsExpitedAmort);
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
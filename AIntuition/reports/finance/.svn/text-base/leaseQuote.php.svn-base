<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));
$assetLevel = new AssetLevel();
$getAssetsLeasing = $assetLevel->getAssetsLeasingCount();
 
$cnt = array();
if(is_object($AIntuitionParameters)){
 	$i=0;
	foreach ($getAssetsLeasing as $key => $value) {		
		$assetBABU = $assetLevel->assetBABU($value["type"],$value["nodeID"]);
		$getAssetsLeasing[$key]["businessArea"] = $assetBABU["businessArea"];
		$getAssetsLeasing[$key]["businessUnit"] = $assetBABU["businessUnit"];
 		$i++;
	}

	foreach ($getAssetsLeasing as $key => $value) {
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
	$cnt["holding"] = count($getAssetsLeasing);
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
<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));
$assetLevel = new AssetLevel();
$getAssetsByBABUonLevelOne = $assetLevel->getAssetsByBABUonLevelOne();

$cnt = array();
if(is_object($AIntuitionParameters)){
	foreach ($getAssetsByBABUonLevelOne as $keyLevel => $valueArray) {
		foreach ($valueArray as $key => $value) {
			if(in_array($value["businessArea"], $AIntuitionParameters->holding->businessArea)){
				$cnt[$keyLevel]["businessArea"][$value["businessArea"]] += $value["cnt"];	
			}
			
			if(in_array($value["businessUnit"], $AIntuitionParameters->holding->businessUnit)){
				$cnt[$keyLevel]["businessUnit"][$value["businessUnit"]] += $value["cnt"];
			}
		}
		if(isset($cnt[$keyLevel]["businessArea"])){
			ksort($cnt[$keyLevel]["businessArea"]);	
		}
		
		if(isset($cnt[$keyLevel]["businessUnit"])){
			ksort($cnt[$keyLevel]["businessUnit"]);	
		}
	}
}else{
	foreach ($getAssetsByBABUonLevelOne as $keyLevel => $valueArray) {
		foreach ($valueArray as $key => $value) {	
			$cnt["holding"][$keyLevel] += $value["cnt"];
		}
	}
}

ksort($cnt);

$AIntuition->insertAIReport(json_encode($cnt));
$AIntuitionMobileReports = $AIntuition->AIntuitionCalculatePercentagesAssetManagement();

?>
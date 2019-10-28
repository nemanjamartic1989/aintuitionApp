<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));
$site = new Site();
$siteByBABU = $site->siteByBABU();

$cnt = array();
if(is_object($AIntuitionParameters)){
	foreach ($siteByBABU as $value) {
		if(in_array($value["businessArea"], $AIntuitionParameters->holding->businessArea)){
			$cnt["businessArea"][$value["businessArea"]] += $value["cnt"];	
		}
		
		if(in_array($value["businessUnit"], $AIntuitionParameters->holding->businessUnit)){
			$cnt["businessUnit"][$value["businessUnit"]] += $value["cnt"];
		}
		
		if(isset($cnt["businessArea"])){
			ksort($cnt["businessArea"]);	
		}
		
		if(isset($cnt["businessUnit"])){
			ksort($cnt["businessUnit"]);	
		}
	}
}else{
	foreach ($siteByBABU as $value) {
		$cnt["holding"] += $value["cnt"];	
	}
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
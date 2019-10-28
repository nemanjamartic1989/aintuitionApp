<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));
$cnt = array();
$db = new DB();
$riskPhase = $db->riskPhase();

if(is_object($AIntuitionParameters)){										
	$res = $db->query("SELECT COUNT( tdbAssetsReplaces.replacedID ) AS cnt,tdbSite.businessAreaID, tdbSite.siteBusinessunitID as businessUnitID
									FROM tdbSiteAsset
									INNER JOIN tdbSite ON tdbSiteAsset.siteID = tdbSite.siteID
									INNER JOIN tdbAssetsReplaces ON tdbSiteAsset.nodeID = tdbAssetsReplaces.replacedNodeID
									WHERE tdbAssetsReplaces.projectPhaseID = :projectPhaseID
								GROUP BY tdbSite.businessAreaID, tdbSite.siteBusinessunitID", array("projectPhaseID"=>$riskPhase));										
	foreach ($res as $key => $value) {
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
	$res = $db->single("SELECT COUNT( a.replacedID ) AS cnt, b.businessAreaID, b.siteBusinessunitID AS businessUnitID  
									FROM tdbAssetsReplaces AS a 
									JOIN tdbSite AS b ON a.siteID = b.siteID
									WHERE a.projectPhaseID = '$riskPhase'"
							);
	$cnt["holding"] = $res["cnt"];
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
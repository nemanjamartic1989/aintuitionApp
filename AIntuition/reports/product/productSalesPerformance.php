<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
// $AIntuitionID = 35; //for test
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));

$db = new DB();

if(is_object($AIntuitionParameters)){
	$cnt = array();		
		$res = $db->query("SELECT COUNT( tdbProductOrder.orderID ) AS cnt, tdbSite.businessAreaID, tdbSite.siteBusinessunitID AS businessUnitID  
									FROM tdbProductOrder 
									JOIN tdbProductSortiment ON tdbProductOrder.productSortimentID = tdbProductSortiment.productSortimentID
									JOIN tdbSite ON tdbProductSortiment.siteID = tdbSite.siteID
									GROUP BY tdbSite.businessAreaID, tdbSite.siteBusinessunitID"
							);
		foreach ($res as $key => $value) {
			if(in_array($value["businessAreaID"], $AIntuitionParameters->holding->businessArea)){
				$cnt["businessArea"][$value["businessAreaID"]] += $value["cnt"];	
				$cnt["businessArea"]["total"] += $value["cnt"];
			}
			
			if(in_array($value["businessUnitID"], $AIntuitionParameters->holding->businessUnit)){
				$cnt["businessUnit"][$value["businessUnitID"]] += $value["cnt"];
				$cnt["businessUnit"]["total"] += $value["cnt"];
			}
		}
		if(isset($cnt["businessArea"])){
			ksort($cnt["businessArea"]);	
		}
		
		if(isset($cnt["businessUnit"])){
			ksort($cnt["businessUnit"]);	
		}				
	
}else{
	$res = $db->single("SELECT COUNT( tdbProductOrder.orderID ) AS cnt
						FROM tdbProductOrder
						JOIN tdbProductSortiment ON tdbProductOrder.productSortimentID = tdbProductSortiment.productSortimentID"
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
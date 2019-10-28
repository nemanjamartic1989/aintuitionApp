<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));
$cnt = array();
$db = new DB();

if(is_object($AIntuitionParameters)){		
	$res = $db->query("SELECT COUNT( a.forecastSalesID ) AS cnt, c.businessAreaID, c.siteBusinessunitID AS businessUnitID  
								FROM tdbForecastSales AS a 
								JOIN tdbProductSortiment AS b ON a.productSortimentID = b.productSortimentID
								JOIN tdbSite AS c ON b.siteID = c.siteID
								GROUP BY c.businessAreaID, c.siteBusinessunitID");
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
	$res = $db->single("SELECT COUNT( a.forecastSalesID ) AS cnt
						FROM tdbForecastSales AS a 
						JOIN tdbProductSortiment AS b ON a.productSortimentID = b.productSortimentID"
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
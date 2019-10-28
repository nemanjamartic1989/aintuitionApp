<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
// $AIntuitionID = 80; //for test
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));
$db = new DB();
$res1 = $db->query("SELECT `businessPartnerName`, `businessPartnerID`, `spTypeID`, `spSubTypeID`, `businessPartnerWebSite` 
						FROM `tdbBusinessPartner` WHERE businessPartnerType = :businessPartnerType",
						array("businessPartnerType"=>"Reseller"));
$cnt = array();							
if(is_object($AIntuitionParameters)){	
	foreach ($res1 as $bp) {
		$businessPartnerID = $bp["businessPartnerID"];
		$res2 = $db->query("SELECT tdbSite.businessAreaID, tdbSite.siteBusinessunitID  
									FROM tdbProductOrder 
									JOIN tdbProductSortiment ON tdbProductOrder.productSortimentID = tdbProductSortiment.productSortimentID
									JOIN tdbSite ON tdbProductSortiment.siteID = tdbSite.siteID
									WHERE businessPartnerID = :businessPartnerID
									GROUP BY tdbSite.businessAreaID, tdbSite.siteBusinessunitID",
									array(
										"businessPartnerID"=>$businessPartnerID
										)
							);
		foreach ($res2 as $key => $value) {
			if(in_array($value["businessAreaID"], $AIntuitionParameters->holding->businessArea)){
				$cnt["businessArea"][$value["businessAreaID"]] += 1;	
				$cnt["businessArea"]["total"] += 1;
			}
			
			if(in_array($value["businessUnitID"], $AIntuitionParameters->holding->businessUnit)){
				$cnt["businessUnit"][$value["businessUnitID"]] += 1;
				$cnt["businessUnit"]["total"] += 1;
			}
		}
		if(isset($cnt["businessArea"])){
			ksort($cnt["businessArea"]);	
		}
		
		if(isset($cnt["businessUnit"])){
			ksort($cnt["businessUnit"]);	
		}				
	}
}else{
	$cnt["holding"] = $db->rowCount();
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
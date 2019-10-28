<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
/*$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));*/
$db = new DB();
$res1 = $db->query("SELECT `businessPartnerName` FROM `tdbBusinessPartner` WHERE businessPartnerType = :businessPartnerType",
						array("businessPartnerType"=>"Supplier"));
$cnt = array();							
//if(is_object($AIntuitionParameters)){	
	foreach ($res1 as $bp) {
		$businessPartnerName = $bp["businessPartnerName"];
		echo $businessPartnerName."<br>";
		/*$res2 = $db->query("SELECT pm.procurementCode, sp.name, pr.destinationSite
					        FROM `tdbProcurementOrder` AS po
					        INNER JOIN `tdbProcurementProposal` AS pp ON po.proposalID = pp.proposalID
					        INNER JOIN `tdbProcurementManagment` AS pm ON pp.procurementID = pm.procurementID
					        LEFT JOIN `tdbServiceProvider` as sp ON pp.companyID = sp.id
					        LEFT JOIN `tdbProcurementRequest` as pr ON pr.procurementID = pp.procurementID
							WHERE sp.name = "Accenture"
					        GROUP BY pp.proposalID
					        ORDER BY po.orderID DESC",
									array(
										"businessPartnerName"=>$businessPartnerName
										)
							);
		foreach ($res2 as $key => $value) {
			if(in_array($value["businessAreaID"], $AIntuitionParameters->holding->businessArea)){
				$cnt["businessArea"][$value["businessAreaID"]] += 1;	
			}
			
			if(in_array($value["businessUnitID"], $AIntuitionParameters->holding->businessUnit)){
				$cnt["businessUnit"][$value["businessUnitID"]] += 1;
			}
		}
		if(isset($cnt["businessArea"])){
			ksort($cnt["businessArea"]);	
		}
		
		if(isset($cnt["businessUnit"])){
			ksort($cnt["businessUnit"]);	
		}*/				
	}
//}else{
	//$cnt["holding"] = $db->rowCount();
//}
/*
ksort($cnt);

if(!isset($cnt["holding"])){
	$AIntuition->insertAIReport(json_encode($cnt));
	$AIntuitionMobileReports = $AIntuition->AIntuitionCalculatePercentagesBABU();	
}else{
	$AIntuition->insertAIReport($cnt["holding"]);
	$AIntuitionMobileReports = $AIntuition->AIntuitionCalculatePercentagesHolding();
}
*/
?>
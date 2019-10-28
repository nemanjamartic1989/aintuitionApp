<?php

/*
	nedostaje deo onaj ko je koga kupio da se prikaze pored duty-a
*/

$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));

$Risk = new Risk();
$concentrationRisk = $Risk->serviceProviderConcentrationRisk();

$cnt = array();
if(is_object($AIntuitionParameters)){
	foreach ($concentrationRisk as $riskLevel => $sp) {
		foreach ($sp as $spID => $spInfo) {
			foreach ($spInfo as $systemType => $systemTypeInfo) {
				$tmp = array();
				foreach ($systemTypeInfo["assets"] as $nodeID) {
					$assetLevel = new AssetLevel();
					$assetBABU = $assetLevel->assetBABU("IT", $nodeID);
					foreach ($assetBABU["businessArea"] as $value1) {
						if(in_array($value1, $AIntuitionParameters->holding->businessArea)){
							$tmp["businessArea"][$value1] += 1;	
						}
					}
					foreach ($assetBABU["businessUnit"] as $value2) {
						if(in_array($value2, $AIntuitionParameters->holding->businessUnit)){
							$tmp["businessUnit"][$value2] += 1;	
						}		
					}
				}
				$cnt[$riskLevel][$spID][$systemType]["percentage"] = $systemTypeInfo["percentage"];
				$cnt[$riskLevel][$spID][$systemType]["assets"] = $tmp;
			}
		}
	}
}else{
	foreach ($concentrationRisk as $riskLevel => $sp) {
		foreach ($sp as $spID => $spInfo) {
			foreach ($spInfo as $systemType => $systemTypeInfo) {
				$tmp = array();
				foreach ($systemTypeInfo["assets"] as $nodeID) {
					$assetLevel = new AssetLevel();
					$assetBABU = $assetLevel->assetBABU("IT", $nodeID);
					foreach ($assetBABU["businessArea"] as $value1) {
						$tmp["businessArea"][$value1] += 1;	
					}
					foreach ($assetBABU["businessUnit"] as $value2) {
						$tmp["businessUnit"][$value2] += 1;			
					}
				}
				$cnt[$riskLevel][$spID][$systemType]["percentage"] = $systemTypeInfo["percentage"];
				$cnt[$riskLevel][$spID][$systemType]["assets"] = $tmp;
			}
		}
	}			
}

$AIntuition->insertAIReport(json_encode($cnt),'all');	

$AIntuitionMobileReports = $AIntuition->AIntuitionMobileReports();
$AIntuitionHandlingTypes = $AIntuition->getFromAIntuition(array("AIntuitionHandlingTypes"));
$calculateArray = array();
$duty = array();
$good_bad = array();
for($i=0; $i<count($AIntuitionMobileReports); $i++){
	$expLast = json_decode($AIntuitionMobileReports[$i]["status"]);
	$n=0;
	foreach ($expLast as $riskLevel => $sp) {
		if($riskLevel == "high"){
			$n++;
			if($AIntuitionHandlingTypes == "Duty"){
				foreach ($sp as $spID => $spInfo) {
					foreach ($spInfo as $systemType => $systemTypeInfo) {
						foreach ($systemTypeInfo->assets as $babu => $babuInfo) {
							if($babu == "businessArea"){
								foreach ($babuInfo as $babuID => $value) {	
									$BusinessArea = new BusinessArea($babuID);
									$get_employeeDutyBusinessArea = $BusinessArea->get_employeeDutyBusinessArea();
									
									if($get_employeeDutyBusinessArea){
										$duty[$babu][$babuID] = $get_employeeDutyBusinessArea;
										// fali jos da se doda za recimo SP i tip Asseta
									}
								}
							}elseif($babu == "businessUnit"){
								//nemamo jos ovaj duty i ne znam bas kako ce se to uraditi
							}
						}
					}
				}
			}elseif($AIntuitionHandlingTypes == "Private"){
				$duty = $AIntuition->get_employeeID();
			}
		}
	}
	
	if($n > 0){		
		$report = FALSE;
		$good_bad["badUnread"] += 1;
		if($AIntuitionMobileReports[$i]["dutyDelegation"] == NULL){
			$AIntuition->updateDutyDelegation($AIntuitionMobileReports[$i]["AIntuitionReportID"], json_encode($duty));			
		}
	}else{
		$report = TRUE;
		$good_bad["goodUnread"] += 1;
	}
	
	if($AIntuitionMobileReports[$i]["reportCode"] == NULL){
		$AIntuition->updateReportCode($AIntuitionMobileReports[$i]["AIntuitionReportID"], $report);			
	}
	
	$calculateArray[$i] = $report;
}

$AIntuition->updateUnread($good_bad["goodUnread"],$good_bad["badUnread"]);							
$AIntuition->AIntuitionInsertPercentages($calculateArray);

?>
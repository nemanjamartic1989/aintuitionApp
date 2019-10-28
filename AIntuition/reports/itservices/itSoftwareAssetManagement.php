<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));

function checklicenses($licenced, $licenses){
	if($licenced <= $licenses){
		return TRUE;
	}else{
		return FALSE;
	}
}

$db = new DB();
$query = "SELECT businessAreaID as businessArea, businessUnitID as businessUnit, objectID as softwareID, tdbVendorConnection.numberOfCPU as licenses FROM tdbVendorConnection 
				JOIN tdbContract ON tdbVendorConnection.contractID = tdbContract.contractID
				WHERE connectionType = :connectionType AND tdbContract.projectPhaseID = :projectPhaseID";

$licences = $db->query($query,array("connectionType"=>"linkWithSoftware", "projectPhaseID"=>$db->riskPhase()));

$licenceReport = array();
foreach ($licences as $key => $contract) {
	$query1 = "SELECT COUNT(nodeID) AS licensed FROM tdbSoftware WHERE name = (SELECT name FROM tdbSoftware WHERE softwareID = :softwareID) AND projectPhaseID = :projectPhaseID";
	$licenced = $db->single($query1,array("softwareID"=>$contract["softwareID"], "projectPhaseID"=>$db->riskPhase()));
	$temp = array();
	foreach ($contract as $key1 => $value1) {
		$temp[$key1] = $value1;
	}
	$temp["licenced"] = $licenced;
	$licenceReport[] = $temp;
}

$cnt = array();
if(is_object($AIntuitionParameters)){
	foreach ($licenceReport as $value) {
		$checkAIntuitionMobileReport = checklicenses($value["licenced"], $value["licenses"]);
		if(in_array($value["businessArea"], $AIntuitionParameters->holding->businessArea)){
			$cnt["businessArea"][$value["businessArea"]]["licenses"] += $value["licenses"];
			$cnt["businessArea"][$value["businessArea"]]["licenced"] += $value["licenced"];	
			
			if(!$checkAIntuitionMobileReport){
				$cnt["businessArea"][$value["businessArea"]]["non_compliant"][] = $value["softwareID"];	
			}
		}
		
		if(in_array($value["businessUnit"], $AIntuitionParameters->holding->businessUnit)){
			$cnt["businessUnit"][$value["businessUnit"]]["licenses"] += $value["licenses"];
			$cnt["businessUnit"][$value["businessUnit"]]["licenced"] += $value["licenced"];
			
			if(!$checkAIntuitionMobileReport){
				$cnt["businessArea"][$value["businessArea"]]["non_compliant"][] = $value["softwareID"];	
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
	foreach ($licenceReport as $value) {
		$checkAIntuitionMobileReport = checklicenses($value["licenced"], $value["licenses"]);
			
		$cnt["holding"]["licenses"] += $value["licenses"];
		$cnt["holding"]["licenced"] += $value["licenced"];
		
		if(!$checkAIntuitionMobileReport){
			$cnt["holding"]["non_compliant"][] = $value["softwareID"];	
		}	
	}
}

ksort($cnt);

$AIntuition->insertAIReport(json_encode($cnt),"all");

// calculation percentages(almost same like forecast)
$AIntuitionMobileReports = $AIntuition->AIntuitionMobileReports();
$AIntuitionHandlingTypes = $AIntuition->getFromAIntuition(array("AIntuitionHandlingTypes"));
$calculateArray = array();
$good_bad = array();
$duty = array();
$j=0;
for($i=0; $i<count($AIntuitionMobileReports); $i++){
	$expLast = json_decode($AIntuitionMobileReports[$i]["status"]);
	$compare = array();
	$reportArray = array();
	$n = 0;
	if(!isset($expLast->holding)){
		foreach ($expLast as $keyLast => $last) {
			foreach ($last as $key => $value) {
				$checkAIntuitionMobileReport = checklicenses($last->$key->licenced, $last->$key->licenses);		
				// delegation duty part and status report
				if(!$checkAIntuitionMobileReport){
					$n++;
					if($AIntuitionHandlingTypes == "Duty"){
						if($keyLast == "businessArea"){
							$BusinessArea = new BusinessArea($key);
							$get_employeeDutyBusinessArea = $BusinessArea->get_employeeDutyBusinessArea();
							if($get_employeeDutyBusinessArea){
								$duty[$keyLast][$key] = $get_employeeDutyBusinessArea;
							}			
						}elseif($keyLast == "businessUnit"){
							//nemamo jos ovaj duty
						}
					}elseif($AIntuitionHandlingTypes == "Private"){
						$duty = $AIntuition->get_employeeID();
					}
				}	
			}
		}
	}else{
		$checkAIntuitionMobileReport = checklicenses($expLast->holding->licenced, $expLast->holding->licenses);		
		if(!$checkAIntuitionMobileReport){
			$n++;
			if($AIntuitionHandlingTypes == "Duty"){
				//ovo jos ne znam kako ce biti i da li treba ustvari prosiriti da kada se radi holding da se ustvari radi nad svim ba, bu i site
			}elseif($AIntuitionHandlingTypes == "Private"){
				$duty = $AIntuition->get_employeeID();
			}	
		}
	}
	
	$report = TRUE;
	if($n > 0){
		$report = FALSE;
		if($AIntuitionMobileReports[$i]["dutyDelegation"] == NULL){
			$AIntuition->updateDutyDelegation($AIntuitionMobileReports[$i]["AIntuitionReportID"], json_encode($duty));			
		}	
	}
	
	if($AIntuitionMobileReports[$i]["readInfo"] == 0){
		if($n > 0){
			$good_bad["badUnread"] += 1;		
			$report = FALSE;
		}else{
			$good_bad["goodUnread"] += 1;
			$report = TRUE;
		}
	}
	
	if($AIntuitionMobileReports[$i]["reportCode"] == NULL){
		$AIntuition->updateReportCode($AIntuitionMobileReports[$i]["AIntuitionReportID"], $report);			
	}
	
	$calculateArray[$i] = $report;
}
		
$AIntuition->updateUnread($good_bad["goodUnread"],$good_bad["badUnread"]);							
$AIntuition->AIntuitionInsertPercentages($calculateArray);
?>
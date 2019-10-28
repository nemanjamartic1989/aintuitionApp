<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));

function checkBandwidth($realDownSpeed, $agreedDownSpeed, $realUploadSpeed, $agreedUploadSpeed){
	$percentage = 5; // 10% tolerance on down/up speed
		
	$agreedDownSpeedL = $agreedDownSpeed;
	$agreedDownSpeedU = $agreedDownSpeed;
	$agreedDownSpeedL -= ($percentage / 100) * $agreedDownSpeedL;
	$agreedDownSpeedU += ($percentage / 100) * $agreedDownSpeedU;
	
	$agreedUploadSpeedL = $agreedUploadSpeed;
	$agreedUploadSpeedU = $agreedUploadSpeed;
	$agreedUploadSpeedL -= ($percentage / 100) * $agreedUploadSpeedL;
	$agreedUploadSpeedU += ($percentage / 100) * $agreedUploadSpeedU;	
	  	
	if (($realDownSpeed >= $agreedDownSpeedL) && ($realDownSpeed <= $agreedDownSpeedU) 
		&& ($realUploadSpeed >= $agreedUploadSpeedL) && ($realUploadSpeed <= $agreedUploadSpeedU)) {
		return TRUE;
	}else{
		return FALSE;
	}
}

$cnt = array();
$db = new DB();
$riskPhase = $db->riskPhase();

$res = $db->query("SELECT d.provider, c.siteID, c.siteBusinessUnitID AS businessUnitID, c.businessAreaID,
						MAX(a.downloadSpeed) AS realDownSpeed, 
						MAX(a.uploadSpeed) AS realUploadSpeed,
						d.downloadSpeed AS agreedDownSpeed,
						d.uploadSpeed AS agreedUploadSpeed
					FROM tdbBandwidth AS a
					JOIN tdbSiteAsset AS b ON a.nodeID = b.nodeID
					JOIN tdbSite AS c ON b.siteID = c.siteID
					JOIN tdbSiteAgreedBandwidth AS d ON c.siteID = d.siteID 
				    WHERE a.projectPhaseID = :projectPhaseID
				    GROUP BY d.provider, c.siteID, c.businessAreaID, c.siteBusinessUnitID", array("projectPhaseID"=>$riskPhase));	

if(is_object($AIntuitionParameters)){
	foreach ($res as $key => $value) {
		if(in_array($value["businessAreaID"], $AIntuitionParameters->holding->businessArea)){
			if(in_array($value["businessUnitID"], $AIntuitionParameters->holding->businessUnit)){	
				$realDownSpeed = $value["realDownSpeed"];
				$realUploadSpeed = $value["realUploadSpeed"];
				$agreedDownSpeed = $value["agreedDownSpeed"];
				$agreedUploadSpeed = $value["agreedUploadSpeed"];
	
				$temp = array(  "realDownSpeed"=>$realDownSpeed,
								"agreedDownSpeed"=>$agreedDownSpeed,
								"realUploadSpeed"=>$realUploadSpeed,
								"agreedUploadSpeed"=>$agreedUploadSpeed);
								
				$cnt[$value["businessAreaID"]][$value["businessUnitID"]][$value["provider"]][$value["siteID"]] = $temp;	
			}					
		}
	}				
}else{
	foreach ($res as $key => $value) {
		$realDownSpeed = $value["realDownSpeed"];
		$realUploadSpeed = $value["realUploadSpeed"];
		$agreedDownSpeed = $value["agreedDownSpeed"];
		$agreedUploadSpeed = $value["agreedUploadSpeed"];

		$temp = array(  "realDownSpeed"=>$realDownSpeed,
						"agreedDownSpeed"=>$agreedDownSpeed,
						"realUploadSpeed"=>$realUploadSpeed,
						"agreedUploadSpeed"=>$agreedUploadSpeed);
					
		$cnt["holding"][$value["businessAreaID"]][$value["businessUnitID"]][$value["provider"]][$value["siteID"]] = $temp;
	}
}

$AIntuition->insertAIReport(json_encode($cnt),'all');

// calculation part
$AIntuitionMobileReports = $AIntuition->AIntuitionMobileReports();
$calculateArray = array();
$good_bad = array();

for($i=0; $i<count($AIntuitionMobileReports); $i++){
	$expLast = json_decode($AIntuitionMobileReports[$i]["status"]);
	
	$duty = array();
	$reportArray = array();
	$n = 0;
	if(!isset($expLast->holding)){
		foreach ($expLast as $ba => $baInfo) {
			foreach ($baInfo as $bu => $buInfo) {
				foreach ($buInfo as $provider => $providerInfo) {
					foreach ($providerInfo as $site => $siteInfo) {
						$checkAIntuitionMobileReport = checkBandwidth($siteInfo->realDownSpeed, $siteInfo->agreedDownSpeed, $siteInfo->realUploadSpeed, $siteInfo->agreedUploadSpeed);
						if(!$checkAIntuitionMobileReport){
							$n++;
							//delegate to ba, bu, site
							$duty[$ba][$bu][$provider][] = $site;
						}	
					}
				}	
			}
		}
	}else{
		foreach ($expLast->holding as $ba => $baInfo) {
			foreach ($baInfo as $bu => $buInfo) {
				foreach ($buInfo as $provider => $providerInfo) {
					foreach ($providerInfo as $site => $siteInfo) {
						$checkAIntuitionMobileReport = checkBandwidth($siteInfo->realDownSpeed, $siteInfo->agreedDownSpeed, $siteInfo->realUploadSpeed, $siteInfo->agreedUploadSpeed);
						if(!$checkAIntuitionMobileReport){
							$n++;
							//delegate to ba, bu, site
							$duty[$ba][$bu][$provider][] = $site;
						}	
					}
				}	
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
		if($report){
			$good_bad["goodUnread"] += 1; 
		}else{
			$good_bad["badUnread"] += 1;
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
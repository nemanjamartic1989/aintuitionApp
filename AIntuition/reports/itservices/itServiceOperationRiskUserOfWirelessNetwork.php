<?php
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));

$Wifi = new Wifi();
$nonAuthorizedWifiBaBuSite = $Wifi->nonAuthorizedConnectedWifiBaBuSite();

$checkAIntuitionMobileReport = (count($nonAuthorizedWifiBaBuSite) > 0) ? FALSE : TRUE;

$cnt = array();
if(is_object($AIntuitionParameters)){
    foreach ($nonAuthorizedWifiBaBuSite as $value) {
        if(in_array($value["businessArea"], $AIntuitionParameters->holding->businessArea)){
            if(in_array($value["businessUnit"], $AIntuitionParameters->holding->businessUnit)){
                if(!$checkAIntuitionMobileReport){
                    $cnt[$value["businessArea"]][$value["businessUnit"]][$value["site"]][$value["wifi"]][] = $value["node"];	
                }
            }					
        }
    }
}else{
    foreach ($nonAuthorizedWifiBaBuSite as $value) {
        if(!$checkAIntuitionMobileReport){
            $cnt["holding"][$value["businessArea"]][$value["businessUnit"]][$value["site"]][$value["wifi"]][] = $value["node"];
        }	
    }
}

ksort($cnt);

if(count($cnt) > 0){
    $cnt = json_encode($cnt);
}else{
    $cnt = TRUE;
}

$AIntuition->insertAIReport($cnt,"all");

// calculation part
$AIntuitionMobileReports = $AIntuition->AIntuitionMobileReports();
$calculateArray = array();
$good_bad = array();

for($i=0; $i<count($AIntuitionMobileReports); $i++){
    $expLast = json_decode($AIntuitionMobileReports[$i]["status"]);
    $checkAIntuitionMobileReport = (is_object($expLast)) ? FALSE : TRUE;
	
    $duty = array();
    $n = 0;

    if(!isset($expLast->holding)){
        $arrExpLast = $expLast;
    }else{
        $arrExpLast = $expLast->holding;
    }

    foreach ($arrExpLast as $ba => $baInfo) {
        foreach ($baInfo as $bu => $buInfo) {
            foreach ($buInfo as $site => $siteInfo) {				
                foreach ($siteInfo as $wifi => $wifiInfo) {
                    foreach ($wifiInfo as $node) {						
                        if(!$checkAIntuitionMobileReport){
                            $n++;
                            //delegate to ba, bu, site
                            if(!in_array($node, $duty[$ba][$bu][$site])){
                                $duty[$ba][$bu][$site][] = $node;
                            }
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
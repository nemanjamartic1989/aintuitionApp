<?php

function checkSensibility($countPositive, $countNegative, $points){
	if($points >= $countPositive){//gornja granica
		$sensibility = "Upper limit";
	}elseif($points <= $countNegative){//donja granica
		$sensibility = "Lower limit";
	}else{
		$sensibility = "neutral";
	}
	return $sensibility;
}

function reportStatusForSensibility($sensibility){
	if($sensibility == "Upper limit"){
		$report = FALSE;
	}elseif($sensibility == "Lower limit"){
		$report = TRUE;
	}elseif($sensibility == "neutral"){
		$report = NULL;
	}
	return $report;
}

$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");
include_once ($dir . "../../../riskModule/ajax/reputationalRisk/simple_html_dom.php");
$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
$AIntuition = new AIntuition($AIntuitionID);
$db = new DB();

$sql = "SELECT competitorName FROM tdbCompetitor";
$competitorList = $db->column($sql);

foreach ($competitorList as $competitor) {
	$wordChecking = array();
	$sql0 = "SELECT SiteSource FROM tdbSourcesReputation WHERE categories LIKE :categories";
	$entWebSites = $db->column($sql0, array("categories" => "%competitor%" ));
	
	foreach ($entWebSites as $entWebSite) {
		$entWebSiteData = json_decode($entWebSite);
		$entWebSiteData = (array)$entWebSiteData;
		
		$link = key($entWebSiteData);
		$language = $entWebSiteData[$link];
		
		$sql1 = "SELECT languageID FROM tdbLanguages WHERE languageName = :languageName";
		$languageID = $db->single($sql1, array("languageName" => $language ));
		
		$sql2 = "SELECT words, points
					FROM tdbAIntuitionTranslatedWords
					JOIN tdbbWordsPoints ON tdbAIntuitionTranslatedWords.wordID = tdbbWordsPoints.wordID
					WHERE tdbAIntuitionTranslatedWords.languageID = :languageID
					AND categoryID = :categoryID";
		$wordsAndPoints = $db->query($sql2, array("languageID" => $languageID, "categoryID" =>5 ));	
		foreach ($wordsAndPoints as $listWP) {
			$word = $listWP["words"];	
			$point = $listWP["points"];
			$wordSearch = $word ." ".$competitor;
			
			$wordSearch = trim(preg_replace('/\s+/',' ', $wordSearch));
			
			$explode = explode(" ", $wordSearch);
			
	        $socialMediaData = array();
	        $getData = array();
	
	        if ($link == "www.newsweek.com") {
	            for ($i = 0; $i < 5; $i++) {
	                $htmlDomClass[$i] = file_get_html('http://www.newsweek.com/business?page=' . $i);
	                foreach ($htmlDomClass[$i]->find('article a') as $page) {
	                    $flight = array();
	                    $pageResult = $page -> innertext;
	                    
						$find = 0;
						foreach ($explode as $w) {
							$pos = stripos($pageResult, $w);
		                    if ($pos !== false) {
		                		$find++;        
		                    }	
						}
						
						if($find == count($explode)){
							$flight['link'] = $pageResult;
			                $flight['href'] = 'http://www.newsweek.com/' . $page -> href;
							$flight['points'] = $point;	
						}
	
	                    if (!empty($flight)) {
	                        $getData[] = $flight;
	                    }
	                }
	                if (!empty($getData)) {
	                    $socialMediaData = $getData;
						$wordChecking[$competitor][$link][$word] = $socialMediaData;
	                }
	            }	
	        } elseif ($link == "www.nytimes.com") {
	            $htmlNY = file_get_html('http://www.nytimes.com/pages/business/index.html');
	            foreach ($htmlNY->find('article a') as $page) {
	                $flight = array();
	                if (!$page -> has_child() && $page -> innertext != "" && $page -> innertext != "previous" && $page -> innertext != "next" && $page -> innertext != "More Video »") {
	
	                    $pageResult = $page -> innertext;
						
						$find = 0;
						foreach ($explode as $w) {
							$pos = stripos($pageResult, $w);
		                    if ($pos !== false) {
		                		$find++;        
		                    }	
						}
						
						if($find == count($explode)){
							$flight['link'] = $pageResult;
			                $flight['href'] = $page -> href;	
							$flight['points'] = $point;
						}
	
	                    if (!empty($flight)) {
	                        $getData[] = $flight;
	                    }
	                }
	            }
	            if (!empty($getData)) {
	                $socialMediaData = $getData;
					$wordChecking[$competitor][$link][$word] = $socialMediaData;
	            }
	        } 
	    } 
	}
	$AIntuition->insertAIReport(json_encode($wordChecking),"all");
}


// report code and percentages
$AIntuitionMobileReports = $AIntuition->AIntuitionMobileReports();
// sensibility from profile setup
$sensibilityAI = json_decode($AIntuition->getFromAIntuition(array("sensibility")));
$countPositive = $sensibilityAI->countPositive;
$countNegative = $sensibilityAI->countNegative;

// duty
$AIntuitionHandlingTypes = $AIntuition->getFromAIntuition(array("AIntuitionHandlingTypes"));	

for($i=0; $i<count($AIntuitionMobileReports); $i++){
	$expLast = json_decode($AIntuitionMobileReports[$i]["status"]);
	$duty = array();
	$temp = array();
	foreach ($expLast as $competitor => $competitorData) {
		foreach ($competitorData as $link => $linkData) {		
			foreach ($linkData as $word => $wordData) {	
				foreach ($wordData as $key => $value) {
					$temp[$competitor]["points"] += $value->points;
				}
			}
		}
	}
	
	foreach ($temp as $name => $data) {
		$checkSensibility = checkSensibility($countPositive, $countNegative, $data["points"]);	
		$report = reportStatusForSensibility($checkSensibility);
		
		if($AIntuitionMobileReports[$i]["reportCode"] == NULL){
			$AIntuition->updateReportCode($AIntuitionMobileReports[$i]["AIntuitionReportID"], $report);			
		}
		
		if($AIntuitionMobileReports[$i]["readInfo"] == 0){
			if(!is_null($report)){	
				if(!$report){
					$good_bad["badUnread"] += 1;		
				}else{
					$good_bad["goodUnread"] += 1;
				}
			}
		}
		
		if($AIntuitionMobileReports[$i]["dutyDelegation"] == NULL){
			if($AIntuitionHandlingTypes == "Duty"){
				$sql3 = "SELECT competitorID FROM tdbCompetitor WHERE competitorName = :competitorName";
				$competitorID = $db->single($sql3, array("competitorName" =>$name));
				$Competitor = new Competitor($competitorID);
				$get_employeeDutyCompetitor = $Competitor->get_employeeDutyCompetitor();
				
				if($get_employeeDutyCompetitor){
					$duty[$name] = $get_employeeDutyCompetitor;
				}
			}elseif($AIntuitionHandlingTypes == "Private"){
				$duty = $AIntuition->get_employeeID();
			}
			
			if(!empty($duty)){
				$AIntuition->updateDutyDelegation($AIntuitionMobileReports[$i]["AIntuitionReportID"], json_encode($duty));
			}			
		}
		
		$calculateArray[$i] = $report;	
	}
}

$AIntuition->updateUnread($good_bad["goodUnread"],$good_bad["badUnread"]);							
$AIntuition->AIntuitionInsertPercentages($calculateArray);

?>
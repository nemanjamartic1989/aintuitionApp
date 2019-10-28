
<?php

$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");

$ForecastSales = new ForecastSales();
$Order = new Order();


$countForecastData = $ForecastSales->forecastQuantityDataCount();

$listOrderedProduct = $Order -> listOrderedProduct();

//echo "<pre>".print_r($countForecastData,1)."</pre>";



$argv = INI::getArguments();
$AIntuitionID = $argv["AIntuitionID"];
//$AIntuitionID = 36; //for test  
$AIntuition = new AIntuition($AIntuitionID);
$AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));


$asset = new Asset();

$db = new DB();

/*$res1 = $db->query("SELECT `businessPartnerName`, `businessPartnerID`, `spTypeID`, `spSubTypeID`, `businessPartnerWebSite` 
						FROM `tdbBusinessPartner` WHERE businessPartnerType = :businessPartnerType",
						array("businessPartnerType"=>"Client"));*/
if(is_object($AIntuitionParameters)){
	$cnt = array();	
	//foreach ($res1 as $bp) {
		//echo "<pre>".print_r($bp,1)."</pre>";
		//$businessPartnerID = $bp["businessPartnerID"];
		$res2 = $db->query("SELECT SUM( a.numberOfProducts) AS cnt, c.businessAreaID, c.siteBusinessunitID as businessUnitID  
							FROM tdbProductOrder AS a 
							JOIN tdbProductSortiment AS b ON a.productSortimentID = b.productSortimentID
							JOIN tdbSite AS c ON b.siteID = c.siteID
							GROUP BY c.businessAreaID, c.siteBusinessunitID"
							);
		
		// echo "<pre>".print_r($res2,1)."</pre><hr />";					
							
		foreach ($res2 as $key => $value) {
			//treba ispraviti za holding
			//if(in_array($value["businessAreaID"], $AIntuitionParameters->holding->businessArea)){
	
				$cnt["businessArea"][$value["businessAreaID"]] += $value["cnt"];
				$cnt["businessArea"]["total"] += $value["cnt"];
			//}
			
			//if(in_array($value["businessUnitID"], $AIntuitionParameters->holding->businessUnit)){
				$cnt["businessUnit"][$value["businessUnitID"]] += $value["cnt"];
				$cnt["businessUnit"]["total"] += $value["cnt"];
			//}
		}
		
		/*
		if(in_array($value["businessAreaID"], $AIntuitionParameters->holding->businessArea)){
				$cnt[$businessPartnerID]["businessArea"][$value["businessAreaID"]] += $value["cnt"];	
				$cnt[$businessPartnerID]["businessArea"]["total"] += $value["cnt"];
			}
			
			if(in_array($value["businessUnitID"], $AIntuitionParameters->holding->businessUnit)){
				$cnt[$businessPartnerID]["businessUnit"][$value["businessUnitID"]] += $value["cnt"];
				$cnt[$businessPartnerID]["businessUnit"]["total"] += $value["cnt"];
			}
		*/
		
		
		if(isset($cnt["businessArea"])){
			ksort($cnt["businessArea"]);	
		}
		
		if(isset($cnt["businessUnit"])){
			ksort($cnt["businessUnit"]);	
		}				
	//}
}else{
	$cnt["holding"] = $db->rowCount();
}

ksort($cnt);

//echo "<pre>".print_r($cnt,1)."</pre>";

$arrayNew = array();
foreach ($cnt as $key2 => $value2) {
			
	foreach ($value2 as $key3 => $value3) {
			
		if($countForecastData[$key2][$key3]!=""){
			$cnt["businessArea"][$value["businessAreaID"]] += $value["cnt"];
				$cnt["businessArea"]["total"] += $value["cnt"];
			//}
			
			//if(in_array($value["businessUnitID"], $AIntuitionParameters->holding->businessUnit)){
				$cnt["businessUnit"][$value["businessUnitID"]] += $value["cnt"];
				$cnt["businessUnit"]["total"] += $value["cnt"];	
			$arrayNew[$key2][$key3]["sales"] = $value3;
			$arrayNew[$key2][$key3]["forecast"] = $countForecastData[$key2][$key3];	
		}
		
	}		
	
}

if(!isset($cnt["holding"])){
	//$AIntuition->insertAIReport(json_encode($arrayNew));
	//$AIntuitionMobileReports = $AIntuition->AIntuitionCalculatePercentagesBABU();	
}else{
	// $AIntuition->insertAIReport($cnt["holding"]);
	//$AIntuitionMobileReports = $AIntuition->AIntuitionCalculatePercentagesHolding();
}

//echo "<pre>".print_r($arrayNew,1)."</pre>";

$AIntuitionMobileReports = $AIntuition->AIntuitionMobileReports("aiReportCronjob");


		$calculateArray = array();
		$good_bad = array();
		$j=0;
		for($i=0; $i<count($AIntuitionMobileReports); $i++){
			// if(isset($AIntuitionMobileReports[$i+1]["status"])){
				$expLast = json_decode($AIntuitionMobileReports[$i]["status"]);
				// $expPrevious = json_decode($AIntuitionMobileReports[$i+1]["status"]);
				$compare = array();
				$reportArray = array();
				$n = 0;
				foreach ($expLast as $keyLast => $last) {
					// var_dump($last);
					
					$k = 0;	
					foreach ($last as $key => $value) {
						
						// echo $last->$key->sales . "<br />";
						// echo $last->$key->forecast . "<br />"; 
						
						$checkAIntuitionMobileReport = checkForecast($last->$key->sales, $last->$key->forecast);
						// if($key == "total"){
							// $compare[$keyLast]["total"] = $checkAIntuitionMobileReport;		
							// $k++;
						// }
						// zameni privremeno
						if(!$checkAIntuitionMobileReport){
							$n++;	
						}
					}
				}
				
				// echo $n . "<hr />";
				
				// zaokomentarisano priveremeno
				// $report = FALSE;
				// if(isset($compare["businessArea"]["total"]) && isset($compare["businessUnit"]["total"])){
					// if($compare["businessArea"]["total"] && $compare["businessUnit"]["total"]){
						// $report = TRUE;	
					// }
				// }elseif(isset($compare["businessArea"]["total"])){
					// if($compare["businessArea"]["total"]){
						// $report = TRUE;	
					// }
				// }
				
				
				// ovo je skroz zamenjeno
				if($AIntuitionMobileReports[$i]["readInfo"] == 0){
					if($n > 0){
						$good_bad["badUnread"] += 1;		
						$report = FALSE;
					}else{
						$good_bad["goodUnread"] += 1;
						$report = TRUE;
					}
				}
				
				$calculateArray[$i] = $report;
				// $j++;
			// }
		}

$db->query("UPDATE tdbAIntuition SET goodUnread = :goodUnread, badUnread = :badUnread WHERE AIntuitionID = :AIntuitionID", 
							array("goodUnread"=>$good_bad["goodUnread"] ,"badUnread"=>$good_bad["badUnread"] ,"AIntuitionID" => $AIntuitionID));

// var_dump($calculateArray);
// ovo nije tacno 100% jer u toj fji oduzima jedan
$AIntuition->AIntuitionInsertPercentages($calculateArray);




function checkForecast($sales, $forecast){
	if($sales >= $forecast){
		return TRUE;
	}else{
		return FALSE;
	}
}











//echo "<pre>".print_r($arrayNew,1)."</pre>";
//echo "<pre>".print_r($cnt,1)."</pre>";
//echo "<pre>".print_r($countForecastData,1)."</pre>";

//$AIntuition->insertAIReport(json_encode($arrayNew));

?>

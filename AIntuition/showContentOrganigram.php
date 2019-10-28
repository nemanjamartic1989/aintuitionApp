<?php
session_start(); // start_session.
include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");

 ?>
<link rel="stylesheet" href="/organizationOrganigram/Treant.css">
<link rel="stylesheet" href="/organizationOrganigram/basic-example.css"> 
<script type="text/javascript" src="/organizationOrganigram/js/organigram.js"></script>
<script type="text/javascript" src="/organizationOrganigram/vendor/raphael.js"></script>
<script type="text/javascript" src="/organizationOrganigram/Treant.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="/AIntuition/js/aIntuition.js"></script>

<?php
		$orgArray = array();
		$textAttr = array();
		$children = array();
		$sqlOrg = "SELECT `orgLev`, `empID`, `holdingID`, `roleName` FROM `tdbHoldingOrganigram` WHERE orgLev = '1' AND projectPhaseID = '$activePhase'";
		$resOrg = mysql_query($sqlOrg);
		
		$arrConf = array();
		$arrConn = array("type" => "step");
		$arrNode = array("HTMLclass" => "nodeExample1");
		
		$arrConf = array(
		    "container" => "#basic-example",
		    
		    "connectors" => $arrConn,
		
		    "node" => $arrNode
		);

		$orgArray[] = $arrConf;
		$link = array();
					
		$temp = array();

$employeeID = $_SESSION['employeeID'];
$roleName = $_SESSION['roleName'];
$holdingID = $_SESSION['holdingID'];
$levelName = $_SESSION['levelName'];
$employeeName1 = $_SESSION['employeeName1'];


while($rowOrg = mysql_fetch_assoc($resOrg)){
	
	$employeeID = $rowOrg['empID'];
	$employeeName[] = displayEmployeeName($rowOrg['empID']);
	$roleName = "Role: ".$rowOrg['roleName'];
	$holdingID = $rowOrg['holdingID'];
	$levelName = "Holding: ".displayClient($rowOrg['holdingID']);
	$employeeName1 = implode(",",$employeeName);				
	
	$href = array();
	$employeeProfileID = $_GET['employeeID'];
	echo $employeeProfileID;
	$link = array(
				"val" => $employeeName1,
	            "href" => "/AIntuition/showAIntuition.php?employeeID=".$employeeID,
	            "target" => "_top"
			);
			
		$temp["text"] = array("content" => $link, "title"=>$roleName, "levelName"=>$levelName);
	
	
	
	$sqlOrg1 = "SELECT `orgLev`, `empID`, `holdingID`, `businessAreaID`, `roleName` FROM `tdbHoldingOrganigram` WHERE orgLev = '2' AND holdingID = '$holdingID' AND projectPhaseID = '$activePhase'";
	$resOrg1 = mysql_query($sqlOrg1);
	
	$tempBA = array();
	$i=0;
	
	$employeeID1 = $_SESSION['employeeID'];
	$roleName1 = $_SESSION['roleName'];
	$holdingID1 = $_SESSION['holdingID'];
	$levelName1 = $_SESSION['levelName'];
	
	while($rowOrg1 = mysql_fetch_assoc($resOrg1)){
			$employeeID1 = $rowOrg1['empID'];
			$employeeName1 = displayEmployeeName($rowOrg1['empID']);
			$roleName1 = "Role: ".$rowOrg1['roleName'];	
			$businessAreaID = $rowOrg1['businessAreaID'];
			$levelName1 = "Business Area : ".displayBusinessArea($rowOrg1['businessAreaID']);
			
			$link1 = array(
				"val" => $employeeName1,
	            "href" => "/AIntuition/showAIntuition.php?employeeID=".$employeeID1,
	            "target" => "_top"
			);
			
			$tempBA["text"]  = array("content" => $link1, "title"=>$roleName1, "levelName"=>$levelName1);
			
			$temp["children"][$i]["text"] = $tempBA["text"];		
			
			$sqlOrg2 = "SELECT `orgLev`, `empID`, `holdingID`, `businessAreaID`, `businessUnitID`, `roleName` FROM `tdbHoldingOrganigram` WHERE orgLev = '3' AND businessAreaID = '$businessAreaID' AND projectPhaseID = '$activePhase'";
			$resOrg2 = mysql_query($sqlOrg2);
			
			
			$tempBU = array();
			$j=0;
			while($rowOrg2 = mysql_fetch_assoc($resOrg2)){
				$employeeName2 = displayEmployeeName($rowOrg2['empID']);
				$roleName2 = "Role: ".$rowOrg2['roleName'];	
				$businessUnitID = $rowOrg2['businessUnitID'];
				$levelName2 = "Business Unit : ".displayBusinessUnit($rowOrg2['businessUnitID']);	
				$employeeID2 = $row['employeeID'];
			
						$tempBU["text"]  = array("name"=>$employeeName2, "title"=>$roleName2, "levelName"=>$levelName2);
						
						$temp["children"][$i]["children"][$j]["text"] = $tempBU["text"];				
	
				
				$sqlOrg3 = "SELECT `orgLev`, `empID`, `holdingID`, `businessAreaID`, `businessUnitID`, `siteID`, `roleName` FROM `tdbHoldingOrganigram` WHERE orgLev = '4' AND businessUnitID = '$businessUnitID' AND projectPhaseID = '$activePhase'";
				$resOrg3 = mysql_query($sqlOrg3);
				
				$tempSite = array();
				$k=0;
				while($rowOrg3 = mysql_fetch_assoc($resOrg3)){
				$employeeName3 = displayEmployeeName($rowOrg3['empID']);
				$roleName3 = "Role: ".$rowOrg3['roleName'];
				$levelName3 = "Site : ".displaySiteName($rowOrg3['siteID']);
									
						$tempSite["text"]  = array("name"=>$employeeName3, "title"=>$roleName3, "levelName"=>$levelName3);
						
						$temp["children"][$i]["children"][$j]["children"][$k]["text"] = $tempSite["text"];			
	
					$k++;		
				}
				$j++;
	
			}
			$i++;
	
		}
			
	}

	//echo "<pre>".print_r($temp,1)."<pre>";

$final = $orgArray1 = array( 
				array(
				    "container" => "#basic-example",
				    "connectors" => $arrConn,
				    "node" => $arrNode
				), $temp
				);
				
if(empty($temp)){
?>	
<div class="noData"><span>No Holding Organigram!</span></div>	
<?php
}else{
	
$json = json_encode($final);
 ?>
<div id="canvas"><div class="chart" id="basic-example"  class="ui-widget-content" onclick="showHoldingOrganigram()" style="width: 2500px;"></div></div> 
<!-- 
	Zbog pojavljivanja scroll-a prilikom crtanja grafika rucno sam ukucao sirinu diva,  
	trebalo bi na neki nacin dinamicki resiti problem sa velicinom svg-a povrsine u javascript-i	
 -->
<script>

$( function() {
    $( "#basic-example" ).draggable();
  } );

function showJsonOrg(json){
	
	var returnData = JSON.parse(json);
	
	new Treant( returnData );

}

	
showJsonOrg('<?php echo $json; ?>');

	
</script>
<script>
 	$("#displayDetails").click(function(){
    	alert("Hello!");
	});
 </script>
<?php
}
 ?>
 
 




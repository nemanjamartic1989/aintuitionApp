<?php
    include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
    $dir = dirname(__DIR__);
    include ($dir . "../../../classes/init.php");
	
    $result=array();
    if(isset($_POST['type']))
	{
		$type=$_POST['type'];
	}
	
	if($type=="save")
	{
		if(isset($_POST['sensibility']))        { $sensibility          = $_POST['sensibility']; $sensibilityCheck = TRUE;}else{$sensibilityCheck = FALSE;}
		if(isset($_POST['holding']))            { $holding              = $_POST['holding'];}
		if(isset($_POST['businessAreas']))      { $businessAreas        = json_decode(($_POST['businessAreas']), true);}
		if(isset($_POST['businessUnits']))      { $businessUnits        = json_decode($_POST['businessUnits'], true);}
		if(isset($_POST['subCategoryID']))      { $subCategoryID        = $_POST['subCategoryID'];}
		if(isset($_POST['status']))             { $status               = ucfirst($_POST['status']);}
		if(isset($_POST['handlingType']))       { $handlingType         = ucfirst($_POST['handlingType']);}
		if(isset($_POST['frequencyType']))      { $frequencyType        = ucfirst($_POST['frequencyType']);}
		if(isset($_POST['frequencyValue']))     { $frequencyValue       = $_POST['frequencyValue'];}
		if(isset($_POST['expirationDate']))     { $expirationDate       = $_POST['expirationDate'];}
		if(isset($_POST['categoryID']))         { $categoryID           = $_POST['categoryID'];}
		if(isset($_POST['employeeID']))         { $employeeID           = $_POST['employeeID'];}
		
		$sqlCheck="SELECT AIntuitionSubCategoryID FROM tdbAIntuition 
		           WHERE employeeID= '$employeeID' AND AIntuitionSubCategoryID='$subCategoryID'";
		$resultCheck=mysql_query($sqlCheck);
		if(mysql_num_rows($resultCheck)>0)
		{
			echo json_encode(array('result'=>'error', 'data'=>'You already choose this Sub Category! Please, choose another!'));
			exit;
		}
		
		$sql = "SELECT ho.orgLev, ho.empID, ho.holdingID, ho.roleName, e.employeeFullName
			    FROM tdbHoldingOrganigram ho
			    JOIN tdbTMPEmployee AS e ON ho.empID = e.employeeID
			    WHERE ho.empID = '$employeeID'";
		$result=mysql_query($sql);
		$row=mysql_fetch_assoc($result);
		$roleName        = $row['roleName'];
		$holdingID       = $row['holdingID'];
		$levelName       = displayClient($row['holdingID']);
		$levelOrganigram = $row['orgLev'];
		$employeeName    = $row['employeeFullName'];
		
		$parameters=json_encode(array('holding'));
		if($holding==0)
		{
			$parameters=json_encode(array("holding"=>array( "businessArea"=>$businessAreas, "businessUnit"=>$businessUnits)));
		}
		
		$frequency=json_encode(array($frequencyType=>$frequencyValue));
		$expirationDate = str_replace('/', '-', $expirationDate);
		$expirationDate = date("Y-m-d", strtotime($expirationDate));
		
		$sensibilityDB    = ($sensibilityCheck) ? ",`sensibility`" : "";
		$sensibilityValue = ($sensibilityCheck) ? ",'$sensibility'" : "";
		
		$sql="INSERT INTO tdbAIntuition(`employeeID`,`employeeName`,`roleName`,`levelName`,`levelOrganigram`,`AIntuitionCategoryID`,`AIntuitionSubCategoryID`,`AIntuitionParameters`,`AIntuitionParametersSetup`,`AIntuitionHandlingTypes`,`AIntuitionFrequency`,`AIntuitionExpirationDate`,`createdBy`,`createdDate` $sensibilityDB)
			  VALUES('$employeeID','$employeeName','$roleName','$levelName','$levelOrganigram','$categoryID','$subCategoryID','$parameters','$status','$handlingType','$frequency','$expirationDate','$userID','$lastUpdate' $sensibilityValue)";
		$result=mysql_query($sql);
		if($result)
		{
			$aintuitionID=mysql_insert_id();
			
			$AIntuition = new AIntuition($aintuitionID);
			$formatAIntuitionFrequency = $AIntuition->formatAIntuitionFrequency();
			$createAIreport = $AIntuition->createAIReport($formatAIntuitionFrequency);
			
			$data['aintuitionID']=$aintuitionID;
			$success='success';
		}
		else
		{
			$success="error";
			$data="Something went wrong";
		}
		
		$result=array('result'=>$success,'data'=>$data);
		
	}
	else if($type=="edit")
	{
		if(isset($_POST['aintuitionID']))            { $aintuitionID= $_POST['aintuitionID'];}
		$sql="SELECT `employeeID`,`employeeName`,`roleName`,`levelName`,`levelOrganigram`,`AIntuitionCategoryID`,`AIntuitionSubCategoryID`,
		             `AIntuitionParameters`,`AIntuitionParametersSetup`,`AIntuitionHandlingTypes`,`AIntuitionFrequency`,`AIntuitionExpirationDate`,`sensibility`
		      FROM tdbAIntuition 
		      WHERE AIntuitionID=$aintuitionID";
		 $result=mysql_query($sql);
		 $row=mysql_fetch_assoc($result);

		 $sensibility = $row["sensibility"];	
		 $parameters=json_decode($row['AIntuitionParameters'], true);
		 $holding=empty($parameters['holding'])?1:0;
		 $businessAreas=$parameters['holding']['businessArea'];
		 
		 $businessUnitsAll=array();
		 if(!empty($parameters['holding']['businessArea']))
		 {
		 	$baIDs=implode($parameters['holding']['businessArea'],',');
			$sqlBA="SELECT ba.businessAreaID, businessAreaName,  businessUnitID, businessUnitName
	              FROM tdbBusinessArea AS ba JOIN tdbBusinessUnit AS bu ON ba.businessAreaID=bu.businessAreaID
			      WHERE bu.businessAreaID IN ($baIDs)";
			$resultBA=mysql_query($sqlBA);
			while($rowBA=mysql_fetch_array($resultBA))
			{
				$businessUnitsAll[$rowBA['businessAreaID']][]=array($rowBA['businessUnitID']=>$rowBA['businessUnitName']);
			}
		 }
		 
		 $businessUnitsChecked=$parameters['holding']['businessUnit'];
		 $expirationDate = date("d/m/Y", strtotime($row['AIntuitionExpirationDate']));
		 
		 $data['sensibility']    		= $sensibility;
		 $data['subCategoryID']  		= $row['AIntuitionSubCategoryID'];
		 $data['status']         		= strtolower($row['AIntuitionParametersSetup']);
		 $data['handlingType']   		= strtolower($row['AIntuitionHandlingTypes']);
		 $data['frequency']      		= json_decode($row['AIntuitionFrequency'], true);
		 $data['expirationDate'] 		= $expirationDate;
		 $data['holding']        		= $holding;
		 $data['businessAreas']  		= $businessAreas;
		 $data['businessUnitsAll']  	= $businessUnitsAll;
		 $data['businessUnitsChecked']  = $businessUnitsChecked;
		 
		 $result=array('result'=>'success','data'=>$data);
		 
	}
	else if($type=="update")
	{
		if(isset($_POST['sensibility']))        { $sensibility          = $_POST['sensibility']; $sensibilityCheck = TRUE;}else{$sensibilityCheck = FALSE;}	
		if(isset($_POST['holding']))            { $holding              = $_POST['holding'];}
		if(isset($_POST['businessAreas']))      { $businessAreas        = json_decode(($_POST['businessAreas']), true);}
		if(isset($_POST['businessUnits']))      { $businessUnits        = json_decode($_POST['businessUnits'], true);}
		if(isset($_POST['subCategoryID']))      { $subCategoryID        = $_POST['subCategoryID'];}
		if(isset($_POST['status']))             { $status               = ucfirst($_POST['status']);}
		if(isset($_POST['handlingType']))       { $handlingType         = ucfirst($_POST['handlingType']);}
		if(isset($_POST['frequencyType']))      { $frequencyType        = ucfirst($_POST['frequencyType']);}
		if(isset($_POST['frequencyValue']))     { $frequencyValue       = $_POST['frequencyValue'];}
		if(isset($_POST['expirationDate']))     { $expirationDate       = $_POST['expirationDate'];}
		if(isset($_POST['categoryID']))         { $categoryID           = $_POST['categoryID'];}
		if(isset($_POST['aintuitionID']))       { $aintuitionID         = $_POST['aintuitionID'];}
		
		$AIntuition = new AIntuition($aintuitionID);
        $formatAIntuitionFrequency = $AIntuition->formatAIntuitionFrequency();
		$removeAIReport = $AIntuition->removeAIReport($formatAIntuitionFrequency);
		
		$parameters=json_encode(array('holding'));
		if($holding==0)
		{
			$parameters=json_encode(array("holding"=>array( "businessArea"=>$businessAreas, "businessUnit"=>$businessUnits)));
		}
		
		$frequency=json_encode(array($frequencyType=>$frequencyValue));
		$expirationDate = str_replace('/', '-', $expirationDate);
		$expirationDate = date("Y-m-d", strtotime($expirationDate));
		
		$sensibilityUpd    = ($sensibilityCheck) ? ",`sensibility` = '$sensibility'" : "";
		
		$sql="UPDATE tdbAIntuition 
		             SET `AIntuitionParameters`      =  '$parameters',
		                 `AIntuitionParametersSetup` =  '$status',
		                 `AIntuitionHandlingTypes`   =  '$handlingType',
		                 `AIntuitionFrequency`       =  '$frequency',
		                 `AIntuitionExpirationDate`  =  '$expirationDate',
		                 `userID`                    =  '$userID',
		                 `lastUpdate`                =  '$lastUpdate'
		                 $sensibilityUpd
		             WHERE `AIntuitionID`= '$aintuitionID' ";
		$result=mysql_query($sql);
		if($result)
		{
			$aintuitionID=mysql_insert_id();
			$formatAIntuitionFrequency = $AIntuition->formatAIntuitionFrequency();
			$createAIreport = $AIntuition->createAIReport($formatAIntuitionFrequency);
			
			$success='success';
			$data="data has been updated";
		}
		else
		{
			$success="error";
			$data="Something went wrong";
		}
		
		$result=array('result'=>$success,'data'=>$data);
	}
	else if($type=="delete")
	{
		if(isset($_POST['aintuitionID']))            { $aintuitionID= $_POST['aintuitionID'];}
		
		$AIntuition = new AIntuition($aintuitionID);
        $formatAIntuitionFrequency = $AIntuition->formatAIntuitionFrequency();
	    $removeAIReport = $AIntuition->removeAIReport($formatAIntuitionFrequency);
	    
		$sql="DELETE FROM tdbAIntuition 
		      WHERE AIntuitionID=$aintuitionID";
		$result=mysql_query($sql);
		
		
		
		$result=array('result'=>'success', 'data'=>$data);
	}
	
	echo json_encode($result);
?>
<?php	
	session_start(); // start session.
	
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php"); 
 	
	$back = "/";
	$home = "/";
 
?>

 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">	
	<?php include($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>	
	<title><?php echo $projName.' | '.getModuleNameByFolder(); ?></title>
	<script src="/roboticAutomation/jquery-ui-1.12.0/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="/AIntuition/css/aIntuition.css">
	<link rel="stylesheet" type="text/css" href="../roboticAutomation/jquery-ui-1.12.0/jquery-ui.css">
	
        <style>
            .figPozicija{
                text-align: -moz-center;
            }
			
           #showMainCategory {
           		margin: 10px 0 0 0;
           }
        </style>
        	<script type="text/javascript" src="/js/jquery.gmap.min.js"></script>
			<script type="text/javascript" src="/js/tdb.js"></script>
			<script type="text/javascript" src="/AIntuition/js/aIntuition.js"></script>

</head>

<body>
	
	<div align="center">
		<div id="loaderDiv" style="display: none" class="loader" align="center"></div>
	</div>
   
    <div class="container_12 background-main">

	    <div class="content">
	    	<?php echo breadcrumbs(); ?>
	    	<br />
	    	<br />
			
		<div id="showDetailsOrganigram"></div>

<!-- VIEW PROFILE AND DATA OF ORGANIGRAM - BEGIN -->
<!-- ASSIGN CATEGORY TO EMPLOYEE - BEGIN -->
<?php 
		$employeeProfileID = $_GET['employeeID'];
	
		$category = explode(";", $category);
	
		$sql = "SELECT ho.orgLev, ho.empID, ho.holdingID, ho.roleName, ho.businessAreaID, ho.businessUnitID FROM tdbHoldingOrganigram ho WHERE ho.empID = '$employeeProfileID'";
		$res = mysql_query($sql); // Send a MySQL query.
			
		$row = mysql_fetch_assoc($res); // Fetch a result row as an associative array.
			
		$employeeName = displayEmployeeName($row['empID']);
		$roleName = $row['roleName'];
		$holdingID = $row['holdingID'];
		$businessAreaID = $row['businessAreaID'];
		$levelName = displayClient($row['holdingID']);
		$levelOrganigram = $row['orgLev'];
			
		
		$sqlCheck="SELECT DISTINCT ac.AIntuitionCategoryID, nameCategory, ai.AIntuitionCategoryID AS aiCatID
				   FROM  `tdbAIntuitionCategory` AS ac
				   LEFT JOIN tdbAIntuition AS ai ON ac.AIntuitionCategoryID = ai.AIntuitionCategoryID
				   AND ai.employeeID =$employeeProfileID
				   ORDER BY ac.AIntuitionCategoryID ASC ";
		$resCheck = mysql_query($sqlCheck);
		
				
	?>
	
	<fieldset id="ChooseCategoryForThisAIntuition"><legend>Choose Category For AIntuition: <?php echo "<b class=\"orange\">".$employeeName."</b>";?></legend>
		
		<!-- List for choose category: -->
		
		<div id="chooseCategory" style="float: left; margin: 0 0 0 50px;">
			
			
			<?php
			while($rowCount = mysql_fetch_assoc($resCheck)){ // Fetch a result row as an associative array.
				$category = $rowCount['category'];
		        $checked="checked = 'checked'";
				if(empty($rowCount['aiCatID']))
				{
					$checked="";
				}
				echo "<input type='checkbox' value='".$rowCount['AIntuitionCategoryID']."' $checked>".$rowCount['nameCategory']."<br>";
			} 
			?>
			
		</div>
		<input type="hidden" name="employeeID" id="employeeID" value="<?php echo $employeeProfileID;?>"/>
		<?php $category = $_SESSION['category'];?>
		<!-- Form for structure Of Holding Organigram: -->
		<?php if($levelOrganigram == 1){
			$levelName = displayClient($row['holdingID']);
			?>
		<div id="holdingOrganigramForm" style="float: right; padding: 0 100px 0 0;">
			<label>Employee Name:</label><input type="text" name="employeeNameAI" id="employeeNameAI" value="<?php echo $employeeName;?>" readonly 	 style="margin-left: 19px;"><br />
			<label>Role Name:</label><input type="text" name="roleNameAI" id="roleNameAI" value="<?php echo $roleName;?>" readonly style="margin-left: 52px;"><br />
			<label>Level Name:</label><input type="text" name="levelNameAI" id="levelNameAI" value="<?php echo $levelName;?>" readonly style="margin-left: 46px;"><br />
			<label>Level Organigram:</label><input type="text" name="levelOrganigramAI" id="levelOrganigramAI" value="<?php echo $levelOrganigram;?>" readonly style="margin-left: 10px;"><br />
		</div>
		<?php } elseif ($levelOrganigram == 2){
			$levelName = displayBusinessArea($row['businessAreaID']);
		?>
		<div id="holdingOrganigramForm" style="float: right; padding: 0 100px 0 0;">
			<label>Employee Name:</label><input type="text" name="employeeNameAI" id="employeeNameAI" value="<?php echo $employeeName;?>" readonly 	 style="margin-left: 19px;"><br />
			<label>Role Name:</label><input type="text" name="roleNameAI" id="roleNameAI" value="<?php echo $roleName;?>" readonly style="margin-left: 52px;"><br />
			<label>Level Name:</label><input type="text" name="levelNameAI" id="levelNameAI" value="<?php echo $levelName;?>" readonly style="margin-left: 46px;"><br />
			<label>Level Organigram:</label><input type="text" name="levelOrganigramAI" id="levelOrganigramAI" value="<?php echo $levelOrganigram;?>" readonly style="margin-left: 10px;"><br />
		</div>
		<?php } elseif ($levelOrganigram == 3){
			$levelName = displayBusinessUnit($row['businessUnitID']);
		?>
		<div id="holdingOrganigramForm" style="float: right; padding: 0 100px 0 0;">
			<label>Employee Name:</label><input type="text" name="employeeNameAI" id="employeeNameAI" value="<?php echo $employeeName;?>" readonly 	 style="margin-left: 19px;"><br />
			<label>Role Name:</label><input type="text" name="roleNameAI" id="roleNameAI" value="<?php echo $roleName;?>" readonly style="margin-left: 52px;"><br />
			<label>Level Name:</label><input type="text" name="levelNameAI" id="levelNameAI" value="<?php echo $levelName;?>" readonly style="margin-left: 46px;"><br />
			<label>Level Organigram:</label><input type="text" name="levelOrganigramAI" id="levelOrganigramAI" value="<?php echo $levelOrganigram;?>" readonly style="margin-left: 10px;"><br />
		</div>
		<?php }?>
		
		<!-- Save or Cancel: -->
		 
		<div id="ExecutionForm" style="padding: 200px 0 0 450px;">
			<input type="button" id="nextAIntuition" onclick="displayMainCategory(<?php echo $employeeProfileID;?>);" value="Next" />
			<input type="button" id="backAIntuition" onclick="backAIntuition(<?php echo $employeeProfileID;?>);" value="Back" />
		</div>
		
		<div id="messageForSaveData"></div>
		
	</fieldset>

	<div id="showMainCategory"></div>
	<div id="showUpdateAIntuition"></div>

<script>

$( function() {
    $( "#basic-example" ).draggable(); // Allow elements to be moved using the mouse.
  } );

function showJsonOrg(json){
	
	var returnData = JSON.parse(json); // Parse the data with JSON.parse(), and the data becomes a JavaScript object.
	
	new Treant( returnData );

}

	
showJsonOrg('<?php echo $json; ?>');

	
</script>

	 </div>
   </div>
    
    <!-- SET FOOTER -->
	<div class="container_12 footer"><?php include($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?></div>
	

</body>
</html>

<script>
	$('.figCon').hover(function () {
    	$(this).addClass('magictime vanishIn');
  	}, function() {
  		$(this).removeClass('magictime vanishIn');
	});
	
  	
  	$('.figPocetna').click(function(){
    	$('.figPocetna').removeClass('activate');
    	$(this).addClass('activate');
	});
	

</script>


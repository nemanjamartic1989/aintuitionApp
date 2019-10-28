<?php 
	session_start(); // session start.
    include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php"); 
	
	$categoryID = $_POST['categoryID'];
	$subCategoryID = $_POST['subCategoryID'];	
	
	$sql = "SELECT `holding`, `businessArea`, `businessUnit`, `sensibility` FROM `tdbAIntuitionSubCategory` WHERE `AIntuitionSubCategoryID` = '$subCategoryID'";	
	$result=mysql_query($sql);
	$row=mysql_fetch_assoc($result);
	if(isset($_POST["sensibility"])){
		$sensibility =	json_decode($_POST["sensibility"]);
	}
?>	

<?php
if ($row["sensibility"] == 1){
?>
	<div style="display: table-cell;">
		<fieldset style="height: 80px;">
			<legend>Sensibility</legend>
			 <table>
	           <tbody>
	           	<tr>
	           		<td>Upper limit</td>
	           		<td><input type="number" name="countPositive<?php echo $categoryID; ?>" id="countPositive<?php echo $categoryID; ?>" value="<?php echo $sensibility->countPositive ?>" /></td>
	           	</tr>
	           	<tr>
	           		<td>lower limit</td>
	           		<td><input type="number" name="countNegative<?php echo $categoryID; ?>" id="countNegative<?php echo $categoryID; ?>" value="<?php echo $sensibility->countNegative ?>" /></td>
	           	</tr>
	           </tbody>
	         </table>
		</fieldset>
	</div>
<?php
}
?>
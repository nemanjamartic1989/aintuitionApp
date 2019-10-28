<?php	
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php"); 

	if(isset($_POST['action']))
	{
		$action=$_POST['action'];
	}

	$userID = $_SESSION['userID'];
	$sources = $_POST['sources'];
	$language = $_POST['language'];
	$modules = json_encode($_POST['modules']);
	$categories = json_encode($_POST['categories']);
	
	$data=array();

if($action=="get")
{
	
$query = "SELECT * FROM tdbSourcesModules";
$result = mysql_query($query);

while($row = mysql_fetch_array($result)){
	$SourcesModulesID = $row['SourcesModulesID'];
	$sources = $row['siteSources'];
	$languages = $row['languages'];
	$ModulesID = json_decode($row['ModulesID']);
	$categories = json_decode($row['categories']);
	
	$ModulesID = implode(",", $ModulesID);
	
	$queryModules = "SELECT * FROM tdbModules WHERE ModulesID IN ($ModulesID)";
	$resultQuery = mysql_query($queryModules);
	
	$names = array();
	
	while($rowModules = mysql_fetch_array($resultQuery)){
		$ModulesID = $rowModules['ModulesID'];
		$name = $rowModules['name'];
		$names[] = $name;
	}

  	$edit="<input id='editSourcesModules' value='".$SourcesModulesID."' onclick='editSettings($SourcesModulesID, $type)' type='image' style='cursor:pointer;' src='/images/ui/buttons/btn_edit.png'>";

	$delete="<input id='deleteSourcesModules' value='".$SourcesModulesID."' type='image' style='cursor:pointer;' src='/images/ui/buttons/btn_delete.png'>";
	
	$data[]=array(
		               	'Sources'    					=> $sources,
		               	'Modules' 					    => $names,
		               	'edit'                			=> $edit,
		               	'delete'              			=> $delete
					  );
	
}
	
} else if ($action == 'save'){
	
$query = "INSERT INTO tdbSourcesModules(categories, siteSources, languages, ModulesID, createdBy, createdDate, userID, lastUpdate) VALUES('$categories', '$sources', '$language', '$modules', '$userID', '$lastUpdate', '$userID', '$lastUpdate')";

$result = mysql_query($query);
	
} else if($action=="edit")
	{
		
	} else if($action == 'update'){

} else if($action == 'delete'){
	
	$SourcesModulesID = $_POST['SourcesModulesID'];
	
	$deleteQuery = "DELETE FROM tdbSourcesModules WHERE SourcesModulesID = '$SourcesModulesID'";
	$deleteResult = mysql_query($deleteQuery);
	
}

	$result=array("data"=>$data, 'result'=>'success');
	$json_data= json_encode($result);
	print $json_data;
?>
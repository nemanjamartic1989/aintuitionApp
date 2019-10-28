<?php
//include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
include_once($_SERVER['DOCUMENT_ROOT']."/core/core.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include/_functions.php");
$dbConfig=new Config();
$dbParameter=$dbConfig::getPatameter();
$dbh= new DatabaseHandler($dbParameter['host'], $dbParameter['dbName'], $dbParameter['dbUser'], $dbParameter['dbPass']);

if(isset($_POST['action']))
{
	$action=$_POST['action'];
}
$data=array();
if($action=="get")
{
	
	$sql="SELECT wordID, word, languageName
          FROM  `tdbWordForTranslate` AS wt
          JOIN tdbLanguages AS l ON wt.languageID = l.languageID";
    $result=$dbh->GetAll($sql);
	foreach($result as $row)
	{
		$wordID=$row['wordID'];
		$sqlPoints="SELECT CONCAT( categoryName,  '-', points ) as points
					FROM  `tdbbWordsPoints` AS wp
					JOIN tdbMentalLexiconCategory AS mc ON wp.categoryID = mc.categoryID
				    WHERE wp.wordID =$wordID";
		$resPoints=$dbh->GetAll($sqlPoints);
		$points="";
		foreach($resPoints as $rowPoints)
		{
			$points.=$rowPoints['points']."<br>";
		}	
		$edit="<input id='editMentalLexicon' value='".$row['wordID']."' type='image' style='cursor:pointer;' src='/images/ui/buttons/btn_edit.png'>";
		$delete="<input id='deleteMentalLexicon' value='".$row['wordID']."' type='image' style='cursor:pointer;' src='/images/ui/buttons/btn_delete.png'>";
		
		$data[]=array(
		               	'wordForTranslate'    => $row['word'],
		               	'language'            => $row['languageName'],
		               	'categoriesPoints'    => $points,
		               	'edit'                => $edit,
		               	'delete'              => $delete
					  );	
	}
	
}
elseif($action=="save")
{
	if(isset($_POST['wordLanguage']))        { $wordLanguage     = $_POST['wordLanguage'];}
	if(isset($_POST['wordForTranslate']))    { $wordForTranslate = $_POST['wordForTranslate'];}
	
	$categoryPoints=array();
	if(isset($_POST['enterprisePoints']))        { $categoryPoints['enterprise']      = $_POST['enterprisePoints'];}
	if(isset($_POST['clientPoints']))            { $categoryPoints['client']          = $_POST['clientPoints'];}
	if(isset($_POST['resellerPoints']))          { $categoryPoints['reseller']        = $_POST['resellerPoints'];}
	if(isset($_POST['suplierPoints']))           { $categoryPoints['supplier']        = $_POST['suplierPoints'];}
	if(isset($_POST['competitorPoints']))        { $categoryPoints['competitor']      = $_POST['competitorPoints'];}
	if(isset($_POST['serviceProviderPoints']))   { $categoryPoints['serviceProvider'] = $_POST['serviceProviderPoints'];}
	
	$sql="SELECT COUNT( wordID ) 
          FROM tdbAIntuitionTranslatedWords AS atw
          WHERE words =  '$wordForTranslate'
          AND languageID
          IN ( 3, 4 )";
    $params=array(':languageID'=>$wordLanguage);
	$wordCount=$dbh->GetOne($sql, $params);
	if($wordCount!=0)
	{
		$result=array("data"=>"This word was entered ", 'result'=>'error');
	    $json_data= json_encode($result);
	    print $json_data;
		exit;
	}
	
	$sql="INSERT INTO tdbWordForTranslate(`word`, `languageID`) 
	      VALUES(:word,:languageID)";
	$params=array(
	               ':word'=>$wordForTranslate,
	               ':languageID'=>$wordLanguage
				  );	
	$dbh->Execute($sql, $params);
	$sql="SELECT LAST_INSERT_ID()";
    $wordID=$dbh->GetOne($sql);
	
	$sql="SELECT categoryID, 
		  CASE 
		  WHEN categoryName =  'Service Provider'
		  THEN  'serviceProvider'
		  ELSE LOWER( categoryName ) 
		  END AS categoryName
		  FROM tdbMentalLexiconCategory";
	$result=$dbh->GetAll($sql);
	$categories=array();
	foreach($result as $row)
	{
		$categories[$row['categoryName']]=$row['categoryID'];
	}
	
	foreach($categories as $categoryName=>$categoryID)
	{
		$sql="INSERT INTO tdbbWordsPoints (`wordID`,`categoryID`,`points`)
		      VALUES('$wordID','$categoryID',".$categoryPoints[$categoryName].")";
		$dbh->Execute($sql, $params);
	}
	
    $chosenLanguage="en";
	if($wordLanguage==4)
	{
		$chosenLanguage="de";
	}
	$translate= new Translator('trnsl.1.1.20170928T095443Z.fc4a7b57be84acdd.7f5e3578aab9443c7657a61cdfa881a50b4eff29');
    $output=array();
    $sql="SELECT languageID, languageName, shortName 
          FROM tdbLanguages";
    $result=$dbh->GetAll($sql);
    
	
    foreach($result as $row)
    {

        $outputLang=trim($row['shortName']);
		$languageID=$row['languageID'];
        $lang=$chosenLanguage.'-'.$outputLang;
        $resultOfTranslate = $translate->translate($wordForTranslate,$lang);
        $output[$outputLang]     = $resultOfTranslate;
		$sql="INSERT INTO tdbAIntuitionTranslatedWords(`languageID`,`words`,`wordID`) VALUES ('$languageID','$resultOfTranslate', '$wordID')";
        $dbh->Execute($sql);
    }
    $output[$chosenLanguage]=$wordForTranslate;
    $output['wordID']=$wordID;
    $data=$output;
     
}
elseif($action=="update")
{
	if(isset($_POST['wordID']))                  { $wordID     = $_POST['wordID'];}
	if(isset($_POST['enterprisePoints']))        { $categoryPoints['enterprise']      = $_POST['enterprisePoints'];}
	if(isset($_POST['clientPoints']))            { $categoryPoints['client']          = $_POST['clientPoints'];}
	if(isset($_POST['resellerPoints']))          { $categoryPoints['reseller']        = $_POST['resellerPoints'];}
	if(isset($_POST['suplierPoints']))           { $categoryPoints['supplier']        = $_POST['suplierPoints'];}
	if(isset($_POST['competitorPoints']))        { $categoryPoints['competitor']      = $_POST['competitorPoints'];}
	if(isset($_POST['serviceProviderPoints']))   { $categoryPoints['serviceProvider'] = $_POST['serviceProviderPoints'];}
	
	$sql="SELECT categoryID, 
		  CASE 
		  WHEN categoryName =  'Service Provider'
		  THEN  'serviceProvider'
		  ELSE LOWER( categoryName ) 
		  END AS categoryName
		  FROM tdbMentalLexiconCategory";
	$result=$dbh->GetAll($sql);
	$categories=array();
	foreach($result as $row)
	{
		$categories[$row['categoryName']]=$row['categoryID'];
	}
	
	foreach($categories as $categoryName=>$categoryID)
	{
		$sql="UPDATE tdbbWordsPoints SET points=".$categoryPoints[$categoryName]."
		      WHERE wordID=$wordID AND categoryID=$categoryID";	
		$dbh->Execute($sql);
	}
	
}
elseif($action=="edit")
{
	if(isset($_POST['wordID']))        { $wordID     = $_POST['wordID'];}
	$sql="SELECT wt.wordID, word, languageID, points, mc.categoryID, REPLACE( LOWER( categoryName ) ,  ' ',  '' ) AS categoryName
		  FROM  `tdbWordForTranslate` AS wt
          JOIN tdbbWordsPoints AS wp ON wt.wordID = wp.wordID
          JOIN tdbMentalLexiconCategory AS mc ON wp.categoryID = mc.categoryID
          WHERE wt.wordID =:wordID";
	$params=array(':wordID'=>$wordID);
	$result=$dbh->GetAll($sql, $params);
	foreach($result as $row)
	{
		$data['languageID']         = $row['languageID'];
		$data['word']               = $row['word'];
		$data[$row['categoryName']] = $row['points'];
	}
	
}
elseif($action=="delete")
{
	if(isset($_POST['wordID']))        { $wordID     = $_POST['wordID'];}
	$sql="DELETE wt . * ,wp . * , atw . * 
	      FROM tdbWordForTranslate AS wt JOIN tdbbWordsPoints AS wp ON wt.wordID = wp.wordID 
	      JOIN tdbAIntuitionTranslatedWords AS atw ON wt.wordID = atw.wordID 
	      WHERE wt.wordID =:wordID";
    $params=array(':wordID'=>$wordID);
	$dbh->Execute($sql, $params);
	
}

    $result=array("data"=>$data, 'result'=>'success');
	$json_data= json_encode($result);
	print $json_data;
?>
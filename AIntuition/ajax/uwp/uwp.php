<?php

include_once($_SERVER['DOCUMENT_ROOT']."/core/core.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include/_functions.php");
$dbConfig=new Config();
$dbParameter=$dbConfig::getPatameter();
$dbh= new DatabaseHandler($dbParameter['host'], $dbParameter['dbName'], $dbParameter['dbUser'], $dbParameter['dbPass']);

//$delegation=array();
//function delegation($array)
//{
//    global $delegation; 
//    foreach($array as $key=>$value)
//    {
//        if(is_array($value))
//        {
//             delegation($value); 
//        }
//        else
//        {
//            $value=intval($value);
//            if($value!==0)
//            {
//                $delegation[]=$value;
//            }
//        }
//    }
//}

function getTypeOfMessage($reportCode)
{
    $message="Neutral Message";
    $lastLetter=substr($reportCode, -1);
    if($lastLetter=="P")
    {
        $message="Positive Message";
    }
    else if($lastLetter=="N")
    {
        $message="Negative Message";
    }
    return $message;
}

$message="";
$delegationMessage="";
$statusMessage="";
function getStatus($array)
{
    global $statusMessage; 
    global $delegationMessage;
    foreach($array as $key=>$value)
    {
        if(is_array($value))
        {
            if(strpos(strtolower($key), 'delegation')===false )
            {
               if(gettype($key)!=="integer")
               {
                   switch($key)
                   {
                       case 'businessArea':
                           $key="Business Area";
                           break;
                       case 'businessUnit':
                            $key="Business Unit";
                           break;
                       case 'mentalLexiconKeywords':
                           $key="Keywords from Mental Lexicon";
                       default:
                           $key=$key;
                   }
                   $statusMessage.=$key.'&nbsp;<br>';
               }
               getStatus($value);
            }
            else
            {
                $employees=implode(',',$value);
                $delegationMessage.=$key." ( ".$employees." )&nbsp;<br>";
            }
        }
        else
        {
            if(strpos(strtolower($key), 'messageStatus')===false)
            {
                $statusMessage.=$key.'-'.$value.'<br>';
            }
            if(strpos(strtolower($key),'delegation')!==false)
            {
                $delegationMessage.=$key." ( ".$value." )&nbsp;<br>"; 
            }
                   
        }
    }
}

$sql="SELECT AIntuitionReportID, ai.AIntuitionID, ai.employeeName, air.status, air.message, air.dutyDelegation, air.reportCode, aisc.nameSubCategory, aic.nameCategory, DATE_FORMAT( air.createdDate,  '%W %M %e %Y' ) AS createdDate, TIME( air.createdDate ) AS createdTime
        FROM tdbAIntuition AS ai
        JOIN tdbAIntuitionReports AS air ON ai.AIntuitionID = air.AIntuitionID
        JOIN tdbAIntuitionSubCategory AS aisc ON ai.AIntuitionSubCategoryID = aisc.AIntuitionSubCategoryID
        JOIN tdbAIntuitionCategory AS aic ON aisc.AIntuitionCategoryID = aic.AIntuitionCategoryID
        WHERE reportCode IS NOT NULL ";
$result=$dbh->GetAll($sql);
$data=array();

foreach($result as $row)
{
    //Get Status Message
    $message= json_decode($row['message'], TRUE);
    getStatus($message);
    
    $data[]=array(
        "DT_RowId"              => "row_".$row['AIntuitionReportID'],
        'employeeName'          => $row['employeeName'],
        'aintuitionCategory'    => $row['nameCategory'],
        'aintuitionSubcategory' => $row['nameSubCategory'],
        'status'                => $row['status'],
        'message'               => $statusMessage,
        'messageType'           => getTypeOfMessage($row['reportCode']),
        'delegation'            => $delegationMessage,
        'reportCode'            => $row['reportCode'],
        'createdDate'           => $row['createdDate'],
        'createdTime'           => $row['createdTime']
    );
    
    $statusMessage="";
    $delegationMessage="";
}

$dbh->Close();

$result=array('draw'=>1,"data"=>$data);
$json_data= json_encode($result);
print $json_data;


?>
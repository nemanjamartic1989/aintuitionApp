<?php
include_once($_SERVER['DOCUMENT_ROOT']."/core/core.php");
//include_once($_SERVER['DOCUMENT_ROOT']."/include/_functions.php");

$config=new Config();
$parameter=$config::getPatameter();
$dbh= new DatabaseHandler($parameter['dbHost'], $parameter['dbName'], $parameter['dbUser'], $parameter['dbPass']);

$data=array();
$message="";

$type= filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);

if($type=="addIntuitions")
{
    $jobTitle = filter_input(INPUT_POST, "jobTitle", FILTER_VALIDATE_INT);
    $int      = json_decode($_POST['intuitions'], TRUE);
    foreach($int as $i)
    {
        $intuitions[]= filter_var($i, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    
    foreach($intuitions as $intuitionID)
    {
        $check=checkIfValueExist('tdbJobTitleAISubcategory', array('jobTitleID'=>$jobTitle,'aintuitionSubCategoryID'=>$intuitionID), $dbh);
        if(!$check)
        {
            $sql="INSERT INTO tdbJobTitleAISubcategory(jobTitleID, aintuitionSubCategoryID)"
               . "VALUES (:jobTitleID,:aintuitionSubCategoryID)";
            $params=array(
                    ':jobTitleID'=>$jobTitle, 
                    ':aintuitionSubCategoryID'=>$intuitionID
            );
            $dbh->Execute($sql, $params);

            $relationID=$dbh->getLastInsertID();

            $sql="SELECT nameSubCategory FROM tdbAIntuitionSubCategory "
                . "WHERE AIntuitionSubCategoryID=:AIntuitionSubCategoryID";
            $params=array(':AIntuitionSubCategoryID'=>$intuitionID);
            $intuitionName=$dbh->GetOne($sql, $params);

            $dataIntuitions[$relationID]=$intuitionName;
        }
        else 
        {
            $sql="SELECT nameSubCategory FROM tdbAIntuitionSubCategory
                  WHERE AIntuitionSubCategoryID=:AIntuitionSubCategoryID";
            $params=array(":AIntuitionSubCategoryID"=>$intuitionID);
            $intuitionName=$dbh->GetOne($sql, $params);

            $existIntuitions[]=$intuitionName;
        }
    }
    $data['intuitions']=$dataIntuitions;
    if(!empty($existIntuitions))
    {
        $message="These intuitions (".implode(", ", $existIntuitions).") already exist";
    }
}
elseif($type=="moveUnknownJobsAsKnown")
{
    $jobTitle = filter_input(INPUT_POST, 'jobTitle', FILTER_VALIDATE_INT);
    $jobes    = json_decode($_POST['unknownJobes'], TRUE);
    foreach($jobes as $job)
    {
        $unknownJobes[]= filter_var($job, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
   
    foreach($unknownJobes as $unknownJobID)
    {
        $sql="SELECT unknownJobName FROM tdbUnknownJob"
           . " WHERE unknownJobID=:unknownJobID";
        $params=array(':unknownJobID'=>$unknownJobID);
        $unknownJobName=$dbh->GetOne($sql, $params);
        
        $check=checkIfValueExist('tdbJobTitle', array('jobTitleName'=>$unknownJobName), $dbh);
        if(!$check)
        {
            $sql="INSERT INTO tdbJobTitle(jobTitleName)"
               . " VALUES(:jobTitleName)";
            $params=array(':jobTitleName'=>$unknownJobName);
            $dbh->Execute($sql, $params);
            
            $newJobID=$dbh->getLastInsertID();
            $dataUnknownJobs[$unknownJobID]= $unknownJobName; 
            $dataNewJobs[$newJobID]    = $unknownJobName; 
            
            $sql="DELETE FROM tdbUnknownJob "
               . " WHERE unknownJobID=:unknownJobID";
            $params=array(':unknownJobID'=>$unknownJobID);
            $dbh->Execute($sql, $params);
        }
        else
        {
            $existJobTitles[]=$unknownJobName;
        }
    }
    $data['unknownJobes' ]= $dataUnknownJobs;
    $data['newJobes']     = $dataNewJobs;
   
    if(!empty($existJobTitles))
    {
        $message="These job titles (".implode(", ", $existJobTitles).") already exist";  
    }
}
elseif($type=="moveUnknownJobsAsAlias")
{
    $jobTitle = filter_input(INPUT_POST, 'jobTitle', FILTER_VALIDATE_INT);
    $jobes    = json_decode($_POST['unknownJobes'], TRUE);
    foreach($jobes as $job)
    {
        $unknownJobes[]= filter_var($job, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    foreach($unknownJobes as $unknownJob)
    {
        $sql="SELECT unknownJobName FROM tdbUnknownJob "
           . "WHERE unknownJobID=:unknownJobID";
        $params=array(':unknownJobID'=>$unknownJob);
        $unknownJobName=$dbh->GetOne($sql, $params);
       
        $check=checkIfValueExist('tdbJobTitleAlias', array('jobTitleAliasName'=>$unknownJobName, 'jobTitleID'=>$jobTitle), $dbh);
        if(!$check)
        {
            $sql="INSERT INTO tdbJobTitleAlias (jobTitleID, jobTitleAliasName)"
               . "VALUES(:jobTitleID,:jobTitleAliasName)";
            $params=array(
                ':jobTitleID'       =>$jobTitle,
                ':jobTitleAliasName'=>$unknownJobName
            );
            $dbh->Execute($sql, $params);

            $jobAliasID=$dbh->getLastInsertID();
            $dataUnknownJobs[$unknownJob]=$unknownJobName;
            $dataNewJobAliases[$jobAliasID]=$unknownJobName;

            $sql="DELETE FROM tdbUnknownJob "
               . "WHERE unknownJobID=:unknownJobID";
            $params=array(':unknownJobID'=>$unknownJob);
            $dbh->Execute($sql, $params);
        }
        else
        {
            $existJobAliases[]=$unknownJobName;
        }
    }
    $data['unknownJobes']=$dataUnknownJobs;
    $data['newJobAliases']=$dataNewJobAliases;
    if(!empty($existJobAliases))
    {
        $message="These job aliases (".implode(", ", $existJobAliases).") already exist.";
    } 
}
elseif($type=="getIntuitionsAndJobAliases")
{
    $jobTitleID= filter_input(INPUT_POST, 'jobTitleID', FILTER_VALIDATE_INT);
    
    $sql="SELECT nameSubCategory, jts.AIntuitionSubCategoryID, relationID
          FROM  `tdbJobTitleAISubcategory` AS jts
          JOIN tdbAIntuitionSubCategory AS sc 
          ON jts.aintuitionSubCategoryID = sc.AIntuitionSubCategoryID
          WHERE jts.jobTitleID =:jobTitleID ";
    $params=array(':jobTitleID'=>$jobTitleID);
    $result=$dbh->GetAll($sql, $params);
    foreach($result as $row)
    {
        $data['intuitions'][$row['relationID']]=$row['nameSubCategory'];
    }
    
    $sql="SELECT jobTitleAliasID, jobTitleAliasName "
       . "FROM tdbJobTitleAlias "
       . "WHERE jobTitleID=:jobTitleID";
    
    $result=$dbh->GetAll($sql, $params);
    $params=array(':jobTitleID'=>$jobTitleID);
    foreach($result as $row)
    {
        $data['aliases'][$row['jobTitleAliasID']]=$row['jobTitleAliasName'];
    }
}
elseif($type=="saveJob")
{
    $jobType    = filter_var($_POST['jobType'], FILTER_SANITIZE_STRING);
    $value      = filter_var($_POST['value'], FILTER_SANITIZE_STRING);
    $jobTitleID = filter_var($_POST['jobTitleID'], FILTER_VALIDATE_INT);
    
    if($jobType=="jobTitle")
    {
        $check=checkIfValueExist('tdbJobTitle', array('jobTitleName'=>$value), $dbh);
        if(!$check)
        {
            $sql="INSERT INTO tdbJobTitle(jobTitleName)"
                . " VALUES(:jobTitleName)";
            $params=array(':jobTitleName'=>$value);
            $dbh->Execute($sql, $params);
            
            $jobTitleID=$dbh->getLastInsertID();
            
            $data['jobTtileID']=$jobTitleID;
            $data['jobTitleName']=$value;
        }
        else
        {
            $message="This Job Title already exist.";
        }
    }
    elseif($jobType=="jobAlias")
    {
        $check=checkIfValueExist('tdbJobTitleAlias', array('jobTitleAliasName'=>$value, 'jobTitleID'=>$jobTitleID), $dbh);
        if(!$check)
        {
            $sql="INSERT INTO tdbJobTitleAlias (jobTitleID, jobTitleAliasName)"
                . " VALUES(:jobTitleID,:jobTitleAliasName)";
            $params=array(
                 ':jobTitleID'       =>$jobTitleID,
                 ':jobTitleAliasName'=>$value
            );
            $dbh->Execute($sql, $params);
             
            $jobAliasID=$dbh->getLastInsertID();
             
            $data['jobAliasID']=$jobAliasID;
            $data['jobAliasName']=$value;
        }
        else 
        {
            $message="This Job Alias already exist.";
        }
    }
}
elseif($type=="delete")
{
    $deleteType = filter_var($_POST['deleteType'], FILTER_SANITIZE_STRING);
    $valueID    = filter_var($_POST['valueID'], FILTER_VALIDATE_INT);
    $jobTitleID = filter_var($_POST['jobTitleID'], FILTER_VALIDATE_INT);
    
    if($deleteType=="intuition")
    {
        $sql="DELETE FROM tdbJobTitleAISubcategory "
           . "WHERE relationID=:relationID";
        $params=array(':relationID'=>$valueID);
        $dbh->Execute($sql, $params);
    }
    elseif($deleteType=="alias")
    {
        $sql="DELETE FROM tdbJobTitleAlias "
           . "WHERE jobTitleAliasID =:jobTitleAliasID";
        $params=array(':jobTitleAliasID'=>$valueID);
        $dbh->Execute($sql, $params);
    }
}

echo json_encode(array('data'=>$data, 'message'=>$message));

function checkIfValueExist($table, $columns, $dbh)
{
    $where="WHERE 1";
    $params=array();
    foreach($columns as $column=>$value)
    {
        $where.=" AND $column=:$column";
        $params[":$column"]=$value;
    }
    $sql="SELECT count(*) FROM $table $where";
    $result=$dbh->GetOne($sql, $params);
    return ($result!=0)?TRUE:FALSE;
}
?>
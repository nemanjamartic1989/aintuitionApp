<?php

include_once($_SERVER['DOCUMENT_ROOT']."/core/core.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include/_functions.php");
$config=new Config();
$parameter=$config::getPatameter();
$dbh= new DatabaseHandler($parameter['dbHost'], $parameter['dbName'], $parameter['dbUser'], $parameter['dbPass']);


$jobTitles=array();
$jobTitleAlias=array();
$sql="SELECT jt.jobTitleID, jobTitleName, jobTitleAliasName, jobTitleAliasID, known
      FROM tdbJobTitle AS jt
      LEFT JOIN  `tdbJobTitleAlias` AS jta ON jt.jobTitleID = jobTitleAliasID";
$result=$dbh->GetAll($sql);
foreach($result as $row)
{
    $jobTitles[$row['jobTitleID']]=$row['jobTitleName'];
    if(!empty($row['jobTitleAliasName']))
    {
        $jobTitleAlias[$row['jobTitleAliasID']]=$row['jobTitleAliasName'];
    }
    
}

$sql="SELECT unknownJobID, unknownJobName "
   . "FROM tdbUnknownJob";
$result=$dbh->GetAll($sql);
$unknownJobs=array();
foreach($result as $row)
{
    $unknownJobs[$row['unknownJobID']]=$row['unknownJobName'];
}

$intuitionsByCategory=array();
$categories=array();
$sql="SELECT aic.AIntuitionCategoryID, nameCategory, AIntuitionSubCategoryID, nameSubCategory
      FROM  `tdbAIntuitionCategory` AS aic
      JOIN tdbAIntuitionSubCategory AS aisc 
      ON aic.AIntuitionCategoryID = aisc.AIntuitionCategoryID";
$result=$dbh->GetAll($sql);
foreach($result as $row)
{
    $categories[$row['AIntuitionCategoryID']]=$row['nameCategory'];
    $intuitionsByCategory[$row['AIntuitionCategoryID']][$row['AIntuitionSubCategoryID']]=$row['nameSubCategory'];
}

?>

<fieldset><legend>Delegation</legend>
    <table  class=""  style="width: 100%;margin-top: 20px;" cellspacing="0" width="100%">
        <thead>
            <tr class="table_header">
                <th width="20%" style="text-align: center">Job Title</th>
                <th width="10%" style="text-align: center"></th>
                <th width="20%" style="text-align: center">Unknown Job Titles from pulled data</th>
                <th width="25%" style="text-align: center">AIntuition Categories</th>
                <th width="25%" style="text-align: center">Intuitions</th>
            </tr>
        </thead>
        <tr>
            <td width="20%">
                <select size="5" style="height: 142px;" id="selJobTitles" onchange="showIntuitionsAndJobAliases(this.value)">
                <?php 
                foreach($jobTitles as $jobTitleID=>$jobTitleName)
                {
                    echo "<option value='".$jobTitleID."'>".$jobTitleName."</option>";
                }
                ?>
                </select>
                <img height="15px" src="/images/ui/buttons/btn_plus_green.png" id="img" onclick="openModal('jobTitle');" title="Add New Job Title" style="cursor: pointer; margin-bottom: 45px; float: right" class="plus_button">
            </td>
            <td width="10%">
                <input type="button" onclick="moveUnknownJobs('jobTitle','one')" value="<" class="moveButton" style=" background-color: #235993;border: none;color: white; padding: 15px 0px;margin: 4px 2px; cursor: pointer;">
                <input type="button" onclick="moveUnknownJobs('jobTitle','all')" value="<<" class="moveButton" style=" background-color: #235993;border: none;color: white; padding: 15px 0px;margin: 4px 2px; cursor: pointer;">
            </td>
            <td width="20%">
                <select size="5" style="height: 142px;" id="selUnknownJobs">
                    <?php
                    foreach ($unknownJobs as $unknownJobID=>$unknownJobName)
                    {
                        echo "<option value='".$unknownJobID."'>".$unknownJobName."</option>";
                    }
                    ?>
                </select>
                
            </td>
            <td width="25%">
                <fieldset  style="overflow-y:scroll;height: 142px; width: 230px;display: block;"><legend>AIntuition Categories</legend>
	             <table width="100%"  class="tableHover tableRowColoring" id="tblCategories">
	                <tbody>
                            <?php
                            foreach($categories as $categoryID=>$categoryName)
                            {
                                $intuitions= json_encode($intuitionsByCategory[$categoryID]);
                                echo "<tr>";
                                echo "<td >".$categoryName."</td>";
                                $checkID='checkAICategory'.$categoryID;
                                echo "<td><input type='checkbox' id='$checkID' value='".$categoryID."' onclick='getAintuitionSubCategory($categoryID, $intuitions)' ></td>";
                                echo "</tr>";
                            }
                            ?>
	                </tbody>
	            </table>
                </fieldset>
            </td>
            <td width="25%">
                <fieldset  style="overflow-y:scroll;height: 142px; width: 250px;display: block;"><legend>Intuitions</legend>
	             <table width="100%"  class="tableHover tableRowColoring" id="tblIntuitions">
	                <tbody>
                           
	                </tbody>
	            </table>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            
            <td>
                <input type="button" onclick="moveUnknownJobs('jobAlias','one')" value="<" class="moveButton" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg); background-color: #235993;border: none;color: white; padding: 15px 0px;margin: 4px 2px; cursor: pointer;">
                <input type="button" onclick="moveUnknownJobs('jobAlias','all')" value="<<" class="moveButton" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg); background-color: #235993;border: none;color: white; padding: 15px 0px;margin: 4px 2px; cursor: pointer;">
            </td>
            <td>&nbsp;</td>
            <td style="text-align:center">
                <input type="button" onclick="moveIntuitions()" value="<<" class="moveButton" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg); background-color: #235993;border: none;color: white; padding: 15px 0px;margin: 4px 2px; cursor: pointer;">
            </td>
        </tr>
    </table>
    <br><br>
    <div id="message"></div>
    <table style="width: 100%">
        <tr>
            <td>
                <input type="button" value="Add New Job Alias" onclick="openModal('jobAlias')">
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="50%">
                
                <fieldset style="max-height:200px; overflow-y: auto; height: 200px"><legend id="jobAliasForTitle"></legend>
                    <div id="listOfJobAlias">
                        
                    </div>
                </fieldset>
            </td>
            <td width="50%">
                <fieldset style="max-height:200px; overflow-y: auto; height: 200px"><legend id="intuitionsForJobTitle"></legend>
                    <div id="listOfIntuitions">
                        
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
   
   
</fieldset>
<div id="jobModal"></div>
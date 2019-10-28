<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$dir = dirname(__DIR__);
include ($dir . "../../../classes/init.php");

$AIntuitionID = 6;
$AIntuition = new AIntuition($AIntuitionID);
// $createAIreport = $AIntuition->createAIReport("0 */1 * * *");
$removeAIReport = $AIntuition->removeAIReport("0 */1 * * *");

// var_dump($AIntuition->get_employeeID());
//var_dump($AIntuition->AIntuitionReportCode());

// $crontab = new Crontab();
// $array = array("0 0 */1 * * /usr/bin/php /var/www/html/tdb1/AIntuition/reports/enterprise/employeeWorkforceInternal.php --AIntuitionID=128","0 */1 * * * /usr/bin/php /var/www/html/tdb1/AIntuition/reports/product/productSalesForecast.php --AIntuitionID=36");
// $crontab->removeCronjob("0 0 */1 * * /usr/bin/php /var/www/html/tdb1/AIntuition/reports/enterprise/employeeWorkforceInternal.php --AIntuitionID=128");
// $crontab->removeCronjob($array);



?>
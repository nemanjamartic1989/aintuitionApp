<?php

include($_SERVER['DOCUMENT_ROOT'] . "/classes/init.php");
$DB = new DB();
//var_dump($_POST);

if (isset($_POST["action"])) {
    $sql = "INSERT INTO `tdbAIntuitionRegistration`(`aintuitionIP`, `neo4jIP`, `employeeRegistrationPassword`, `employeeRegistrationPasswordLength`) VALUES (:aintuitionIP, :neo4jIP, :employeeRegistrationPassword, :employeeRegistrationPasswordLength)";

    $params = array(
        "aintuitionIP" => $_POST["aintuitionIP"],
        "neo4jIP" => $_POST["neo4jIP"],
        "employeeRegistrationPassword" => md5($_POST["employeeRegistrationPassword"]),
        "employeeRegistrationPasswordLength" => strlen($_POST["employeeRegistrationPassword"])
    );

    $action = $_POST["action"];
    if ($action == "save") {
        $registration = $DB->query($sql, $params);
    } elseif ($action == "update") {
        $DB->query("TRUNCATE TABLE  `tdbAIntuitionRegistration`");
        if ($DB->querySuccess()) {
            $registration = $DB->query($sql, $params);
        }
    }
}
?>
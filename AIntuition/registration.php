<script>
    document.getElementById('employeeRegistrationPassword').focus();
</script>
<?php
include($_SERVER['DOCUMENT_ROOT'] . "/classes/init.php");

$DB = new DB();
$registrationSql = "SELECT `aintuitionIP`, `neo4jIP`, `employeeRegistrationPassword` FROM `tdbAIntuitionRegistration`";
$registration = $DB->row($registrationSql);

//    var_dump($registration);

if (!$registration) {
    $button = "Save";
} else {
    $button = "Update";
}
?>
<input type="button" onclick="backToMainMenu();" value="Back to main menu" style="float:right;"/><br /><br />
<fieldset>
    <legend>Registration</legend>
    <form id="registrationForm">
        <table>
            <tr>
                <td>AIntuition server</td>
                <td><input type="text" name="aintuitionIP" id="aintuitionIP" readonly="readonly" value="<?php echo $_SERVER['SERVER_ADDR']; ?>" ></td>
            </tr>

            <tr>
                <td>Graph server</td>
                <td><input title="Correct format is IP address with port(for example: 192.168.1.1:3000)" type="text" name="neo4jIP" id="neo4jIP" value="<?php echo isset($registration["neo4jIP"]) ? $registration["neo4jIP"] : '';  ?>" ></td>
            </tr>

            <tr>
                <td>Employee registration password</td>
                <td><input type="password" name="employeeRegistrationPassword" id="employeeRegistrationPassword" value="<?php echo isset($registration["employeeRegistrationPassword"]) ? $registration["employeeRegistrationPassword"] : '';  ?>" ></td>
            </tr>

            <tr>
                <td>
                    <input type="button" value="<?php echo $button; ?>" onclick="registrationAction('<?php echo strtolower($button); ?>')" >
                </td>            
                <td>
                    <input type="button" value="Cancel" onclick="location.href='/AIntuition'" >
                </td>
            </tr>
        </table>
    </form>
    <div id="registrationAction"></div>
</fieldset>

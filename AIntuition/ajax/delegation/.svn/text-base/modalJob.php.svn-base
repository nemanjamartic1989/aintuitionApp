<?php

include_once($_SERVER['DOCUMENT_ROOT']."/core/core.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include/_functions.php");
$config=new Config();
$parameter=$config::getPatameter();
$dbh= new DatabaseHandler($parameter['dbHost'], $parameter['dbName'], $parameter['dbUser'], $parameter['dbPass']);

if(isset($_POST['type'])) { $type=$_POST['type'];}
$legend=($type=="jobTitle")?"Add New Job Title":"Add New Job Alias";

?>
<div class="modalDialog">
    <div class="modalContent" style="margin: 20% auto;">
        <a onclick="$('#jobModal').html('');" title="Close" class="close">X</a>
        <fieldset>
            <legend><?php echo $legend; ?></legend>
	        <table width="100%">
	        	<?php echo $tr; ?>
	        	<tr>
	        		<td><label>Name</label></td>
	        		<td><input type="text" name="elementValue" id="elementValue"></td>
	        	</tr>
	        	<tr>
	        		<td>&nbsp;</td>
	        		<td><input type="button" value="Save" onclick="saveJob('<?php echo $type; ?>')"></td>
	        	</tr>
	        	
	        </table>
	        <div id="modalErrorMessage"></div>
        </fieldset>
    </div>
</div>
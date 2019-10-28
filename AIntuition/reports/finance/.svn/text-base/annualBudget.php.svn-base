<?php
	$dir = dirname(__DIR__);
	include ($dir . "../../../classes/init.php");
	$argv = INI::getArguments();
	$aintuitionID = $argv["AIntuitionID"];
	$aintuitionID=140;
	$aintuition = new AIntuition($aintuitionID);
    $aintuitionParameters = json_decode($aintuition->getFromAIntuition(array("AIntuitionParameters")));
	
	
	
	var_dump($aintuitionParameters);
?>
<?php 
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
?>
<input type="button" onclick="backToMainMenu();" value="Back to main menu" style="float:right;"/><br /><br />

<!-- NAVIGATION - begin -->
<fieldset id="mainMenuForexModule" class="fieldset-group">
	
	<div class="figPozicija" style="margin-bottom: 80px;padding-top:20px;border-spacing: 12px 0;">
		
		<figure class="figPocetna cursorP figSources figCon" onclick="sourcesForAIntuition();">
	        <figcaption class="figcapPocetna"> Sources For AIntuition </figcaption>
	    </figure> 
	    
		<figure class="figPocetna cursorP figModules figCon" onclick="sourcesForModules();">
	        <figcaption class="figcapPocetna"> Sources For Modules </figcaption>
	    </figure> 

	</div>

</fieldset>

<div id="displaySourcesSpecies"></div>
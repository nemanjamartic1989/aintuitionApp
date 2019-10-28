	<script>
		$(document).ready(function(){
			$('#zoomHolding').click(function() {
			
		       updateZoom(0.1);
		    });
		
		 $('#zoomOutHolding').click(function() {
		    updateZoom(-0.1);
		 });
		 zoomLevel = 1;
		 var updateZoom = function(zoom) 
		 {
		 	
		  zoomLevel += zoom;
		      $("#ifHolding").contents().find("body").css({ zoom: zoomLevel, '-moz-transform': 'scale(' + zoomLevel + ')' });
		 }
		});

	</script>

<input type="button" onclick="backToMainMenu();" value="Back to main menu" style="float:right;"/><br /><br />

<button type="button" id="zoomHolding" class="zoomIn"><img src="/images/ui/plus.png" width="25" height="25"></button>
			<button type="button" id="zoomOutHolding" class="zoomOut"><img src="/images/ui/minus.png" width="25" height="25"></button>
			<p style="margin: 0 0 0 100px; font-size: 15px; float:right;">Create a profile for the employee.</p>
<iframe id="ifHolding" class="aiOrganigram" style="width: 100%; height: 700px; float: left; border: 2px solid rgb(243, 107, 33);" src="/AIntuition/showContentOrganigram.php"></iframe>


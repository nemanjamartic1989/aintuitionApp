<?php	
	session_start(); // start session.
	
	// Include need file(s):
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php"); 
 	
	$back = "/";
	$home = "/";
 
?>

 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta charset="UTF-8"/>	
	<?php include($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>	
	<title><?php echo $projName.' | '.getModuleNameByFolder(); ?></title>
	<script src="/roboticAutomation/jquery-ui-1.12.0/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="/AIntuition/css/aIntuition.css">
	<link rel="stylesheet" type="text/css" href="/AIntuition/css/sourcesReputation.css">
	<link rel="stylesheet" type="text/css" href="/AIntuition/css/mentalLexicon.css">
	<script type="text/javascript" src="/js/ui/jquery-ui.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../roboticAutomation/jquery-ui-1.12.0/jquery-ui.css">
	<title><?php echo $projName.' | '.getModuleNameByFolder(); ?></title>
        <style>
            .figPozicija{
                text-align: -moz-center;
            }
			
			#newProfile {
				float: right;
			}
			
			#backAI {
				float: right;
				display: none;
			}
			
           #showMainCategory {
           		margin: 10px 0 0 0;
           }
        </style>
        	<script type="text/javascript" src="/js/jquery.gmap.min.js"></script>
			<script type="text/javascript" src="/js/tdb.js"></script>
			<script type="text/javascript" src="/AIntuition/js/aIntuition.js"></script>

</head>

<body>

	
	<div align="center">
		<div id="loaderDiv" style="display: none" class="loader" align="center"></div>
	</div>
   
    <div class="container_12 background-main">
    	
    	<!-- GO TO LIST OF ORGANIGRAM CONTENT AND OPPORTUNITY TO ASSIGN CATEGORY TO EMPLOYEE -->
    	
    		<input type="button" id="backAI"  onclick="backAIntuition();" value="back to A-Intuition" />


	    <div class="content">
	    	<?php echo breadcrumbs(); ?>
	    	<br />
	    	<br />
			
			<!-- ZOOM ORGANIGRAM -->
			
	
			<fieldset id="mainMenuAIntuition">
				<div class="figPozicija" style="margin-bottom: 80px;padding-top:20px;border-spacing: 12px 0;">
					<figure class="figPocetna cursorP figAIntuition figCon" onclick="showIntuitionProfile();">
				        <figcaption class="figcapPocetna"> Intuition Profile </figcaption>
				    </figure> 
					<figure class="figPocetna cursorP figMentalLexicon figCon" onclick="showMentalLexicon();">
				        <figcaption class="figcapPocetna"> Mental Lexicon </figcaption>
				    </figure> 
					<figure class="figPocetna cursorP figSources figCon" onclick="showSources();">
				        <figcaption class="figcapPocetna"> Sources </figcaption>
				    </figure> 	
				    <figure class="figPocetna cursorP figCompilance figCon" onclick="showCompilance();">
				        <figcaption class="figcapPocetna"> Compliance </figcaption>
				    </figure>
				     <figure class="figPocetna cursorP figA8 figMobile" onclick="showMobile();">
				        <figcaption class="figcapPocetna"> Mobile </figcaption>
				    </figure>					    				      
				    <figure class="figPocetna cursorP figMobile figCon" onclick="showMobile();">
				      <figcaption class="figcapPocetna"> Mobile </figcaption>
				    </figure>
				    <figure class="figPocetna cursorP figA8 figMobile" onclick="showDelegation();">
				        <figcaption class="figcapPocetna"> Delegation </figcaption>
				    </figure>
				</div>
				

			</fieldset>
			
			<div id="displayIntuitionProfile"></div>
			<div id="displayMentalLexicon"></div>
			<div id="displaySources"></div>
			<div id="displayCompilance"></div>
			<div id="displayMobile"></div>
			<div id="displayDelegation"></div>
			
		</div>
    </div>

		<div id="showDetailsOrganigram"></div>

	<div id="showMainCategory"></div>

<script>

$( function() {
    $( "#basic-example" ).draggable(); // Allow elements to be moved using the mouse.
  } );

function showJsonOrg(json){
	
	var returnData = JSON.parse(json); // Parse the data with JSON.parse(), and the data becomes a JavaScript object.
	
	new Treant( returnData );

}

	
showJsonOrg('<?php echo $json; ?>');

	
</script>


    
    <!-- SET FOOTER -->
	<div class="container_12 footer"><?php include($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?></div>
	

</body>
</html>

<script>
	$('.figCon').hover(function () {
    	$(this).addClass('magictime vanishIn');
  	}, function() {
  		$(this).removeClass('magictime vanishIn');
	});
	
  	
  	$('.figPocetna').click(function(){
    	$('.figPocetna').removeClass('activate');
    	$(this).addClass('activate');
	});
</script>


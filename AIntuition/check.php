<script>
	$(document).ready(function(){
		var Sources = $("#displayTableSourcesReputation").dataTable({
			"ajax":{
				'type': 'POST',
				'url': '/AIntuition/ajax/sources/sources.php',
				'data': function(d){
					d.action = 'get'
				}
			},
			"columns":[
			{"data": "SiteSourceReputation"},
			{"data": "languageSources"},
			{"data": "chooseCategorySources"},
			{"data": "edit"},
			{"data": "delete"}
			],
			"aoColumnDefs": [
	      { "bSortable": false, "aTargets": [-1] }
	    ],
	    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
	    "oLanguage": {
	      "oPaginate": {
	        "sFirst":       " ",
	        "sPrevious":    " ",
	        "sNext":        " ",
	        "sLast":        " ",
	      },
	      "sLengthMenu":    "Records per page: _MENU_",
	      "sInfo":          "Total of _TOTAL_ records (showing _START_ to _END_)",
	      "sInfoFiltered":  "(filtered from _MAX_ total records)"
	    }
			
		});
		
		
		$(document).on("click", "#saveReputation", function(){
			var validate=validation();
			
			if(!validate)
			{
				return false;
			}
			
			var sendData = {SiteSourceReputation: SiteSourceReputation, languageSources: languageSources, chooseCategorySources: chooseCategorySources, action: "save"};
		});
		
		var request   = $.ajax({
	        url:          '/AIntuition/ajax/sources/sources.php',
	        type:         'POST',
	        beforeSend:function(){cursorLoaderShow();},
	        cache:        false,
	        data:         sendData,
	      });
	      
	      
	    // UPDATE SOURCES REPUTATION - BEGIN  
	      
	    $(document).on('click','#updateMentalLexicon',function(e){
	  	var wordID=$("#hiddenWordID").val();
	  	
	  	var chooseCategorySources=$("#chooseCategorySources").val();
		
	    var sendData={wordID:wordID, action:'update', chooseCategorySources: chooseCategorySources};
	  	var request   = $.ajax({
	        url:          '/AIntuition/ajax/mentalLexicon/mentalLexicon.php',
	        type:         'POST',
	        beforeSend:function(){cursorLoaderShow();},
	        cache:        false,
	        data:         sendData,
	      });
	      request.done(function(output){
	      	    $("#SiteSourceReputation").prop('disabled',false);
				$("#languageSources").prop('disabled',false);
	      		$("#saveReputation").css("display",'inline');
	  	        $("#updateReputation").css("display",'none');
	      	    clearForm();
		      	Sources.api().ajax.reload(function(){}, false);
	      });
	      request.fail(function(jqXHR, textStatus){
	       
	      });
	      request.complete(function(){
				cursorLoaderHide();
		 });
		 
  	 });
  	 
  	 	 // UPDATE SOURCES REPUTATION - END  
  	 	 
  	 	 // EDIT SOURCES REPUTATION - BEGIN
  	 	$(document).on('click','#editSources',function(e){
	  	var wordID=$(this).attr('value');
	  	$("#hiddenWordID").val(wordID);
	  	
	    var sendData={wordID:wordID, action:'edit'};
	  	var request   = $.ajax({
	        url:          '/AIntuition/ajax/sources/sources.php',
	        type:         'POST',
	        beforeSend:function(){cursorLoaderShow();},
	        cache:        false,
	        data:         sendData,
	      });
	      request.done(function(output){
	      	    var data=JSON.parse(output);
	      	    var editData=data.data;
	      	    $("#SiteSourceReputation").val(editData.languageID);
				$("#languageSources").val(editData.word);
	      	    outputSave('chooseCategorySources', editData.chooseCategorySources)
			 	outputSave('chooseCategorySourcesOutput', editData.chooseCategorySources)
	      	    $("#saveReputation").css("display",'none');
	  	        $("#updateReputation").css("display",'inline');
	      	    
				$("#SiteSourceReputation").prop('disabled',true);
				$("#languageSources").prop('disabled',true);
		      	//mentalLexicon.api().ajax.reload(function(){}, false);
	      });
	      request.fail(function(jqXHR, textStatus){
	       
	      });
	      request.complete(function(){
				cursorLoaderHide();
		 });
		 
  	 }) 
  	 	 // EDIT SOURCES REPUTATION - END   
 
		// DELETE SOURCES REPUTATION - BEGIN
		  	  $(document).on('click','#deleteReputation',function(e){
	  	 var wordID=$(this).attr('value');
		 var sendData={wordID:wordID, action:'delete'};
	  	var request   = $.ajax({
	        url:          '/AIntuition/ajax/sources/sources.php',
	        type:         'POST',
	        beforeSend:function(){cursorLoaderShow();},
	        cache:        false,
	        data:         sendData,
	      });
	      request.done(function(output){
	      	    $('table#displayTableSourcesReputation tr#tableTr'+wordID).remove();
	      	    $("#SiteSourceReputation").prop('disabled',false);
				$("#languageSources").prop('disabled',false);
				$("#SiteSourceReputation").val('--');
				$("#languageSources").val('');
	      		$("#saveReputation").css("display",'inline');
	  	        $("#updateReputation").css("display",'none');
		      	Sources.api().ajax.reload(function(){}, false);
	      });
	      request.fail(function(jqXHR, textStatus){
	       
	      });
	      request.complete(function(){
				cursorLoaderHide();
		 });
		 
  	 })
		// DELETE SOURCES REPUTATION - END
		
		function validation()
  	 {
  	 	if($("#languageSources").val()=="--" || $("#languageSources").val()=="")
		{
			$("#languageSources").css('background','lightgray');
			$("#languageSources").focus();
			$("#message").html("<span class='red'>Please choose language!.</span>");
			return false;
		}
		
		if($("#SiteSourceReputation").val()=="")
		{
			$("#SiteSourceReputation").css('background','lightgray');
			$("#SiteSourceReputation").focus();
			$("#message").html("<span class='red'>Please insert source of site.</span>");
			return false;
		}
		
		return true;
  	 }
  	   
  	 function clearForm()
  	 {
  	 	$("#languageSources").val("--");
	 	$("#SiteSourceReputation").val("");
	 	outputSave('chooseCategorySourcesOutput', 0)
	 	
	 	outputSave('chooseCategorySources', 0)
  	 	
  	 }
		
	});
</script>

<table style="width: 100%; margin-top: 20px; margin-bottom: 20px;">
	<tr>
		<td width="33%" align='center' id="message">&nbsp;</td>
		<td width="33%" align='center'>
			<input type="button" id="updateReputation" style="display: none" value="Update">
			<input type="button" id="saveReputation" value="Save">
		</td>
		<td width="33%" align='center'>&nbsp;</td>
	</tr>
</table>

<table id="displayTableSourcesReputation" class="tableRowColoring"  style="width: 100%;     margin-top: 20px;" cellspacing="0" width="100%">
        <thead>
            <tr class="table_header">
                <th>Category</th>
				<th>Source - Language</th>	
				<th>Edit</th>
				<th>Remove</th>
            </tr>
        </thead>
</table>

<input type="hidden" id="hiddenWordID" value="">
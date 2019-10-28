/////////////////////////////////////////////////////////////////// DISPLAY PART OF AINTUITION - BEGIN //////////////////////////////////////////////////////////////////

// SHOW INTUITION PROFILE:

function showIntuitionProfile(){
	$.ajax({
		url:"/AIntuition/intuitionProfile.php",
	    complete: function(){
        	cursorLoaderHide();
       },	
		success:function(data){
			$('#displayIntuitionProfile').html(data);
			$('#displayIntuitionProfile').show();
			$("#mainMenuAIntuition").hide();
		}
	});
}

// SHOW MENTAL LEXICON:

function showMentalLexicon(){
	$.ajax({
		url:"/AIntuition/mentalLexicon.php",
	    complete: function(){
        	cursorLoaderHide();
       },	
		success:function(data){
			$('#displayMentalLexicon').html(data);
			$('#displayMentalLexicon').show();
			$("#mainMenuAIntuition").hide();
		}
	});
}

function showDelegation()
{
    $.ajax({
            url:"/AIntuition/delegation.php", // Specifies the URL to send the request to.
	    complete: function(){ // A function to run when the request is finished (after success and error functions).
        	cursorLoaderHide();
            },	
	    success:function(data){ // A function to be run when the request succeeds.
                $('#displayDelegation').html(data);
                $('#displayDelegation').show();
                $("#mainMenuAIntuition").hide();
	    }
	});
}

function showMobile(){
	window.open('http://aintuition.vca.ag/cellphone/','_blank');
}

$(function(){
	  $('#chooseCategoryMentalLexicon').on('change', function(){
		  var val = $(this).val();
		  if(val == 5) {
		    $('#showPartnerSubType').show();
		  }
		  else if(val == 7) {
		    $('#showGRCSubType').show(); 
		  }
	  });
 });

function backToMainMenu(){
	window.location.reload();
}


function outputSave(div, vol) {
	document.querySelector('#'+div).value = vol;
}

function outputUpdate(vol) {
	document.querySelector('#volumeUpdate').value = vol;
}

// ADD MULTIPLE CATEGORIES AND POINTS:
function addCategory(){
	var category = $("#chooseCategoryMentalLexicon").val();
	var pointsOfCategory = $("#SliderQualityTranslate").val();
	var partnerSubType = $("#showPartnerSubType").val();
	
	var wordForTranslate = $("#wordForTranslate").val();
	
	// Check condition if a field word for translate is empty or not:
	if(wordForTranslate == ''){
		alert("Please insert the word into the field that is being translated!");
	} else {
		
	if(category === 'Partner' && (partnerSubType === 'Reseller' || partnerSubType === 'Supplier')){
		if(partnerSubType !== ''){
			category = partnerSubType;
		} else {
			alert("Partner Subcategory is not selected!");
		}
	}
	
	var categories = [];
	var points = [];
	
	categories.push(category);
	points.push(pointsOfCategory);
	
	
	
	// Check condition if category
	
	if(category == ''){ // Make sure the category is selected.
		
		alert("Please choose category"); // if not, print message.
		
		
	} else { // if yes, add category.
		
		if(category == 'Partner'){
			alert("Please choose Partner subcategory"); // if not, print message.
		} else {
			
			
	// Check condition if array categories has duplicate values:
	
   var $tableRows = $("#displayTable tr");
   var $rowsToMark = $();

    $tableRows.each(function(n) {
        var id = this.id;
        var categoriesTableRows = $(this).find('#categories').html();

        $tableRows.each(function(n) {
            var $this;
            if (this.id != id) {
                $this = $(this);
                
                if ($this.find('#categories').html() == categories) {
                    alert("You've already selected this category!");
                    $(this).remove();
              		
                } else {
                	return true;
                }
            }
        });
    });
  
     console.log(categories); // Display choosen category in console.
     
	$("#ListOfAssignedPointsToCategory").show();
	
	// Append table row after click on button ADD CATEGORY:
	$("#displayTable").append('<tr id="showCategoriesPoints"><td class="tableNewBorder" name="categories[]" align="center" id="categories">' + categories + '</td><td class="tableNewBorder" name="points[]" align="center" id="points">' + points +'</td><td class="tableNewBorder" align="center"><img style="cursor:pointer" src="/images/ui/buttons/btn_delete.png"  id="removeCategoriesPoints"></td></tr>');
	
	$("#displayTable").on('click','#removeCategoriesPoints',function(){
        $(this).parent().parent().remove();
    });
	}
	
   }
    categories = JSON.stringify(categories);
    points = JSON.stringify(points);
	}
}

// UPDATE MULTIPLE CATEGORIES AND POINTS:
function updateCategoriesPoints(){
	var category = $("#chooseCategoryMentalLexiconUpdate").val();
	var pointsOfCategory = $("#SliderQualityTranslateUpdate").val();
	var partnerSubType = $("#showPartnerSubTypeUpdate").val();
	
	var wordForTranslate = $("#wordForTranslateUpdate").val();
	
	// Check condition if a field word for translate is empty or not:
	if(wordForTranslate == ''){
		alert("Please insert the word into the field that is being translated!");
	} else {
	
	if(category === 'Partner' && (partnerSubType === 'Reseller' || partnerSubType === 'Supplier')){
		if(partnerSubType !== ''){
			category = partnerSubType;
		} else {
			alert("Partner Subcategory is not selected!");
		}
	}
	
	var categories = [];
	var points = [];
	
	categories.push(category);
	points.push(pointsOfCategory);
	
	$("#NoteForPointsOfCategory").show();
	
	if(category == ''){ // Make sure the category is selected.
		
		alert("Please choose category"); // if not, print message.
		
	} else { // if yes, add category.
		
		if(category == 'Partner'){
			alert("Please choose subcategory"); // if not, print message.
		} else {
			// Check condition if array categories has duplicate values:
	
   var $tableRows = $("#displayTableUpdate tr");
   var $rowsToMark = $();

    $tableRows.each(function(n) {
        var id = this.id;
        var categoriesTableRows = $(this).find('#categoriesUpdate').html();

        $tableRows.each(function(n) {
            var $this;
            if (this.id != id) {
                $this = $(this);
                
                if ($this.find('#categoriesUpdate').html() == categories) {
                    alert("You've already selected this category!");
                    $(this).remove();
              		
                } else {
                	return true;
                }
            }
        });
    });
    
    // Append table row after click on button ADD CATEGORY:
	$("#displayTableUpdate").append('<tr id="showCategoriesPointsUpdate"><td class="tableNewBorder" name="categoriesUpdate[]" align="center" id="categoriesUpdate">' + categories + '</td><td class="tableNewBorder" name="pointsUpdate[]" align="center" id="pointsUpdate">' + points +'</td><td class="tableNewBorder" align="center"><img style="cursor:pointer" src="/images/ui/buttons/btn_delete.png"  id="removeCategoriesPointsUpdateForm"></td></tr>');
	
	$("#displayTableUpdate").on('click','#removeCategoriesPointsUpdateForm',function(){
        $(this).parent().parent().remove();
    });
  }
   }
    categories = JSON.stringify(categories); // Convert a JavaScript object into a string.
    points = JSON.stringify(points); // Convert a JavaScript object into a string.
	}
}

function removeRowCategoriesPoints(){
	$('#displayTableUpdate').on('click', '#removeCategoriesPointsUpdateForm', function() { 
    	$(this).closest("tr").remove();
	});
}


/////////////////////////////////////////////////////////////////// DISPLAY PART OF AINTUITION - END //////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////// SOURCES BEGIN /////////////////////////////////////////////////////////////////////////////////////

function showSources(){
	$.ajax({
		url:"/AIntuition/sources.php", // Specifies the URL to send the request to.
	    complete: function(){ // 	A function to run when the request is finished (after success and error functions).
        	cursorLoaderHide();
       },	
		success:function(data){ // 	A function to be run when the request succeeds
			$('#displaySources').html(data);
			$('#displaySources').show();
			$("#mainMenuAIntuition").hide();
		}
	});
}

function sourcesForModules(){
	
	$.ajax({
		url:"/AIntuition/sourcesForModules.php", // Specifies the URL to send the request to.
	    complete: function(){ // 	A function to run when the request is finished (after success and error functions).
        	cursorLoaderHide();
       },	
		success:function(data){ // 	A function to be run when the request succeeds
			$('#displaySources').html(data);
			$('#displaySources').show();
			$("#mainMenuAIntuition").hide();
		}
	});
	
}

// FILTER FOR CATEGORY:
function DisplaySourcesReputationType(id){
	var src_img = $("#typeFilterImg").attr("src");

    $.ajax({
        url: "/AIntuition/ajax/sources/DisplayCategoriesType.php", // Specifies the URL to send the request to.
        type: "POST", // Specifies the type of request. (GET or POST)
        context: document.body, // 	Specifies the "this" value for all AJAX related callback functions.
        data: {id:id}, // Specifies data to be sent to the server.
        beforeSend: function() { // A function to run before the request is sent.
            $('#typeFilterImg').attr("src", "/images/ajax_filter_loader.gif");
        },
        complete: function() { // 	A function to run when the request is finished (after success and error functions).
            $('#typeFilterImg').attr("src", src_img);
        },
        success: function(data) { // A function to be run when the request succeeds.
            $('#typeListCategory').html(data);
			$('#typeListCategory').show();
        }
    });
	
}

function DisplayAllDataFilter(){
	$.ajax({
				url: "/AIntuition/ajax/sources/DisplayAllCategories.php", // Specifies the URL to send the request to.
				type: 'POST', // Specifies the type of request. (GET or POST)
				context: document.body, // Specifies the "this" value for all AJAX related callback functions.
				success: function(data){ // A function to be run when the request succeeds.
				$('#displayDataFilter').html(data);
				$('#displayDataFilter').show();
				$("#typeListCategory").hide();
				}
			});		

}

function DisplayFilteredCategoryData(id){
	$.ajax({
				url: "/AIntuition/ajax/sources/DisplayFilteredCategories.php?id=" + id, // Specifies the URL to send the request to.
				type: 'POST', // Specifies the type of request. (GET or POST)
				data: {id: id}, // Specifies data to be sent to the server.
				context: document.body, // Specifies the "this" value for all AJAX related callback functions.
				success: function(data){ // A function to be run when the request succeeds.
				$('#displayDataFilter').html(data);
				$('#displayDataFilter').show();
				$("#typeListCategory").hide();
				}
			});		
}

function displayCategory(){
	var chooseLanguageSources = $("#languageSources").val();
	
	$.ajax({
		url:"/AIntuition/ajax/sources/subCategoryReputation.php", // Specifies the URL to send the request to.
		type: 'POST',
		data: {chooseLanguageSources: chooseLanguageSources},		
	    context : document.body,
	    complete: function(){ // A function to run when the request is finished (after sucess and error function).
        	cursorLoaderHide();
        },	
		success:function(data){ // A function to be run when the request succeeds.
			$('#showCategoryReputation').html(data);
			$('#showCategoryReputation').show();
			
		}
	});
}

function subCategoryReputation(chooseCategorySources){
	var chooseCategorySources = $("#chooseCategorySources").val();
	var chooseSubCategoryReputation = $("#chooseSubCategoryReputation").val();
	
	$.ajax({
		url:"/AIntuition/ajax/sources/reputationSites.php?chooseCategorySources=" + chooseCategorySources, // Specifies the URL to send the request to.
		type: 'POST',
		data: {chooseCategorySources: chooseCategorySources, chooseSubCategoryReputation: chooseSubCategoryReputation},		
	    context : document.body,
	    complete: function(){ // A function to run when the request is finished (after sucess and error function).
        	cursorLoaderHide();
        },	
		success:function(data){ // A function to be run when the request succeeds.
			$('#chooseSitesForReputation').html(data);
			$('#chooseSitesForReputation').show();
			
		}
	});
}

// ADDING SITE IN TABLE WHICH DATA WILL BE SEND IN DATABASE:
function addSiteReputation(){
	var site = $("#SiteSourceReputation").val();
	var language = $("#languageSources").val();
	var category = $("#chooseCategorySources").val();
	
	var sites = [];
	var languages = [];
	
	sites.push(site);
	languages.push(language);
	
	console.log(sites);
	console.log(languages);
	
	// Check condition if array categories has duplicate values:
	
   var $tableRows = $("#displayTableSitesLanguages tr");
   var $rowsToMark = $();

    $tableRows.each(function(n) {
        var id = this.id;
        var categoriesTableRows = $(this).find('#sites').html();

        $tableRows.each(function(n) {
            var $this;
            if (this.id != id) {
                $this = $(this);
                
                if ($this.find('#sites').html() == sites) {
                    alert("You've already selected this site!");
                    $(this).remove();
              		
                } else {
                	return true;
                }
            }
        });
    });
  
	
	if(site == ''){
		$("#showMessageErrorInsertSiteSources").show();
		$("#showMessageErrorInsertSiteSources").fadeIn().delay(3000).fadeOut();
	} else {
	
		if(language == ''){
			$("#showMessageErrorlanguageForTranslateSources").show();
			$("#showMessageErrorlanguageForTranslateSources").fadeIn().delay(3000).fadeOut();
	} else {
		
		if(category == ''){
			$("#showMessageErrorChooseCategorySources").show();
			$("#showMessageErrorChooseCategorySources").fadeIn().delay(3000).fadeOut();
		} else {
		
		var validUrl = /^(ftp|http|https):\/\/[^ "]+$/.test(site);
		
		if(validUrl == true){
			if(site.length < 100){
	$("#ListOfAssignedSitesLanguages").show();	
		
	// Append table row after click on button ADD CATEGORY:
	$("#displayTableSitesLanguages").append('<tr id="showSitesLanguages"><td class="tableNewBorder" name="sites[]" align="center" id="sites">' + sites + '</td><td class="tableNewBorder" name="languages[]" align="center" id="languages">' + languages +'</td><td class="tableNewBorder" align="center"><img style="cursor:pointer" src="/images/ui/buttons/btn_delete.png"  id="removeSitesLanguages"></td></tr>');
	
	$("#displayTableSitesLanguages").on('click','#removeSitesLanguages',function(){
        $(this).parent().parent().remove();
    });
   } else {
	   	$("#showErrorMessageForLengthSource").show();
	  	$("#showErrorMessageForLengthSource").fadeIn().delay(3000).fadeOut();
   }
  } else {
	  	$("#showErrorMessageForSource").show();
	  	$("#showErrorMessageForSource").fadeIn().delay(3000).fadeOut();
  }
    
    }
    
   }
   
  }
  
  $("#saveReputation").css({"marginTop": "100px", "marginLeft": "800px"});
}

function updateSiteReputation(){
	var site = $("#SiteSourceReputationUpdate").val();
	var language = $("#languageSourcesUpdate").val();
	
	var sites = [];
	var languages = [];
	
	sites.push(site);
	languages.push(language);
	
	console.log(sites);
	console.log(languages);

	// Check condition if array categories has duplicate values:
	
   var $tableRows = $("#displayTableSitesLanguagesUpdate tr");
   var $rowsToMark = $();

    $tableRows.each(function(n) {
        var id = this.id;
        var categoriesTableRows = $(this).find('#sitesUpdate').html();

        $tableRows.each(function(n) {
            var $this;
            if (this.id != id) {
                $this = $(this);
                
                if ($this.find('#sitesUpdate').html() == sites) {
                    alert("You've already selected this site!");
                    $(this).remove();
              		
                } else {
                	return true;
                }
            }
        });
    });
  
    if(site == ''){
		alert("Please complete field of site!");
	} else {
	
		if(language == ''){
			alert("Please choose language!");
	} else {
		
		 var validUrlUpdate = /^(ftp|http|https):\/\/[^ "]+$/.test(site);
		 
	if(validUrlUpdate == true){
		
		if(site.length < 100){
	$("#ListOfAssignedSitesLanguagesUpdate").show();
	
	// Append table row after click on button ADD CATEGORY:
	$("#displayTableSitesLanguagesUpdate").append('<tr id="showSitesLanguagesUpdate"><td class="tableNewBorder" name="sitesUpdate[]" align="center" id="sitesUpdate">' + sites + '</td><td class="tableNewBorder" name="languagesUpdate[]" align="center" id="languagesUpdate">' + languages +'</td><td class="tableNewBorder" align="center"><img style="cursor:pointer" src="/images/ui/buttons/btn_delete.png"  id="removeSitesLanguagesUpdate"></td></tr>');
	
	$("#displayTableSitesLanguagesUpdate").on('click','#removeSitesLanguagesUpdate',function(){
        $(this).parent().parent().remove();
    });
    
     } else {
	   	$("#showErrorMessageForLengthSourceUpdate").show();
	  	$("#showErrorMessageForLengthSourceUpdate").fadeIn().delay(3000).fadeOut();
   }
    
  } else {
   $("#showErrorMessageForSourceUpdate").show();
  	$("#showErrorMessageForSourceUpdate").fadeIn().delay(3000).fadeOut();
  }
 	

}

}

}

function removeRowSitesLanguages(){
		$('#displayTableSitesLanguagesUpdate').on('click', '#removeSitesLanguagesUpdate', function() { 
	    	$(this).closest("tr").remove();
		});
	}
	
// SEARCH OPTION FOR SOURCE REPUTATION:

function searchDataSourcesReputation(){
	
	var searchDataSourcesReputation = $("#searchDataSourcesReputation").val();
	
	$.ajax({
		url: '/AIntuition/ajax/sources/searchDataSourcesReputation.php',
		type: 'POST',
		data: {searchDataSourcesReputation: searchDataSourcesReputation},
		context: document.body,
		success: function(data){
			$("#displayDataFilter").html(data);
			$("#displayDataFilter").show();
		}
	});
}

function searchDataSourcesReputationAfterDelete(){
	
	var searchDataSourcesReputation = $("#searchDataSourcesReputationAfterDelete").val();
	
	$.ajax({
		url: '/AIntuition/ajax/sources/searchDataSourcesReputation.php',
		type: 'POST',
		data: {searchDataSourcesReputation: searchDataSourcesReputation},
		context: document.body,
		success: function(data){
			$("#displayDataFilterAfterDelete").html(data);
			$("#displayDataFilterAfterDelete").show();
		}
	});
}
///////////////////////////////////////////////////////////////// SAVE, UPDATE, DELETE SOURCES(REPUTATION) - BEGIN /////////////////////////////////////////////////////////

function saveSourcesReputation(){
	var categoryReputation = $("#chooseCategorySources").val();
	var SiteSourceReputation = $("#SiteSourceReputation").val();
	var languageReputation = $("#languageSources").val();
	
	var categories = new Array();
	
	$("input[name='chooseCategoriesSources[]']:checked").each(function(){
		categories.push(this.value);
	});
      
	console.log(categories);
	
	// Sites:	
	var sites = [];
	$('#displayTableSitesLanguages tr td#sites').each(function(){
      var site = $(this).text();
      
      sites.push(site);
      
	});
	console.log(sites);
	
	// Languages:
	var languages = [];
	$('#displayTableSitesLanguages tr td#languages').each(function(){
      var language = $(this).text();
      languages.push(language);
      
	});
	console.log(languages);
	
	// Check length of field site:
	if(SiteSourceReputation.length > 100){
		$("#showErrorMessageForLengthSource").fadeIn().delay(3000).fadeOut();
	}
	
	//var validUrl = /^(www):\/\/[^ "]+$/.test(SiteSourceReputation); // validate url.
	//var validUrl = /^(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(SiteSourceReputation);
	var validUrl = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(SiteSourceReputation);
	
	
	if(SiteSourceReputation !== '' && languageReputation !== '' && categories.length != 0){
	
	if(validUrl == false){
		$("#showErrorMessageForSource").fadeIn().delay(3000).fadeOut();
	} else {
	
	var conf = confirm("Do you want to save this data?");
	
	if(conf == true){
	
	
	
	$.ajax({
		url:"/AIntuition/ajax/save/saveSourcesReputation.php", // Specifies the URL to send the request to.
		type: 'POST',
		data: {categoryReputation: categoryReputation, SiteSourceReputation: SiteSourceReputation, languageReputation: languageReputation, sites: sites, languages: languages, categories: categories},		
	    context : document.body,
	    complete: function(){ // A function to run when the request is finished (after sucess and error function).
        	cursorLoaderHide();
        },	
		success:function(data){ // A function to be run when the request succeeds.
			$('#displayTableSourcesReputation').html(data);
			$('#displayTableSourcesReputation').show();
			$("#ListOfSourcesReputation").hide();
			$("#ListOfSourcesReputationUpdate").hide();
			$("#ListOfSourcesReputationDelete").hide();
			$("#messageForSaveDataOfSourcesReputation").fadeIn().delay(3000).fadeOut();
		}
	});
	
	} 
	
	}
	
	} else {
		if(SiteSourceReputation == ''){
			$("#showMessageErrorInsertSiteSources").show();
			$("#showMessageErrorInsertSiteSources").fadeIn().delay(3000).fadeOut();
		} 
		
		if(languageReputation == ''){
			$("#showMessageErrorlanguageForTranslateSources").show();
			$("#showMessageErrorlanguageForTranslateSources").fadeIn().delay(3000).fadeOut();
		} 
		
		if(categories.length == 0){
			$("#showMessageErrorChooseCategorySources").show();
			$("#showMessageErrorChooseCategorySources").fadeIn().delay(3000).fadeOut();
		}
	}
}

function updateSourcesReputationForm(SourcesReputationID){
	$.ajax({
		url:"/AIntuition/ajax/update/updateSourcesReputationForm.php?SourcesReputationID=" + SourcesReputationID, // Specifies the URL to send the request to.
		type: 'POST',
		data: {SourcesReputationID: SourcesReputationID},		
	    context : document.body,
	    complete: function(){ // A function to run when the request is finished (after sucess and error function).
        	cursorLoaderHide();
        },	
		success:function(data){ // A function to be run when the request succeeds.
			$('#updateMessageSourcesReputationForm').html(data);
			$('#updateMessageSourcesReputationForm').show();
			$('#SourcesReputationFormForSave').hide();
			$("#ListOfSourcesReputation").show();
			$("#ListOfSourcesReputationSave").hide();
			$("#ListOfSourcesReputationDelete").hide();
			$("#displayTableSourcesReputation").show();
			$("#ListOfSourcesReputation").css('margin-top',"0px");
			$("#divSaveSourcesForm").hide();			
		}
	});
	
	
	//$("#ListOfSourcesReputation").css("marginTop", "500px");
}

function updateSourcesReputation(SourcesReputationID){
	var categoryReputation = $("#chooseCategorySourcesUpdate").val();
	var SiteSourceReputation = $("#SiteSourceReputationUpdate").val();
	var languageReputation = $("#languageSourcesUpdate").val();
	
	var sites = [];
	$('#displayTableSitesLanguagesUpdate tr td#sitesUpdate').each(function(){
      var site = $(this).text();
      
      sites.push(site);
      
	});
	console.log(sites);
	
	// Categories:
	var categories = new Array();
	
	$("input[name='chooseCategoriesSourcesUpdate[]']:checked").each(function(){
		categories.push(this.value);
	});
      
	console.log(categories);
	
	// VALIDATION URL SOURCE:
	var validUrl = /^(ftp|http|https):\/\/[^ "]+$/.test(SiteSourceReputation); // validate url.
	
	if(validUrl == false){ // Check condition and prints message if URL is not valid.
		//$("#showErrorMessageForSourceUpdate").show();
		//$("#showErrorMessageForSourceUpdate").fadeIn().delay(3000).fadeOut();
	}
	
	var languages = [];
	$('#displayTableSitesLanguagesUpdate tr td#languagesUpdate').each(function(){
      var language = $(this).text();
      languages.push(language);
      
	});
	console.log(languages);
	
	var conf = confirm("Do you want to update this data?");
	
	if(conf == true){
	
	$.ajax({
		url:"/AIntuition/ajax/update/updateSourcesReputation.php?SourcesReputationID=" + SourcesReputationID, // Specifies the URL to send the request to.
		type: 'POST',
		data: {categories: categories, SiteSourceReputation: SiteSourceReputation, languageReputation: languageReputation, SourcesReputationID: SourcesReputationID, sites: sites, languages: languages},		
	    context : document.body,
	    complete: function(){ // A function to run when the request is finished (after sucess and error function).
        	cursorLoaderHide();
        },	
		success:function(data){ // A function to be run when the request succeeds.
			$('#displayTableSourcesReputation').html(data);
			$('#displayTableSourcesReputation').show();
			$("#ListOfSourcesReputation").hide();
			$("#ListOfSourcesReputationSave").hide();
			$("#ListOfSourcesReputationDelete").hide();
			$("#messageForUpdateDataOfSourcesReputation").fadeIn().delay(3000).fadeOut();
		}
	});
	
	
	
	}
}

function deleteSourcesReputation(SourcesReputationID){
	
	var conf = confirm("Do you want to delete this data?");
	
	if(conf == true){
	
	$.ajax({
		url: '/AIntuition/ajax/delete/deleteSourcesReputation.php?SourcesReputationID=' + SourcesReputationID,
		type: 'POST',
		data: {SourcesReputationID: SourcesReputationID},
		context: document.body,
		success: function(data){
			$("#displayTableSourcesReputation").html(data);
			$("#displayTableSourcesReputation").show();
			$("#ListOfSourcesReputation").hide();
			$("#ListOfSourcesReputationSave").hide();
			$("#ListOfSourcesReputationUpdate").hide();
			$("#messageForDeleteDataOfSourcesReputation").fadeIn().delay(3000).fadeOut();
		}
	});
	
	}
}

function cancelSourcesReputation(){
	$('#SourcesReputationFormForSave').show();
	$("#divSaveSourcesForm").show();
	$('#ListOfSourcesReputation').css("margin-top", "100px");
	$('#SourcesReputationFormForUpdate').hide();
}
///////////////////////////////////////////////////////////////// SAVE, UPDATE, DELETE SOURCES(REPUTATION) - END /////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////// SOURCES END /////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////// DISPLAY ORGANIGRAM EMPLOYEE //////////////////////////////////////////////////////

function displayLevelOrganigram(){
	$.ajax({
	        url:'/AIntuition/detailsOrganigram/showDetailsOrganigram.php',  // Specifies the URL to send the request to.
	        type:'POST', // Specifies the type of request. (GET or POST).
	        context : document.body,
	        success: function(data){ // A function to be run when the request succeeds.
	           $('#showDetailsOrganigram').html(data);
	           $('#showDetailsOrganigram').show();	  
	        }
	    });	
	    
	$('html, body').animate({ scrollTop: $('#showDetailsOrganigram').offset().top }, 'slow');
}

function updateOrganigramAIntuition(aIntuitionHoldingOrganigramID){
	$.ajax({
	        url:'/AIntuition/ajax/update/listForUpdateOrganigramAIntuition.php?aIntuitionHoldingOrganigramID=' + aIntuitionHoldingOrganigramID,  // Specifies the URL to send the request to.
	        type:'POST', // Specifies the type of request. (GET or POST).
	        data: {aIntuitionHoldingOrganigramID: aIntuitionHoldingOrganigramID}, // Specifies data to be sent to the server.
	        context : document.body,
	        success: function(data){ // A function to be run when the request succeeds.
	           $('#showMessageUpdate').html(data);
	           $('#showMessageUpdate').show();	  
	        }
	    });	
	    
	$('html, body').animate({ scrollTop: $('#updateAIntuition').offset().top }, 'slow');
}





function cancelUpdateAIntuition(){
	$('#ChooseCategoryForUpdateThisAIntuition').hide();
}

function showHoldingOrganigram(employeeID, levelOrganigram){
	$.ajax({
	        url:'/AIntuition/detailsOrganigram/showChooseCategoryOrganigram.php?employeeID=' + employeeID + '&levelOrganigram=' + levelOrganigram,  // Specifies the URL to send the request to.
	        type:'POST', // Specifies the type of request. (GET or POST).
	        data: {employeeID: employeeID, levelOrganigram: levelOrganigram}, // Specifies data to be sent to the server.
	        success: function(data){ // A function to be run when the request succeeds.
	           $('#ChooseCategoryForThisAIntuition').html(data);
	           $('#ChooseCategoryForThisAIntuition').show();	  
	        }
	    });	
	    
	    $('html, body').animate({ scrollTop: $('#ChooseCategoryForThisAIntuition').offset().top }, 'slow');
}


///////////////////////////////////////////////////////////////// SAVE, UPDATE, DELETE AINTUITION - BEGIN //////////////////////////////////////////////////////////////////



// SHOW FORM FOR UPDATE:
function updateAIntuitionForm(AIntuitionID){
	
	$.ajax({
	        url:'/AIntuition/ajax/updateCategory/displayStatusAIntuitionUpdate.php?AIntuitionID=' + AIntuitionID, // Specifies the URL to send the request to.
	        type:'POST', // Specifies the type of request. (GET or POST).  
	        data: {AIntuitionID: AIntuitionID}, // Specifies data to be sent to the server.
	        context: document.body,
	        success: function(data){ // A function to be run when the request succeeds.
	           $('#backAI').show();
	           $('#saveAIntuition').hide();
	           $('.listOfSubCategory').hide();
	           $('#displayFormForUpdate').html(data);
	           $('#displayFormForUpdate').show(); 
	           $("#displayStatus").hide();
			   $("#holdingIntuitionArea").hide();
			   $("#fieldsetBA").hide();
			   $("#fieldsetBU").hide(); 
			   $("#SelectInutitionAreaLabel").hide(); 
			   $("#holdingLabel").hide(); 
			   $("#CategoryNameLabel").hide();  
	        }      
	    });	
	    
	// $('html, body').animate({ scrollTop: $('#updateAIntuition').offset().top }, 'slow');
}



function cancelUpdateForm(){
	$("#containerUpdateForm").hide();
	$("#SelectInutitionAreaLabel").hide();
	$("#holdingLabel").hide();
	$("#CategoryNameLabel").hide();
}

///////////////////////////////////////////////////////////////// SAVE, UPDATE, DELETE AINTUITION - END //////////////////////////////////////////////////////////////////


function hideDetailOrganigram(){
	$("#ShowDetailOrganigram").hide();    
}

function displayMainCategory(employeeProfileID){
	var category = [];
	$('#chooseCategory input:checked').each(function() {
	    category.push($(this).attr('value'));
	});
	categories=JSON.stringify(category);
	employeeProfileID = $("#employeeID").val();
	
	$.ajax({
	        url:'/AIntuition/ajax/category/listCategories.php?employeeProfileID=' + employeeProfileID, // Specifies the URL to send the request to.
	        type:'POST', // Specifies the type of request. (GET or POST).  
	        data: {employeeProfileID: employeeProfileID, categories:categories}, // Specifies data to be sent to the server.
	        context: document.body,
	        success: function(data){ // A function to be run when the request succeeds.
	           $('.aiOrganigram').hide();
	           $('#newProfile').hide();
	           $('#ListOfAIntuitionProfile').hide();
	           $('#showDetailsOrganigram').hide();
	           $('#ChooseCategoryForThisAIntuition').hide();
	           $('.zoomIn').hide();
	           $('.zoomOut').hide();
	           $('#backAI').show();
	           $('#showMainCategory').html(data);
	           $('#showMainCategory').show();
	        }      
	    });	
}

function displayMainCategoryForUpdate(AIntuitionID){
		
	$.ajax({
	        url:'/AIntuition/ajax/update/mainCategoryForUpdate.php?AIntuitionID=' + AIntuitionID, // Specifies the URL to send the request to.
	        type:'POST', // Specifies the type of request. (GET or POST).  
	        data: {AIntuitionID: AIntuitionID}, // Specifies data to be sent to the server.
	        context: document.body,
	        success: function(data){ // A function to be run when the request succeeds.
	           $('.aiOrganigram').hide();
	           $("#ChooseCategoryForUpdateThisAIntuition").hide();
	           $('#newProfile').hide();
	           $('#ListOfAIntuitionProfile').hide();
	           $('#showDetailsOrganigram').hide();
	           $('#ChooseCategoryForThisAIntuition').hide();
	           $('.zoomIn').hide();
	           $('.zoomOut').hide();
	           $('#backAI').show();
	           $('#showMainCategory').html(data);
	           $('#showMainCategory').show();
	        }      
	    });	
}

function backAIntuition(){
     	window.history.back(); 		
	}
	
function backChooseCategory(){
     	window.location.reload(); // Refresh Page.		
	}



function getBusinessUnits(categoryID, businessAreaID, businessUnits)
{
	if($("#checkBA"+businessAreaID+"Cat"+categoryID).is(':checked'))
	{
		$.each(businessUnits, function(businessUnitID, businessUnitName){
			var trClass="businessArea"+businessAreaID+"Category"+categoryID;
			
			$("#tblBusinessUnits"+categoryID+" tbody").append("<tr class='"+trClass+"'><td>"+businessUnitName+"</td><td><input type='checkbox' value='"+businessUnitID+"'></td></tr>");
	    });
	}	
	else
	{	
		$("#tblBusinessUnits"+categoryID+" tr.businessArea"+businessAreaID+"Category"+categoryID).remove();
	}
}

function frequency(type, categoryID)
{
	var textLabel="";
	var count;
	if(type=="hourly")
	{
		textLabel="Frequency Per Hour";
		count=24;
	}
	else if(type=="daily")
	{
		textLabel="Frequency Per Day";
		count=31;
	}
	else
	{
		textLabel="Frequency Per Month";
		count=12;
	}
	$("#label"+categoryID).text(textLabel);
	$('#frequencyValue'+categoryID)
		    .find('option')
		    .remove()
		    .end();
     for(var i=1;i<=count;i++)
     {
     	$('#frequencyValue'+categoryID).append('<option value="'+i+'">'+i+'</option>');
     }
}

function holding(categoryID)
{
	if($("#holding"+categoryID).is(":checked"))
	{
		$("#divBusinessUnit"+categoryID).css("display","none");
		$("#divBusinessArea"+categoryID).css("display","none");
	}
	else
	{
		$("#divBusinessUnit"+categoryID).css("display","table-cell");
		$("#divBusinessArea"+categoryID).css("display","table-cell");
	}
}
function saveCategoryData(categoryID, employeeID)
{
	var validate=categoryValidation(categoryID);
	if(!validate)
	{
		return false;
	}
	var subCategoryID="";
	var holding=0;
	var businessAreas=[];
	var businessUnits=[];
	var status="";
	var handlingType="";
	var frequencyType="";
	var frequencyValue="";
	var expirationDate="";
	var sendDate="";
	var sensibility;
	
	if($("#holding"+categoryID).is(":checked"))
	{
		holding=1;
	}
	
	if(holding==0)
	{
		$("#tblBusinessAreas"+categoryID+" input:checkbox:checked").each(function(){
			businessAreas.push($(this).attr('value'));
		});	
		
		$("#tblBusinessUnits"+categoryID+" input:checkbox:checked").each(function(){
			businessUnits.push($(this).attr('value'));
		});		
	}
	businessAreas=JSON.stringify(businessAreas);
	businessUnits=JSON.stringify(businessUnits);
	status=$("#AIntuitionStatus"+categoryID).val();
	
    handlingType=$("input[name=handlingType"+categoryID+"]:checked").val();
    frequencyType=$("input[name=frequency"+categoryID+"]:checked").val();
    frequencyValue=$("#frequencyValue"+categoryID).val();
	subCategoryID=$("#selSubCategory"+categoryID).val();
	expirationDate=$("#AIntuitionExpirationDate"+categoryID).val();
	
	sendData={
				type:'save', holding:holding, businessAreas:businessAreas, subCategoryID:subCategoryID,
	          	businessUnits:businessUnits, status:status, handlingType:handlingType, categoryID:categoryID,
	          	frequencyType:frequencyType, frequencyValue:frequencyValue, expirationDate:expirationDate, employeeID:employeeID
	         };
	
	// Only for AI that includes mental lexicon 
	countPositive = $("#countPositive"+categoryID).val();
	countNegative = $("#countNegative"+categoryID).val();
	if(countPositive != undefined && countNegative != undefined){
		sensibility = {countPositive:countPositive, countNegative:countNegative};
		sensibility = JSON.stringify(sensibility);	
		sendData["sensibility"] = sensibility;
	}
	         
	$.ajax({ 
		url: '/AIntuition/ajax/category/category.php',
		type: 'POST', 
		data: sendData,
		content: document.body,
		success: function(data){ 
			var data=JSON.parse(data);
			console.log(data);
			if(data.result!="success")
			{
				alert(data.data);
			}
			else
			{
				var subCategoryName=$("#selSubCategory"+categoryID+" option:selected").text();
				$("#table"+categoryID+" tbody").append("<tr><td class='tableNewBorder' align='center'>"+subCategoryName+"</td><td class='tableNewBorder' align='center'><img style='cursor:pointer'  src='/images/ui/buttons/btn_edit.png' onclick='editAintuition("+data.data.aintuitionID+", "+categoryID+","+employeeID+")'> </td><td class='tableNewBorder' align='center'><img style='cursor:pointer' id='removeTr"+data.data.aintuitionID+"' src='/images/ui/buttons/btn_delete.png' onclick='deleteAIntuition("+data.data.aintuitionID+", "+categoryID+")'></td></tr>");
				clearCategoryForm(categoryID);
				$("#message"+categoryID).html("<span class='red'>Data has been saved.</span>");
			}
		}
	});
}

function updateCategoryData(aintuitionID, categoryID, employeeID)
{
	var validate=categoryValidation(categoryID);
	if(!validate)
	{
		return false;
	}
	var subCategoryID="";
	var holding=0;
	var businessAreas=[];
	var businessUnits=[];
	var status="";
	var handlingType="";
	var frequencyType="";
	var frequencyValue="";
	var expirationDate="";
	var sendData="";
	
	if($("#holding"+categoryID).is(":checked"))
	{
		holding=1;
	}
	
	if(holding==0)
	{
		$("#tblBusinessAreas"+categoryID+" input:checkbox:checked").each(function(){
			businessAreas.push($(this).attr('value'));
		});	
		
		$("#tblBusinessUnits"+categoryID+" input:checkbox:checked").each(function(){
			businessUnits.push($(this).attr('value'));
		});		
	}
	businessAreas=JSON.stringify(businessAreas);
	businessUnits=JSON.stringify(businessUnits);
	status=$("#AIntuitionStatus"+categoryID).val();
	
    handlingType=$("input[name=handlingType"+categoryID+"]:checked").val();
    frequencyType=$("input[name=frequency"+categoryID+"]:checked").val();
    frequencyValue=$("#frequencyValue"+categoryID).val();
	subCategoryID=$("#selSubCategory"+categoryID).val();
	expirationDate=$("#AIntuitionExpirationDate"+categoryID).val();
	
	sendData={
				type:'update', holding:holding, businessAreas:businessAreas, subCategoryID:subCategoryID,
	          	businessUnits:businessUnits, status:status, handlingType:handlingType, categoryID:categoryID,
	          	frequencyType:frequencyType, frequencyValue:frequencyValue, expirationDate:expirationDate, aintuitionID:aintuitionID
	         };
	
	// Only for AI that includes mental lexicon 
	countPositive = $("#countPositive"+categoryID).val();
	countNegative = $("#countNegative"+categoryID).val();
	if(countPositive != undefined && countNegative != undefined){
		sensibility = {countPositive:countPositive, countNegative:countNegative};
		sensibility = JSON.stringify(sensibility);	
		sendData["sensibility"] = sensibility;
	}         
	         
	$.ajax({ 
		url: '/AIntuition/ajax/category/category.php',
		type: 'POST', 
		data: sendData,
		content: document.body,
		success: function(data){ 
			var data=JSON.parse(data);
			if(data.result=="success")
			{
				$("#saveButton"+categoryID).attr("onclick","saveCategoryData("+aintuitionID+","+employeeID+","+employeeID+")");
				$("#saveButton"+categoryID).attr("value","Save");
				$("#message"+categoryID).html("<span class='red'>Data has been updated.</span>");
				clearCategoryForm(categoryID);
			}
		}
	});
}


function deleteAIntuition(aintuitionID, categoryID){
	
	var conf = confirm("Do you want to delete this Category of AIntuition?");
	if(conf == true){
		$(document).on ("click", '#removeTr'+aintuitionID, function () {
	       $(this).closest('tr').remove();
	    });
		$.ajax({
					url: '/AIntuition/ajax/category/category.php',
					type: 'POST',
					data: {aintuitionID: aintuitionID, type:'delete'}, // Specifies data to be sent to the server.
					contet: document.body,
					success: function(data)
					{ 
						
					}
				});	
				
	}
}

function editAintuition(aintuitionID, categoryID, employeeID)
{
	$.ajax({
			url: '/AIntuition/ajax/category/category.php',
			type: 'POST',
			data: {aintuitionID: aintuitionID, type:'edit'}, // Specifies data to be sent to the server.
			contet: document.body,
			success: function(data)
			{ 
				 var data=JSON.parse(data);
				 data=data.data;
				 
				 subCategoryFormValidation(categoryID, data.subCategoryID, data.sensibility);
				 
				 $("#saveButton"+categoryID).attr("onclick","updateCategoryData("+aintuitionID+","+categoryID+","+employeeID+")");
				 $("#saveButton"+categoryID).attr("value","Update");
				 $("#selSubCategory"+categoryID).prop('disabled', false);
				 $("#selSubCategory"+categoryID).val(data.subCategoryID);
				 //$("#selSubCategory"+categoryID).find("option[value=" + data.subCategoryID +"]").attr('selected', true);
				 $("#selSubCategory"+categoryID).prop('disabled', true);
				 $("#AIntuitionStatus"+categoryID).val(data.status);
				 $('input[name=handlingType'+categoryID+'][value=' + data.handlingType + ']').prop('checked',true);			
				 for(var key in data.frequency)
				 {
				 	var handlingType=key.toLowerCase();
				 	var frequencyValue=data.frequency[key];
				    $('input[name=frequency'+categoryID+'][value=' + handlingType + ']').prop('checked',true);
				    $("#frequencyValue"+categoryID).val(frequencyValue);
				 }
				 $("#AIntuitionExpirationDate"+categoryID).val(data.expirationDate);
				 if(data.holding =='1')
				 {
				 	$("#holding"+categoryID).prop('checked', true);
				 	$("#divBusinessUnit"+categoryID).css("display","none");
		            $("#divBusinessArea"+categoryID).css("display","none");
				 }
				 else
				 {
				 	$("#holding"+categoryID).prop('checked', false);
				 	$("#divBusinessUnit"+categoryID).css("display","table-cell");
					$("#divBusinessArea"+categoryID).css("display","table-cell");
					
					if(data.businessAreas!="null")
					{
						$("#tblBusinessAreas"+categoryID+" tr").each(function(){
							$.each(data.businessAreas, function(i, value){
								var chckValue=$(this).closest('tr').find('input:checkbox').val();
							    if(chckValue=value)
							    {
							    	$('#checkBA'+value+'Cat'+categoryID).prop('checked',true);
							    }	
							});
						});
					}
			        
			        $("#tblBusinessUnits"+categoryID+" tbody").empty();
			        $.each(data.businessUnitsAll, function(baID, bus){
			        	$.each(bus, function(i, value){
			        		for(var key in value)
							{
							 	var businessUnitID=key;
							 	var businessUnitName=value[key];
							}
							var trClass="businessArea"+baID+"Category"+categoryID;
							var checked='';
							$.each(data.businessUnitsChecked, function(buKey, buIDChecked){
								if(businessUnitID==buIDChecked)
								{
									checked="checked = 'checked'";
								}
							});
							$("#tblBusinessUnits"+categoryID+" tbody").append("<tr class='"+trClass+"'><td>"+businessUnitName+"</td><td><input type='checkbox' "+checked+" value='"+businessUnitID+"'></td></tr>");
			        	});
			        });
					
				 }
			}
		});	
}

function categoryValidation(categoryID)
{
	if($("#selSubCategory"+categoryID).val()=="" || $("#selSubCategory"+categoryID).val()=="--")
	{
		$("#selSubCategory"+categoryID).css('background','lightgray');
		$("#selSubCategory"+categoryID).focus();
		$("#message"+categoryID).html("<span class='red'>Please fill out this field.</span>");
		return false;
	}
	
	if(!$("#holding"+categoryID).is(":checked"))
	{
		var ba=false;
		$("#tblBusinessAreas"+categoryID+" input:checkbox:checked").each(function(){
			if($(this).attr('value'))
			{
			   ba=true;
			   return false;
			}
		});	
		if(!ba)
		{
			$("#message"+categoryID).html("<span class='red'>You must choose Business Area or Business Unit.</span>");
			return false;
		}
	}
	
	if($("#AIntuitionStatus"+categoryID).val()=="" || $("#AIntuitionStatus"+categoryID).val()=="--")
	{
		$("#AIntuitionStatus"+categoryID).css('background','lightgray');
		$("#AIntuitionStatus"+categoryID).focus();
		$("#message"+categoryID).html("<span class='red'>Please fill out this field.</span>");
		return false;
	}
	
	if($("#AIntuitionExpirationDate"+categoryID).val()=="")
	{
		$("#AIntuitionExpirationDate"+categoryID).css('background','lightgray');
		$("#AIntuitionExpirationDate"+categoryID).focus();
		$("#message"+categoryID).html("<span class='red'>Please fill out this field.</span>");
		return false;
	}
	
	return true;
}

function clearCategoryForm(categoryID)
{
	$("#selSubCategory"+categoryID).prop("disabled", false);
	$("#selSubCategory"+categoryID).val("--");
	$("#divBusinessUnit"+categoryID).css("display","table-cell");
	$("#divBusinessArea"+categoryID).css("display","table-cell");
	$("#tblBusinessAreas"+categoryID+" input:checkbox:checked").each(function(){
		$(this).prop('checked', false);
	});
	$("#tblBusinessUnits"+categoryID+" tbody").empty();
	$("#holding"+categoryID).prop("checked", false);
	$("#AIntuitionStatus"+categoryID).val("--");
	$('input[name=handlingType'+categoryID+'][value="private"]').prop('checked',true);
	$('input[name=frequency'+categoryID+'][value="hour"]').prop('checked',true);
	$("#frequencyValue"+categoryID).val("1");
	$("#AIntuitionExpirationDate"+categoryID).val("");
	$("#divSensibility"+categoryID).empty();
}

function subCategoryFormValidation(categoryID, subCategoryID, sensibility){
	
	var sendData = {categoryID: categoryID, subCategoryID: subCategoryID};
	
	if(sensibility != undefined){	
		sendData["sensibility"] = sensibility;
	}
	
	$.ajax({
		url: '/AIntuition/ajax/category/subCategoryFormValidation.php',
		type: 'POST',
		data: sendData, // Specifies data to be sent to the server.
		contet: document.body,
		success: function(data)
		{ 
			$("#divSensibility"+categoryID).html(data);
		}
	});			
}

function moveUnknownJobs(type, howMany)
{
    var sendData;
    var unknownJobes=[];
    if(type=="jobTitle")
    {
        if(howMany=="one")
        {
            var unknownJob=$("#selUnknownJobs").val();
            if(unknownJob=="" || unknownJob=="--" || unknownJob ==null)
            {
                alert("You must choose unknown job!");
                return false;
            }
            unknownJobes.push(unknownJob);
        }
        else
        {
             $("#selUnknownJobs option").each(function(){
                unknownJobes.push($(this).attr("value"));
            }); 
        }
        unknownJobes=JSON.stringify(unknownJobes);
        sendData={type:"moveUnknownJobsAsKnown", unknownJobes:unknownJobes};
    }
    else
    {
        var jobTitle=$("#selJobTitles").val();
      
        if(jobTitle=="" || jobTitle=="--" || jobTitle ==null || jobTitle=="undefined")
        {
            alert("You must choose job title!");
            return false;
        }
        if(howMany=="one")
        {
            var unknownJob=$("#selUnknownJobs").val();
            if(unknownJob=="" || unknownJob=="--" || unknownJob ==null)
            {
                alert("You must choose unknown job!");
                return false;
            }
            unknownJobes.push(unknownJob);
        }
        else
        {
            $("#selUnknownJobs option").each(function(){
                unknownJobes.push($(this).attr("value"));
            }); 
        }
        unknownJobes=JSON.stringify(unknownJobes);
        sendData={type:"moveUnknownJobsAsAlias", jobTitle:jobTitle, unknownJobes:unknownJobes};
    }
    //console.log(sendData);
    $.ajax({
           url:"/AIntuition/ajax/delegation/delegation.php",
           data:sendData,
           type:"POST",
           success:function(data){
                var data         = JSON.parse(data);
                var unknownJobes = data.data.unknownJobes;
                var  newJobes    = data.data.newJobes;
                var newJobAliases= data.data.newJobAliases;
                if(unknownJobes!==undefined && unknownJobes!=null)
                {
                   $.each(unknownJobes, function(id, val){
                        $("#selUnknownJobs option[value='"+id+"']").remove();
                    });
                }
                if(type=="jobTitle" && newJobes!=undefined && newJobes!=null)
                {
                    $.each(newJobes, function(id, val){
                        $("#selJobTitles").append('<option value='+id+'>'+val+'</option>');
                    });
                }
                else if(type=="jobAlias" && newJobAliases!=undefined && newJobAliases!=null)
                {
                    $.each(newJobAliases, function(id, val){
                        $("#listOfJobAlias").append("<div class='rpaBusinessDuties'>"+val+"\
                                                        <span class='exitRpaBusinessDuties' id='alias"+id+"' data-id='"+id+"' onclick='deleteJobAliasAndInuition(\"alias\",this)'>X</span>\n\
                                                    </div>");
                    });
                    
                } 
                 $("#message").html("<span class='red'>"+data.message+"</span>");
           }
       });
    
}

function moveIntuitions()
{
    var intuitions=[];
    var sendData="";
    var jobTitle=$("#selJobTitles").val();
    
    $("#tblIntuitions input:checkbox:checked").each(function(){
        intuitions.push($(this).attr('value'));
    });
    
    if(jobTitle=="" || jobTitle=="--" || jobTitle ==null)
    {
        alert("You must choose job title");
        return false;
    }
    else if(!intuitions.length)
    {
        alert("You must check at least one intuition");
        return false;
    }
    else
    {
       intuitions=JSON.stringify(intuitions);
       sendData={type:"addIntuitions", jobTitle:jobTitle, intuitions:intuitions};
       
       $.ajax({
           url:"/AIntuition/ajax/delegation/delegation.php",
           data:sendData,
           type:"POST",
           success:function(data){
                var data=JSON.parse(data);
                var intuitions=data.data.intuitions;
                console.log(data);
                if(intuitions!=undefined && intuitions!=null)
                {
                    $.each(intuitions, function(id, val){
                      $("#listOfIntuitions").append("<div class='rpaBusinessDuties'>"+val+"<span class='exitRpaBusinessDuties' id='intuition"+id+"' data-id='"+id+"' onclick='deleteJobAliasAndInuition(\"intuition\",this)'>X</span></div>");
                    });
                }
                $("#message").html("<span class='red'>"+data.message+"</span>");
           }
       });
    }
    
    
}

function showIntuitionsAndJobAliases(jobTitleID)
{
    var jobTitleName=$("#selJobTitles option:selected").text();
    var sendData={jobTitleID:jobTitleID, type:"getIntuitionsAndJobAliases"};
    $.ajax({
           url:"/AIntuition/ajax/delegation/delegation.php",
           data:sendData,
           type:"POST",
           success:function(data){
                $("#listOfIntuitions").html("");
                $("#listOfJobAlias").html("");
                var data       = JSON.parse(data);
                var intuitions = data.data.intuitions
                var aliases    = data.data.aliases;
                if(intuitions!==undefined && intuitions!=null)
                {
                    $.each(intuitions, function(id, val){
                        $("#listOfIntuitions").append("<div class='rpaBusinessDuties'>"+val+"\
                                                            <span class='exitRpaBusinessDuties' id='"+id+"' data-id='"+id+"' onclick='deleteJobAliasAndInuition(\"intuition\",this)'>X</span>\n\
                                                        </div>");
                    });
                }
                
                if(aliases!==undefined && aliases!=null)
                {
                    $.each(aliases, function(id, val){
                        $("#listOfJobAlias").append("<div class='rpaBusinessDuties'>"+val+"\
                                                        <span class='exitRpaBusinessDuties' id='"+id+"' data-id='"+id+"' onclick='deleteJobAliasAndInuition(\"alias\",this)'>X</span>\n\
                                                    </div>");
                    });
                }
                
                $("#jobAliasForTitle").html("<span>Job Title Aliases for "+jobTitleName+"</span>");
                $("#intuitionsForJobTitle").html("<span>Intuitions for Job Title "+jobTitleName+"</span>");
           }
       });
}

function openModal(type)
{
    var sendData={type:type};
    $.ajax({
        url: "/AIntuition/ajax/delegation/modalJob.php",
        type: "POST",
        data: sendData,
        success: function (data) {
            $("#jobModal").show();
            $("#jobModal").html(data);
        }
    });
}

function saveJob(jobType)
{
    var value=$("#elementValue").val();
    var jobTitleID=$("#selJobTitles").val();
    if(value=="")
    {
        $("#modalErrorMessage").html("<span class='red'>Name can not be empty!</span>");
        return false;
    }
    
    if(jobType=="jobAlias" && (jobTitleID=="" || jobTitleID==null || jobTitleID=="--"))
    {
        $("#modalErrorMessage").html("<span class='red'>You must choose Job Title</span>");
        return false;
    }
  
    var sendData={type:"saveJob",jobType:jobType, value:value, jobTitleID:jobTitleID};
    $.ajax({
        url: "/AIntuition/ajax/delegation/delegation.php",
        type: "POST",
        data: sendData,
        success: function (data) {
           var data=JSON.parse(data);
           console.log(data.message);
           if(data.message!="" && data.message!=undefined)
           {
                $("#modalErrorMessage").html("<span class='red'>"+data.message+"</span>");
           }
           else
           {
                $('#jobModal').html('');
                if(jobType=="jobTitle")
                {
                     $("#selJobTitles").append('<option value='+data.data.jobTtileID+'>'+data.data.jobTitleName+'</option>');
                }
                else if(jobType=="jobAlias")
                {
                     $("#listOfJobAlias").append("<div class='rpaBusinessDuties'>"+data.data.jobAliasName+"\
                                                             <span class='exitRpaBusinessDuties' id='alias"+data.data.jobAliasID+"' data-id='"+data.data.jobAliasID+"' onclick='deleteJobAliasAndInuition(\"alias\",this)'>X</span>\n\
                                                         </div>");
                }
           }
           
        }
    });
}

function deleteJobAliasAndInuition(type, span)
{
    var valueID=$(span).attr("data-id");
    var id=$(span).attr("id");
    var jobTitleID=$("#selJobTitles").val();
    var sendData={type:"delete", deleteType:type, valueID:valueID, jobTitleID:jobTitleID};
    $.ajax({
        url: "/AIntuition/ajax/delegation/delegation.php",
        type: "POST",
        data: sendData,
        success: function (data) {
           
           $("#"+id).closest('div').remove();
           $("#"+id).remove();
        }
    });
    
}

function getAintuitionSubCategory(categoryID, intuitions)
{
   if($("#checkAICategory"+categoryID).is(':checked'))
    {
            $.each(intuitions, function(intuitionID, intuitionName){
                    var trClass="AICategory"+categoryID;
                    $("#tblIntuitions tbody").append("<tr class='"+trClass+"'><td>"+intuitionName+"</td><td><input type='checkbox' value='"+intuitionID+"'></td></tr>");
        });
    }	
    else
    {	
            $("#tblIntuitions tr.AICategory"+categoryID).remove();
    } 
}
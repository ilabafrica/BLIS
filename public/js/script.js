/**
 * Custom javascript function
 * @author  (c) @iLabAfrica
 */
$(function(){
	/**	HEADER
	 *   Username display
	 */
	$('.user-link').click(function(){
		$('.user-settings').toggle();
	});

	$('.user-profile .user-settings a').click(function(){
		$('.user-settings').toggle();
	});

	/*	LEFT SIDEBAR FUNCTIONS	*/
	
	/*  Click main menu */
	$('.main-menu').click(function(){

		$('.main-menu').removeClass('active');
		$(this).addClass('active');

		$('.main-menu').siblings().hide();
		$(this).siblings().show();
	});

	/**  USER 
	 *-  Load password reset input field
	 */

	$('a.reset-password').click(function() {
		if ( $('input.reset-password').hasClass('hidden')) {
				$('input.reset-password').removeClass('hidden');
		}else {
			$('input.reset-password').addClass('hidden');
		}
	});

	/*Submitting Profile edit, with password change validation*/
	$('.update-reset-password').click(function() {
			editUserProfile();
	});

	/** 
	 *	LAB CONFIGURATION 
	 */

	 /* Add another surveillance */
	$('.add-another-surveillance').click(function(){
		newSurveillanceNo = $(this).data('new-surveillance');
		var inputHtml = $('.addSurveillanceLoader').html();
		//Count new measures on the new measure button
		$('.surveillance-input').append(inputHtml);
		$('.surveillance-input .new').addClass('new-surveillance-'+newSurveillanceNo).removeClass('new');
		$(this).data('new-surveillance',  newSurveillanceNo+1).attr('data-new-surveillance',  newSurveillanceNo+1);
		addNewSurveillanceAttributes(newSurveillanceNo);
		delete newSurveillanceNo;
	});
	 
	 /* Add another disease */
	$('.add-another-disease').click(function(){
		newDiseaseNo = $(this).data('new-disease');
		var inputHtml = $('.addDiseaseLoader').html();
		//Count new measures on the new measure button
		$('.disease-input').append(inputHtml);
		$('.disease-input .new').addClass('new-disease-'+newDiseaseNo).removeClass('new');
		$(this).data('new-disease',  newDiseaseNo+1).attr('data-new-disease',  newDiseaseNo+1);
		addNewDiseaseAttributes(newDiseaseNo);
		delete newDiseaseNo;
	});

	/** 
	 *	MEASURES 
	 */

	 /* Add another measure */
	$('.add-another-measure').click(function(){
		newMeasureNo = $(this).data('new-measure');
		var inputHtml = $('.measureGenericLoader').html();
		//Count new measures on the new measure button
		$('.measure-container').append(inputHtml);
		$('.measure-container .new-measure-section').find(
			'.measuretype-input-trigger').addClass('new-measure-'+newMeasureNo);
		$('.measure-container .new-measure-section').find(
			'.measuretype-input-trigger').attr('data-new-measure-id',  newMeasureNo);
		$('.measure-container .new-measure-section').find(
			'.add-another-range').attr('data-new-measure-id',  newMeasureNo);
		$('.measure-container .new-measure-section').find(
			'.add-another-range').addClass('new-measure-'+newMeasureNo);
		$('.measure-container .new-measure-section').find(
			'.measurevalue').addClass('new-measure-'+newMeasureNo);
		$('.measure-container .new-measure-section').addClass(
			'measure-section new-'+newMeasureNo).removeClass('new-measure-section');
		$(this).data('new-measure',  newMeasureNo+1).attr('data-new-measure',  newMeasureNo+1);
		addNewMeasureAttributes(newMeasureNo);
		delete newMeasureNo;
	});

	 /* Add another measure range value */
	$('.measure-container').on('click', '.add-another-range', function(){
		var inputClass = [
			'.numericInputLoader',
			'.alphanumericInputLoader',
			'.alphanumericInputLoader',
			'.freetextInputLoader'
		]; 

		if ($(this).data('measure-id') === 0) {
			var newMeasureId = $(this).data('new-measure-id');
			var measureID = 'new-measure-'+newMeasureId;
		} else {
			var measureID = $(this).data('measure-id');
		}
		var measureTypeId = $('.measuretype-input-trigger.'+measureID).val() - 1;
		var inputHtml = $(inputClass[measureTypeId]).html();
		$(".measurevalue."+measureID).append(inputHtml);
		if ($(this).data('measure-id') != 0) {
			editMeasureRangeAttributes(measureTypeId,measureID);
		}else{
			addMeasureRangeAttributes(measureTypeId, newMeasureId);
		}
	});

	/*  load measure range input UI for the selected measure type */
	$( '.measure-container' ).on('change', '.measuretype-input-trigger', loadRangeFields);

	/*  re-load measure range input UI for the selected measure type on error */
	if ($('.measurevalue').is(':empty')){
		var measure_type = $( '.measuretype-input-trigger' ).val();
		if ( measure_type > 0 ) {
			loadRangeFields();
		}
	}

	/** GLOBAL DELETE	
	 *	Alert on irreversible delete
	 */
	$('.confirm-delete-modal').on('show.bs.modal', function(e) {
	    $('#delete-url').val($(e.relatedTarget).data('id'));
	});

	$('.btn-delete').click(function(){
		$('.confirm-delete-modal').modal('toggle');
		window.location.href = $('#delete-url').val();
	});

	UIComponents();

	/* Clicking the label of an radio/checkbox, checks the control*/
	$('span.input-tag').click(function(){
		$(this).siblings('input').trigger('click');
	});

	// Delete measure range

	$('body').on('click', '.measure-input .close', function(){
		$(this).parent().parent().remove();
	});

	// Delete measure

	$('.measure-container').on('click', '.close', function(){
		$(this).parent().parent().remove();
	});
	
	// Delete Surveillance entry

	$('.surveillance-input').on('click', '.close', function(){
		$(this).parent().parent().parent().remove();
	});

	// Delete Disease entry

	$('.disease-input').on('click', '.close', function(){
		$(this).parent().parent().parent().remove();
	});

	/** 
	 * Fetch Test results
	 */

	$('.fetch-test-data').click(function(){
		var testTypeID = $(this).data('test-type-id');
		var url = $(this).data('url');
		$.post(url, { test_type_id: testTypeID}).done(function(data){
			$.each($.parseJSON(data), function (index, obj) {
				console.log(index + " " + obj);
				$('#'+index).val(obj);
			});
		});
	});

	/** 
	 * Search for patient from new test modal
	 * UI Rendering Logic here
	 */

	$('#new-test-modal .search-patient').click(function(){
		var searchText = $('#new-test-modal .search-text').val();
		var url = location.protocol+ "//"+location.host+ "/patient/search";
		var output = "";
		var cnt = 0;
		$.post(url, { text: searchText}).done(function(data){
			$.each($.parseJSON(data), function (index, obj) {
				output += "<tr>";
				output += "<td><input type='radio' value='" + obj.id + "' name='pat_id'></td>";
				output += "<td>" + obj.patient_number + "</td>";
				output += "<td>" + obj.name + "</td>";
				output += "</tr>";
				cnt++;
			});
			$('#new-test-modal .table tbody').html( output );
			if (cnt === 0) {
				$('#new-test-modal .table').hide();
			} else {
				$('#new-test-modal .table').removeClass('hide');
				$('#new-test-modal .table').show();
			}
		});
	});


	/* 
	* Prevent patient search modal form submit (default action) when the ENTER key is pressed
	*/

	$('#new-test-modal .search-text').keypress(function( event ) {
		if ( event.which == 13 ) {
			event.preventDefault();
			$('#new-test-modal .search-patient').click();
		}
	});

	/** - Get a Test->id from the button clicked,
	 *  - Fetch corresponding test and default specimen data
	 *  - Display all in the modal.
	 */
	$('#change-specimen-modal').on('show.bs.modal', function(e) {
	    //get data-id attribute of the clicked element
	    var id = $(e.relatedTarget).data('test-id');
		var url = $(e.relatedTarget).data('url');

	    $.post(url, { id: id}).done(function(data){
		    //Show it in the modal
		    $(e.currentTarget).find('.modal-body').html(data);
	    });
	});
  

	/** Receive Test Request button.
	 *  - Updates the Test status via an AJAX call
	 *  - Changes the UI to show the right status and buttons
	 */
	$('.tests-log').on( "click", ".receive-test", function(e) {

		var testID = $(this).data('test-id');
		var specID = $(this).data('specimen-id');

		var url = location.protocol+ "//"+location.host+ "/test/" + testID+ "/receive";
		$.post(url, { id: testID}).done(function(){});

		var parent = $(e.currentTarget).parent();
		// First replace the status
		var newStatus = $('.pending-test-not-collected-specimen').html();
		parent.siblings('.test-status').html(newStatus);

		// Add the new buttons
		var newButtons = $('.accept-button').html();
		parent.append(newButtons);

		// Set properties for the new buttons
		parent.children('.accept-specimen').attr('data-test-id', testID);
		parent.children('.accept-specimen').attr('data-specimen-id', specID);

		// Now remove the unnecessary buttons
		$(this).siblings('.receive-test').remove();
		$(this).remove();
	});

	/** Accept Specimen button.
	 *  - Updates the Specimen status via an AJAX call
	 *  - Changes the UI to show the right status and buttons
	 */
	$('.tests-log').on( "click", ".accept-specimen", function(e) {

		var testID = $(this).data('test-id');
		var specID = $(this).data('specimen-id');
		var url = $(this).data('url');
		$.post(url, { id: specID}).done(function(){});

		var parent = $(e.currentTarget).parent();
		// First replace the status
		var newStatus = $('.pending-test-accepted-specimen').html();
		parent.siblings('.test-status').html(newStatus);

		// Add the new buttons
		var newButtons = $('.reject-start-buttons').html();
		parent.append(newButtons);
		var referButton = $('.start-refer-button').html();
		parent.append(referButton);

		// Set properties for the new buttons
		var rejectURL = location.protocol+ "//"+location.host+ "/test/" + specID+ "/reject";
		parent.children('.reject-specimen').attr('id',"reject-" + testID + "-link");
		parent.children('.reject-specimen').attr('href', rejectURL);

		var referURL = location.protocol+ "//"+location.host+ "/test/" + specID+ "/refer";
		parent.children('.refer-button').attr('href', referURL);

		parent.children('.start-test').attr('data-test-id', testID);

		// Now remove the unnecessary buttons
		$(this).siblings('.change-specimen').remove();
		$(this).remove();
	});

	/**
	 * Automatic Results Interpretation
	 * Updates the test  result via ajax call
	 */
	 /*UNSTABLE!---TO BE RE-THOUGHT
	$(".result-interpretation-trigger").focusout(function() {
		var interpretation = "";
		var url = $(this).data('url');
		var measureid = $(this).data('measureid');
		var age = $(this).data('age');
		var gender = $(this).data('gender');
		var measurevalue = $(this).val();
		$.post(url, { 
				measureid: measureid,
				age: age,
				measurevalue: measurevalue,
				gender: gender
			}).done( function( interpretation ){
			$( ".result-interpretation" ).val( interpretation );
		});
	});
	*/

	/** Start Test button.
	 *  - Updates the Test status via an AJAX call
	 *  - Changes the UI to show the right status and buttons
	 */
	$('.tests-log').on( "click", ".start-test", function(e) {
		var testID = $(this).data('test-id');
		var url = $(this).data('url');
		$.post(url, { id: testID}).done(function(){});

		var parent = $(e.currentTarget).parent();
		// First replace the status
		var newStatus = $('.started-test-accepted-specimen').html();
		parent.siblings('.test-status').html(newStatus);

		// Add the new buttons
		var newButtons = $('.enter-result-buttons').html();
		parent.append(newButtons);

		// Set properties for the new buttons
		var resultURL = location.protocol+ "//"+location.host+ "/test/" + testID+ "/enterresults";
		parent.children('.enter-result').attr('id',"enter-results-" + testID + "-link");
		parent.children('.enter-result').attr('href',resultURL);

		// Now remove the unnecessary buttons
		$(this).siblings('.refer-button').remove();
		$(this).remove();
	});

	/**
	 *-----------------------------------
	 * REPORTS
	 *-----------------------------------
	 */

		/*Dynamic loading of select list options*/
		$('#section_id').change(function(){
			$.get("/reports/dropdown", 
				{ option: $(this).val() }, 
				function(data) {
					var test_type = $('#test_type');
					test_type.empty();
					test_type.append("<option value=''>Select Test Type</option>");
					$.each(data, function(index, element) {
			            test_type.append("<option value='"+ element.id +"'>" + element.name + "</option>");
			        });
				});
		});
		/*End dynamic select list options*/
		
		/*Toggle summary div for reports*/
		$('#reveal').click(function(){
			if ( $('#summary').hasClass('hidden')) {
					$('#summary').removeClass('hidden');
			}else {
				$('#summary').addClass('hidden');
			}
		});



});
	/**
	 *-----------------------------------
	 * Section for AJAX loaded components
	 *-----------------------------------
	 */
	$( document ).ajaxComplete(function() {
		/* - Identify the selected patient by setting the hidden input field
		   - Enable the 'Next' button on the modal
		*/
		$('#new-test-modal .table input[type=radio]').click(function(){
			$('#new-test-modal #patient_id').val($(this).val());
			$('#new-test-modal .modal-footer .next').prop('disabled', false);

		});
		/* - Check the radio button when the row is clicked
		   - Identify the selected patient by setting the hidden input field
		   - Enable the 'Next' button on the modal
		*/
		$('#new-test-modal .patient-search-result tr td').click(function(){
			var theRadio = $(this).parent().find('td input[type=radio]');
			theRadio.prop("checked", true);
			$('#new-test-modal #patient_id').val(theRadio.val());
			$('#new-test-modal .modal-footer .next').prop('disabled', false);
		});
	});

	/**
	 *	Lab Configurations Functions
	 */
	function addNewSurveillanceAttributes (newSurveillanceNo) {
		$('.new-surveillance-'+newSurveillanceNo).find('select.test-type').attr(
			'name', 'new-surveillance['+newSurveillanceNo+'][test-type]');
		$('.new-surveillance-'+newSurveillanceNo).find('select.disease').attr(
			'name', 'new-surveillance['+newSurveillanceNo+'][disease]');
	}

	function addNewDiseaseAttributes (newDiseaseNo) {
		$('.new-disease-'+newDiseaseNo).find('input.disease').attr(
			'name', 'new-diseases['+newDiseaseNo+'][disease]');
	}

	/**
	 *	Measure Functions
	 */
	function loadRangeFields () {
		var headerClass = [
			'.numericHeaderLoader',
			'.alphanumericHeaderLoader',
			'.alphanumericHeaderLoader',
			'.freetextHeaderLoader'
		]; 
		var inputClass = [
			'.numericInputLoader',
			'.alphanumericInputLoader',
			'.alphanumericInputLoader',
			'.freetextInputLoader'
		];

		if ($(this).data('measure-id') === 0) {
			var newMeasureId = $(this).data('new-measure-id');
			var measureID = 'new-measure-'+newMeasureId;
		} else {
			var measureID = $(this).data('measure-id');
		}

			measureTypeId = $('.measuretype-input-trigger.'+measureID).val() - 1;
			var headerHtml = $(headerClass[measureTypeId]).html();
			var inputHtml = $(inputClass[measureTypeId]).html();
		if (measureTypeId == 0) {
			$('.measurevalue.'+measureID).removeClass('col-md-6');
			$('.measurevalue.'+measureID).addClass('col-md-12');
		} else{
			$('.measurevalue.'+measureID).removeClass('col-md-12');
			$('.measurevalue.'+measureID).addClass('col-md-6');
		}
		if (measureTypeId == 3) {
			$('.measurevalue.'+measureID).siblings('.actions-row').addClass('hidden')
		}else{
			$('.measurevalue.'+measureID).siblings('.actions-row').removeClass('hidden')
		}
		$('.measurevalue.'+measureID).empty();
		$('.measurevalue.'+measureID).append(headerHtml);
		$('.measurevalue.'+measureID).append(inputHtml);
		if ($(this).data('measure-id') != 0) {
			editMeasureRangeAttributes(measureTypeId,measureID);
		}else{
			addMeasureRangeAttributes(measureTypeId, newMeasureId);
		}
	}

	function addNewMeasureAttributes (measureID) {
		$('.measure-section.new-'+measureID+' input.name').attr(
			'name', 'new-measures['+measureID+'][name]');
		$('.measure-section.new-'+measureID+' select.measure_type_id').attr(
			'name', 'new-measures['+measureID+'][measure_type_id]');
		$('.measure-section.new-'+measureID+' input.unit').attr(
			'name', 'new-measures['+measureID+'][unit]');
		$('.measure-section.new-'+measureID+' textarea.description').attr(
			'name', 'new-measures['+measureID+'][description]');
	}

	function addMeasureRangeAttributes (measureTypeId,measureID) {
		if (measureTypeId == 0) {
			$('.measurevalue.new-measure-'+measureID+' input.agemin').attr(
				'name', 'new-measures['+measureID+'][agemin][]');
			$('.measurevalue.new-measure-'+measureID+' input.agemax').attr(
				'name', 'new-measures['+measureID+'][agemax][]');
			$('.measurevalue.new-measure-'+measureID+' select.gender').attr(
				'name', 'new-measures['+measureID+'][gender][]');
			$('.measurevalue.new-measure-'+measureID+' input.rangemin').attr(
				'name', 'new-measures['+measureID+'][rangemin][]');
			$('.measurevalue.new-measure-'+measureID+' input.rangemax').attr(
				'name', 'new-measures['+measureID+'][rangemax][]');
			$('.measurevalue.new-measure-'+measureID+' input.interpretation').attr(
				'name', 'new-measures['+measureID+'][interpretation][]');
			$('.measurevalue.new-measure-'+measureID+' input.measurerangeid').attr(
				'name', 'new-measures['+measureID+'][measurerangeid][]');
		} else{
			$('.measurevalue.new-measure-'+measureID+' input.val').attr(
				'name', 'new-measures['+measureID+'][val][]');
			$('.measurevalue.new-measure-'+measureID+' input.interpretation').attr(
				'name', 'new-measures['+measureID+'][interpretation][]');
			$('.measurevalue.new-measure-'+measureID+' input.measurerangeid').attr(
				'name', 'new-measures['+measureID+'][measurerangeid][]');
		}
	}

	function editMeasureRangeAttributes (measureTypeId,measureID) {
		if (measureTypeId == 0) {
			$('.measurevalue.'+measureID+' input.agemin').attr(
				'name', 'measures['+measureID+'][agemin][]');
			$('.measurevalue.'+measureID+' input.agemax').attr(
				'name', 'measures['+measureID+'][agemax][]');
			$('.measurevalue.'+measureID+' select.gender').attr(
				'name', 'measures['+measureID+'][gender][]');
			$('.measurevalue.'+measureID+' input.rangemin').attr(
				'name', 'measures['+measureID+'][rangemin][]');
			$('.measurevalue.'+measureID+' input.rangemax').attr(
				'name', 'measures['+measureID+'][rangemax][]');
			$('.measurevalue.'+measureID+' input.interpretation').attr(
				'name', 'measures['+measureID+'][interpretation][]');
			$('.measurevalue.'+measureID+' input.measurerangeid').attr(
				'name', 'measures['+measureID+'][measurerangeid][]');
		} else{
			$('.measurevalue.'+measureID+' input.val').attr(
				'name', 'measures['+measureID+'][val][]');
			$('.measurevalue.'+measureID+' input.interpretation').attr(
				'name', 'measures['+measureID+'][interpretation][]');
			$('.measurevalue.'+measureID+' input.measurerangeid').attr(
				'name', 'measures['+measureID+'][measurerangeid][]');
		}
	}

	function UIComponents(){
		/* Datepicker */
		$( '.standard-datepicker').datepicker({ dateFormat: "yy-mm-dd" });
	}

	function editUserProfile()
	{
		/*If Password-Change Validation*/
	    var currpwd = $('#current_password').val();
	    var newpwd1 = $('#new_password').val();
	    var newpwd2= $('#new_password_confirmation').val();
	    var newpwd1_len = newpwd1.length;
	    var newpwd2_len = newpwd2.length;
	    var error_flag = false;
	    if(currpwd == '')
	    {
	        $('.curr-pwd-empty').removeClass('hidden');
	        error_flag = true;
	    }
	    else
	    {
	        $('.curr-pwd-empty').addClass('hidden');
	    }

	    if(newpwd1 == '')
	    {
	        $('.new-pwd-empty').removeClass('hidden');
	        error_flag = true;
	    }
	    else
	    {
	        $('.new-pwd-empty').addClass('hidden');
	    }
	    if(newpwd2 == '')
	    {
	        $('.new-pwdrepeat-empty').removeClass('hidden');
	        error_flag = true;
	    }
	    else
	    {
	        $('.new-pwdrepeat-empty').addClass('hidden');
	    }
	    
	    if(!error_flag)
	    {
	        if(newpwd1_len != newpwd2_len || newpwd1 != newpwd2)
	        {
	            $('.new-pwdmatch-error').removeClass('hidden');
	            error_flag = true;
	        }
	        else
	        {
	            $('.new-pwdmatch-error').addClass('hidden');
	        }
	    }
	    if(!error_flag)
	    {
	        $('#form-edit-password').submit();
	    }
	}

	$(document).ready( function () {
		$('.search-table').DataTable({
        	'bStateSave': true,
        	'fnStateSave': function (oSettings, oData) {
            	localStorage.setItem('.search-table', JSON.stringify(oData));
        	},
        	'fnStateLoad': function (oSettings) {
            	return JSON.parse(localStorage.getItem('.search-table'));
        	}
   		});
	});

	//Make sure all input fields are entered before submission
	function authenticate (form) {
    	var empty = false;
		$('form :input:not(button)').each(function() {

            if ($(this).val() == '') {
                empty = true;
	            $('.error-div').removeClass('hidden');
            }
	        if (empty) return false;
	    });
        if (empty) return;
	    $(form).submit();
	}

	function saveObservation(tid, user, username){
		txtarea = "observation_"+tid;
		observation = $("#"+txtarea).val();

		$.ajax({
			type: 'POST',
			url:  '/culture/storeObservation',
			data: {obs: observation, testId: tid, userId: user, action: "add"},
			success: function(){
				drawCultureWorksheet(tid , user, username);
			}
		});
	}
	/**
	 * Request a json string from the server containing contents of the culture_worksheet table for this test
	 * and then draws a table based on this data.
	 * @param  {int} tid      Test Id of the test
	 * @param  {string} username Current user
	 * @return {void}          No return
	 */
	function drawCultureWorksheet(tid, user, username){
		console.log(username);
		$.getJSON('/culture/storeObservation', { testId: tid, userId: user, action: "draw"}, 
			function(data){
				var tableBody ="";
				$.each(data, function(index, elem){
					tableBody += "<tr>"
					+" <td>"+elem.timeStamp+" </td>"
					+" <td>"+elem.user+"</td>"
					+" <td>"+elem.observation+"</td>"
					+" <td> </td>"
					+"</tr>";
				});
				tableBody += "<tr>"
					+"<td>0 seconds ago</td>"
					+"<td>"+username+"</td>"
					+"<td><textarea id='observation_"+tid+"' class='form-control result-interpretation' rows='2'></textarea></td>"
					+"<td><a class='btn btn-xs btn-success' href='javascript:void(0)' onclick='saveObservation("+tid+", &quot;"+user+"&quot;, &quot;"+username+"&quot;)'>Save</a></td>"
					+"</tr>";
				$("#tbbody_"+tid).html(tableBody);
			}
		);
	}

	/*Begin save drug susceptibility*/	
	function saveDrugSusceptibility(tid, oid){
		console.log(oid);
		var dataString = $("#drugSusceptibilityForm_"+oid).serialize();
		$.ajax({
			type: 'POST',
			url:  '/susceptibility/saveSusceptibility',
			data: dataString,
			success: function(){
				drawSusceptibility(tid, oid);
			}
		});
	}
	/*End save drug susceptibility*/
	/*Function to render drug susceptibility table after successfully saving the results*/
	 function drawSusceptibility(tid, oid){
		$.getJSON('/susceptibility/saveSusceptibility', { testId: tid, organismId: oid, action: "results"}, 
			function(data){
				var tableRow ="";
				var tableBody ="";
				$.each(data, function(index, elem){
					tableRow += "<tr>"
					+" <td>"+elem.drugName+" </td>"
					+" <td>"+elem.zone+"</td>"
					+" <td>"+elem.interpretation+"</td>"
					+"</tr>";
				});
				//tableBody +="<tbody>"+tableRow+"</tbody>";
				$( "#enteredResults_"+oid).html(tableRow);
				$("#submit_drug_susceptibility_"+oid).hide();
			}
		);
	}
	/*End drug susceptibility table rendering script*/
	/*Function to toggle possible isolates*/
	function toggle(className, obj){
		var $input = $(obj);
		if($input.prop('checked'))
			$(className).show();
		else
			$(className).hide();
	}
	/*End toggle function*/
	/*Toggle susceptibility tables*/
	function showSusceptibility(id){
		$('#drugSusceptibilityForm_'+id).toggle(this.checked);
	}
	/*End toggle susceptibility*/

// Hello.
//
// This is JSHint, a tool that helps to detect errors and potential
// problems in your JavaScript code.
//
// To start, simply enter some JavaScript anywhere on this page. Your
// report will appear on the right side.
//
// Additionally, you can toggle specific options in the Configure
// menu.

$(function(){
	/*	HEADER
	|   Username display
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

	/*  USER 
	|-  Load password reset input field
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

	/*  MEASURES 
	|-  Add another measure button 
	*/
	$('.add-another-range').click(function(){
		var mtval = $("#measuretype").val() - 1;
		$(".measurevalue" ).append(measureInputs[mtval]);
	});
	
	/*  load measure range input UI for the selected measure type */
	$( "#measuretype" ).change(function() {
		var mtval = $(this).val() - 1;
		$(".measurevalue" ).html(measureInputs[mtval]);
	});

	/** GLOBAL DELETE	
	 *	Alert on irreversible delete
	 */
	$('.confirm-delete-modal').on('show.bs.modal', function(e) {
	    $('#delete-url').val($(e.relatedTarget).data('id'));
	});

	$('.btn-delete').click(function(){
		$('.confirm-delete-modal').modal('toggle');
		$.ajax({url: $('#delete-url').val()})
			.done(function(){
				location.reload(true);
			});
	});

	UIComponents();

	/* Clicking the label of an radio/checkbox, checks the control*/
	$('span.input-tag').click(function(){
		$(this).siblings('input').trigger('click');
	});

	// Delete numeric range

	$("body").on("click", ".numeric-range-measure .close", function(){
		$(this).parent().remove();
	});

	/* 
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
	/* Prevent patient search modal form submit (default action) when the ENTER key is pressed*/
	$('#new-test-modal .search-text').keypress(function( event ) {
		if ( event.which == 13 ) {
			event.preventDefault();
			$('#new-test-modal .search-patient').click();
		}
	});

	/* - Get a Test->id from the button clicked,
	|  - Fetch corresponding test and default specimen data
	|  - Display all in the modal.
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

	/* Accept Specimen button.
	|  - Updates the Specimen status via an AJAX call
	|  - Changes the UI to show the right status and buttons
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

		// Set properties for the new buttons
		var rejectURL = location.protocol+ "//"+location.host+ "/test/" + specID+ "/reject";
		parent.children('.reject-specimen').attr('id',"reject-" + testID + "-link");
		parent.children('.reject-specimen').attr('href', rejectURL);

		parent.children('.start-test').attr('data-test-id', testID);

		// Now remove the unnecessary buttons
		$(this).siblings('.change-specimen').remove();
		$(this).remove();
	});

	/* Start Test button.
	|  - Updates the Test status via an AJAX call
	|  - Changes the UI to show the right status and buttons
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
		$(this).remove();
	});

});
	/*
	|-----------------------------------
	| Section for AJAX loaded components
	|-----------------------------------
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
	 * HTML ELEMENTS
	 */
	 
	 /*
	 | Measure Inputs
	 | TODO: Move the HTML lines to the appropriate view
	 */

	var numericInput ='<div class="numeric-range-measure">' +
		'<input name="measurerangeid[]" type="hidden" value="0">' +
		'<button class="close" aria-hidden="true" type="button" title="Delete">×</button>' +
		'<div><span class="range-title">Age Range:</span>' +
		  '<input name="agemin[]" type="text"><span>:</span>' +
			'<input name="agemax[]" type="text">' +
		'</div><div><span class="range-title">Gender:</span>' +
			'<select name="gender[]">' +
				'<option value="0">Male</option>' +
				'<option value="1">Female</option>' +
				'<option value="2">Both</option>' +
			'</select>' +
		'</div><div><span class="range-title">Measure Range:</span>' +
      
			'<input name="rangemax[]" type="text">' +
		'</div></div>';

	var alphanumericInput = '<div class="alphanumericInput">' +
								'<input name="val[]" type="text">' +
								'<span class="alphanumericSlash">/</span></div>';

	var autocompleteInput = '<div class="autocompleteInput">' +
								'<input name="val[]" type="text"></div>';

	var freetextInput = '<p>A text box will appear for results entry</p>';

	var measureInputs = [numericInput, alphanumericInput, autocompleteInput, freetextInput]; 

	function UIComponents(){
		/* Datepicker */
		$( '.standard-datepicker').datepicker({ dateFormat: "yy-mm-dd" });
	}

	function editUserProfile()
	{
		/*If Password-Change Validation*/
	    var currpwd = $('#current-password').val();
	    var newpwd1 = $('#new-password').val();
	    var newpwd2= $('#repeat-password').val();
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

//	Functions used in reports blades
function reports(){
	//	Set default date for 'from' and 'to' date range i.e. today's date
	/*Get today's date*/
	var currentDate = new Date();
	var day = currentDate.getDate();
	var month = currentDate.getMonth() + 1;
	if(day<10) {
	    day='0'+day
		if(month<10) {
	    	month='0'+month
		}
	} 	
	var year = currentDate.getFullYear();
	/* Begin Datepicker */
	$('#start').datepicker({ dateFormat: "yy-mm-dd" });
	$('#end').datepicker({ dateFormat: "yy-mm-dd" });
	$("#start").val(year + "-" + month + "-" + day);
	$("#end").val(year + "-" + month + "-" + day);
	/*	End Datepicker 	*/

	/*	Export patient report to .doc format	*/
	$("#word").click(function(event){
		var from=new Date($('#start').val());
		var to=new Date($('#end').val());
		var today = new Date();
		var id = $('#patient').val();
		
		console.log("todate "+to);
		console.log("today date "+today);
		var errorDiv = $('#error');
    	if(from>today||from>to||to>today){
    		errorDiv.show();
    		errorDiv.text('Please check your dates range and try again.');

    	}
    	else{
    		errorDiv.hide();
	        $.ajax({
	            type: 'POST',
	            url: '/patientreport/'+id+'/word',
	            data: $('form#form-patientreport-filter').serialize(),
	            dataType: 'json',
	        })

	        .success(function(data) {
	    		window.open(data);
	        });
	    }

        event.preventDefault();
    });
}

//	Function to check dates range
function checkDateRange(){
	var from = new Date($('#start').val());
	var to = new Date($('#end').val());
	var today = new Date();
	if(from>today||from>to||to>today)
		return 1;
	else
		return 0;
}
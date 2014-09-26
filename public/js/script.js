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
	$('.main-menu').click(function(event){

		$('.main-menu').removeClass('active');
		$(this).addClass('active');

		$('.main-menu').siblings().hide();
		$(this).siblings().show();
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
			.done(function(data){
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
	// Search for patient from new test modal
	// UI Rendering Logic here
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
			if (cnt == 0) {
				$('#new-test-modal .table').hide();
			} else {
				$('#new-test-modal .table').removeClass('hide');
				$('#new-test-modal .table').show();
			};
		});
	});
});
	/*
	|-----------------------------------
	| Section for AJAX loaded components
	|-----------------------------------
	*/
	$( document ).ajaxComplete(function() {
		// Identify the selected patient by setting the hidden input field
		$('#new-test-modal .table input').click(function(){
			$('#new-test-modal #patient_id').val($(this).val());
		});
	});

	/**
	 * HTML ELEMENTS
	 */
	 
	 /*Measure Inputs*/

	var numericInput ='<div class="numeric-range-measure">'
		+'<input name="measurerangeid[]" type="hidden" value="0">'
		+'<button class="close" aria-hidden="true" type="button" title="Delete">×</button>'
		+'<div><span class="range-title">Age Range:</span>'
			+'<input name="agemin[]" type="text"><span>:</span>'
			+'<input name="agemax[]" type="text">'
		+'</div><div><span class="range-title">Gender:</span>'
			+'<select name="gender[]">'
				+'<option value="0">Male</option>'
				+'<option value="1">Female</option>'
				+'<option value="2">Both</option>'
			+'</select>'
		+'</div><div><span class="range-title">Measure Range:</span>'
			+'<input name="rangemin[]" type="text"><span>:</span>'
			+'<input name="rangemax[]" type="text">'
		+'</div></div>';

	var alphanumericInput = '<div class="alphanumericInput">'
								+'<input name="val[]" type="text">'
								+'<span class="alphanumericSlash">/</span></div>';

	var autocompleteInput = '<div class="autocompleteInput">'
								+'<input name="val[]" type="text"></div>';

	var freetextInput = '<p>A text box will appear for results entry</p>';

	var measureInputs = [numericInput, alphanumericInput, autocompleteInput, freetextInput]; 

	function UIComponents(){
		/* Datepicker */
		$( '.standard-datepicker').datepicker({ dateFormat: "yy-mm-dd" });
	}

	function startTest(testId){
		var url = location.protocol+ "//"+location.host+ "/test/" +testId+ "/start";
		$.get( url, function() {
			$('#start-test-'+testId+'-link').replaceWith( $('#enter-results-'+testId+'-link') );
			$('#enter-results-'+testId+'-link').removeClass('hidden');
			updateTestStatus(testId);
		});
	}

	function updateTestStatus(testId){
		var url = location.protocol+ "//"+location.host+ "/test/" +testId+ "/getteststatus";
		$.get( url, function(testStatus) {
			$('#test-status-'+testId).html(testStatus);
		});
	}

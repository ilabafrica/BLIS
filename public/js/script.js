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
			if (cnt == 0) {
				$('#new-test-modal .table').hide();
			} else {
				$('#new-test-modal .table').removeClass('hide');
				$('#new-test-modal .table').show();
			};
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
	$('.test-create').on( "click", ".accept-specimen", function(e) {
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
	$('.test-create').on( "click", ".start-test", function(e) {
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

/*DOM ready functions*/
 function reports(){
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
	$('#from').datetimepicker({
					pickTime: false
				});
	$('#to').datetimepicker({
					pickTime: false
				});
	$("#from").val(year + "-" + month + "-" + day);
	$("#to").val(year + "-" + month + "-" + day);
	/*End Datepicker*/	

	/*Font size - Increase/Decrease*/
	// Reset Font Size
    var originalFontSize = $('#patientReport').css('font-size');
    //console.log(originalFontSize);

    $("#resetFont").click(function(){
      $('#patientReport').css('font-size', originalFontSize);
    });

    // Increase Font Size
    $("#increaseFont").click(function(){
      var currentFontSize = $('#patientReport').css('font-size');
      var currentFontSizeNum = parseFloat(currentFontSize, 10);
      var newFontSize = currentFontSizeNum*1.2;

      $('#patientReport').css('font-size', newFontSize);
      return false;
    });

	/*Dynamic loading of select list options*/
	$('#section_id').change(function(){
		$.get("/api/dropdown", 
			{ option: $(this).val() }, 
			function(data) {
				var test_type = $('#test_type');
				test_type.empty();

				$.each(data, function(index, element) {
		            test_type.append("<option value='"+ element.id +"'>" + element.name + "</option>");
		        });
			});
	});
	
	/*End dynamic select list options*/
	/*Toggling test, patient and rejected specimen records*/
	$("input[name='records']").change( function() {
        if($('#tests').is(':checked')) { 
            $('#sections').show();
             $('#chartContainer').show();
             $('#rejected_specimen_div').hide();
             $('#genderChartContainer').hide();
             $('#rejectionChartContainer').hide();
        }
        else if($('#patients').is(':checked')) { 
             $('#sections').hide();
             $('#test_records_div').hide();
             $('#chartContainer').hide();
             $('#rejected_specimen_div').hide();
             $('#patient_records_div').show();
             $('#genderChartContainer').show();
             $('#rejectionChartContainer').hide();
        }
        else{
            $('#sections').hide();
             $('#test_records_div').hide();
             $('#patient_records_div').hide();
             $('#rejected_specimen_div').show();
             $('#chartContainer').hide();
             $('#genderChartContainer').hide();
             $('#rejectionChartContainer').show();
        }
		
	});
	/*End toggling*/
	/*Submit patient report filters without page reload*/
	$('#form-patientreport-filter').submit(function(event){
		var id=$('#patient').val();
        $.ajax({
            type: 'GET',
            url: '/patientreport/'+id,
            data: $('form#form-patientreport-filter').serialize(),
            dataType: 'json',
        })

        .done(function(data) {
            console.log(data); 
        });

        event.preventDefault();
    });
	/*End ajax submit*/

	/*Submit prevalence report filters without page reload*/
	$('#prevalence_rates').submit(function(event){
		var from=$('#from').val();
		var to=$('#to').val();
        $.ajax({
            type: 'POST',
            url: '/prevalence/filter',
            data: $('form#prevalence_rates').serialize(),
            dataType: 'json',
        })

        .success(function(data) {
            var tableBody =""; 
            if(data.length!=0){
            	$.each(data, function(index, elem){
					tableBody += "<tr>"
					+" <td>"+elem.test+" </td>"
					+" <td>"+elem.total+"</td>"
					+" <td>"+elem.positive+"</td>"
					+" <td>"+elem.negative+"</td>"
					+" <td>"+elem.rate+"</td>"
					+"</tr>";
				});
        	}
        	else{
        		tableBody += "<tr>"
					+" <td colspan='5'>No records found for that time range.</td>"
					+"</tr>";
        	}
        	$("#tableBody").empty();
            $("#tableBody").append(tableBody);
        });

        event.preventDefault();
    });
	/*End ajax submit*/

	/*Toggling counts records*/
	$("input[name='counts']").change( function() {
        if($('#tests_grouped').is(':checked')) { 
           	$('#tests_ungrouped_div').hide();
	        $('#testsChartContainer').hide();
	        $('#specimens_ungrouped_div').hide();
	        $('#specimenChartsDiv').hide();
        }
        else if($('#tests_ungrouped').is(':checked')) { 
	        $('#tests_ungrouped_div').show();
	        $('#testsChartContainer').show();
	        $('#specimens_ungrouped_div').hide();
	        $('#specimenChartsDiv').hide();
        }
        else if($('#specimens_grouped').is(':checked')) { 
            $('#tests_ungrouped_div').hide();
	        $('#testsChartContainer').hide();
	        $('#specimens_ungrouped_div').hide();
	        $('#specimenChartsDiv').hide();
        }
        else if($('#specimens_ungrouped').is(':checked')) { 
            $('#tests_ungrouped_div').hide();
	        $('#testsChartContainer').hide();
	        $('#specimens_ungrouped_div').show();
	        $('#specimenChartsDiv').show();
        }
        else{
            $('#tests_ungrouped_div').hide();
	        $('#testsChartContainer').hide();
	        $('#specimens_ungrouped_div').hide();
	        $('#specimenChartsDiv').hide();
        }
		
	});
	/*End toggling*/
}

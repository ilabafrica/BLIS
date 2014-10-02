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

	//UIComponents();

	/* Clicking the label of an radio/checkbox, checks the control*/
	$('span.input-tag').click(function(){
		$(this).siblings('input').trigger('click');
	});

	// Delete numeric range

	$("body").on("click", ".numeric-range-measure .close", function(){
		$(this).parent().remove();
	});

	$(".view-report-item-button").on('click', function() { alert('ok'); });

	

	});

$(document).ready(function($){
	/*Get today's date*/
	var currentDate = new Date();
	var day = currentDate.getDate();
	var month = currentDate.getMonth() + 1;
	if(day<10) {
	    day='0'+day
	}
	if(month<10) {
    month='0'+month
	} 	
	var year = currentDate.getFullYear();
	/* Begin Datepicker */
	$('#from').datetimepicker();
	$('#to').datetimepicker();
	$("#from").val(month + "/" + day + "/" + year);
	$("#to").val(month + "/" + day + "/" + year);
	/*End Datepicker*/	

	/*Font size - Increase/Decrease*/
	// Reset Font Size
    var originalFontSize = $('#wrap').css('font-size');
    //console.log(originalFontSize);

    $(".resetFont").click(function(){
      $('#wrap').css('font-size', originalFontSize);
    });

    // Increase Font Size
    $(".increaseFont").click(function(){
      var currentFontSize = $('#wrap').css('font-size');
      var currentFontSizeNum = parseFloat(currentFontSize, 10);
      var newFontSize = currentFontSizeNum*1.2;

      $('#wrap').css('font-size', newFontSize);
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
});
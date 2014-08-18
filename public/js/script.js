$(function(){
	/*	Header: Username display */
	$('.user-link').click(function(){
		$('.user-settings').toggle();
	});

	/*	LEFT SIDEBAR FUNCTIONS	*/
	
	/* Click main menu */
	$('.main-menu').click(function(event){

		$('.main-menu').removeClass('active');
		$(this).addClass('active');

		$('.main-menu').siblings().hide();
		$(this).siblings().show();
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

	$( document ).ajaxComplete(function() {

		UIComponents();

		/* Clicking the label of an radio/checkbox, checks the control*/
		$('span.input-tag').click(function(){
			$(this).siblings('input').trigger('click');
		});

		/* Add another measure button */
		$('.add-another-range').click(function(){
			var mtval = $("#measuretype").val() - 1;
			$(".measurevalue" ).append(measureInputs[mtval]);
		});
		
		/* load measure range input UI for the selected measure type */
		$( "#measuretype" ).change(function() {
			var mtval = $(this).val() - 1;
			$(".measurevalue" ).html(measureInputs[mtval]);
		});

		/**	
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

		// Delete numeric range

		$("body").on("click", ".numeric-range-measure .close", function(){
			$(this).parent().remove();
		});

	});

	/**
	 * Controller function: Loads requested page in to the central div (#the-one-main)
	 *  via an asynchronous ajax call.
	 */
	function pageloader(mypage){
		$.ajax({url: mypage })
			.done(function( data ) {
				$( "#the-one-main" ).html(data);
		});
	}

	function formsubmit(formid){
		var myform = $("#" + formid);
		var url = myform.attr( "action" );
		
		$.post(url, myform.serialize())
			.done(function(data){
				location.reload(true);
			});
	}

	function multipartformsubmit(formid){
		var myform = $("#" + formid);
		var url = myform.attr( "action" );
		var formData = new FormData(myform[0]);

	    $.ajax({
	        url: url,
	        type: 'POST',
	        data: formData,
	        async: false,
	        cache: false,
	        contentType: false,
	        processData: false
	    })
	    .done(function(data){
	    	location.reload(true);
	    });
	}

	/*Loads URL then toggles (closes) an element (div), given the element's class. For closing profile div */
	function loadandclose(url, classtoclose){
		pageloader(url);
		$("." + classtoclose).toggle();
	}

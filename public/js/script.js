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

		$(this).children('a').first().trigger('click');
	});

	/* Click submenu */
	$('.sub-menu-items div').click(function(){
		$('.main-menu').removeClass('active');
		var mm = $(this).closest('ul').parent().siblings('.main-menu');
		mm.addClass('active');

		$('.main-menu').siblings().hide();
		mm.siblings().show();

		$(this).children('a').first().trigger('click');
	});

	/* Load appropriate page when div on side bar is clicked*/
	$('.sidebar a').click(function(event){
		event.stopPropagation();
		var thispage = $(this).attr("href");
		if($(this).attr("title") == "Home"){
			window.location.href = thispage;
		}else{
			pageloader(thispage);
		}
	});

});
	
	/**
	 * HTML ELEMENTS
	 */
	 
	 /*Measure Inputs*/

	var numericInput ='<div class="numeric-range-measure well">'
		+'<div><span class="range-title">Age Range:</span>'
			+'<input name="agemin[]" type="text"><span>:</span>'
			+'<input name="agemax[]" type="text">'
		+'</div><div><span class="range-title">Gender:</span>'
			+'<select name="gender[]">'
				+'<option value="1">Male</option>'
				+'<option value="2">Female</option>'
				+'<option value="3">Both</option>'
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
		$('.add-another-measure').click(function(){
			if($("#measuretype").val() === '1') 
			{
				$(".measurevalue" ).append(numericInput);
			}
			else if($("#measuretype").val() === '2') 
			{
				$(".measurevalue" ).append(alphanumericInput);
			}
			else if($("#measuretype").val() === '3') 
			{
				$(".measurevalue" ).append(autocompleteInput);
			}
		});
		
		/* load measure range input UI for the selected measure type */

		$( "#measuretype" ).change(function() {
			if ($(this).val() === '1') 
			{
				$( ".measurevalue" ).html(numericInput);
					// $( ".addanother" ).show();
			}
			else if ($(this).val() === '2') 
			{
				$(".measurevalue").html(alphanumericInput);
				// $( ".addanother" ).show();
			}
			else if ($(this).val() === '3') 
			{
				$(".measurevalue").html(autocompleteInput);
				// $( ".addanother" ).show();
			}
			else if ($(this).val() === '4') 
			{
				$(".measurevalue").html(freetextInput);
				// $( ".addanother" ).hide();
			}
		});
	});

	/**	
	 *	Alert on irreversible delete
	 */
	$(document).on("click", '.delete-item-link', function(){
		$('#delete-url').val($(this).data('id'));
	});

	$(document).on("click", '.btn-delete', function(){
		$('.confirm-delete-modal').modal('toggle');
		pageloader($('#delete-url').val());
	});

	/**
	 * Controller function: Loads requested page in to the central div (#the-one-main)
	 *  via an asynchronous ajax call.
	 */
	function pageloader(mypage){
		$.ajax({
			url: mypage,
			success: function( data ) {
				$( "#the-one-main" ).html(data);
			}
		});
	}

	function formsubmit(formid){
		var myform = $("#" + formid);
		url = myform.attr( "action" );
		
		$.post(url, myform.serialize())
			.done(function(data){
				$( "#the-one-main" ).html( data );
			});
	}

	function multipartformsubmit(formid){
		var myform = $("#" + formid);
		url = myform.attr( "action" );
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
	    	$( "#the-one-main" ).html( data );
	    });
	}

	/*Loads URL then toggles (closes) an element (div), given the element's class. For closing profile div */
	function loadandclose(url, classtoclose){
		pageloader(url);
		$("." + classtoclose).toggle();
	}

	/**
	 *Loads measure values form to 'add measure view' 
	 */
	function addmeasure(){
		if ($("#measuretype").val() === '1') 
		{
			$( ".measurevalue" ).append(numericInputBody);
		}
		else if ($("#measuretype").val() === '2') 
		{
			$( ".measurevalue" ).append(alphanumericInput);
		}
		else if ($("#measuretype").val() === '3') 
		{
			$( ".measurevalue" ).append(autocompleteInput);
		}
	}
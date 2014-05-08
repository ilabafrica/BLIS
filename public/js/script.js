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

/*
*
*/
	function UIComponents(){
		/* Datepicker */
		$( '.standard-datepicker').datepicker({ dateFormat: "yy-mm-dd" });

	}

	$( document ).ajaxComplete(function() {
		UIComponents();

		/* load measure range input UI for the selected measure type */
		$( "#measuretype" ).change(function() {
			if ($(this).val() === '1') 
			{
				$( ".measurevalue" ).html(
					'<div class="col-md-12">'
						+'<div class="col-md-4">Age Range</div>'
						+'<div class="col-md-4">Gender</div>'
						+'<div class="col-md-4">Measure Range</div>'
					+'</div>'
					+'<div class="col-md-4">'
						+'<label for="agemin" class="hide">agemin</label>'						
						+'<input class="form-control input-small" name="agemin[]" type="text">'
						+'<label for="agemax" class="">:</label>'						
						+'<input class="form-control input-small" name="agemax[]" type="text">'						
					+'</div>'
					+'<div class="col-md-4">'
						+'<label for="gender" class="hide">gender</label>'						
						+'<select class="form-control input-small" name="gender[]">'
						+'<option value="1">M</option>'
						+'<option value="2">F</option>'
						+'<option value="3">B</option>'
						+'</select>'						
					+'</div>'
					+'<div class="col-md-4">'
						+'<label for="rangemin" class="hide">Min</label>'						
						+'<input class="form-control input-small" name="rangemin[]" type="text">'
						+'<label for="rangemax" class="">:</label>'						
						+'<input class="form-control input-small" name="rangemax[]" type="text">'						
					+'</div>'
					);
					$( ".addanother" ).show();
			}
			else if ($(this).val() === '2') 
			{
				$(".measurevalue").html(
					'<div class="col-md-4">'
						+'<label for="val" class="hide"></label>'						
						+'<input class="form-control input-small" name="val" type="text">/'
					+'</div>'
				);
				$( ".addanother" ).show();
			}
			else if ($(this).val() === '3') 
			{
				$(".measurevalue").html(
					'<div class="col-md-4">'
						+'<label for="val" class="hide"></label>'						
						+'<input class="form-control input-small" name="val" type="text">'
					+'</div>'
				);
				$( ".addanother" ).show();
			}
			else if ($(this).val() === '4') 
			{
				$(".measurevalue").html(
					'<p>A text box will appear for result entry</p>'
				);
				$( ".addanother" ).hide();
			}
		});
	});

/*	
*	Alert on irreversible delete
*/
	$(document).on("click", '.delete-item-link', function(){
		$('#delete-url').val($(this).data('id'));
	});

	$(document).on("click", '.btn-delete', function(){
		$('.confirm-delete-modal').modal('toggle');
		pageloader($('#delete-url').val());
	});

	/* Controller function: Loads requested page in to the central div (#the-one-main)
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
					$( ".measurevalue" ).append( 
						'<div class="col-md-4">'
							+'<label for="agemin" class="hide">agemin</label>'						
							+'<input class="form-control input-small" name="agemin[]" type="text">'
							+'<label for="agemax" class="">:</label>'						
							+'<input class="form-control input-small" name="agemax[]" type="text">'						
						+'</div>'
						+'<div class="col-md-4">'
							+'<label for="gender" class="hide">gender</label>'						
							+'<select class="form-control input-small" name="gender[]">'
							+'<option value="1">M</option>'
							+'<option value="2">F</option>'
							+'<option value="3">B</option>'
							+'</select>'						
						+'</div>'
						+'<div class="col-md-4">'
							+'<label for="rangemin" class="hide">Min</label>'						
							+'<input class="form-control input-small" name="rangemin[]" type="text">'
							+'<label for="rangemax" class="">:</label>'						
							+'<input class="form-control input-small" name="rangemax[]" type="text">'						
						+'</div>'
					);
				}
				else if ($("#measuretype").val() === '2') 
				{
					$( ".measurevalue" ).append( 
						'<div class="col-md-4">'
							+'<label for="val" class="hide"></label>'						
							+'<input class="form-control input-small" name="val" type="text">/'
						+'</div>'
					);
				}
				else if ($("#measuretype").val() === '3') 
				{
					$( ".measurevalue" ).append( 
						'<div class="col-md-4">'
							+'<label for="val" class="hide"></label>'						
							+'<input class="form-control input-small" name="val" type="text">'
						+'</div>'
					);
				}
		}

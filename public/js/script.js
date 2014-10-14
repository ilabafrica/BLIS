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

	/*  USER 
	|-  Edit Profile 
	*/
	/*Toggle Password-Change and User-Profile Edit*/
	$('.edit-user').click(function(){
		if ($(this).attr('id') == 'profile') {
		    if ($('.edit-profile').hasClass('hidden')) {
		    	$('.edit-profile').removeClass('hidden');
		    	$('.profile-photo').removeClass('hidden');
		    	$('.change-pass').addClass('hidden');
		    }
	    } else{
		    if ($('.change-pass').hasClass('hidden')) {
		    	$('.change-pass').removeClass('hidden');
		    	$('.edit-profile').addClass('hidden');
		    	$('.profile-photo').addClass('hidden');
		    	$( '.change-pass-trigger' ).attr( 'value', 'password');
		    }
	    };
	});
	/*Submitting Profile edit, with password change validation*/
	$('.submit-profile-edit').click(function() {
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

	function editUserProfile()
	{
		/*If Password-Change Validation*/
	    if(!$('.change-pass').hasClass('hidden')){
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
		        $('#form-edit-user').submit();
		    }
		}else{
		    $('#form-edit-user').submit();
		}
	}
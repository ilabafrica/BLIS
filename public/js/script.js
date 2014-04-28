$(function(){
	/*	Header: Username display */
	$('.user-link').click(function(){
		$('.user-settings').toggle();
	});
	/*	Left Sidebar Functions	*/
	$('.main-menu').click(function(){
		$('.main-menu').removeClass('active');
		$(this).addClass('active');

		$('.main-menu').siblings().hide();
		$(this).siblings().show();
	});

	$('.sub-menu-items div').click(function(){
		$('.main-menu').removeClass('active');
		var mm = $(this).closest('ul').parent().siblings('.main-menu');
		mm.addClass('active');

		$('.main-menu').siblings().hide();
		mm.siblings().show();
	});

	/* Datepicker */
	$( ".standard-datepicker").datepicker({ dateFormat: "yy-mm-dd" });
});

	/* Controller function: Loads requested page in to the central div (#the-one-main)
	*  via an asynchronous ajax call.
	*/
	function pageloader(mypage){
		$.ajax({
			url: mypage,
			data: {},
			success: function( data ) {
				$( "#the-one-main" ).html( data );
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

/*For closing profile div*/
	function loadandclose(url, classtoclose){
		pageloader(url);
		$("." + classtoclose).toggle();
	}

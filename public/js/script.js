$(function(){
	/*	Header: Username display */
	$('.user-link').click(function(){
		$('.user-settings').toggle();
	});
	/*	Left Sidebar Functions	*/
	$('.main-menu').click(function(){
		$('.main-menu').removeClass('active');
		$(this).addClass('active');
	});

	$('.sub-menu-items div').click(function(){
		$('.main-menu').removeClass('active');
		$(this).closest('ul').parent().siblings('.main-menu').addClass('active');
	});

	/* Patient Create */
	$( ".patient-create .date-of-birth").datepicker({ dateFormat: "yy-mm-dd" });
});
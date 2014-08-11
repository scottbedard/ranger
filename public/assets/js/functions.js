$(function() {
    
	$('.menu').click(function() {
		$('#navigation').slideToggle();
	});

	$('.navigate').click(function() {
		address = $(this).val();
		window.location = 'http://maps.apple.com/?q=' + address;
	});

});
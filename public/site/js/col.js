
var wDWs = $(window).width();

if (wDWs < 991) {
	$('.open-filters').click(function(e){
		e.stopPropagation();
		$(this).toggleClass('openf');
		$('.dqdt-sidebar').toggleClass('openf');
		$('.opacity_sidebar').toggleClass('openf');
	});
	$('.opacity_sidebar').click(function(e){
		$('.opacity_sidebar').removeClass('openf');
		$('.dqdt-sidebar, .open-filters').removeClass('openf')
	});
	if ($('.dqdt-sidebar').hasClass('openf')) {
		$('.open-filters').addClass('openf');
		$(this).toggleClass('openf');
	} else{
		$('.open-filters').removeClass('openf');
	}
} else{
	$('.open-filters').click(function(e){
		e.stopPropagation();
		$(this).toggleClass('openf');
		$('.dqdt-sidebar').toggleClass('openf');

	});

	if ($('.dqdt-sidebar').hasClass('openf')) {
		$('.open-filters').addClass('openf');
		$(this).toggleClass('openf');
	} else{
		$('.open-filters').removeClass('openf');
	}
}

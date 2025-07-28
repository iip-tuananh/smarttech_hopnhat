window.awe = window.awe || {};
awe.init = function () {
	awe.showPopup();
	awe.hidePopup();
};

awe_lazyloadImage();
function awe_lazyloadImage() {
	var ll = new LazyLoad({
		elements_selector: ".lazyload",
		load_delay: 100,
		threshold: 0
	});
} window.awe_lazyloadImage=awe_lazyloadImage;

var wDWs = $(window).width();


var placeholderText = ['Bạn muốn tìm gì?','Khoá thông minh', 'Khoá cửa nhận diện khuôn mặt', 'Khoá cửa bằng vân tay', 'Khoá cơ, khoá điện'];
$('.search-auto').placeholderTypewriter({text: placeholderText});



// $(document).ready(function(){
// 	function getItemSearch(name, smartjson){
// 		return fetch(`https://${window.location.hostname}/search?q=name:(*${name}*)&view=${smartjson}&type=product`)
// 			.then(res => res.json())
// 			.catch(err => console.error(err))
// 	}
// 	function getItemSearch2(title, smartjsonarticle){
// 		return fetch(`https://${window.location.hostname}/search?q=${title}&view=${smartjsonarticle}&type=article`)
// 			.then(res => res.json())
// 			.catch(err => console.error(err))
// 	}
// 	$('.search-smart input[type="text"]').bind('keyup change', function(e){
// 		let term = $(this).val().trim();
// 		let term2 = $(this).val().trim();
// 		let data = '';
// 		let data2 = '';
// 		var resultbox = '';
// 		var resultbox2 = '';
// 		if(term.length > 0) {
// 			$('.search-suggest').addClass('open');
// 			async function goawaySearch() {

// 				data = await getItemSearch(term, 'smartjson');
// 				data2 = await getItemSearch2(term, 'smartjsonar');


// 				setTimeout(function(){
// 					var sizeData = Object.keys(data).length;
// 					var sizeData2 = Object.keys(data2).length;
// 					var check1 = data.searchResultCount;
// 					var check2 = data2.searchResultCount;
// 					if(sizeData > 0) {
// 						resultbox +=`<div class="title-search"><span>Sản phẩm</span></div>`

// 						Object.keys(data).forEach(function(key) {

// 							if (data[key].url == undefined){

// 							} else {
// 								if (data[key].compare_price != 0 ) {
// 									resultbox += `<div class="product-smart"><a class="image_thumb" href="${data[key].url}" title="${data[key].name}"><img width="370" height="480" class="lazyload loaded" src="${data[key].image}" data-src="${data[key].image}" alt="${data[key].name}" data-was-processed="true"></a><div class="product-info"><h3 class="product-name line-clamp line-clamp-1"><a href="${data[key].url}" title="${data[key].name}">${data[key].name}</a></h3><div class="price-box"><span class="price">${data[key].price}</span><span class="compare-price">${data[key].compare_price}</span></div></div></div>`
// 								} else {
// 									resultbox += `<div class="product-smart"><a class="image_thumb" href="${data[key].url}" title="${data[key].name}"><img width="370" height="480" class="lazyload loaded" src="${data[key].image}" data-src="${data[key].image}" alt="${data[key].name}" data-was-processed="true"></a><div class="product-info"><h3 class="product-name line-clamp line-clamp-1"><a href="${data[key].url}" title="${data[key].name}">${data[key].name}</a></h3><div class="price-box"><span class="price">${data[key].price}</span></div></div></div>`
// 								}
// 							}
// 						});
// 						resultbox +=`<a class="see-more" href="/search?q=name:(*${term}*)&type=product"  title="Xem thêm ${check1} sản phẩm">Xem thêm ${check1} sản phẩm</a>`

// 						$('.list-search').html(resultbox);
// 					} else {

// 						$('.list-search').html('<span></span>');
// 					}

// 					if(sizeData2 > 0 ) {
// 						resultbox2 +=`<div class="title-search"><span>Tin tức</span></div>`


// 						Object.keys(data2).forEach(function(key) {
// 							if (data2[key].url == undefined){

// 							}else{
// 								resultbox2 += `<div class="art-smart"><a class="image_thumb" href="${data2[key].url}" title="${data2[key].name}"><img width="370" height="480" class="lazyload loaded" src="${data2[key].image}" data-src="${data2[key].image}" alt="${data2[key].name}" data-was-processed="true"></a><div class="product-info"><h3 class="product-name"><a href="${data2[key].url}" title="${data2[key].name}">${data2[key].name}</a></h3></div></div>`
// 							}
// 						});
// 						resultbox2 +=`<a class="see-more" href="/search?query=(*${term}*)&type=article"  title="Xem thêm ${check2} tin tức">Xem thêm ${check2} tin tức</a></div>`
// 						$('.list-search2').html(resultbox2);

// 					} else {
// 						$('.list-search2').html('<span></span>');
// 					}
// 					if(sizeData == 0 && sizeData2 == 0 ){
// 						$('.list-search').html('<div class="not-pro">Không có thấy kết quả tìm kiếm</div>');
// 					}
// 				}, 200);
// 			}
// 			goawaySearch();
// 		}else {
// 			$('.search-suggest').removeClass('open');
// 			$('.list-search').html('');
// 			$('.list-search2').html('');
// 		}
// 	});
// });
// $('.header-search-form').submit(function(e){
// 	e.preventDefault();
// 	var search_val = $(this).parent().find('input').val();
// 	var url = '/search?query=name:(*'+search_val +'*)&type=product';
// 	window.location.href = url;
// })


if (wDWs < 1199) {
	/*Remove html mobile*/
	$('.quickview-product').remove();
};

if (wDWs < 767) {
	$('.col-footer h4').click(function(e){
		$(this).toggleClass('current');
		$(this).next('div').toggleClass("current");

	});
};

$('.dropdown-toggle').click(function() {
	$(this).parent().toggleClass('open');
});
$('.btn-close').click(function() {
	$(this).parents('.dropdown').toggleClass('open');
});

$(".opacity_menu").click(function(){
	$('.opacity_menu').removeClass('open_opacity');
});
if ($('.dqdt-sidebar').hasClass('openf')) {
	$('.wrapmenu_full').removeClass('open_menu');
}
$('.ul_collections li > svg').click(function(){
	$(this).parent().toggleClass('current');
	$(this).toggleClass('fa-angle-down fa-angle-right');
	$(this).next('ul').slideToggle("fast");
	$(this).next('div').slideToggle("fast");
});

if (wDWs < 991) {
	$('.menu-bar').on('click', function(){
		$('.opacity_menu').addClass('current');
		$('.header-nav').addClass('current');
		$('body').addClass('modal-open');
	})
	$('.item_big li .fa').click(function(e){
		if($(this).hasClass('current')) {
			$(this).closest('ul').find('li, .fa').removeClass('current');
		} else {
			$(this).closest('ul').find('li, .fa').removeClass('current');
			$(this).closest('li').addClass('current');
			$(this).addClass('current');
		}
	});
	$('.opacity_menu').on('click', function(){
		$('.header-nav').removeClass('current');
		$('.opacity_menu').removeClass('current');
		$('body').removeClass('modal-open');
	})
};
$('.dropdown-toggle').click(function() {
	$(this).parent().toggleClass('open');
});
$('.close-pop').click(function() {
	$('#popup-cart').removeClass('opencart');
	$('body').removeClass('opacitycart');
});

awe_backtotop();
$(document).on('click','.overlay, .close-popup, .btn-continue, .fancybox-close', function() {
	hidePopup('.awe-popup');
	setTimeout(function(){
		$('.loading').removeClass('loaded-content');
	},500);
	return false;
});

function awe_showLoading(selector) {
	var loading = $('.loader').html();
	$(selector).addClass("loading").append(loading);
}  window.awe_showLoading=awe_showLoading;
function awe_hideLoading(selector) {
	$(selector).removeClass("loading");
	$(selector + ' .loading-icon').remove();
}  window.awe_hideLoading=awe_hideLoading;
function awe_showPopup(selector) {
	$(selector).addClass('active');
}  window.awe_showPopup=awe_showPopup;
function awe_hidePopup(selector) {
	$(selector).removeClass('active');
}  window.awe_hidePopup=awe_hidePopup;
awe.hidePopup = function (selector) {
	$(selector).removeClass('active');
}
$(document).on('click','.overlay, .close-window, .btn-continue, .fancybox-close', function() {
	awe.hidePopup('.awe-popup');
	setTimeout(function(){
		$('.loading').removeClass('loaded-content');
	},500);
	return false;
});

$(document).ready(function() {
	if ($('.item_big').width() > $('.header-nav').width()) {
		$('.control-menu').addClass('active');
	} else {
		$('.control-menu').removeClass('active');
	}
	var margin_left = 0;
	$('#prev').on('click', function(e) {
		e.preventDefault();
		animateMargin( 190 );
	});
	$('#next').on('click', function(e) {
		e.preventDefault();
		animateMargin( -190 );
	});

	const animateMargin = ( amount ) => {
		margin_left = Math.min(0, Math.max( getMaxMargin(), margin_left + amount ));
		$('ul.item_big').animate({
			'margin-left': margin_left
		}, 300);
	};
	const getMaxMargin = () =>
	$('ul.item_big').parent().width() - $('ul.item_big')[0].scrollWidth;

	$('.scroll-down').on('click', function () {
		var dataHref = $(this).data('href'),
			extraHeader = 0;
		if ($(window).width() >= 1200) {
			extraHeader = 10
		}
		$('html, body').animate({
			scrollTop: $(dataHref).offset().top - extraHeader
		}, 800);
	});

});

function awe_convertVietnamese(str) {
	str= str.toLowerCase();
	str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
	str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
	str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
	str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
	str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
	str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
	str= str.replace(/đ/g,"d");
	str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
	str= str.replace(/-+-/g,"-");
	str= str.replace(/^\-+|\-+$/g,"");
	return str;
} window.awe_convertVietnamese=awe_convertVietnamese;

function awe_backtotop() {
	$(window).scroll(function() {
		$(this).scrollTop() > 200 ? $('.backtop').addClass('show') : $('.backtop').removeClass('show')
	});
	$('.backtop').click(function() {
		return $("body,html").animate({
			scrollTop: 0
		}, 800), !1
	});
} window.awe_backtotop=awe_backtotop;

var SuccessNoti = function(SuccessText){
	$.notify({
		// options
		title: '<strong>Tuyệt vời</strong><br>',
		message: SuccessText,
		icon: 'glyphicon glyphicon-ok'
	},{
		// settings
		element: 'body',
		//position: null,
		type: "success",
		//allow_dismiss: true,
		//newest_on_top: false,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 1031,
		delay: 3300,
		timer: 1000,
		url_target: '_blank',
		mouse_over: null,
		animate: {
			enter: 'animated fadeInDown',
			exit: 'animated fadeOutRight'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
	});
}
var InfoNoti = function(InfoText){
	$.notify({
		// options
		title: '<strong>Thông báo</strong><br>',
		message: InfoText,
		icon: 'glyphicon glyphicon-info-sign',
	},{
		// settings
		element: 'body',
		position: null,
		type: "info",
		allow_dismiss: true,
		newest_on_top: false,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 1031,
		delay: 3300,
		timer: 1000,
		url_target: '_blank',
		mouse_over: null,
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
	});
}
var ErrorNoti = function(ErrorText){
	$.notify({
		// options
		title: '<strong>Thông báo</strong><br',
		message: ErrorText,
		icon: 'glyphicon glyphicon-info-sign',
	},{
		// settings
		element: 'body',
		position: null,
		type: "warning",
		allow_dismiss: true,
		newest_on_top: false,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 1031,
		delay: 3300,
		timer: 1000,
		url_target: '_blank',
		mouse_over: null,
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
	});
}

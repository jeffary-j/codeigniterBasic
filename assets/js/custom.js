////////////////////////////////////////////////////////////////////////////////
// ISOTOPE 
//
// init Isotope
var $grid = $('#main-grid').imagesLoaded( function() {
	$grid.isotope({	
		itemSelector: '.main-item',
		percentPosition: true,
		masonry: {
			columnWidth: '.grid-sizer'
			
		}
	});
});
// filter items on button click
$('.filter-button-group').on( 'click', 'a', function(e) {
	e.preventDefault();
	var filterValue = $(this).attr('data-filter');
	$grid.isotope({ filter: filterValue });
});

////////////////////////////////////////////////////////////////////////////////
// SCROLLR 
//
var s = skrollr.init();
skrollr.init({
	easing: {
		sin: function(p) {
			return (Math.sin(p * Math.PI * 2 - Math.PI/2) + 1) / 2;
		},
		cos: function(p) {
			return (Math.cos(p * Math.PI * 2 - Math.PI/2) + 1) / 2;
		},
	},
	render: function(data) {
		//Loop
		if(data.curTop === data.maxTop) {
			this.setScrollTop(0, true);
		}
	}
});

////////////////////////////////////////////////////////////////////////////////
// HEAD FILTER 
//
$(".filter").click(function(){
	$(this).toggleClass("active");
	if($(this).hasClass("active")){
		$(".inner-filter ").fadeIn();
	}else {
		$(".inner-filter ").fadeOut();
	}
});

////////////////////////////////////////////////////////////////////////////////
// Mobile Head Menu 
//
$(document).ready(function() {
	$(window).on('resize', function(){
		var win = $(this);

		if (win.width() < 1040) { 
			$(".mobile-gnb").hide();
			$(".mobile-category").hide();
		}else {
			$(".mobile-gnb").show();
			$(".mobile-gnb").css("display","inline-block");
			$(".mobile-category").show();
			$(".header-button-menu").find("div").removeClass("open");
		}
	});
		
	$(".header-button-menu").click(function(){
		$(this).find("div").toggleClass("open");			
		if($(this).find("div").hasClass("open")){
			$(".mobile-gnb").fadeIn();
			$(".mobile-category").fadeIn();
		}else {
			$(".mobile-gnb").fadeOut();
			$(".mobile-category").fadeOut();
		}
	});
});



////////////////////////////////////////////////////////////////////////////////
// LoadingImg 
//
function showLoadingImg(){
	$(".loading-wrap").fadeIn("slow");
	$("<div id='loading_img' class='loading-wrap'><div class='loading' ></div></div>").appendTo("body");
}


function hideLoadingImg() {
	$(".loading-wrap").fadeOut("slow");
	$("#loading_img").remove();
}

$(document).ready(function(){
	//set ajax start and stop img
	$(document).ajaxStart(function(){ 
		showLoadingImg();
	});

	$(document).ajaxStop(function(){ 
		hideLoadingImg();
	});
});
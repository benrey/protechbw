jQuery( document ).ready(function($) {
	
	// animation
	AOS.init({ 
		duration: 800,
		anchorPlacement: 'bottom center' });
			
	// nav scroll		
	var $window = $(window);
	window.onscroll = function() {
	    
	    var scrollTop = $window.scrollTop();
	    if(scrollTop >= 20) {
			$('body').addClass('scrolled');
			$('.logoname').addClass('scrolled');
	    }
		else {
			$('body').removeClass('scrolled');
			$('.logoname').removeClass('scrolled');
		}
	}	
	
	// mobile menu
	$('#nav-toggle').click(function() {
		$(this).toggleClass('open');
		$('html').toggleClass('fixed');
		$('#site-header nav').fadeToggle();
	});

	// toggle search
	$('#menu-search a, #site-search .bg').click(function(e) {
		e.preventDefault();

		$('body').toggleClass('searching');
		$(this).toggleClass('active').blur();
		$('#site-search form.desktop').fadeToggle();
	});
	
	// scroll to top
	$("#totop").click(function(e) {
		e.preventDefault();
		$("html, body").animate({ scrollTop: 0 }, "slow");
	});

});

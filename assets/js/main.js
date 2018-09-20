$(document).ready(function () {

	// hide webhost
	$('body').children('div').last().remove();

	// hide footer on scroll up
	var didScroll;
	var lastScrollTop = 0;
	var delta = 5;
	var navbarHeight = $('footer').outerHeight();

	$(window).scroll(function(event){
	    didScroll = true;
	});

	setInterval(function() {
	    if (didScroll) {
	        hasScrolled();
	        didScroll = false;
	    }
	}, 250);

	function hasScrolled() {
	    var st = $(this).scrollTop();
	    
	    // Make sure they scroll more than delta
	    if(Math.abs(lastScrollTop - st) <= delta)
	        return;
	    
	    // If they scrolled down and are past the navbar, add class .nav-up.
	    // This is necessary so you never see what is "behind" the navbar.
	    if (st > lastScrollTop && st > navbarHeight){
	        // Scroll Down
	        $('footer').removeClass('has-scroll');
	    } else {
	        // Scroll Up
	        if(st + $(window).height() < $(document).height()) {
	            $('footer').addClass('has-scroll');
	        }
	    }
	    
	    lastScrollTop = st;
	}

	// init Isotope
	var $grid = $('.grid').isotope({
	  	itemSelector: '.element-item',
	  	layoutMode: 'fitRows'
	});
	// filter functions
	var filterFns = {
	  	// show if number is greater than 50
	  	numberGreaterThan50: function() {
	    	var number = $(this).find('.number').text();
	    	return parseInt( number, 10 ) > 50;
	  	},
	  	// show if name ends with -ium
	  	ium: function() {
	    	var name = $(this).find('.name').text();
	    	return name.match( /ium$/ );
	  	}
	};
	// bind filter button click
	$('.filters-button-group').on( 'click', 'button', function() {
	  	var filterValue = $( this ).attr('data-filter');
	  	
	  	// use filterFn if matches value
	  	filterValue = filterFns[ filterValue ] || filterValue;
	  	$grid.isotope({ filter: filterValue });
	});
	
	// change is-checked class on buttons
	$('.button-group').each( function( i, buttonGroup ) {
	  	var $buttonGroup = $( buttonGroup );
	  	$buttonGroup.on( 'click', 'button', function() {
	    	$buttonGroup.find('.is-checked').removeClass('is-checked');
	    	$( this ).addClass('is-checked');
	  });
	});
});
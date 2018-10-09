/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

$(document).on('ready', function() {  

	var sticky_header = $('#site-header');
	var screen_scroll = 0;
	var scrolling = false;


	$(window).scroll(function(){
		screen_scroll = $(window).scrollTop();
		scrolling = true;
	});


	//shrink header
	setInterval(function(){
		if ( screen_scroll >= 100 ) { sticky_header.addClass('scrolled'); }
		else { sticky_header.removeClass('scrolled'); }
	}, 250);

	if ( $('body').hasClass('single') ) {
		// social scroll
		
		var socialLinksPosition     = $('.social-bar ul').offset();
		var socialLinksPositionStop = $('.social-share').position();
		var social_moving = false;		

		//Progress bar
		var winHeight = $(window).height(), 
		   docHeight = $(document).height(),//Instead, we can use other elements like section, article or div that holds the content of the article to calculate the height and present the user with a much more accurate representation of the reading position indicator.
		   progressBar = $('#reading-progress'),
		   max, value;

			max = docHeight - winHeight;
			progressBar.attr('max', max);

			setInterval(function(){
				if ( scrolling ) { 
		    		scrolling = false;
					progressBar.attr('value', screen_scroll);

					// social scroll

				   if ( screen_scroll < ( socialLinksPositionStop.top - 400 ) ) {
					    if ( screen_scroll > ( socialLinksPosition.top - 20 ) ) {
				  				social_moving = true;
					      	$('.social-bar ul').css('position', 'fixed').css('top', '28%').css("display","block");
					    } else {
					        $('.social-bar ul').css('position', 'static');
					    }
				   }
				   else {
			    		if ( social_moving ) {
			        		$('.social-bar ul').css('position', 'absolute').css('bottom', ( screen_scroll - 1070) + 'px').css('top','initial');
			    		}
		  				social_moving = false;
				   }
					
				}
			},250);

	} // end $('body').hasClass('single-post') 
	
	$('a[href^="#"]').on('click', function(event) {
		 var target = $(this.getAttribute('href'));
		 if( target.length ) {
			  event.preventDefault();
			  $('html, body').stop().animate({
					scrollTop: target.offset().top
			  }, 1000);
		 }
	});


});

} )( jQuery );

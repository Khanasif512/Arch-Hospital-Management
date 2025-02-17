/*! Show Dropdown Menu content on hover */
	$(function() {
		$(".dropdown").hover(
			function(){ $(this).addClass('open') },
			function(){ $(this).removeClass('open') }
		);
	});


/*! Preload(Show wow effects after page loads) At Body Starts */
	$(window).load(function() {
	  $("body").removeClass("preload");
	});
	
/*! Preloader(Show animation before loading page) Starts */
	jQuery(document).ready(function($) {  

	// site preloader -- also uncomment the div in the header and the css style for #preloader
	$(window).load(function(){
		$('#preloader').fadeOut('slow',function(){$(this).remove();});
	});

	});
/*! Preloader Ends */

/*! Main Slider */
/* Demo Scripts for Bootstrap Carousel and Animate.css article
* on SitePoint by Maria Antonietta Perna
*/

(function( $ ) {

	//Function to animate slider captions 
	function doAnimations( elems ) {
		//Cache the animationend event in a variable
		var animEndEv = 'webkitAnimationEnd animationend';
		
		elems.each(function () {
			var $this = $(this),
				$animationType = $this.data('animation');
        // requires you add [data-delay] & [data-dur] in markup. values are in ms
        $animDur = parseInt($this.data('dur'));
        $animDelay = parseInt($this.data('delay'));
        
			$this.css({"animation-duration": $animDur + "ms", "animation-delay": $animDelay + "ms", "animation-fill-mode": "both"}).addClass($animationType).one(animEndEv, function () {
				$this.removeClass($animationType);
			});
		});
	}
	
	//Variables on page load 
	var $myCarousel = $('#carousel-example-generic'),
		$firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
		
	//Initialize carousel 
	$myCarousel.carousel();
	
	//Animate captions in first slide on page load 
	doAnimations($firstAnimatingElems);
	
/*	//Pause carousel  
	$myCarousel.carousel('pause'); */
	
	
	//Other slides to be animated on carousel slide event 
	$myCarousel.on('slide.bs.carousel', function (e) {
		var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
		doAnimations($animatingElems);
	});  
	
})(jQuery);


/*! Back To Top */
	$(window).scroll(function() {
		if ($(this).scrollTop() > 50 ) {
			$('.scrolltop:hidden').stop(true, true).fadeIn();
		} else {
			$('.scrolltop').stop(true, true).fadeOut();
		}
	});
	$('.scrolltop').on("click",function(){
			$('html,body').animate({ scrollTop: 0 }, 'slow', function () {
			});

		});

/*! Owl Carousel for Technology We Use */
    $(document).ready(function() {
     
      $("#owl-demo").owlCarousel({
     
			autoPlay: 3000, //Set AutoPlay to 3 seconds

			items : 6,
			itemsDesktop : [1199,5],
			itemsDesktopSmall : [979,5],
			itemsTablet : [768,4],
			itemsMobile : [479,4],
		  
		      // Navigation
			scrollPerPage : true,
			
			responsive: true,
      });
     
    });
	
/*! Owl Carousel for Our Achievements */
    $(document).ready(function() {
     
      $("#our-achievement").owlCarousel({
     
			autoPlay: 3000, //Set AutoPlay to 3 seconds

			items : 4,
			itemsDesktop : [1199,4],
			itemsDesktopSmall : [979,4],
			itemsTablet : [768,4],
			itemsMobile : [479,3],
		  
		      // Navigation
			scrollPerPage : true,
			
			responsive: true,
      });
     
    });	

/*! Owl Carousel for Our Clients */
    $(document).ready(function() {
     
      $("#our-client").owlCarousel({
     
			autoPlay: 3000, //Set AutoPlay to 3 seconds

			items : 6,
			itemsDesktop : [1199,5],
			itemsDesktopSmall : [979,5],
			itemsTablet : [768,5],
			itemsMobile : [479,3],
		  
		      // Navigation
			scrollPerPage : true,
			
			responsive: true,
      });
     
    });
	
//Alert Auto Close
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 6000);	
	

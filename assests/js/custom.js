$(document).ready(function(){
	//for main menu
	$(".menu-trigger").click(function(){
		$(".menubar").slideToggle('slow', function(){
			$(this).toggleClass("nav-expanded").css('display', '');
		});
	});
    
    // for isotope
	//activate isotope in container
	$(".product-items").isotope({
		itemSelector: '.single-item',
		layoutMode: 'fitRows',
	});

	//add isotop click function
	$('.isotopes-content li').click(function(){
		$(".isotopes-content li>a").removeClass("active");
		$(this).addClass("active");

		var selector = $(this).attr('data-filter');
		$('.product-items').isotope({
			filter: selector,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false,
			}
		});	
		return false;
	});
    
 });

$(document).ready(function(){
	//for main menu
	$(".mobileview-menu").click(function(){
		$(".nav").slideToggle('slow', function(){
			$(this).toggleClass("nav-expanded").css('display', '');
		});
	});
});


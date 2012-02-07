				
$(document).ready(function() {
	// Initialize scroller
	$(".bookshelfFullWidth .scrollContent").scrollContent({ 
	    btnNext: ".scrollContentBtnRight", 
	    btnPrev: ".scrollContentBtnLeft", 
	    speed: 1000,
	    visible: 6 
	});
	// Bookshelf Popups
		$("ul.scrollFrame li").hover(
			function() {
				$("div.bsPopup", this).fadeIn(150);
			}, function() {
				$("div.bsPopup", this).fadeOut(150);
			}
		);
		
	// Bookshelf tabs
	$(".scrollContent").hide(), $("#bookshelf-1").show();
	$("#bookshelfTab-1").addClass("active");
	$("#bookshelfTab-1").click(function() {
		$(".scrollContent").hide(), $("#bookshelf-1").show(),
		$(".bookshelfNav li").removeClass("active"), $(this).addClass("active"); 
	});
	$("#bookshelfTab-2").click(function() { 
		$(".scrollContent").hide(), $("#bookshelf-2").show(),
		$(".bookshelfNav li").removeClass("active"), $(this).addClass("active");
	});
	$("#bookshelfTab-3").click(function() { 
		$(".scrollContent").hide(), $("#bookshelf-3").show(),
		$(".bookshelfNav li").removeClass("active"), $(this).addClass("active");
	});
});
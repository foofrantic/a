if (Drupal.jsEnabled) {
  document.documentElement.className = 'js';
}
$(document).ready(function() {
	$("#users").hide();
	$("#words").hide();
	$(".popular").addClass("active");
$(".popular").click(function()
{
	$("#popular").show('slow');
	$("#users").hide('slow');
	$("#words").hide('slow');
	$(this).addClass("active");
	$(".users").removeClass("active");
	$(".words").removeClass("active");
});

$(".users").click(function()
{
	$("#users").show('slow');
	$("#popular").hide('slow');
	$("#words").hide('slow');
	$(this).addClass("active");
	$(".popular").removeClass("active");
	$(".words").removeClass("active");
});


$(".words").click(function()
{
	$("#words").show('slow');
	$("#popular").hide('slow');
	$("#users").hide('slow');
	$(this).addClass("active");
	$(".users").removeClass("active");
	$(".popular").removeClass("active");
});

$('#profile_comments').hide();
$('#profile_twitter').hide();
$('#chapters').hide();

$(".pigeonhole").click(function()
{
	$("#profile_pigeonhole").show('slow');
	$("#profile_comments").hide('slow');
	$("#profile_twitter").hide('slow');
	$("#chapters").hide('slow');
	$(this).addClass("active");
	$(".comments").removeClass("active");
	$(".twitter").removeClass("active");
});

$(".comments").click(function()
{
	$("#profile_pigeonhole").hide('slow');
	$("#profile_twitter").hide('slow');
	$("#chapters").hide('slow');
	$("#profile_comments").show('slow');
	$(this).addClass("active");
	$(".pigeonhole").removeClass("active");
	$(".twitter").removeClass("active");
});

$(".twitter").click(function()
{
	$("#profile_pigeonhole").hide('slow');
	$("#profile_comments").hide('slow');
	$("#profile_twitter").show('slow');
	$(this).addClass("active");
	$(".pigeonhole").removeClass("active");
	$(".comments").removeClass("active");
});


$(".chapters").click(function()
{
	$("#profile_pigeonhole").hide('slow');
	$("#profile_comments").hide('slow');
	$("#chapters").show('slow');
	$(this).addClass("active");
	$(".pigeonhole").removeClass("active");
});

$(".readmore").click(function()
{
	$(".readmore").hide();
	$(".extended_bio").show('slow');
});

$(".close_bio").click(function()
{
	$(".extended_bio").hide('slow');
	$(".readmore").show();
});

});


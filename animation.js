$(document).ready(function(){
	$('.expander').next().hide();
	$('.expander').click(function(){
		$(this).next().slideToggle(400);
	})
})

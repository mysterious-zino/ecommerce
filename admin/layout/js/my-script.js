$(document).ready(function(){
	'use strict';
	$('.toggel-info').click(function(){
		$(this).toggleClass('selected').parent().next('.card-body').slideToggle();
		if($(this).hasClass('selected')){
			$(this).html('<i class="fas fa-plus "></i>');
		}else {
			$(this).html('<i class="fas fa-minus "></i>');
		}
	});
	$('[placeholder]').focus(function(){
		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder','');
	}).blur(function(){
		$(this).attr('placeholder',$(this).attr('data-text'));
	});
	$('input').each(function(){
		if($(this).attr('required') === 'required') {
			$(this).after('<span class="asterisk">*</span>');
		}
	});
	var pass = $('.password');
	$('.show-pass').hover(function(){
		pass.attr('type','text');
	},function(){
		pass.attr('type','password');
	});
	$('.confirm').click(function(){
		
		return confirm('what you do');
	});
	$('.categor h2').click(function(){
		$(this).next().slideToggle(500);
	});
	$('.order span').click(function(){
		$(this).addClass('active').siblings('span').removeClass('active');
		if($(this).data('view') === 'full'){
			$('.categor .box-info').fadeIn(200);
		}else {
			$('.categor .box-info').fadeOut(200);
		}
	});
	 // Calls the selectBoxIt method on your HTML select box
	 $("select").selectBoxIt({
	 	autoWidth: false
	 });

	    // Uses the Twitter Bootstrap theme for the drop down
	    //theme: "bootstrap"



});
$(document).ready(function(){
	'use strict';
	
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
	
	$('.confirm').click(function(){
		
		return confirm('what you do');
	});
	
	 // Calls the selectBoxIt method on your HTML select box
	 $("select").selectBoxIt({
	 	autoWidth: false
	 });

	    // Uses the Twitter Bootstrap theme for the drop down
	    //theme: "bootstrap"
    $('.login-box h2 span').click(function(){
    	$(this).addClass('active').siblings().removeClass('active');
    	$('.login-box form').hide();
    	$('.' + $(this).data('banona')).delay(450).fadeIn(2000);
    });

    $('.new-items .form-horizontal .live ').keyup(function(){
    	$($(this).data('dz')).text($(this).val());
    });





});
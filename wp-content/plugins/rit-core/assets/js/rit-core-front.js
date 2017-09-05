    
jQuery(document).ready(function ($) {
    "use strict";

    $('.rit_popup').on('click', function(e){
    	e.preventDefault();
    	window.open($(this).attr('href'), 'newwindow', 'width=500, height=350'); 
    	return false;
    })

    // donate form
	$('.rit-paypal-form').each(function(){

		$(this).find('.rit-amount-button').click(function(){
			
			var amount = $(this).attr('data-val');
			$(this).addClass('active').siblings().removeClass('active');
			$(this).parent('.rit-paypal-amount-wrapper').siblings('[name="amount"]').val(amount);
		});

		$(this).find('.custom-amount').change(function(){
			var amount = parseInt($(this).val());
			$(this).siblings().removeClass('active');
			$(this).parent('.rit-paypal-amount-wrapper').siblings('[name="amount"]').val(amount);
		});
		
		$(this).submit(function(e){
			var valid = true; 
			var rit_form = $(this);
			
			// check require fields
			$(this).find('.rit-require').each(function(){
				if( valid && $(this).val() == '' ){
					rit_form.children('.rit-notice.require-field').slideDown(200)
						.siblings('.rit-notice').slideUp(200);
					valid = false;
				}
			});
			
			// check email
			$(this).find('.rit-email').each(function(){
				var re = /\S+@\S+/;
				if( valid && !re.test($(this).val()) ){
					rit_form.children('.rit-notice.email-invalid').slideDown(200)
						.siblings('.rit-notice').slideUp(200);
					valid = false;
				}
			});	

			if( valid ){
				rit_form.children('.rit-notice').slideUp(200);
				rit_form.children('.rit-paypal-loader').slideDown(200);
				
				var ajax_url = rit_form.attr('data-ajax');
				
				$.ajax({
					type: 'POST',
					url: ajax_url,
					data: jQuery(this).serialize(),
					dataType: 'json',
					error: function(a, b, c){
						console.log(a, b, c);
					},
					success: function(data){
						rit_form.children('.rit-notice.alert-message')
							.html(data.message).slideDown(200).addClass('rit-' + data.status);
						rit_form.children('.rit-paypal-loader').slideUp(200);
						
						if( data.status == 'success' ){
							rit_form[0].submit();
						}
					}
				});					
			}

			e.preventDefault();
			e.returnValue = false;
		});
	});
});
 
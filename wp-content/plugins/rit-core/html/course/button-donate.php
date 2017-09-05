<?php

global $post;

if(isset($params['item'])){
	setup_postdata( $params['item'] ); 
}

?>
<a class="rit-donate-button" data-rel="fancybox" href="#donate-button-<?php echo get_the_ID(); ?>">
	<?php echo esc_html__('Donate', RIT_TEXT_DOMAIN)?>
</a>
<div id="donate-button-<?php echo get_the_ID(); ?>" style="/*display: none;*/">
	<div class="rit-paypal-form-wrapper">
		<h3 class="rit-paypal-form-head"><?php echo esc_html__( 'You are donating to :', RIT_TEXT_DOMAIN) . ' <span>' . get_the_title() . '</span>'; ?></h3>
		
		<?php
		 $payment_link = 'https://www.paypal.com/cgi-bin/webscr';
		if(get_theme_mod('rit_course_paypal_test', 0) == 1){
			$payment_link = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}
		
		?>
		<form class="rit-paypal-form" action="<?php echo $payment_link; ?>" method="post" data-ajax="<?php echo admin_url('admin-ajax.php'); ?>" >
			<div class="rit-paypal-amount-wrapper">
				<span class="rit-head"><?php echo esc_html__('How much would you like to donate?', RIT_TEXT_DOMAIN); ?></span>
				<?php

				$donation_values = get_post_meta( $post->ID, 'rit_donation_value', true);

				$currency_format = get_post_meta( $post->ID, 'rit_currency_format', true);

				$currency_code = get_post_meta( $post->ID, 'rit_currency_code', true);

				$currency_symbol = get_post_meta( $post->ID, 'rit_currency_symbol', true);

				$currency_format = ( $currency_format == 'NUMBER$'  || $currency_format == '$NUMBER' ) ? $currency_format : 'NUMBER$';

				
				if(isset($donation_values) && $donation_values != ''){

					$donation_values = explode(';', $donation_values);

					foreach($donation_values as $key => $donate_value ){
						?>
						<a class="rit-amount-button btn btn-primary <?php echo $key == 0 ? 'active' : ''?>" data-val="<?php echo $donate_value; ?>"><?php echo rit_money_format($donate_value, $currency_format, $currency_symbol ); ?></a>		
						<?php
					}
				}

				?>
				
			
				<input type="text" class="custom-amount" placeholder="<?php echo esc_html__('Or Your Amount', RIT_TEXT_DOMAIN) . '(' . $currency_code . ')'; ?>" />
				<div class="clear"></div>
			</div>
			<div class="rit-paypal-fields">
				<div class=""><span class="rit-head"><?php echo esc_html__('Name *', RIT_TEXT_DOMAIN); ?></span>
					<input class="rit-require" type="text" name="rit-name">
				</div>
				<div class=""><span class="rit-head"><?php echo esc_html__('Last Name *', RIT_TEXT_DOMAIN); ?></span>
					<input class="rit-require" type="text" name="rit-last-name">
				</div>
				<div class="clear"></div>
				<div class=""><span class="rit-head"><?php echo esc_html__('Email *', RIT_TEXT_DOMAIN); ?></span>
					<input class="rit-require rit-email" type="text" name="rit-email">
				</div>
				<div class=""><span class="rit-head"><?php echo esc_html__('Phone', RIT_TEXT_DOMAIN); ?></span>
					<input type="text" name="rit-phone">
				</div>		
				<div class="clear"></div>
				<div class=""><span class="rit-head"><?php echo esc_html__('Address', RIT_TEXT_DOMAIN); ?></span>
					<textarea name="rit-address"></textarea>
				</div>
				<div class=""><span class="rit-head"><?php echo esc_html__('Additional Note', RIT_TEXT_DOMAIN); ?></span>
					<textarea name="rit-additional-note"></textarea>
				</div>		
				<div class="clear"></div>
			</div>
			<?php
				$paypal_account = get_post_meta( $post->ID, 'rit_paypal_account', true);

				if(!$paypal_account ){

					$paypal_account  = get_theme_mod('rit_course_paypal_account', 'sandbox@ri-charity.com');
				}
			?>
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="<?php echo $paypal_account; ?>">
			<input type="hidden" name="item_name" value="<?php echo get_the_title(); ?>">
			<input type="hidden" name="item_number" value="<?php echo get_the_ID(); ?>">
			<input type="hidden" name="amount" value="<?php echo isset($donation_values[0]) ? $donation_values[0] : ''; ?>">    
			<input type="hidden" name="return" value="<?php echo get_permalink(); ?>">
			<input type="hidden" name="no_shipping" value="0">
			<input type="hidden" name="no_note" value="1">
			<input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>">
			<input type="hidden" name="lc" value="AU">
			<input type="hidden" name="bn" value="PP-BuyNowBF">
			<input type="hidden" name="action" value="save_paypal_form">
			<input type="hidden" name="notify_url" value="<?php echo home_url('/'); ?>?paypal=ipn">
			
			<input type="hidden" name="security" value="<?php echo wp_create_nonce('rit-paypal-create-nonce'); ?>">
			<div class="rit-notice email-invalid" style="display: none;" ><?php echo esc_html__('Invalid Email Address ', RIT_TEXT_DOMAIN); ?></div>
			<div class="rit-notice require-field" style="display: none;"><?php echo esc_html__('Please fill all required fields', RIT_TEXT_DOMAIN); ?></div>
			<div class="rit-notice alert-message" ></div>
			<div class="rit-paypal-loader" ></div>
			<input type="submit" value="donate" >
		</form>
	</div>
</div>
<?php
wp_reset_postdata(); ?>

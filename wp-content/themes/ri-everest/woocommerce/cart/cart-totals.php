<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="cart_totals everest-cart-totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>
	<div class="wrapper_cart_totals">
		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>
		<div class="order-total col-xs-12">
            <h3 class="title"><?php  _e( 'Cart Total', 'woocommerce' ); ?></h3>
            <p><label class="primary-font"><?php  _e( 'Subtotal', 'woocommerce' ); ?></label><?php wc_cart_totals_subtotal_html(); ?></p>

			<div class="shipping">
				<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
					<div class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
						<p><?php wc_cart_totals_coupon_label( $coupon ); ?></p>
						<p><?php wc_cart_totals_coupon_html( $coupon ); ?></p>
					</div>
				<?php endforeach; ?>

				<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
					<div class="primary-font">
						<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
						<?php wc_cart_totals_shipping_html(); ?>
						<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
					</div>
				<?php elseif ( WC()->cart->needs_shipping() ) : ?>

					<div class="shipping">
						<p><?php  _e( 'Shipping', 'woocommerce' ); ?></p>
						<p><?php woocommerce_shipping_calculator(); ?></p>
					</div>

				<?php endif; ?>

				<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
					<div class="fee">
						<p><?php echo esc_html( $fee->name ); ?></p>
						<p><?php wc_cart_totals_fee_html( $fee ); ?></p>
					</div>
				<?php endforeach; ?>

				<?php if ( WC()->cart->tax_display_cart == 'excl' ) : ?>
					<?php if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) : ?>
						<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
							<div class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
								<p><?php echo esc_html( $tax->label ); ?></p>
								<p><?php echo wp_kses_post( $tax->formatted_amount ); ?></p>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<div class="tax-total">
							<p><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></p>
							<p><?php wc_cart_totals_taxes_total_html(); ?></p>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<p><label  class="primary-font"><?php  _e( 'Cart Total', 'woocommerce' ); ?></label><?php wc_cart_totals_order_total_html(); ?></p>


		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
        <?php if ( WC()->cart->get_cart_tax() ) : ?>
            <p><small><?php
                    $estimated_text = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
                        ? sprintf( ' ' . __( ' (taxes estimated for %s)', 'woocommerce' ), WC()->countries->estimated_for_prefix() . WC()->countries->countries[ WC()->countries->get_base_country() ])
                        : '';
                    printf( __( 'Note: Shipping and taxes are estimated%s and will be updated during checkout based on your billing and shipping information.', 'woocommerce' ), $estimated_text );
                    ?></small></p>
        <?php endif; ?>

        <div class="wc-proceed-to-checkout">
			<input type="submit" class="button btn-update-cart" name="update_cart"
				   value="<?php esc_attr_e('Update Cart', 'woocommerce'); ?>"/>
            <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

        </div>
        </div>
	</div>



	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>

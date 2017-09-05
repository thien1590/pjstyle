<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version 3.1.0
 */

if (!defined('ABSPATH')) {
	exit;
}

?>
<div  id="mini-cart" data-text-emptycart="<?php esc_html_e('No products in the cart.', 'woocommerce'); ?>">
<div class="cart-header">
    <div class="cart-panel-title clearfix">
        <h4 class="mycart pull-left"><?php esc_html_e('My Cart', 'ri-quartz'); ?></h4>
        <h5 class="close pull-right"><i class="clever-icon-close"></i> </h5>
    </div>
</div>
<?php do_action('woocommerce_before_mini_cart'); ?>
<ul class="cart_list product_list_widget <?php echo $args['list_class']; if (sizeof(WC()->cart->get_cart()) <= 0) {echo 'cart-empty';} ?>">

<?php if ( ! WC()->cart->is_empty() ) : ?>

        <?php
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                ?>
                <li class="mini-cart-item">
                    <div class="wrapper-thumb col-xs-3" >
                    <?php echo apply_filters('woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s" data-cart-item-key="%s">&times;</a>', esc_url(WC()->cart->get_remove_url($cart_item_key)), __('Remove this item', 'woocommerce'), $cart_item_key), $cart_item_key); ?>
                    <?php if (!$_product->is_visible()) : ?>
                        <?php echo str_replace(array('http:', 'https:'), '', $thumbnail) . $product_name . '&nbsp;'; ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>" class="mini-cart-img">
                            <?php echo str_replace(array('http:', 'https:'), '', $thumbnail) ?>
                        </a>
                    <?php endif; ?>
                    </div>
                    <div class="cart-item-detail col-xs-9 primary-font">
                        <?php if ($_product->is_visible()) : ?>
                        <a class="primary-font" href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>">
                            <?php echo $product_name ?>
                        </a>
                        <?php endif; ?>
                        <?php echo WC()->cart->get_item_data($cart_item); ?>
                        <?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key); ?>
                    </div>
                </li>
                <?php
            }
        }
        ?>

    <?php else : ?>

        <li class="empty primary-font"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></li>

    <?php endif; ?>

</ul><!-- end product list -->

<?php if (sizeof(WC()->cart->get_cart()) > 0) : ?>
<div class="bottom-cart">
    <p class="total"><strong class="primary-font"><?php  _e('Subtotal', 'woocommerce'); ?>
            :</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

    <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

    <p class="buttons">
        <a href="<?php echo WC()->cart->get_cart_url(); ?>"
           class="button btn wc-forward"><?php  _e('View Cart', 'woocommerce'); ?></a>
        <a href="<?php echo WC()->cart->get_checkout_url(); ?>"
           class="button btn checkout wc-forward"><?php  _e('Checkout', 'woocommerce'); ?></a>
    </p>
</div>
<?php endif; ?>
<?php do_action('woocommerce_after_mini_cart'); ?>
</div>
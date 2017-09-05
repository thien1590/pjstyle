<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 6/25/2015
 * Time: 9:41 AM
 */
$header='';
if (is_single() || is_page()) {
    if (get_post_meta(get_the_ID(), 'rit_header_options', true) == '' || get_post_meta(get_the_ID(), 'rit_header_options', true) == 'use-default') {
        $header = get_theme_mod('rit_default_header', 'default');
    } else {
        $header = get_post_meta(get_the_ID(), 'rit_header_options', true);
    }
}else{
    $header = get_theme_mod('rit_default_header', 'default');
}
?>
<div id="topcart">
    <div class="wrap-icon-cart">
    <div class="right-cart">
        <h5><?php esc_html_e('My cart', 'ri-everest') ?></h5>
        <?php echo WC()->cart->get_cart_subtotal(); ?>
    </div>
    <a class="btn-header" href="<?php echo WC()->cart->get_cart_url(); ?>"
       title="<?php echo esc_html__('View your shopping cart', 'ri-everest') ?>"><span class="primary-font"><?php echo WC()->cart->cart_contents_count ?></span></a>
    </div>
    <div class="wrap-mini-cart">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <div class="mask-close"></div>
</div>
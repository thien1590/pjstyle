<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}


// Extra post classes
$classes = array();
$classes[].='product-item';
?>
<li <?php post_class($classes); ?> style="min-width:<?php echo get_theme_mod('rit_woocol_min_width','180')?>px">
    <div class="wrapper-top-product">
        <?php do_action('woocommerce_before_shop_loop_item'); ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php
            /**
             * woocommerce_before_shop_loop_item_title hook
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action('woocommerce_before_shop_loop_item_title');
            ?>
        </a>
        <?php
        /**
         * woocommerce_after_shop_loop_item hook
         *
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action('woocommerce_after_shop_loop_item');
        if (is_plugin_active('yith-woocommerce-wishlist/init.php')) {
            echo do_shortcode('[yith_wcwl_add_to_wishlist]');
        }
        $postdate = get_the_time('Y-m-d');   // Post date
        $postdatestamp = strtotime($postdate);   // Timestamped post date
        $newness = get_theme_mod('rit_days_products_new', '30');  // Newness in days

        if ((time() - (60 * 60 * 24 * $newness)) < $postdatestamp) { // If the product was published within the newness time frame display the new badge
            echo '<span class="product-label label-new">' . esc_html(__('New', 'ri-everest')) . '</span>';
        }
        ?>

    </div>
    <div class="product-info">
        <h3 class="product-name"><a href="<?php the_permalink(); ?>"
                                    title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
        <?php
        echo get_the_term_list(get_the_ID(), 'product_cat', '<div class="product-cat primary-font">', ' - ', '</div>');
        ?>
        <div class="other-info">
            <?php
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
            do_action('woocommerce_after_shop_loop_item_title');
            ?>
            <?php do_action('woocommerce_template_single_rating');
            ?>
            <div class="product-description">
                <?php echo apply_filters('woocommerce_short_description', $post->post_excerpt) ?>
            </div>
            <?php
            if (get_theme_mod('rit_product_hide_cart', '0') != '1') {
                ?>
                <div class="wrapper-product-opt">
                    <?php
                    /**
                     * woocommerce_template_loop_add_to_cart hook
                     *
                     * @hooked woocommerce_template_loop_add_to_cart - 10
                     */
                    do_action('woocommerce_template_loop_add_to_cart');
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</li>


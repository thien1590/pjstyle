<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if ($related_products) :
    if (get_theme_mod('rit_enable_slider_related_product') == 'yes'):?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery(".list-related .products").owlCarousel({
                    // Most important owl features
                    items: '<?php echo get_theme_mod('rit_number_products_related_display_per_row', 4);?>',
                    itemsCustom: false,
                    itemsDesktop: [1199,<?php echo get_theme_mod('rit_number_products_related_display_per_row', 4);?>],
                    itemsDesktopSmall: [980,<?php if (get_theme_mod('rit_number_products_related_display_per_row', 4) > 1) echo get_theme_mod('rit_number_products_related_display_per_row', 4) - 1; else echo get_theme_mod('rit_number_products_related_display_per_row', 4);?>],
                    itemsTablet: [768,<?php if (get_theme_mod('rit_number_products_related_display_per_row', 4) > 2) echo get_theme_mod('rit_number_products_related_display_per_row', 4) - 2; else echo get_theme_mod('rit_number_products_related_display_per_row', 4);?>],
                    itemsTabletSmall: false,
                    itemsMobile: [479, 1],
                    singleItem: false,
                    itemsScaleUp: false,
                    // Navigation
                    pagination: false,
                    navigation: true,
                    navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    rewindNav: true,
                    scrollPerPage: false
                });
            })
        </script>
        <?php
    endif;
    ?>
    <div class="related product_style_2">

        <h3 class="title"><span><?php _e('Related Products', 'woocommerce'); ?></span></h3>
        <div class="rit-smart-layout rit-products list-related grid-layout row <?php
        if (get_theme_mod('rit_enable_slider_related_product') == 'yes'):echo esc_attr('product-carousel'); endif;
        ?>">
            <?php woocommerce_product_loop_start(); ?>
            <?php foreach ($related_products as $related_product) : ?>

                <?php
                $post_object = get_post($related_product->get_id());

                setup_postdata($GLOBALS['post'] =& $post_object);
                wc_get_template_part('content', 'product-related'); ?>
                <?php
            endforeach;
            woocommerce_product_loop_end(); ?>
        </div>
    </div>

<?php endif;

wp_reset_postdata();

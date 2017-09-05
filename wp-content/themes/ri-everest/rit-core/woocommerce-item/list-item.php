<?php
/**
 * The Template for displaying all single products.
 *
 * List layout item of woo for ri-everest
 *
 * @author        RiverThemes
 * @version     1.0
 */
global $post, $product;
$class = 'row ';
if ($atts['pagination'] == 'ajax' || $atts['pagination'] == 'infinite-scroll') :
    $class .= ' rit-ajax-item';
endif;
?>
<li <?php post_class(' product ' . $class); ?>>
    <div class="col-xs-4">
        <?php do_action('woocommerce_before_shop_loop_item'); ?>
        <div class="wrapper-top-product">
            <a href="<?php the_permalink(); ?>">
                <?php
                /**
                 * woocommerce_before_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action('ri_everest_woocommerce_show_product_loop_sale_flash');
                echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), $atts['products_img_size']);
                if(!$atts['hide_sec_img'])
                    ri_everest_loop_product_thumbnail($atts['products_img_size']);
                if(!$atts['hide_extend_label']) {
                    $postdate = get_the_time('Y-m-d');   // Post date
                    $postdatestamp = strtotime($postdate);   // Timestamped post date
                    $newness = get_theme_mod('rit_days_products_new', '30');  // Newness in days

                    if ((time() - (60 * 60 * 24 * $newness)) < $postdatestamp) { // If the product was published within the newness time frame display the new badge
                        echo '<span class="product-label label-new">' . esc_html(__('New', 'ri-everest')) . '</span>';
                    }
                    if(is_plugin_active('yith-woocommerce-wishlist/init.php')) {
                        echo do_shortcode('[yith_wcwl_add_to_wishlist]');
                    }
                }
                ?>
            </a>
        </div>
    </div>
    <div class="col-xs-8">
        <div class="product-info">
            <?php
            if ($atts['show_cat'] == '1') {
                echo get_the_term_list(get_the_ID(), 'product_cat', '<div class="product-cat primary-font">', ' - ', '</div>');
            }
            ?>
            <h3 class="product-name">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h3>
            <?php
            if ($atts['products_type'] != 'products_carousel') {
                ?>
                <div class="product-description">
                <?php echo apply_filters('woocommerce_short_description', $post->post_excerpt) ?>
                </div>
                <?php
            }
            ?>
            <div class="item-title">
                <?php
                /**
                 * woocommerce_after_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action('woocommerce_template_single_rating');
                do_action('woocommerce_after_shop_loop_item_title');
                ?>
            </div>
            <?php
            if ($atts['products_type'] != 'products_carousel') {
                ?>
                <div class="group-btn">
                    <?php

                    /**
                     * woocommerce_after_shop_loop_item hook
                     *
                     * @hooked woocommerce_template_loop_add_to_cart - 10
                     */
                    do_action('woocommerce_after_shop_loop_item');
                    do_action('woocommerce_template_loop_add_to_cart');
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</li>

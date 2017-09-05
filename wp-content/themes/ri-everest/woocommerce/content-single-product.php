<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<?php
/**
	 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form();
    return;
}
?>
<div class="main-product-detail row">
    <div id="product-<?php the_ID(); ?>" <?php post_class('detail-product'); ?>>
        <div class="col-xs-12 col-sm-6">
            <?php
            /**
             * woocommerce_before_single_product_summary hook
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
            do_action('woocommerce_before_single_product_summary');
            ?>
        </div>
        <div class="woo-summary col-xs-12 col-sm-6">
            <div class="wrapp-title-product">
                <?php
                do_action('ri_everest_template_single_title');
                $prev_product = get_previous_post(true, '', 'product_cat');
                $next_product = get_next_post(true, '', 'product_cat');
                echo '<ul class="link-products">';
                if (!empty($prev_product)) :
                    $prev_product_link = get_permalink($prev_product->ID);
                    $prev_product_title = $prev_product->post_title;
                    $_product = wc_get_product( $prev_product->ID );
                    ?>
                    <li class="prev-product">
                        <a href="<?php echo esc_url($prev_product_link); ?>" class="product-link-btn"
                           title="<?php echo esc_attr($prev_product_title); ?>"><i
                                class="fa fa-angle-left"></i></a>
                        <div class="product-item">
                            <?php if (get_the_post_thumbnail($prev_product->ID, 'thumbnail') != '') { ?>
                                <a class="product-img" href="<?php echo esc_url($prev_product_link); ?>"
                                   title="<?php echo esc_attr($prev_product_title); ?>">
                                    <?php echo get_the_post_thumbnail($prev_product->ID, 'thumbnail'); ?>
                                </a>
                            <?php } ?>
                            <div class="product-item-info">
                                <h3 class="product-title">
                                    <a href="<?php echo esc_url($prev_product_link); ?>"
                                       title="<?php echo esc_attr($prev_product_title); ?>">
                                        <?php echo esc_html($prev_product_title); ?>
                                    </a>
                                </h3>
                                <?php if ( $price_html = $_product->get_price_html() ) : ?>
                                    <p class="price"><?php echo $price_html; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if (!empty($next_product)) :
                    $next_product_link = get_permalink($next_product->ID);
                    $next_product_title = $next_product->post_title;
                    $_product = wc_get_product( $next_product->ID );
                    ?>
                    <li  class="next-product">
                        <a class="pull-right product-link-btn" href="<?php echo esc_url($next_product_link); ?>"
                           title="<?php echo esc_attr($next_product_title); ?>"><i class="fa fa-angle-right"></i></a>

                        <div class="product-item">
                            <?php if (get_the_post_thumbnail($next_product->ID, 'thumbnail') != '') { ?>
                                <a class="product-img" href="<?php echo esc_url($next_product_link); ?>"
                                   title="<?php echo esc_attr($next_product_title); ?>">
                                    <?php echo get_the_post_thumbnail($next_product->ID, 'thumbnail'); ?>
                                </a>
                            <?php } ?>
                            <div class="product-item-info">
                                <h3 class="product-title">
                                    <a href="<?php echo esc_url($next_product_link); ?>"
                                       title="<?php echo esc_attr($next_product_title); ?>">
                                        <?php echo esc_html($next_product_title); ?>
                                    </a>
                                </h3>
                                <?php if ( $price_html = $_product->get_price_html() ) : ?>
                                    <p class="price"><?php echo $price_html; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endif;
                echo '</ul>';
                ?>
            </div>
            <?php

            /**
             * woocommerce_single_product_summary hook
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             */
            do_action('woocommerce_single_product_summary');
            ?>

        </div><!-- .summary -->
        <div class="col-xs-12 wrapper-detail-product-info">
            <?php
            /**
             * woocommerce_after_single_product_summary hook
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
            do_action('woocommerce_after_single_product_summary');
            ?>
        </div>
        <meta itemprop="url" content="<?php the_permalink(); ?>"/>
    </div>
    <!-- #product-<?php the_ID(); ?> -->
</div>
<?php do_action('woocommerce_after_single_product'); ?>

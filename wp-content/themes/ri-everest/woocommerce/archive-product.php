<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$sidebar = $class_main = $class_content = $class_sidebar = '';

$sidebar = get_theme_mod('rit_default_product_sidebar', 'no-sidebar');
$class_content = $sidebar;
if (isset($_GET['sidebar'])) {
    switch ($_GET['sidebar']) {
        case 'no-sidebar':
            $sidebar = 'no-sidebar';
            break;
        case 'left-sidebar':
            $sidebar = 'left-sidebar';
            break;
        case 'right-sidebar':
            $sidebar = 'right-sidebar';
            break;
        case 'both-sidebar':
            $sidebar = 'both-sidebar';
            break;
    }
}
if ($sidebar == 'no-sidebar' || $sidebar == '') {
    $class_main = 'col-md-12';
} elseif ($sidebar == 'left-sidebar' || $sidebar == 'right-sidebar') {
    $class_main = 'col-sm-12 col-md-9';
} else {
    $class_main = 'col-sm-12 col-md-6';
}
$class_main .= ' new-product';
get_header();
get_theme_mod('rit_product_hide_cart', '') == '1' ? $class_content .= ' hide-cart' : '';
wp_enqueue_script('isotope');
wp_enqueue_script('imagesloaded');
//Layout
$layout = '';
$layout = get_theme_mod('rit_product_layout_view');
if (isset($_GET['product-view'])):
    $layout = $_GET['product-view'];
endif;
if (isset($_COOKIE['product-view'])):
    $layout = $_COOKIE['product-view'];
endif; 
if (have_posts()) : ?>
    <div class="wrapper-breadcrumb woo-breadcrumb breadcrumb-portfolio-page">
        <div class="container">
            <?php
            /**
             * woocommerce_before_main_content hook
             *
             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
             * @hooked woocommerce_breadcrumb - 20
             */
            do_action('woocommerce_before_main_content');
            ?>
        </div>
    </div>
<?php endif; ?>
<main id="rit-main" <?php echo esc_attr(is_search() ? 'class=product-search' : ''); ?>>
    <div class="container woo-category-page <?php echo esc_attr($class_content) ?>">
        <div class="row">
            <?php if ($sidebar == 'left-sidebar' || $sidebar == 'both-sidebar') { ?>
                <?php get_template_part('woocommerce/woo', 'sidebar') ?>
            <?php } ?>
            <div
                class="wrap-content-product-page <?php echo esc_attr($class_main); ?> <?php echo esc_attr(get_theme_mod('rit_product_style', 'default')); ?>">
                <?php if (have_posts()) : ?>

                    <div class="header-woopagecat">
                        <?php get_template_part('woocommerce/woo', 'banner') ?>
                        <?php
                        if (is_shop()) {
                            do_action('woocommerce_archive_description');
                        }
                        ?>
                        <div class="woo-opt-page">
                            <div class="row">
                                <div class="pageview pull-left col-xs-12 col-sm-2">
                                           <span data-view="grid"
                                                 class="pageviewitem <?php
                                                 if ($layout == 'grid'):
                                                     echo esc_attr('active');
                                                 endif; ?>"><i
                                                   class="clever-icon-menu-3"></i> </span>
                                        <span data-view="list" class="pageviewitem  <?php
                                        if ($layout != 'grid'):
                                            echo esc_attr('active');
                                        endif; ?>"><i class="clever-icon-list"></i> </span>
                                </div>
                                <div class="col-xs-12 col-sm-10 align-right">
                                    <span class="filter-trigger"><?php esc_html_e('Filter','ri-everest')?></span>
                                    <?php
                                    /**
                                     * woocommerce_before_shop_loop hook
                                     *
                                     * @hooked woocommerce_result_count - 20
                                     * remove @hooked woocommerce_catalog_ordering - 30
                                     */
                                    do_action('woocommerce_before_shop_loop');
                                    ?>
                                    <div class="sort-by">
                                        <?php
                                        /**
                                         * woocommerce_catalog_ordering hook
                                         *
                                         * @hooked woocommerce_catalog_ordering - 10
                                         */
                                        do_action('woocommerce_catalog_ordering');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rit-smart-layout rit-products list-related <?php echo esc_attr($layout.'-layout') ?> row"
                         data-width="<?php echo get_theme_mod('rit_woocol_min_width', '180') ?>">
                        <?php woocommerce_product_loop_start(); ?>
                        <?php woocommerce_product_subcategories(); ?>
                        <?php
                        while (have_posts()) :
                            the_post();
                            wc_get_template_part('content', 'product');
                        endwhile; // end of the loop. ?>
                        <?php woocommerce_product_loop_end(); ?>
                    </div>
                    <?php
                    /**
                     * woocommerce_after_shop_loop hook
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action('woocommerce_after_shop_loop');
                    ?>
                <?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>
                    <div class="no-product">
                        <?php wc_get_template('loop/no-products-found.php'); ?>
                    </div>
                <?php endif; ?>
                <?php
                /**
                 * woocommerce_after_main_content hook
                 *
                 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                 */
                //do_action( 'woocommerce_after_main_content' );
                ?>
            </div>
            <?php
            /**
             * woocommerce_sidebar hook
             *
             * @hooked woocommerce_get_sidebar - 10
             */
            //do_action( 'woocommerce_sidebar' );
            ?>

            <?php if ($sidebar == 'right-sidebar' || $sidebar == 'both-sidebar') { ?>
                <?php get_template_part('woocommerce/woo-sidebar', 'right') ?>
            <?php } ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>

<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_header();
get_template_part('woo-main', 'cover');
wp_enqueue_script('isotope');
wp_enqueue_script('imagesloaded');
?>
<main id="rit-main">
    <div class="wrapper-breadcrumb">
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
    <div class="container">
        <div class="wrapper-content">
            <div class="main-content product-detail">
                <?php while (have_posts()) : the_post(); ?>

                    <?php wc_get_template_part('content', 'single-product'); ?>

                <?php endwhile; // end of the loop. ?>

                <?php
                /**
                 * woocommerce_after_main_content hook
                 *
                 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                 */
                do_action('woocommerce_after_main_content');
                ?>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>

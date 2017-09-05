<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 10/08/2015
 * Time: 11:38 SA
 */
$class = '';
switch ($atts['column']) {
    case 'columns1':
        $class = 'col-xs-12';
        break;
    case 'columns2':
        $class = 'col-xs-12 col-sm-6';
        break;
    case 'columns3':
        $class = 'col-xs-12 col-sm-4';
        break;
    case 'columns4':
        $class = 'col-xs-12 col-sm-3';
        break;
    case 'columns5':
        $class = 'col-xs-12 col-sm-1-5';
        break;
    case 'columns6':
        $class = 'col-xs-12 col-sm-2';
        break;
    default:
        $class = 'col-xs-12 col-sm-4';
        break;
}
if ($atts['pagination'] == 'ajax' || $atts['pagination'] == 'infinite-scroll') :
    $class .= ' rit-ajax-item';
endif;
global $product;
?>
<li <?php post_class($class.' product '); ?>>
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
            do_action('ri_everest_woocommerce_show_product_loop_sale_flash');
            echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), $atts['products_img_size']);
            if(!$atts['hide_sec_img'])
            ri_everest_loop_product_thumbnail($atts['products_img_size']);
            ?>
        </a>
        <?php
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
        /**
         * woocommerce_after_shop_loop_item hook
         *
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action('woocommerce_after_shop_loop_item');

        ?>
    </div>
    <div class="product-info">
        <h3 class="product-name"><a href="<?php the_permalink(); ?>"
                                    title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
        <?php
        if($atts['show_cat']=='1'){
            echo get_the_term_list(get_the_ID(), 'product_cat', '<div class="product-cat primary-font">', ' - ', '</div>');
        }

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
            <?php do_action('woocommerce_template_single_rating'); ?>
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
        </div>
    </div>
</li>

<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 6/22/2015
 * Time: 4:18 PM
 * All custom function of woo.
 */
if (class_exists('WooCommerce')) {
    add_action('after_setup_theme', 'ri_everest_woocommerce_support');
    function ri_everest_woocommerce_support()
    {
        add_theme_support('woocommerce');
    }

    //Remove link close woo 2.5
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
//Custom number product display
    add_filter('loop_shop_per_page', create_function('$cols', 'return ' . get_theme_mod('rit_number_products_display') . ';'), 20);

//Custom hook for product page woocommerce
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    add_action('woocommerce_template_single_rating', 'woocommerce_template_single_rating', 11);
    add_action('ri_everest_woocommerce_show_product_loop_sale_flash', 'woocommerce_show_product_loop_sale_flash', 5);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    add_action('woocommerce_catalog_ordering', 'woocommerce_catalog_ordering', 10);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    add_action('woocommerce_template_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    add_action('ri_everest_template_single_title', 'woocommerce_template_single_title', 5);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 15);
//Custom number products related display
    add_filter( 'woocommerce_output_related_products_args', 'ri_related_products_args' );
    function ri_related_products_args( $args ) {
        $args['posts_per_page'] =get_theme_mod('rit_number_products_related_display','8'); // 4 related products
        return $args;
    }

    add_action('woocommerce_before_shop_loop_item_title', 'ri_everest_loop_product_thumbnail', 10);

    function ri_everest_loop_product_thumbnail($size = 'shop_catalog')
    {
        $id = get_the_ID();
        $image_product_hover = get_theme_mod('rit_woo_product_hover');
        $gallery = get_post_meta($id, '_product_image_gallery', true);
        if (!empty($gallery) && ($image_product_hover != 'off')) {
            $gallery = explode(',', $gallery);
            $first_image_id = $gallery[0];
            echo wp_get_attachment_image($first_image_id, $size, false, array('class' => 'hover-image'));
        }
    }

    add_filter('gettext', 'ri_everest_sort_change', 20, 3);
    function ri_everest_sort_change($translated_text, $text, $domain)
    {
        if (is_woocommerce()) {
            switch ($translated_text) {
                case 'Out of stock' :
                    $translated_text = esc_html__('Sorry, this product is unavailable. Please choose a different combination.', 'ri-everest');
                    break;
            }
        }
        return $translated_text;
    }

    if (class_exists('YITH_WCQV')) {
        if (is_plugin_active('yith-woocommerce-quick-view/init.php')) {
            remove_action('yith_wcqv_product_image', 'woocommerce_show_product_images', 20);
            add_action('yith_wcqv_product_image', 'ri_everest_product_images_quickview', 20);
            if (!function_exists('ri_everest_product_images_quickview')) {

                /**
                 * Output the product image before the single product summary.
                 *
                 * @subpackage    Product
                 */
                function ri_everest_product_images_quickview()
                {
                    wc_get_template('single-product/product-image-quickview.php');
                }
            }
        }
    }
    /* WooCommerce - Ajax add to cart =================================================================================== */
    add_filter('add_to_cart_fragments', 'rit_header_add_to_cart_fragment');
    //Update topcart when addtocart(Ajax cart)
    add_filter('woocommerce_add_to_cart_fragments', 'ri_everest_top_cart');

    function ri_everest_top_cart($fragments)
    {
        ob_start();
        get_template_part('included/templates/topheadcart');
        $fragments['#topcart'] = ob_get_clean();
        return $fragments;
    }
    /* WooCommerce - Ajax remover cart ================================================================================== */
    add_action('wp_ajax_cart_remove_product', 'rit_woo_remove_product');
    add_action('wp_ajax_nopriv_cart_remove_product', 'rit_woo_remove_product');
    function rit_woo_remove_product()
    {
        $product_key = $_POST['product_key'];

        $cart = WC()->instance()->cart;
        $removed = $cart->remove_cart_item($product_key);

        if ($removed) {
            $output['status'] = '1';
            $output['cart_count'] = $cart->get_cart_contents_count();
            $output['cart_subtotal'] = $cart->get_cart_subtotal();
        } else {
            $output['status'] = '0';
        }
        echo json_encode($output);
        exit;

    }

}
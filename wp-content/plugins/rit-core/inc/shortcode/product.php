<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     2.0.2
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2015 Zootemplate
 * @license     GPL v2
 */
if (!function_exists('rit_shortcode_products')) {
    function rit_shortcode_products($atts, $content)
    {

        if (class_exists('WooCommerce')) {
            $product_categories = get_categories(
                array(
                    'taxonomy' => 'product_cat',
                )
            );
            $product_cats = array();
            $product_cats_all = '';
            if (count($product_categories) > 0) {

                foreach ($product_categories as $value) {
                    $product_cats[$value->name] = $value->slug;
                }
                $product_cats_all = implode(',', $product_cats);
            }


            $product_tags = get_terms('product_tag');
            $product_tags_arr = array();
            $product_tags_all = '';
            if (count($product_tags) > 0) {

                foreach ($product_tags as $value) {
                    $product_tags_arr[$value->name] = $value->slug;
                }
                $product_tags_all = implode(',', $product_tags_arr);
            }


            $attributes_arr = array();
            $attributes_arr_all = '';
            if (function_exists('wc_get_attribute_taxonomies')) {
                $product_attribute_taxonomies = wc_get_attribute_taxonomies();
                if (count($product_attribute_taxonomies) > 0) {

                    foreach ($product_attribute_taxonomies as $value) {
                        $attributes_arr[$value->attribute_label] = $value->attribute_name;
                    }
                    $attributes_arr_all = implode(',', $attributes_arr);
                }
            }

            $atts = shortcode_atts(array(
                'title' => '',
                'post_type' => 'product',
                'product_style' => 'default',
                'pagination' => 'none',
                'column' => 'columns3',
                'posts_per_page' => 4,
                'products_type' => 'products_carousel',
                'products_carousel_style' => 'grid',
                'class_icon_block' => '',
                'show_cat'=>1,
                'hide_extend_label'=>'',
                'product_slider_nav' => 0,
                'product_slider_pagination' => 0,
                'products_img_size' => 'shop_thumbnail',
                'hide_sec_img' => '',
                'paged' => 1,
                'ignore_sticky_posts' => 1,
                'show' => '',
                'orderby' => 'date',
                'element_custom_class' => '',
                'padding_bottom_module' => '',
                'show_cat_filter'=>0,
                'filter_categories' => $product_cats_all,
                'show_tags_filter'=>0,
                'filter_tags' => '',
                'show_attributes_filter'=>0,
                'filter_attributes' => '',
                'show_filter' => 0,
                'show_reset_filter' => 0,
                'show_featured_filter' => 1,
                'show_price_filter' => 0,
                'price_filter_level' => 5,
                'price_filter_range' => 100,
                'show_loadmore' => 1
            ), $atts);


            $meta_query = WC()->query->get_meta_query();


            $wc_attr = array(
                'post_type' => 'product',
                'posts_per_page' => $atts['posts_per_page'],
                'paged' => $atts['paged'],
                'orderby' => $atts['orderby'],
                'ignore_sticky_posts' => $atts['ignore_sticky_posts'],
            );

            if ($atts['show'] == 'featured') {


                $meta_query[] = array(
                    'key' => '_featured',
                    'value' => 'yes'
                );

                $wc_attr['meta_query'] = $meta_query;

            } elseif ($atts['show'] == 'onsale') {

                $product_ids_on_sale = wc_get_product_ids_on_sale();

                $wc_attr['post__in'] = $product_ids_on_sale;

                $wc_attr['meta_query'] = $meta_query;

            } elseif ($atts['show'] == 'best-selling') {

                $wc_attr['meta_key'] = 'total_sales';

                $wc_attr['meta_query'] = $meta_query;

            } elseif ($atts['show'] == 'latest') {

                $wc_attr['orderby'] = 'date';

                $wc_attr['order'] = 'DESC';

            } elseif ($atts['show'] == 'toprate') {

                add_filter('posts_clauses', array('WC_Shortcodes', 'order_by_rating_post_clauses'));

            } elseif ($atts['show'] == 'price') {

                $wc_attr['orderby'] = "meta_value_num {$wpdb->posts}.ID";
                $wc_attr['order'] = 'ASC';
                $wc_attr['meta_key'] = '_price';

            } elseif ($atts['show'] == 'price-desc') {

                $wc_attr['orderby'] = "meta_value_num {$wpdb->posts}.ID";
                $wc_attr['order'] = 'DESC';
                $wc_attr['meta_key'] = '_price';

            }
            if ($atts['filter_categories'] != $product_cats_all && $atts['filter_categories'] != '') {
                $wc_attr['product_cat'] = $atts['filter_categories'];
            }


            $atts['wc_attr'] = $wc_attr;


            return rit_get_template_part('shortcode', 'product', array('atts' => $atts));
        }
        return null;

    }
}
if (!function_exists('products_carousel_script')) {
    function products_carousel_script()
    {
        wp_enqueue_script('owlCarousel', RIT_PLUGIN_URL . '/assets/js/owl.carousel.min.js', false, false, true);
    }
}

add_shortcode('rit_products', 'rit_shortcode_products');

add_action('vc_before_init', 'rit_product_integrate_vc');

if (!function_exists('rit_product_integrate_vc')) {
    function rit_product_integrate_vc()
    {
        if (class_exists('WooCommerce')) {
            $product_categories = get_categories(
                array(
                    'taxonomy' => 'product_cat',
                )
            );
            $product_cats = array();
            $product_cats_all = '';
            if (count($product_categories) > 0) {
                foreach ($product_categories as $value) {
                    if(is_object($value))
                        $product_cats[$value->name] = $value->slug;
                }
                $product_cats_all = implode(',', $product_cats);
            }
            $product_tags = get_terms('product_tag');
            $product_tags_arr = array();
            $product_tags_all = '';
            if (count($product_tags) > 0) {
                foreach ($product_tags as $value) {
                    if(is_object($value))
                        $product_tags_arr[$value->name] = $value->slug;
                }
                $product_tags_all = implode(',', $product_tags_arr);
            }
            $attributes_arr = array();
            $attributes_arr_all = '';
            if (function_exists('wc_get_attribute_taxonomies')) {
                $product_attribute_taxonomies = wc_get_attribute_taxonomies();
                if (count($product_attribute_taxonomies) > 0) {

                    foreach ($product_attribute_taxonomies as $value) {
                        $attributes_arr[$value->attribute_label] = $value->attribute_name;
                    }
                    $attributes_arr_all = implode(',', $attributes_arr);
                }
            }
            vc_map(
                array(
                    'name' => esc_html__('RIT Products', RIT_TEXT_DOMAIN),
                    'base' => 'rit_products',
                    'icon' => 'icon-rit',
                    'category' => esc_html__('RIT', RIT_TEXT_DOMAIN),
                    'description' => esc_html__('Show multiple products by ID or SKU.', RIT_TEXT_DOMAIN),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', RIT_TEXT_DOMAIN),
                            'value' => '',
                            'param_name' => 'title',
                            'description' => esc_html__('Enter text used as shortcode title (Note: located above content element)', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Image size', RIT_TEXT_DOMAIN),
                            'value' => array(
                                esc_html__('Thumbnail', RIT_TEXT_DOMAIN) => 'shop_thumbnail',
                                esc_html__('Catalog Images', RIT_TEXT_DOMAIN) => 'shop_catalog',
                                esc_html__('Single Product Image', RIT_TEXT_DOMAIN) => 'shop_single'
                            ),
                            'param_name' => 'products_img_size',
                            'description' => esc_html__('Select image size follow size in woocommerce product image size', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Hide second image', RIT_TEXT_DOMAIN),
                            'value' => array( esc_html__( 'Yes', RIT_TEXT_DOMAIN ) => 'true' ),
                            'param_name' => 'hide_sec_img',
                            'description' => esc_html__('Hide second image when hover', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            "type" => "rit_multi_select",
                            "heading" => esc_html__("Categories showing in the filter", RIT_TEXT_DOMAIN),
                            "param_name" => "filter_categories",
                            "std" => $product_cats_all,
                            "value" => $product_cats,
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Asset type', RIT_TEXT_DOMAIN),
                            'value' => array(
                                esc_html__('All', RIT_TEXT_DOMAIN) => '',
                                esc_html__('Featured product', RIT_TEXT_DOMAIN) => 'featured',
                                esc_html__('Onsale product', RIT_TEXT_DOMAIN) => 'onsale',
                                esc_html__('Best Selling', RIT_TEXT_DOMAIN) => 'best-selling',
                                esc_html__('Latest product', RIT_TEXT_DOMAIN) => 'latest',
                                esc_html__('Top rate product', RIT_TEXT_DOMAIN) => 'toprate ',
                                esc_html__('Sort by price: low to high', RIT_TEXT_DOMAIN) => 'price',
                                esc_html__('Sort by price: high to low', RIT_TEXT_DOMAIN) => 'price-desc',
                            ),
                            'std' => '',
                            'param_name' => 'show',
                            'description' => esc_html__('Select asset type of products', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Order by', RIT_TEXT_DOMAIN),
                            'value' => array(
                                esc_html__('Date', RIT_TEXT_DOMAIN) => 'date',
                                esc_html__('Menu order', RIT_TEXT_DOMAIN) => 'menu_order',
                                esc_html__('Title', RIT_TEXT_DOMAIN) => 'title',
                            ),
                            'std' => 'date',
                            'param_name' => 'orderby',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Number of product', RIT_TEXT_DOMAIN),
                            'value' => 6,
                            'param_name' => 'posts_per_page',
                            'description' => esc_html__('Number of product showing', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Ignore sticky products", RIT_TEXT_DOMAIN),
                            "param_name" => "ignore_sticky_posts",
                            'std' => 1,
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Load More button", RIT_TEXT_DOMAIN),
                            "param_name" => "show_loadmore",
                            'std' => 1,
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Custom Class', RIT_TEXT_DOMAIN),
                            'value' => '',
                            'param_name' => 'element_custom_class',
                            'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', RIT_TEXT_DOMAIN),
                        ),
                        //Layout
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout type', RIT_TEXT_DOMAIN),
                            'value' => array(
                                esc_html__('Carousel', RIT_TEXT_DOMAIN) => 'products_carousel',
                                esc_html__('Grid', RIT_TEXT_DOMAIN) => 'products_grid',
                                esc_html__('List', RIT_TEXT_DOMAIN) => 'products_list'
                            ),
                            'group'=> esc_html__('Layout', RIT_TEXT_DOMAIN),
                            'param_name' => 'products_type',
                            'description' => esc_html__('Select layout type for display product', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Product Carousel Style', RIT_TEXT_DOMAIN),
                            'value' => array(
                                esc_html__('Grid', RIT_TEXT_DOMAIN) => 'grid',
                                esc_html__('List', RIT_TEXT_DOMAIN) => 'list'
                            ),
                            'group'=> esc_html__('Layout', RIT_TEXT_DOMAIN),
                            'std' => 'grid',
                            'param_name' => 'products_carousel_style',
                            'description' => esc_html__('Select layout of Product carousel', RIT_TEXT_DOMAIN),
                            'dependency' => Array('element' => 'products_type', 'value' => array('products_carousel')),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Show Category', RIT_TEXT_DOMAIN),
                            'value' => array(
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => '1',
                                esc_html__('No', RIT_TEXT_DOMAIN) => '0',
                            ),
                            'group'=> esc_html__('Layout', RIT_TEXT_DOMAIN),
                            'param_name' => 'show_cat',
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Enable slide navigation", RIT_TEXT_DOMAIN),
                            "param_name" => "product_slider_nav",
                            'std' => 0,
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                            'group'=> esc_html__('Layout', RIT_TEXT_DOMAIN),
                            'dependency' => Array('element' => 'products_type', 'value' => array('products_carousel')),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Enable slide pagination", RIT_TEXT_DOMAIN),
                            "param_name" => "product_slider_pagination",
                            'std' => 0,
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                            'group'=> esc_html__('Layout', RIT_TEXT_DOMAIN),
                            'dependency' => Array('element' => 'products_type', 'value' => array('products_carousel')),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Style', RIT_TEXT_DOMAIN),
                            'value' => array(
                                esc_html__('Default', RIT_TEXT_DOMAIN) => 'default',
                                esc_html__('Style 1', RIT_TEXT_DOMAIN) => 'product_style_1',
                                esc_html__('Style 2', RIT_TEXT_DOMAIN) => 'product_style_2',
                                esc_html__('Style 3', RIT_TEXT_DOMAIN) => 'product_style_3',
                                esc_html__('Style 4', RIT_TEXT_DOMAIN) => 'product_style_4',
                                esc_html__('Style 5', RIT_TEXT_DOMAIN) => 'product_style_5',
                                esc_html__('Style 6', RIT_TEXT_DOMAIN) => 'product_style_6'
                            ),
                            'group'=> esc_html__('Layout', RIT_TEXT_DOMAIN),
                            'param_name' => 'product_style',
                            'description' => esc_html__('Select layout type for display product', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Class icon of block', RIT_TEXT_DOMAIN),
                            'group'=> esc_html__('Layout', RIT_TEXT_DOMAIN),
                            'param_name' => 'class_icon_block',
                            'description' => esc_html__('Add class of font icon you use', RIT_TEXT_DOMAIN),
                            "dependency" => Array('element' => 'product_style', 'value' => array('product_style_4')),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Column number', RIT_TEXT_DOMAIN),
                            'value' => array(
                                esc_html__('1 Columns', RIT_TEXT_DOMAIN) => 'columns1',
                                esc_html__('2 Columns', RIT_TEXT_DOMAIN) => 'columns2',
                                esc_html__('3 Columns', RIT_TEXT_DOMAIN) => 'columns3',
                                esc_html__('4 Columns', RIT_TEXT_DOMAIN) => 'columns4',
                                esc_html__('5 Columns', RIT_TEXT_DOMAIN) => 'columns5',
                                esc_html__('6 Columns', RIT_TEXT_DOMAIN) => 'columns6'
                            ),
                            'group'=> esc_html__('Layout', RIT_TEXT_DOMAIN),
                            'std' => 'columns3',
                            'param_name' => 'column',
                            'description' => esc_html__('Display product with the number of column', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Hide extend label', RIT_TEXT_DOMAIN),
                            'value' => array( esc_html__( 'Yes', RIT_TEXT_DOMAIN ) => 'true' ),
                            'param_name' => 'hide_extend_label',
                            'group'=> esc_html__('Layout', RIT_TEXT_DOMAIN),
                            'description' => esc_html__('Hide new label, wish list button', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Bottom padding for the module', RIT_TEXT_DOMAIN),
                            'value' => '',
                            'param_name' => 'padding_bottom_module',
                            'group'=> esc_html__('Layout', RIT_TEXT_DOMAIN),
                            'description' => esc_html__('The space in bottom. Default is 50px', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Filter", RIT_TEXT_DOMAIN),
                            "param_name" => "show_filter",
                            'std' => 0,
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Reset Filter", RIT_TEXT_DOMAIN),
                            "param_name" => "show_reset_filter",
                            'std' => 0,
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Featured, Onsale, Best Selling, Latest product filter", RIT_TEXT_DOMAIN),
                            "param_name" => "show_featured_filter",
                            'std' => '1',
                            "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                        ),

                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show category filter", RIT_TEXT_DOMAIN),
                            "param_name" => "show_cat_filter",
                            "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                            "std" => '0',
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Product Tags Filter", RIT_TEXT_DOMAIN),
                            "param_name" => "show_tags_filter",
                            "std" => '0',
                            "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            "type" => "rit_multi_select",
                            "heading" => esc_html__("Tags showing in the filter", RIT_TEXT_DOMAIN),
                            "param_name" => "filter_tags",
                            "dependency" => Array('element' => 'show_tags_filter', 'value' => array('1')),
                            "std" => '',
                            "value" => $product_tags_arr,
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Product Attributes Filter", RIT_TEXT_DOMAIN),
                            "param_name" => "show_attributes_filter",
                            "std" => '0',
                            "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            "type" => "rit_multi_select",
                            "heading" => esc_html__("Product attributes showing in the filter", RIT_TEXT_DOMAIN),
                            "param_name" => "filter_attributes",
                            "dependency" => Array('element' => 'show_attributes_filter', 'value' => array('1')),
                            "std" => '',
                            "value" => $attributes_arr,
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Price Filter", RIT_TEXT_DOMAIN),
                            "param_name" => "show_price_filter",
                            "std" => 1,
                            "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                            "value" => array(
                                esc_html__('No', RIT_TEXT_DOMAIN) => 0,
                                esc_html__('Yes', RIT_TEXT_DOMAIN) => 1,
                            ),
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Number of price levels', RIT_TEXT_DOMAIN),
                            'value' => '5',
                            'std' => '5',
                            'param_name' => 'price_filter_level',
                            "dependency" => Array('element' => 'show_price_filter', 'value' => array('1')),
                            'description' => esc_html__('Number of price levels showing in the filter', RIT_TEXT_DOMAIN),
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Filter range', RIT_TEXT_DOMAIN),
                            'std' => '100',
                            'value' => '100',
                            'param_name' => 'price_filter_range',
                            "dependency" => Array('element' => 'show_price_filter', 'value' => array('1')),
                            'group'=> esc_html__('Filter', RIT_TEXT_DOMAIN),
                            'description' => esc_html__('Range of price filter. Example range equal 100 => price filter are "0$ to 100$", "100$ to 200$"', RIT_TEXT_DOMAIN),
                        ),
                    )
                )
            );
        }
    }
}
<?php

/**
 * The Shortcode DEAL
 */


function rit_deal_shortcode( $atts) {
    $atts=shortcode_atts(
        array(
            'title'             => '',
            'column' 			=> 'columns3',
            'class_icon_block'=>'',
            'product_style'     =>'default',
            'products_img_size' => 'shop_thumbnail',
            'carousel_style'		=> 'false',
            'posts_per_page' 		=> '8',
            'element_custom_class' => '',
            'padding_bottom_module' => ''

        ), $atts );
    return rit_get_template_part('shortcode', 'product-deal', array('atts' => $atts));
}
if (!function_exists('products_countdown_script')) {
    function products_countdown_script()
    {
        wp_enqueue_script('countdownjs', RIT_PLUGIN_URL . '/assets/js/countdown.js', array(), false, true);
    }
}
add_shortcode( 'rit_deal', 'rit_deal_shortcode' );

add_action( 'vc_before_init', 'rit_deal_shortcode_vc' );

/**
 * The VC Functions
 */
function rit_deal_shortcode_vc() {
    vc_map(
        array(
            'icon'     => 'rit-deal',
            'name'     => __( 'RIT Deal Products', RIT_TEXT_DOMAIN ),
            'base'     => 'rit_deal',
            'category' => __( 'RIT', RIT_TEXT_DOMAIN ),
            'params'   => array(
                array(
                    'type'       => 'textfield',
                    'heading'    => esc_html__( 'Title', RIT_TEXT_DOMAIN ),
                    'param_name' => 'title',
                    'value'      => '',
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__("Enable Carousel", RIT_TEXT_DOMAIN),
                    'param_name' => 'carousel_style',
                    'value' => array(
                        esc_html__('Yes', RIT_TEXT_DOMAIN) => 'true')
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Style', RIT_TEXT_DOMAIN),
                    'value' => array(
                        esc_html__('Default', RIT_TEXT_DOMAIN) => 'product_default_style',
                        esc_html__('Style 1', RIT_TEXT_DOMAIN) => 'product_style_1',
                        esc_html__('Style 2', RIT_TEXT_DOMAIN) => 'product_style_2',
                        esc_html__('Style 3', RIT_TEXT_DOMAIN) => 'product_style_3',
                        esc_html__('Style 4', RIT_TEXT_DOMAIN) => 'product_style_4'
                    ),
                    'param_name' => 'product_style',
                    'description' => esc_html__('Select layout type for display product', RIT_TEXT_DOMAIN),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Class icon of block', RIT_TEXT_DOMAIN),
                    'param_name' => 'class_icon_block',
                    'description' => esc_html__('Add class of font icon you use', RIT_TEXT_DOMAIN),
                    "dependency" => Array('element' => 'product_style', 'value' => array('product_style_4')),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Image size', RIT_TEXT_DOMAIN),
                    'value' => array(
                        esc_html__('Thumbnail', RIT_TEXT_DOMAIN) => 'shop_thumbnail',
                        esc_html__('Catalog Images', RIT_TEXT_DOMAIN) => 'shop_catalog',
                        esc_html__('Single Product Image', RIT_TEXT_DOMAIN) => 'shop_single'
                    ),
                    'std' => 'shop_thumbnail',
                    'param_name' => 'products_img_size',
                    'description' => esc_html__('Select image size follow size in woocommerce product image size', RIT_TEXT_DOMAIN),
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
                    'std' => 'columns3',
                    'param_name' => 'column',
                    'description' => esc_html__('Display product with the number of column', RIT_TEXT_DOMAIN),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Number of Post', RIT_TEXT_DOMAIN),
                    'value' => 8,
                    'param_name' => 'posts_per_page',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Extra class name', RIT_TEXT_DOMAIN ),
                    'param_name' => 'element_custom_class',
                    'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', RIT_TEXT_DOMAIN )
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Padding bottom', RIT_TEXT_DOMAIN ),
                    'param_name' => 'padding_bottom_module',
                    'description' => esc_html__( 'Set padding bottom.', RIT_TEXT_DOMAIN )
                )
            )
        )
    );
}
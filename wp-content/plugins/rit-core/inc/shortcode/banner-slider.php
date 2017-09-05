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

function rit_shortcode_banner_slider($atts)
{

    $atts = shortcode_atts(
        array(
            'posts_per_page' => "-1",
            'number' => 5,
            'order' => 'DESC',
            'orderby' => 'date',
            'target' => '_blank',
            'speed' => 1000,
            'auto' => 'true',
            'arrow' => 'true',
            'size' => 'medium',
            'el_class'=> '',

        ), $atts);

    return rit_get_template_part('shortcode', 'banner-slider', array('atts' => $atts));
}

add_shortcode('rit_banner_slider', 'rit_shortcode_banner_slider');

add_action('vc_before_init', 'rit_banner_slider_integrate_vc');

if (!function_exists('rit_banner_slider_integrate_vc')) {
    function rit_banner_slider_integrate_vc()
    {
        vc_map(
            array(
                'name' => esc_html__('RIT Banner Slider', RIT_TEXT_DOMAIN),
                'base' => 'rit_banner_slider',
                'icon' => 'icon-rit',
                'category' => esc_html__('RIT', RIT_TEXT_DOMAIN),
                'description' => esc_html__('Show banner carousel', RIT_TEXT_DOMAIN),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Number of banner', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'param_name' => 'posts_per_page',
                        'description' => esc_html__('Number of banner in slide', RIT_TEXT_DOMAIN),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Number item show', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'param_name' => 'number',
                        'description' => esc_html__('Number of image showing', RIT_TEXT_DOMAIN),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Order by', RIT_TEXT_DOMAIN ),
                        'param_name' => 'orderby',
                        'value' => array(
                            '',
                            esc_html__( 'Date', RIT_TEXT_DOMAIN ) => 'date',
                            esc_html__( 'ID', RIT_TEXT_DOMAIN ) => 'ID',
                            esc_html__( 'Author', RIT_TEXT_DOMAIN ) => 'author',
                            esc_html__( 'Title', RIT_TEXT_DOMAIN ) => 'title',
                            esc_html__( 'Modified', RIT_TEXT_DOMAIN ) => 'modified',
                            esc_html__( 'Random', RIT_TEXT_DOMAIN ) => 'rand',
                            esc_html__( 'Comment count', RIT_TEXT_DOMAIN ) => 'comment_count',
                            esc_html__( 'Menu order', RIT_TEXT_DOMAIN ) => 'menu_order'
                        ),
                        'description' => sprintf( esc_html__( 'Select how to sort retrieved posts. More at %s.', RIT_TEXT_DOMAIN ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Order', RIT_TEXT_DOMAIN ),
                        'param_name' => 'order',
                        'value' => array(
                            esc_html__( 'Descending', RIT_TEXT_DOMAIN ) => 'DESC',
                            esc_html__( 'Ascending', RIT_TEXT_DOMAIN ) => 'ASC'
                        ),
                        'description' => sprintf( esc_html__( 'Select ascending or descending order. More at %s.', RIT_TEXT_DOMAIN ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Link Target', RIT_TEXT_DOMAIN ),
                        'param_name' => 'target',
                        'value' => array(
                            esc_html__( 'Same window', RIT_TEXT_DOMAIN ) => '_self',
                            esc_html__( 'New window', RIT_TEXT_DOMAIN ) => "_blank"
                        ),
                        'dependency' => array(
                            'element' => 'img_link',
                            'not_empty' => true
                        ),
                        'description' => esc_html__('Number of product will showing', RIT_TEXT_DOMAIN),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Slide Speed', RIT_TEXT_DOMAIN),
                        'value' => '1000',
                        'param_name' => 'speed',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Auto slide', RIT_TEXT_DOMAIN ),
                        'param_name' => 'auto',
                        'description' => esc_html__( 'If checked, image will auto run carousel.', RIT_TEXT_DOMAIN ),
                        'value' => array( esc_html__( 'Yes', RIT_TEXT_DOMAIN ) => 'true' )
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Show Arrow', RIT_TEXT_DOMAIN ),
                        'param_name' => 'arrow',
                        'value' => array( esc_html__( 'Yes', RIT_TEXT_DOMAIN ) => 'true' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Banner size', RIT_TEXT_DOMAIN ),
                        'param_name' => 'size',
                        'value' => 'medium',
                        'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', RIT_TEXT_DOMAIN )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Extra class name', RIT_TEXT_DOMAIN ),
                        'param_name' => 'el_class',
                        'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', RIT_TEXT_DOMAIN )
                    )
                    
                )
            )
        );
    }
}
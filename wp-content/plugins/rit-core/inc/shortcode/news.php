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

if (!function_exists('rit_shortcode_news')) {
    function rit_shortcode_news($atts, $content)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'layout_type' => '',
            'cat' => '',
            'posts_per_page' => '4',
            'columns' => 2,
            'orderby' => 'date',
            'order' => 'DESC',
            'post__in' => '',
            'post__not_in' => '',
            'view_more' => false,
            'animation_type' => '',
            'animation_duration' => '',
            'animation_delay' => '',
            'el_class' => ''
        ), $atts);

        $layout_type = ($atts['layout_type'] != '') ? $atts['layout_type'] : 'vertical';

        return rit_get_template_part('shortcode', 'news-'.$layout_type, array('atts' => $atts));
    }
}

add_shortcode('rit_news', 'rit_shortcode_news');

add_action('vc_before_init', 'rit_news_integrate_vc');

if (!function_exists('rit_news_integrate_vc')) {
    function rit_news_integrate_vc()
    {
        vc_map(
            array(
                'name' => esc_html__('RIT News', RIT_TEXT_DOMAIN),
                'base' => 'rit_news',
                'icon' => 'icon-rit',
                'category' => esc_html__('RIT', RIT_TEXT_DOMAIN),
                'description' => esc_html__('Get post and display for news', RIT_TEXT_DOMAIN),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', RIT_TEXT_DOMAIN),
                        'value' => 6,
                        'param_name' => 'title',
                        'description' => esc_html__('Enter text used as shortcode title (Note: located above content element)', RIT_TEXT_DOMAIN),
                    ),
                    array(
                        'type' => 'rit_image_radio',
                        'heading' => esc_html__('Layout type', RIT_TEXT_DOMAIN),
                        'value' => array(
                            esc_html__(RIT_PLUGIN_URL.'assets/images/headline.png', RIT_TEXT_DOMAIN) => 'headline',
                            esc_html__(RIT_PLUGIN_URL.'assets/images/horizontal.png', RIT_TEXT_DOMAIN) => 'horizontal',
                            esc_html__(RIT_PLUGIN_URL.'assets/images/vertical.png', RIT_TEXT_DOMAIN) => 'vertical',
                            esc_html__(RIT_PLUGIN_URL.'assets/images/normal.png', RIT_TEXT_DOMAIN) => 'normal',
                        ),
                        'width' => '100px',
                        'height' => '70px',
                        'param_name' => 'layout_type',
                        'description' => esc_html__('Select layout type for display post', RIT_TEXT_DOMAIN),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Column', RIT_TEXT_DOMAIN),
                        "value" => array(
                            esc_html__('1', RIT_TEXT_DOMAIN ) => 1,
                            esc_html__('2', RIT_TEXT_DOMAIN ) => 2,
                            esc_html__('3', RIT_TEXT_DOMAIN ) => 3,
                            esc_html__('4', RIT_TEXT_DOMAIN ) => 4
                        ),
                        'std' => '2',
                        'param_name' => 'columns',
                        'description' => esc_html__('Display post with the number of column', RIT_TEXT_DOMAIN),
                    ),
                    array(
                        "type" => "rit_post_categories",
                        "heading" => esc_html__("Category IDs", RIT_TEXT_DOMAIN),
                        "description" => esc_html__("Select category", RIT_TEXT_DOMAIN),
                        "param_name" => "cat",
                        "admin_label" => true,
                        'description' => esc_html__('Select category which you want to get post in', RIT_TEXT_DOMAIN),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Number of post', RIT_TEXT_DOMAIN),
                        'value' => 6,
                        'param_name' => 'posts_per_page',
                        'description' => esc_html__('Number of post showing', RIT_TEXT_DOMAIN),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Order by', RIT_TEXT_DOMAIN),
                        'value' => array(
                            esc_html__('Date', RIT_TEXT_DOMAIN) => 'date',
                            esc_html__('Random', RIT_TEXT_DOMAIN) => 'ran',
                            esc_html__('Title', RIT_TEXT_DOMAIN) => 'title',
                            esc_html__('Modified date', RIT_TEXT_DOMAIN) => 'modified',
                        ),
                        'std' => 'date',
                        'param_name' => 'orderby',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Order', RIT_TEXT_DOMAIN),
                        'value' => array(
                            esc_html__('DESC', RIT_TEXT_DOMAIN) => 'DESC',
                            esc_html__('ASC', RIT_TEXT_DOMAIN) => 'ASC',
                        ),
                        'std' => 'date',
                        'param_name' => 'order',
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Exclude Post IDs", RIT_TEXT_DOMAIN),
                        "description" => esc_html__("comma separated list of post ids", RIT_TEXT_DOMAIN),
                        "param_name" => "post__not_in"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Include Post IDs", RIT_TEXT_DOMAIN),
                        "description" => esc_html__("comma separated list of post ids", RIT_TEXT_DOMAIN),
                        "param_name" => "post__in"
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__("Show View More", RIT_TEXT_DOMAIN),
                        'param_name' => 'view_more',
                        'std' => 'no',
                        'value' => array(esc_html__('Yes', RIT_TEXT_DOMAIN) => 'yes')
                    ),
                    array(
                        "type" => 'rit_animation_type',
                        "heading" => esc_html__("Animation Type", RIT_TEXT_DOMAIN),
                        "param_name" => "animation_type",
                        "admin_label" => true
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Animation Duration", RIT_TEXT_DOMAIN),
                        "param_name" => "animation_duration",
                        "description" => esc_html__("numerical value (unit: milliseconds)", RIT_TEXT_DOMAIN),
                        "value" => '1000'
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Animation Delay", RIT_TEXT_DOMAIN),
                        "param_name" => "animation_delay",
                        "description" => esc_html__("numerical value (unit: milliseconds)", RIT_TEXT_DOMAIN),
                        "value" => '0'
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
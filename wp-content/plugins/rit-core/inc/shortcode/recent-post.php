<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     2.0.1
 * @author      CleverSoft
 * @link        http://cleversoft.co
 * @copyright   Copyright (c) 2015 CleverSoft
 * @license     GPL v2
 */

if (!function_exists('rit_shortcode_recent_post')) {
    function rit_shortcode_recent_post($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'columns' => 3,
            'cat' => '',
            'parent' => 1,
            'post_in' => '',
            'number' => 8,
            'view_more' => false,
            'el_class' => '',
            'pagination' => 0
        ), $atts);

        return rit_get_template_part('shortcode', 'recent-post', array('atts' => $atts));
    }
}
add_shortcode('rit_recent_post', 'rit_shortcode_recent_post');

add_action('vc_before_init', 'rit_recent_post_integrate_vc');

if (!function_exists('rit_recent_post_integrate_vc')) {
    function rit_recent_post_integrate_vc()
    {
        vc_map(array(
            'name' => esc_html__('RIT Recent Post', RIT_TEXT_DOMAIN),
            'base' => 'rit_recent_post',
            'category' => esc_html__('RIT', RIT_TEXT_DOMAIN),
            'description' => esc_html__('Show recent post.', RIT_TEXT_DOMAIN),
            'icon' => 'rit-blog',
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Title", RIT_TEXT_DOMAIN),
                    "param_name" => "title",
                    "admin_label" => true,
                    'description' => esc_html__('Enter text used as shortcode title (Note: located above content element)', RIT_TEXT_DOMAIN),
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
                    "type" => "dropdown",
                    "heading" => esc_html__("Get posts in children of categories", RIT_TEXT_DOMAIN),
                    "param_name" => "parent",
                    'std' => 1,
                    "value" => array(
                        esc_html__('No', RIT_TEXT_DOMAIN ) => 0,
                        esc_html__('Yes', RIT_TEXT_DOMAIN ) => 1,
                    ),
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Post IDs", RIT_TEXT_DOMAIN),
                    "description" => esc_html__("comma separated list of post ids", RIT_TEXT_DOMAIN),
                    "param_name" => "post_in"
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Posts number", RIT_TEXT_DOMAIN),
                    "param_name" => "number",
                    "value" => '8',
                    'description' => esc_html__('Number of post showing', RIT_TEXT_DOMAIN),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Extra class name', RIT_TEXT_DOMAIN ),
                    'param_name' => 'el_class',
                    'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', RIT_TEXT_DOMAIN )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Enable pagination", RIT_TEXT_DOMAIN),
                    "param_name" => "pagination",
                    'std' => '7',
                    "value" => array(
                        esc_html__('No', RIT_TEXT_DOMAIN ) => 0,
                        esc_html__('Yes', RIT_TEXT_DOMAIN ) => 1,
                    )
                )
            )
        ));
    }
}

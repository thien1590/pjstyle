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

if (!function_exists('rit_shortcode_blog')) {
    function rit_shortcode_blog($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'post_layout' => 'timeline',
            'post_style'=>'default',
            'columns' => 3,
            'cat' => '',
            'parent'=>1,
            'post_in' => '',
            'number' => 8,
            'blog_img_size'=>'medium',
            'pagination'=>'standard',
            'output_type'=>'no',
            'carousel_pag'=>'',
            'carousel_nav'=>'',
            'excerpt_lenght'=>40,
            'view_more' => false,
            'animation_type' => '',
            'animation_duration' => '',
            'animation_delay' => '',
            'el_class' => ''
        ), $atts);

        $layout_type = ($atts['post_layout'] != '') ? $atts['post_layout'] : 'large';

        return rit_get_template_part('shortcode', 'blog-' . $layout_type, array('atts' => $atts));
    }
}
add_shortcode('blog', 'rit_shortcode_blog');

add_action('vc_before_init', 'rit_blog_integrate_vc');

if (!function_exists('rit_blog_integrate_vc')) {
    function rit_blog_integrate_vc()
    {
        vc_map(array(
            'name' => esc_html__('RIT Blog', RIT_TEXT_DOMAIN),
            'base' => 'blog',
            'category' => esc_html__('RIT', RIT_TEXT_DOMAIN),
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
                    "type" => "dropdown",
                    "heading" => esc_html__("Blog Style", RIT_TEXT_DOMAIN),
                    "param_name" => "post_style",
                    'std' => 'timeline',
                    "value" => array(
                        esc_html__('Default', RIT_TEXT_DOMAIN ) => 'default',
                        esc_html__('Style 1', RIT_TEXT_DOMAIN ) => 'blog_style_1',
                        esc_html__('Style 2', RIT_TEXT_DOMAIN ) => 'blog_style_2',
                        esc_html__('Style 3', RIT_TEXT_DOMAIN ) => 'blog_style_3',
                        esc_html__('Style 4', RIT_TEXT_DOMAIN ) => 'blog_style_4',
                        esc_html__('Style 5', RIT_TEXT_DOMAIN ) => 'blog_style_5',

                    ),
                    "admin_label" => true,
                    'description' => esc_html__('Select style for display post', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Blog Layout", RIT_TEXT_DOMAIN),
                    "param_name" => "post_layout",
                    'std' => 'timeline',
                    "value" => array(
                        esc_html__('Carousel', RIT_TEXT_DOMAIN ) => 'carousel',
                        esc_html__('Grid', RIT_TEXT_DOMAIN ) => 'grid',
                        esc_html__('Large', RIT_TEXT_DOMAIN ) => 'large',
                        esc_html__('Masonry', RIT_TEXT_DOMAIN ) => 'masonry',
                        esc_html__('Medium', RIT_TEXT_DOMAIN ) => 'medium',
                        esc_html__('Time line', RIT_TEXT_DOMAIN ) => 'timeline'

                    ),
                    "admin_label" => true,
                    'description' => esc_html__('Select layout type for display post', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Columns", RIT_TEXT_DOMAIN),
                    "param_name" => "columns",
                    'dependency' => Array('element' => 'post_layout', 'value' => array('grid','carousel')),
                    'std' => '3',
                    "value" => array(
                        esc_html__('1', RIT_TEXT_DOMAIN ) => 1,
                        esc_html__('2', RIT_TEXT_DOMAIN ) => 2,
                        esc_html__('3', RIT_TEXT_DOMAIN ) => 3,
                        esc_html__('4', RIT_TEXT_DOMAIN ) => 4,
                        esc_html__('6', RIT_TEXT_DOMAIN ) => 6
                    ),
                    'description' => esc_html__('Display post with the number of column', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "rit_post_categories",
                    "heading" => esc_html__("Category IDs", RIT_TEXT_DOMAIN),
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
                    'description' => esc_html__('Yes, If you want to get post in all children categories', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Post IDs", RIT_TEXT_DOMAIN),
                    "description" => esc_html__("comma separated list of post ids", RIT_TEXT_DOMAIN),
                    "param_name" => "post_in"
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Image size', RIT_TEXT_DOMAIN),
                    'value' => array(
                        esc_html__('Thumbnail', RIT_TEXT_DOMAIN) => 'thumbnail',
                        esc_html__('Medium', RIT_TEXT_DOMAIN) => 'medium',
                        esc_html__('Large', RIT_TEXT_DOMAIN) => 'large',
                        esc_html__('Full', RIT_TEXT_DOMAIN) => 'full'
                    ),
                    'param_name' => 'blog_img_size',
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Posts Count", RIT_TEXT_DOMAIN),
                    "param_name" => "number",
                    "value" => '8',
                    'description' => esc_html__('Number of post showing', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Pagination", RIT_TEXT_DOMAIN),
                    "param_name" => "pagination",
                    'std' => 'standard',
                    "value" => array(
                        esc_html__('Standard', RIT_TEXT_DOMAIN ) => 'standard',
                        esc_html__('Infinite Scroll', RIT_TEXT_DOMAIN ) => 'infinite-scroll',
                        esc_html__('Ajax Load more', RIT_TEXT_DOMAIN ) => 'ajax',
                        esc_html__('None', RIT_TEXT_DOMAIN ) => 'none',
                    ),
                    'description' => esc_html__('Select pagination type', RIT_TEXT_DOMAIN),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__("Show Carousel Pagination", RIT_TEXT_DOMAIN),
                    'param_name' => 'carousel_pag',
                    'std' => 'no',
                    'value' => array(esc_html__('Yes', RIT_TEXT_DOMAIN) => 'yes'),
                    'dependency' => Array('element' => 'post_layout', 'value' => array('carousel')),
                    'description' => esc_html__('Yes, If you want to Show Carousel Pagination', RIT_TEXT_DOMAIN),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__("Show Carousel Navigation", RIT_TEXT_DOMAIN),
                    'param_name' => 'carousel_nav',
                    'std' => 'no',
                    'value' => array(esc_html__('Yes', RIT_TEXT_DOMAIN) => 'yes'),
                    'dependency' => Array('element' => 'post_layout', 'value' => array('carousel')),
                    'description' => esc_html__('Yes, If you want to Show Carousel Navigation', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Content display", RIT_TEXT_DOMAIN),
                    "param_name" => "output_type",
                    'std' => 1,
                    "value" => array(
                        esc_html__('None', RIT_TEXT_DOMAIN ) => 'no',
                        esc_html__('Excerpt', RIT_TEXT_DOMAIN ) => 'excerpt',
                        esc_html__('Full content', RIT_TEXT_DOMAIN ) => 'content',
                    ),
                    'description' => esc_html__('Select type of content', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Excerpt lenght", RIT_TEXT_DOMAIN),
                    "param_name" => "excerpt_lenght",
                    'dependency' => Array('element' => 'output_type', 'value' => array('excerpt')),
                    "description" => esc_html__("Total character display of excerpt.", RIT_TEXT_DOMAIN),
                    "value" => '40'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__("Show View More", RIT_TEXT_DOMAIN),
                    'param_name' => 'view_more',
                    'std' => 'no',
                    'value' => array(esc_html__('Yes', RIT_TEXT_DOMAIN) => 'yes'),
                    'description' => esc_html__('Yes, If you want to show button "Read more"', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => 'rit_animation_type',
                    "heading" => esc_html__("Animation Type", RIT_TEXT_DOMAIN),
                    "param_name" => "animation_type",
                    "admin_label" => true,
                    'description' => esc_html__('Select animation type', RIT_TEXT_DOMAIN),
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
        ));
    }
}

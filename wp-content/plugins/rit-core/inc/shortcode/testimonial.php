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

if (!function_exists('rit_shortcode_testimonial')) {
    function rit_shortcode_testimonial($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'category' => '',
            'order_by' => 'date',
            'item_count' => '3',
            'output_type' => 'excerpt',
            'excerpt_length' => '20',
            'columns'=>'1',
            'style' => 'normal',
            'preset_style' => 'default',
            'hide_avatar'=>'',
            'carousel_nav' => 'no',
            'carousel_pag' => 'no',
            'page_link' => 'no',
            'background' => '',
            'background_color' => '',
            'el_class' => '',
        ), $atts);

        return rit_get_template_part('shortcode', 'testimonial', array('atts' => $atts));
    }
}
add_shortcode('testimonial', 'rit_shortcode_testimonial');

add_action('vc_before_init', 'rit_testimonial_integrate_vc');

if (!function_exists('rit_testimonial_integrate_vc')) {
    function rit_testimonial_integrate_vc()
    {
        vc_map(array(
            "name" => esc_html__("RIT Testimonials", RIT_TEXT_DOMAIN),
            "base" => "testimonial",
            "class" => "",
            "icon" => "spb-icon-testimonial",
            "wrapper_class" => "clearfix",
            "controls" => "full",
            'category' => esc_html__('RIT', RIT_TEXT_DOMAIN),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Title", RIT_TEXT_DOMAIN),
                    "param_name" => "title",
                    "value" => "",
                    "description" => esc_html__("Heading text. Leave it empty if not needed.", RIT_TEXT_DOMAIN)
                ),
                array(
                    "type" => "rit_testimonial_categories",
                    "heading" => esc_html__("Testimonials category", RIT_TEXT_DOMAIN),
                    "param_name" => "category",
                    "description" => esc_html__("Choose the category for the testimonials.", RIT_TEXT_DOMAIN)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Testimonials Order", RIT_TEXT_DOMAIN),
                    "param_name" => "order_by",
                    "value" => array(
                        esc_html__('Random', RIT_TEXT_DOMAIN) => "rand",
                        esc_html__('Latest', RIT_TEXT_DOMAIN) => "date"
                    ),
                    "description" => esc_html__("Choose the order of the testimonials.", RIT_TEXT_DOMAIN)
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Number of items", RIT_TEXT_DOMAIN),
                    "param_name" => "item_count",
                    "value" => "3",
                    "description" => esc_html__("The number of testimonials to show per page. Leave blank to show ALL testimonials.", RIT_TEXT_DOMAIN)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Content display", RIT_TEXT_DOMAIN),
                    "param_name" => "output_type",
                    'std' => 1,
                    "value" => array(
                        esc_html__('Excerpt', RIT_TEXT_DOMAIN) => 'excerpt',
                        esc_html__('Full content', RIT_TEXT_DOMAIN) => 'content',
                    ),
                    'description' => esc_html__('Select type of content', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Excerpt lenght", RIT_TEXT_DOMAIN),
                    "param_name" => "excerpt_length",
                    'dependency' => Array('element' => 'output_type', 'value' => array('excerpt')),
                    "description" => esc_html__("Total character display of excerpt.", RIT_TEXT_DOMAIN),
                    "value" => '20'
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Testimonials Style", RIT_TEXT_DOMAIN),
                    "param_name" => "style",
                    "value" => array(
                        esc_html__('Normal', RIT_TEXT_DOMAIN) => "normal",
                        esc_html__('Carousel', RIT_TEXT_DOMAIN) => "carousel"
                    ),
                    'std' => 'normal',
                    'group'=> esc_html__('Style', RIT_TEXT_DOMAIN),
                    "description" => esc_html__("Choose style display.", RIT_TEXT_DOMAIN)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Preset Style", RIT_TEXT_DOMAIN),
                    "param_name" => "preset_style",
                    "value" => array(
                        esc_html__('Default', RIT_TEXT_DOMAIN) => "default",
                        esc_html__('Style 1', RIT_TEXT_DOMAIN) => "style-1",
                        esc_html__('Style 2', RIT_TEXT_DOMAIN) => "style-2",
                        esc_html__('Style 3', RIT_TEXT_DOMAIN) => "style-3",
                        esc_html__('Style 4', RIT_TEXT_DOMAIN) => "style-4",
                        esc_html__('Style 5', RIT_TEXT_DOMAIN) => "style-5"
                    ),
                    'std' => 'default',
                    'group'=> esc_html__('Style', RIT_TEXT_DOMAIN),
                    "description" => esc_html__("Choose preset style display.", RIT_TEXT_DOMAIN)
                ),
                array(
                    "type" => "checkbox",
                    "heading" => esc_html__("Hide avatar author", RIT_TEXT_DOMAIN),
                    "param_name" => "hide_avatar",
                    'value' => array( esc_html__( 'Yes', RIT_TEXT_DOMAIN ) => 'true' ),
                    'group'=> esc_html__('Style', RIT_TEXT_DOMAIN),
                    "description" => esc_html__("Hide avatar author.", RIT_TEXT_DOMAIN)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Columns", RIT_TEXT_DOMAIN),
                    "param_name" => "columns",
                    'group'=> esc_html__('Style', RIT_TEXT_DOMAIN),
                    'std' => '1',
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
                    "type" => "dropdown",
                    "heading" => esc_html__("Enable Carousel navigation", RIT_TEXT_DOMAIN),
                    "param_name" => "carousel_nav",
                    "value" => array(
                        esc_html__('Yes', RIT_TEXT_DOMAIN) => "yes",
                        esc_html__('No', RIT_TEXT_DOMAIN) => "no"
                    ),
                    'std' => 'no',
                    'group'=> esc_html__('Style', RIT_TEXT_DOMAIN),
                    "dependency" => Array('element' => 'style', 'value' => array('carousel')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Enable Carousel pagination", RIT_TEXT_DOMAIN),
                    "param_name" => "carousel_pag",
                    "value" => array(
                        esc_html__('Yes', RIT_TEXT_DOMAIN) => "yes",
                        esc_html__('No', RIT_TEXT_DOMAIN) => "no"
                    ),
                    'std' => 'no',
                    'group'=> esc_html__('Style', RIT_TEXT_DOMAIN),
                    "dependency" => Array('element' => 'style', 'value' => array('carousel')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Testimonials page link", RIT_TEXT_DOMAIN),
                    "param_name" => "page_link",
                    "value" => array(esc_html__('No', RIT_TEXT_DOMAIN) => "no", esc_html__('Yes', RIT_TEXT_DOMAIN) => "yes"),
                    "description" => esc_html__("Include a link to the testimonials page (which you must choose in the theme options).", RIT_TEXT_DOMAIN)
                ),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Image background", RIT_TEXT_DOMAIN),
                    "param_name" => "background",
                    'group'=> esc_html__('Style', RIT_TEXT_DOMAIN),
                    "description" => esc_html__("Set image background for block.", RIT_TEXT_DOMAIN)
                ),
                array(
                    "type" => "colorpicker",
                    "heading" => esc_html__("Color mask", RIT_TEXT_DOMAIN),
                    "param_name" => "background_color",
                    'group'=> esc_html__('Style', RIT_TEXT_DOMAIN),
                    "description" => esc_html__("Set color mask for block.", RIT_TEXT_DOMAIN),
                    'std'=>'rgba(0,0,0,0.3)'
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Extra class name", RIT_TEXT_DOMAIN),
                    "param_name" => "el_class",
                    "value" => "",
                    "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", RIT_TEXT_DOMAIN)
                )
            )
        ));
    }
}

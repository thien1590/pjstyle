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


if (!function_exists('rit_shortcode_portfolio')) {
    function rit_shortcode_portfolio($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'portfolio_layout' => 'grid',
            'columns' => '3',
            'cat' => '',
            'post_in' => '',
            'number' => 8,
            'view_more' => false,
            'pagination' => 'standard',
            'animation_type' => '',
            'animation_duration' => '',
            'animation_delay' => '',
            'el_class' => ''
        ), $atts);

        $layout_type = ($atts['portfolio_layout'] != '') ? $atts['portfolio_layout'] : 'large';

        return rit_get_template_part('shortcode', 'portfolio-' . $layout_type, array('atts' => $atts));
    }
}
add_shortcode('portfolio', 'rit_shortcode_portfolio');

add_action('vc_before_init', 'rit_portfolio_integrate_vc');

if (!function_exists('rit_portfolio_integrate_vc')) {
    function rit_portfolio_integrate_vc()
    {
        vc_map( array(
            'name' => esc_html__('RIT Portfolios', RIT_TEXT_DOMAIN),
            'base' => 'portfolio',
            'category' => esc_html__('RIT', RIT_TEXT_DOMAIN),
            'icon' => 'rit-portfolios',
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
                    "heading" => esc_html__("Portfolio Layout", RIT_TEXT_DOMAIN),
                    "param_name" => "portfolio_layout",
                    'std' => 'timeline',
                    "value" => array(
                        esc_html__('Grid', RIT_TEXT_DOMAIN ) => 'grid',
                        esc_html__('Timeline', RIT_TEXT_DOMAIN ) => 'timeline',
                        esc_html__('Medium', RIT_TEXT_DOMAIN ) => 'medium',
                        esc_html__('Large', RIT_TEXT_DOMAIN ) => 'large',
                        esc_html__('Full', RIT_TEXT_DOMAIN ) => 'full',
                        esc_html__('Masonry', RIT_TEXT_DOMAIN ) => 'masonry'
                    ),
                    "admin_label" => true,
                    'description' => esc_html__('Select layout type for display portfolio', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Columns", RIT_TEXT_DOMAIN),
                    "param_name" => "columns",
                    'dependency' => Array('element' => 'portfolio_layout', 'value' => array( 'grid','medium')),
                    'std' => '3',
                    "value" => array(
                        esc_html__('2', RIT_TEXT_DOMAIN ) => '2',
                        esc_html__('3', RIT_TEXT_DOMAIN ) => '3',
                        esc_html__('4', RIT_TEXT_DOMAIN ) => '4',
                        esc_html__('5', RIT_TEXT_DOMAIN ) => '5',
                        esc_html__('6', RIT_TEXT_DOMAIN ) => '6'
                    ),
                    'description' => esc_html__('Display portfolio with the number of column', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "rit_portfolio_categories",
                    "heading" => esc_html__("Category IDs", RIT_TEXT_DOMAIN),
                    "description" => esc_html__("Select category", RIT_TEXT_DOMAIN),
                    "param_name" => "cat",
                    "admin_label" => true,
                    'description' => esc_html__('Select category which you want to get portfolio in', RIT_TEXT_DOMAIN),
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Portfolio IDs", RIT_TEXT_DOMAIN),
                    "description" => esc_html__("comma separated list of portfolio ids", RIT_TEXT_DOMAIN),
                    "param_name" => "post_in"
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Portfolios number", RIT_TEXT_DOMAIN),
                    "param_name" => "number",
                    "value" => '8',
                    'description' => esc_html__('Number of portfolios showing', RIT_TEXT_DOMAIN),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__("Show View More", RIT_TEXT_DOMAIN),
                    'param_name' => 'view_more',
                    'std' => 'no',
                    'value' => array( esc_html__( 'Yes', RIT_TEXT_DOMAIN ) => 'yes' )
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
                    )
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
        ) );
    }
}

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

if (!function_exists('rit_social_share_shortcode')) {
    function rit_social_share_shortcode($atts)
    {
        $atts = shortcode_atts(array(
                	'social_list' => '',
	                'counter_format' => 'comma',
	                'cache_time' => 600
	            ), $atts);

        return rit_get_template_part('shortcode', 'social-share', array('atts' => $atts));
    }
}
add_shortcode('rit-social-share', 'rit_social_share_shortcode');

add_action('vc_before_init', 'rit_social_share_integrate_vc');

if (!function_exists('rit_social_share_integrate_vc')) {
    function rit_social_share_integrate_vc()
    {
        vc_map(
        	array(
	            'name' => esc_html__('RIT Social Share', RIT_TEXT_DOMAIN),
	            'base' => 'rit-social-share',
	            'category' => esc_html__('RIT', RIT_TEXT_DOMAIN),
	            'icon' => 'rit-social-share',
	            "params" => array(
	                array(
	                    "type" => "rit_multi_select",
	                    "heading" => esc_html__("Social List", RIT_TEXT_DOMAIN),
	                    "param_name" => "social_list",
	                    'value' => array(
	                        esc_html__('Facebook', RIT_TEXT_DOMAIN) => 'facebook',
	                        esc_html__('Twitter', RIT_TEXT_DOMAIN) => 'twitter',
	                        esc_html__('Google +', RIT_TEXT_DOMAIN) => 'googlePlus',
	                        esc_html__('Pinterest', RIT_TEXT_DOMAIN) => 'pinterest',
	                        esc_html__('LinkedIn', RIT_TEXT_DOMAIN) => 'linkedIn'
	                    ),
	                    'description' => esc_html__('Select list social button will be display', RIT_TEXT_DOMAIN),
	                ),
	                array(
	                    "type" => "rit_multi_select",
	                    "heading" => esc_html__("Counter Format", RIT_TEXT_DOMAIN),
	                    "param_name" => "counter_format",
	                    'value' => array(
	                        esc_html__('Comma', RIT_TEXT_DOMAIN) => 'comma',
	                        esc_html__('Short', RIT_TEXT_DOMAIN) => 'short',
	                    ),
	                    'description' => esc_html__('Counter Format will be display is 100,000 or 100k', RIT_TEXT_DOMAIN),
	                ),
	            ),
            )
        );
    }
}
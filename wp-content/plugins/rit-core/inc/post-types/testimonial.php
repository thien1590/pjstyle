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

if (!class_exists('RIT_Custom_Post_Type_Testimonial')) {
    class RIT_Custom_Post_Type_Testimonial
    {
        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new RIT_Custom_Post_Type_Testimonial();
            }
            return $instance;
        }

        public function init() {
            add_action('init', array($this, 'register_testimonial'));
            add_action('init', array($this, 'register_testimonial_category'));
        }

        public function register_testimonial()
        {
            $labels = array(
                'name' => esc_html__('Testimonials', 'rit-core-language'),
                'singular_name' => esc_html__('Testimonial', 'rit-core-language'),
                'add_new' => esc_html__('Add New', 'rit-core-language'),
                'add_new_item' => esc_html__('Add New Testimonial', 'rit-core-language'),
                'edit_item' => esc_html__('Edit Testimonial', 'rit-core-language'),
                'new_item' => esc_html__('New Testimonial', 'rit-core-language'),
                'view_item' => esc_html__('View Testimonial', 'rit-core-language'),
                'search_items' => esc_html__('Search Testimonials', 'rit-core-language'),
                'not_found' =>  esc_html__('No testimonials have been added yet', 'rit-core-language'),
                'not_found_in_trash' => esc_html__('Nothing found in Trash', 'rit-core-language'),
                'parent_item_colon' => ''
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => false,
                'menu_icon'=> 'dashicons-format-quote',
                'rewrite' => false,
                'supports' => array('title', 'editor'),
                'has_archive' => true,
            );

            register_post_type( 'testimonial' , $args );
        }

        public function register_testimonial_category()
        {
            $args = array(
                "label" 						=> esc_html__('Testimonial Categories', 'rit-core-language'),
                "singular_label" 				=> esc_html__('Testimonial Category', 'rit-core-language'),
                'public'                        => true,
                'hierarchical'                  => true,
                'show_ui'                       => true,
                'show_in_nav_menus'             => false,
                'args'                          => array( 'orderby' => 'term_order' ),
                'rewrite'                       => false,
                'query_var'                     => true
            );

            register_taxonomy( 'testimonial_category', 'testimonial', $args );
        }
    }

    RIT_Custom_Post_Type_Testimonial::getInstance()->init();
}
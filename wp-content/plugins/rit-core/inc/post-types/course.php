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

if (!class_exists('RIT_Custom_Post_Type_Course')) {
    class RIT_Custom_Post_Type_Course
    {
        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new RIT_Custom_Post_Type_Course();
            }
            return $instance;
        }

        public function __construct() {
            add_action('init', array($this, 'register_course'));
            add_action('init', array($this, 'register_course_category'));
        }

        public function register_course()
        {
            $labels = array(
                'name' => esc_html__('Courses', RIT_TEXT_DOMAIN),
                'singular_name' => esc_html__('Course', RIT_TEXT_DOMAIN),
                'add_new' => esc_html__('Add New', RIT_TEXT_DOMAIN),
                'add_new_item' => esc_html__('Add New Course', RIT_TEXT_DOMAIN),
                'edit_item' => esc_html__('Edit Course', RIT_TEXT_DOMAIN),
                'new_item' => esc_html__('New Course', RIT_TEXT_DOMAIN),
                'view_item' => esc_html__('View Course', RIT_TEXT_DOMAIN),
                'search_items' => esc_html__('Search Course', RIT_TEXT_DOMAIN),
                'not_found' => esc_html__('No course items have been added yet', RIT_TEXT_DOMAIN),
                'not_found_in_trash' => esc_html__('Nothing found in Trash', RIT_TEXT_DOMAIN),
                'parent_item_colon' => ''
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => false,
                'menu_icon' => 'dashicons-format-image',
                'hierarchical' => false,
                'rewrite' => array(
                    'slug' => 'course'
                ),
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'revisions'
                ),
                'has_archive' => true,
            );

            register_post_type('course', $args);
        }

        public function register_course_category()
        {
            $args = array(
                "label" => esc_html__('Course Categories', RIT_TEXT_DOMAIN),
                "singular_label" => esc_html__('Course Category', RIT_TEXT_DOMAIN),
                'public' => true,
                'hierarchical' => true,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'args' => array('orderby' => 'term_order'),
                'rewrite' => array(
                    'slug' => 'course_category',
                    'with_front' => false,
                    'hierarchical' => true,
                ),
                'query_var' => true
            );
            register_taxonomy('course_category', 'course', $args);
        }
    }

    RIT_Custom_Post_Type_Course::getInstance();
}
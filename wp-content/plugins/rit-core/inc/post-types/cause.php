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

if (!class_exists('RIT_Custom_Post_Type_Cause')) {
    class RIT_Custom_Post_Type_Cause
    {
        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new RIT_Custom_Post_Type_Cause();
            }
            return $instance;
        }

        public function __construct() {
            add_action('init', array($this, 'register_cause'));
            add_action('init', array($this, 'register_cause_category'));
        }

        public function register_cause()
        {
            $labels = array(
                'name' => esc_html__('Causes', 'rit-core-language'),
                'singular_name' => esc_html__('Cause', 'rit-core-language'),
                'add_new' => esc_html__('Add New', 'rit-core-language'),
                'add_new_item' => esc_html__('Add New Cause', 'rit-core-language'),
                'edit_item' => esc_html__('Edit Cause', 'rit-core-language'),
                'new_item' => esc_html__('New Cause', 'rit-core-language'),
                'view_item' => esc_html__('View Cause', 'rit-core-language'),
                'search_items' => esc_html__('Search Cause', 'rit-core-language'),
                'not_found' => esc_html__('No cause items have been added yet', 'rit-core-language'),
                'not_found_in_trash' => esc_html__('Nothing found in Trash', 'rit-core-language'),
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
                    'slug' => 'cause'
                ),
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'revisions'
                ),
                'has_archive' => true,
            );

            register_post_type('cause', $args);
        }

        public function register_cause_category()
        {
            $args = array(
                "label" => esc_html__('Cause Categories', 'rit-core-language'),
                "singular_label" => esc_html__('Cause Category', 'rit-core-language'),
                'public' => true,
                'hierarchical' => true,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'args' => array('orderby' => 'term_order'),
                'rewrite' => array(
                    'slug' => 'cause_category',
                    'with_front' => false,
                    'hierarchical' => true,
                ),
                'query_var' => true
            );
            register_taxonomy('cause_category', 'cause', $args);
        }
    }

    RIT_Custom_Post_Type_Cause::getInstance();
}
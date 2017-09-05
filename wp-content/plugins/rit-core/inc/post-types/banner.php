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


if (!class_exists('RIT_Custom_Post_Type_Banner')) {
    class RIT_Custom_Post_Type_Banner
    {
        public function init() {
            add_action('init', array($this, 'register_banner'));
        }

        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new RIT_Custom_Post_Type_Banner();
            }
            return $instance;
        }

        function register_banner()
        {

            $labels = array(
                'name' => esc_html__('Banner', 'rit-core-language'),
                'singular_name' => esc_html__('Banner', 'rit-core-language'),
                'menu_name' => esc_html__('Banner', 'rit-core-language'),
                'parent_item_colon' => esc_html__('Parent Banner :', 'rit-core-language'),
                'all_items' => esc_html__('All Banners', 'rit-core-language'),
                'view_item' => esc_html__('View Banner ', 'rit-core-language'),
                'add_new_item' => esc_html__('Add New Banner ', 'rit-core-language'),
                'add_new' => esc_html__('Add New Banner', 'rit-core-language'),
                'edit_item' => esc_html__('Edit Banner ', 'rit-core-language'),
                'update_item' => esc_html__('Update Banner ', 'rit-core-language'),
                'search_items' => esc_html__('Search Banner ', 'rit-core-language'),
                'not_found' => esc_html__('Not found', 'rit-core-language'),
                'not_found_in_trash' => esc_html__('Not found in Trash', 'rit-core-language'),
            );
            $args = array(
                'label' => esc_html__('Banner', 'rit-core-language'),
                'description' => esc_html__('Banner post type.', 'rit-core-language'),
                'labels' => $labels,
                'supports' => array('title', 'thumbnail',),
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'show_in_admin_bar' => true,
                'menu_position' => 80,
                'menu_icon' => 'dashicons-images-alt',
                'can_export' => true,
                'has_archive' => true,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'capability_type' => 'page',
            );
            register_post_type('banner', $args);

        }
    }

    RIT_Custom_Post_Type_Banner::getInstance()->init();
}

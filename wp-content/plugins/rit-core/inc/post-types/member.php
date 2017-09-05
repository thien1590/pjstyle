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


if (!class_exists('RIT_Custom_Post_Type_Member')) {
    class RIT_Custom_Post_Type_Member
    {
        public function init() {
            add_action('init', array($this, 'register_member'));
        }

        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new RIT_Custom_Post_Type_Member();
            }
            return $instance;
        }

        function register_member()
        {

            $labels = array(
                'name' => esc_html__('Member', 'rit-core-language'),
                'singular_name' => esc_html__('Member', 'rit-core-language'),
                'menu_name' => esc_html__('Member', 'rit-core-language'),
                'parent_item_colon' => esc_html__('Parent Member :', 'rit-core-language'),
                'all_items' => esc_html__('All Members', 'rit-core-language'),
                'view_item' => esc_html__('View Member ', 'rit-core-language'),
                'add_new_item' => esc_html__('Add New Member ', 'rit-core-language'),
                'add_new' => esc_html__('Add New Member', 'rit-core-language'),
                'edit_item' => esc_html__('Edit Member ', 'rit-core-language'),
                'update_item' => esc_html__('Update Member ', 'rit-core-language'),
                'search_items' => esc_html__('Search Member ', 'rit-core-language'),
                'not_found' => esc_html__('Not found', 'rit-core-language'),
                'not_found_in_trash' => esc_html__('Not found in Trash', 'rit-core-language'),
            );
            $args = array(
                'label' => esc_html__('Member', 'rit-core-language'),
                'description' => esc_html__('Member post type.', 'rit-core-language'),
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
            register_post_type('member', $args);

        }
    }

    RIT_Custom_Post_Type_Member::getInstance()->init();
}

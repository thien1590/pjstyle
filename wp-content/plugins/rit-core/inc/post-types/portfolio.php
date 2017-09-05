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

if (!class_exists('RIT_Custom_Post_Type_Portfolio')) {
    class RIT_Custom_Post_Type_Portfolio
    {
        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new RIT_Custom_Post_Type_Portfolio();
            }
            return $instance;
        }

        public function init() {
            add_action('init', array($this, 'register_portfolio'));
            add_action('init', array($this, 'register_portfolio_category'));
        }

        public function register_portfolio()
        {
            $labels = array(
                'name' => esc_html__('Portfolio', 'rit-core-language'),
                'singular_name' => esc_html__('Portfolio Item', 'rit-core-language'),
                'add_new' => esc_html__('Add New', 'rit-core-language'),
                'add_new_item' => esc_html__('Add New Portfolio Item', 'rit-core-language'),
                'edit_item' => esc_html__('Edit Portfolio Item', 'rit-core-language'),
                'new_item' => esc_html__('New Portfolio Item', 'rit-core-language'),
                'view_item' => esc_html__('View Portfolio Item', 'rit-core-language'),
                'search_items' => esc_html__('Search Portfolio', 'rit-core-language'),
                'not_found' => esc_html__('No portfolio items have been added yet', 'rit-core-language'),
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
                    'slug' => 'portfolio'
                ),
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'revisions'
                ),
                'has_archive' => true,
            );

            register_post_type('portfolio', $args);
        }

        public function register_portfolio_category()
        {
            $args = array(
                "label" => esc_html__('Portfolio Categories', 'rit-core-language'),
                "singular_label" => esc_html__('Portfolio Category', 'rit-core-language'),
                'public' => true,
                'hierarchical' => true,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'args' => array('orderby' => 'term_order'),
                'rewrite' => array(
                    'slug' => 'portfolio_category',
                    'with_front' => false,
                    'hierarchical' => true,
                ),
                'query_var' => true
            );
            register_taxonomy('portfolio_category', 'portfolio', $args);
        }
    }

    RIT_Custom_Post_Type_Portfolio::getInstance()->init();
}

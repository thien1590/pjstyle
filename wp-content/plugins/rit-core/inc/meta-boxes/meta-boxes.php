<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     2.0.1
 * @author      CleverSoft
 * @link        http://cleversoft.co
 * @copyright   Copyright (c) 2015 CleverSoft
 * @license     GPL v2
 */

if (!class_exists('RIT_Meta_Boxes')) {
    class RIT_Meta_Boxes
    {
        public $meta_boxes;

        public function __construct()
        {
            $this->add_meta_box_options();
            add_action('admin_init', array($this, 'register'));
        }

        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new RIT_Meta_Boxes();
            }
            return $instance;
        }

        public function add_meta_box_options()
        {
            $meta_boxes = array();
            /* Testimonial Meta Box */
            $meta_boxes[] = array(
                'id' => 'post_meta_box',
                'title' => esc_html__('Post Meta', RIT_TEXT_DOMAIN),
                'pages' => array('testimonial'),
                'context' => 'normal',
                'fields' => array(
                    array(
                        'name' => esc_html__('Author avatar', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('Author avatar display in frontend', RIT_TEXT_DOMAIN),
                        'id' => "rit_author_img",
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1
                    ),
                    array(
                        'name' => esc_html__('Author name', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('Author name display in frontend', RIT_TEXT_DOMAIN),
                        'id' => "rit_author",
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Author description', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('Author description display in frontend', RIT_TEXT_DOMAIN),
                        'id' => "rit_author_des",
                        'type' => 'text',
                    ),
                ));
            /* Page Background Meta Box */
            $meta_boxes[] = array(
                'id' => 'page_background_meta_box',
                'title' => esc_html__('Page Background Options', RIT_TEXT_DOMAIN),
                'pages' => array('post', 'page'),
                'context' => 'normal',
                'fields' => array(
                    // BACKGROUND SIZE
                    array(
                        'name' => esc_html__('Preset Style', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_preset_style",
                        'type' => 'select',
                        'options' => array(
                            'none' => 'Select',
                            'pink' => 'Pink',
                            'green' => 'Green',
                            'red' => 'Red'
                        ),
                        'multiple' => false,
                        'std' => 'none',
                    ),
                )
            );

            /* Page Background Meta Box */
            $meta_boxes[] = array(
                'id' => 'title_meta_box',
                'title' => esc_html__('Meta Options', RIT_TEXT_DOMAIN),
                'pages' => array('post', 'page'),
                'context' => 'normal',
                'fields' => array(
                    array(
                        'name' => esc_html__('Logo page', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_logo_stt",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Logo for page', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_logo_page",
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1
                    ),
                    array(
                        'name' => esc_html__('Logo height', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_logo_page_height",
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Logo padding top', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_logo_page_top",
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Logo padding bottom', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_logo_page_bottom",
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Title Options', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_heading_title",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Disible Title', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_disible_title",
                        'type' => 'checkbox'
                    ),
                    array(
                        'name' => esc_html__('Slider Options', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_heading_slider",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Slider shortcode', RIT_TEXT_DOMAIN),
                        'id' => "rit_slider_shortcode",
                        'type' => 'text',
                        'desc' => esc_html__('Enter slider shortcode here.', RIT_TEXT_DOMAIN)
                    ),
                    array(
                        'name' => esc_html__('Header Options', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_heading_header",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Header Options', RIT_TEXT_DOMAIN),
                        'id' => "rit_header_options",
                        'type' => 'select',
                        'options' => array(
                            'use-default' => esc_html__('Use Default', RIT_TEXT_DOMAIN),
                            'default' => esc_html__('Header Default', RIT_TEXT_DOMAIN),
                            'responsive' => esc_html__('Header Responsive', RIT_TEXT_DOMAIN),
                            'canvas' => esc_html__('Header Canvas', RIT_TEXT_DOMAIN),
                            'oneline' => esc_html__('Header One line', RIT_TEXT_DOMAIN),
                            'center' => esc_html__('Header Center', RIT_TEXT_DOMAIN),
                            'simpleline' => esc_html__('Header Simple Line', RIT_TEXT_DOMAIN),
                        ),
                        'std' => 'use-default',
                        'desc' => esc_html__('Choose Options Header.', RIT_TEXT_DOMAIN)
                    ),
                    array(
                        'name' => esc_html__('Sidebar Options', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_heading_sidebar",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Sidebar Options', RIT_TEXT_DOMAIN),
                        'id' => "rit_sidebar_options",
                        'type' => 'select',
                        'options' => array(
                            'use-default' => 'Use Default',
                            'no-sidebar' => 'No Sidebar',
                            'left-sidebar' => 'Left Sidebar',
                            'right-sidebar' => 'Right Sidebar',
                            'both-sidebar' => 'Both Sidebar'
                        ),
                        'std' => 'use-default',
                        'desc' => esc_html__('Choose Options Sidebar.', RIT_TEXT_DOMAIN)
                    ),
                    array(
                        'name' => esc_html__('Left Sidebar', RIT_TEXT_DOMAIN),
                        'id' => "rit_left_sidebar",
                        'type' => 'sidebars',
                    ),
                    array(
                        'name' => esc_html__('Right Sidebar', RIT_TEXT_DOMAIN),
                        'id' => "rit_right_sidebar",
                        'type' => 'sidebars',
                    ),
                    array(
                        'name' => esc_html__('Footer Options', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_heading_footer",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Footer Options', RIT_TEXT_DOMAIN),
                        'id' => "rit_footer_options",
                        'type' => 'select',
                        'options' => array(
                            'use-default' => 'Use Default',
                            'default' => 'Default style',
                            'big-info' => 'Big info',
                            'big-info-2' => 'Big info 2'
                        ),
                        'std' => 'use-default',
                        'desc' => esc_html__('Choose Options Footer Options.', RIT_TEXT_DOMAIN)
                    ),
                )
            );

            /* Banner Meta Box */
            $meta_boxes[] = array(
                'id' => 'banner_meta_box',
                'title' => esc_html__('Banner Options', RIT_TEXT_DOMAIN),
                'pages' => array('banner'),
                'context' => 'normal',
                'fields' => array(
                    array(
                        'name' => esc_html__('Banner Url', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('When click into banner, it will be redirect to this url', RIT_TEXT_DOMAIN),
                        'id' => "rit_banner_url",
                        'type' => 'text'
                    ),
                    array(
                        'name' => esc_html__('Banner class', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('', RIT_TEXT_DOMAIN),
                        'id' => "rit_banner_class",
                        'type' => 'text'
                    ),
                )
            );
            /* Portfolio Meta Box */
            $meta_boxes[] = array(
                'id' => 'portfolio_meta_box',
                'title' => esc_html__('Portfolio Options', RIT_TEXT_DOMAIN),
                'pages' => array('portfolio'),
                'context' => 'normal',
                'fields' => array(
                    array(
                        'name' => esc_html__('Detail Image', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('The image that will be used in the detail page.', RIT_TEXT_DOMAIN),
                        'id' => "rit_detail_image",
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1
                    ),
                )
            );
            $meta_boxes[] = array(
                'id' => 'portfolio_extend_info',
                'title' => esc_html__('Portfolio Extend Information', RIT_TEXT_DOMAIN),
                'pages' => array('portfolio'),
                'context' => 'normal',
                'fields' => array(
                    array(
                        'name' => esc_html__('Portfolio extend information status', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('Enable/Disable portfolio extend information.', RIT_TEXT_DOMAIN),
                        'id' => "rit_portfolio_extend_info_status",
                        'type' => 'select',
                        'options' => array(
                            'disable' => 'Disable',
                            'enable' => 'Enable'
                        ),
                        'std' => 'disable',
                    ),
                    array(
                        'name' => esc_html__('Client', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('The name of client.', RIT_TEXT_DOMAIN),
                        'id' => "rit_client_portfolio",
                        'type' => 'text'
                    ),
                    array(
                        'name' => esc_html__('Date complete', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('Date complete project.', RIT_TEXT_DOMAIN),
                        'id' => "rit_date_complete_portfolio",
                        'type' => 'date'
                    ),
                    array(
                        'name' => esc_html__('Live demo', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('Live demo link project.', RIT_TEXT_DOMAIN),
                        'id' => "rit_live_demo_portfolio",
                        'type' => 'url'
                    ),
                    array(
                        'name' => esc_html__('Short description', RIT_TEXT_DOMAIN),
                        'desc' => esc_html__('Short description of project.', RIT_TEXT_DOMAIN),
                        'id' => "rit_short_des_portfolio",
                        'type' => 'textarea'
                    ),
                )
            );
            $this->meta_boxes = $meta_boxes;
        }

        public function register()
        {
            if (class_exists('RW_Meta_Box')) {
                foreach ($this->meta_boxes as $meta_box) {
                    new RW_Meta_Box($meta_box);
                }
            }
        }
    }
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if(is_plugin_active('meta-box/meta-box.php')){
    RIT_Meta_Boxes::getInstance();
    include('field/sidebars.php' );
}
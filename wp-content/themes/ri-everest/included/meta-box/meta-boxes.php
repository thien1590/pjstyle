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
if (!class_exists('RIT_Theme_Meta_Boxes')) {
    class RIT_Theme_Meta_Boxes
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
                $instance = new RIT_Theme_Meta_Boxes();
            }
            return $instance;
        }

        public function add_meta_box_options()
        {
            $meta_boxes = array();
            /* Page Background Meta Box */
            $meta_boxes[] = array(
                'id' => 'page_background_meta_box',
                'title' => esc_html__('Page Background Options', 'ri-everest'),
                'pages' => array('post', 'page'),
                'context' => 'normal',
                'fields' => array(
                    array(
                        'name' => esc_html__('Preset Style', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_preset_style",
                        'type' => 'select',
                        'options' => array(
                            'default' => esc_html__('Default','ri-everest'),
                            'pink' => esc_html__('Pink','ri-everest'),
                            'green' => esc_html__('Green','ri-everest'),
                            'red' => esc_html__('Red','ri-everest'),
                            'goldenrod' => esc_html__('GoldenRod','ri-everest')
                        ),
                        'multiple' => false,
                        'std' => 'none',
                    ),
                    // INNER BACKGROUND IMAGE
                    array(
                        'name' => esc_html__('Background Image', 'ri-everest'),
                        'desc' => esc_html__('The image that will be used as the INNER page background image.', 'ri-everest'),
                        'id' => "rit_inner_background_image",
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1
                    ),
                    array(
                        'name' => esc_html__('Background Color', 'ri-everest'),
                        'desc' => esc_html__('Background color of page, post.', 'ri-everest'),
                        'id' => "rit_inner_background_color",
                        'type' => 'color',
                    ),
                    array(
                        'name' => esc_html__('Background Position', 'ri-everest'),
                        'desc' => esc_html__('Position of background image.', 'ri-everest'),
                        'id' => "rit_background_image_position",
                        'type' => 'select',
                        'options' => array(
                            'center top' => esc_html__('Center Top','ri-everest'),
                            'center center'=>esc_html__('Center Center','ri-everest'),
                            'center bottom' => esc_html__('Center Bottom','ri-everest'),
                            'left top' => esc_html__('Left Top','ri-everest'),
                            'left center'=>esc_html__('Left Center','ri-everest'),
                            'left bottom' => esc_html__('Left Bottom','ri-everest'),
                            'right top' => esc_html__('Right Top','ri-everest'),
                            'right center'=>esc_html__('Right Center','ri-everest'),
                            'right bottom' => esc_html__('Right Bottom','ri-everest'),
                        ),
                        'multiple' => false,
                        'std' => 'center center',
                    ),
                    // BACKGROUND SIZE
                    array(
                        'name' => esc_html__('Background Image Size', 'ri-everest'),
                        'desc' => esc_html__('For background image size.', 'ri-everest'),
                        'id' => "rit_background_image_size",
                        'type' => 'select',
                        'options' => array(
                            'cover' => esc_html__('Cover','ri-everest'),
                            'contain'=> esc_html__('Contain','ri-everest'),
                            'full'=> esc_html__('Full width','ri-everest'),
                        ),
                        'multiple' => false,
                        'std' => 'cover',
                    ),
                    array(
                        'name' => esc_html__('Background Image Repeat', 'ri-everest'),
                        'desc' => esc_html__('For repeating patterns, choose Repeat.', 'ri-everest'),
                        'id' => "rit_background_image_repeat",
                        'type' => 'select',
                        'options' => array(
                            'no-repeat' => esc_html__('No Repeat','ri-everest'),
                            'repeat'=>esc_html__('Repeat','ri-everest'),
                        ),
                        'multiple' => false,
                        'std' => 'no-repeat',
                    ),
                )
            );
            $meta_boxes[] = array(
                'id' => 'title_meta_box',
                'title' => esc_html__('Meta Options', 'ri-everest'),
                'pages' => array('post', 'page'),
                'context' => 'normal',
                'fields' => array(
                    array(
                        'name' => esc_html__('Logo page', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_logo_stt",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Logo for page', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_logo_page",
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1
                    ),
                    array(
                        'name' => esc_html__('Logo height', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_logo_page_height",
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Logo padding top', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_logo_page_top",
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Logo padding bottom', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_logo_page_bottom",
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Title Options', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_heading_title",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Disible Title', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_disible_title",
                        'type' => 'checkbox'
                    ),
                    array(
                        'name' => esc_html__('Slider Options', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_heading_slider",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Slider shortcode', 'ri-everest'),
                        'id' => "rit_slider_shortcode",
                        'type' => 'text',
                        'desc' => esc_html__('Enter slider shortcode here.', 'ri-everest')
                    ),
                    array(
                        'name' => esc_html__('Header Options', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_heading_header",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Header Options', 'ri-everest'),
                        'id' => "rit_header_options",
                        'type' => 'select',
                        'options' => array(
                            'use-default' => esc_html__('Use Default', 'ri-everest'),
                            'default' => esc_html__('Header Default', 'ri-everest'),
                            'default-style-2' => esc_html__('Header Default Style 2', 'ri-everest'),
                            'default-style-3' => esc_html__('Header Default Style 3', 'ri-everest'),
                            'oneline' => esc_html__('Header One line', 'ri-everest'),
                            'oneline-2' => esc_html__('Header One line 2', 'ri-everest'),
                            'transparent' => esc_html__('Header Transparent', 'ri-everest'),
                        ),
                        'std' => 'use-default',
                        'desc' => esc_html__('Choose Options Header.', 'ri-everest')
                    ),
                    array(
                        'name' => esc_html__('Header Sticky', 'ri-everest'),
                        'id' => "rit_enable_sticky_header",
                        'desc' => esc_html__('Enable header sticky.', 'ri-everest'),
                        'type' => 'checkbox',
                    ),
                    array(
                        'name' => esc_html__('Disable breadcrumb', 'ri-everest'),
                        'id' => "rit_disable_breadcrumb",
                        'desc' => esc_html__('Disable breadcrumb.', 'ri-everest'),
                        'type' => 'checkbox',
                    ),
                    array(
                        'name' => esc_html__('Sidebar Options', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_heading_sidebar",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Sidebar Options', 'ri-everest'),
                        'id' => "rit_sidebar_options",
                        'type' => 'select',
                        'options' => array(
                            'use-default' => esc_html__('Use Default','ri-everest'),
                            'no-sidebar' => esc_html__('No Sidebar','ri-everest'),
                            'left-sidebar' => esc_html__('Left Sidebar','ri-everest'),
                            'right-sidebar' => esc_html__('Right Sidebar','ri-everest'),
                            'both-sidebar' => esc_html__('Both Sidebar','ri-everest')
                        ),
                        'std' => 'use-default',
                        'desc' => esc_html__('Choose Options Sidebar.', 'ri-everest')
                    ),
                    array(
                        'name' => esc_html__('Left Sidebar', 'ri-everest'),
                        'id' => "rit_left_sidebar",
                        'type' => 'sidebars',
                    ),
                    array(
                        'name' => esc_html__('Right Sidebar', 'ri-everest'),
                        'id' => "rit_right_sidebar",
                        'type' => 'sidebars',
                    ),
                    array(
                        'name' => esc_html__('Footer Options', 'ri-everest'),
                        'desc' => esc_html__('', 'ri-everest'),
                        'id' => "rit_heading_footer",
                        'type' => 'heading'
                    ),
                    array(
                        'name' => esc_html__('Footer Options', 'ri-everest'),
                        'id' => "rit_footer_options",
                        'type' => 'select',
                        'options' => array(
                            'use-default' => esc_html__('Use Default','ri-everest'),
                            'default' => esc_html__('Default style','ri-everest'),
                            'default-2' => esc_html__('Default style 2','ri-everest'),
                            'white'=>esc_html__('White style','ri-everest'),
                            'dark'=>esc_html__('Dark style','ri-everest'),
                            //'big-info' => esc_html__('Big info','ri-everest'),
                            //'big-info-2' => esc_html__('Big info 2','ri-everest')
                        ),
                        'std' => 'use-default',
                        'desc' => esc_html__('Choose Options Footer Options.', 'ri-everest')
                    ),
                    array(
                        'name' => esc_html__('Footer fixed', 'ri-everest'),
                        'id' => "rit_enable_footer_fixed",
                        'desc' => esc_html__('Enable footer fixed.', 'ri-everest'),
                        'type' => 'checkbox',
                    ),
                )
            );
            /* Page Background Meta Box */
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
    RIT_Theme_Meta_Boxes::getInstance();
    include('field/sidebars.php' );
}
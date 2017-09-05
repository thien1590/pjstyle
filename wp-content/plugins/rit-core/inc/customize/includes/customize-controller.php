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


if (!class_exists('RIT_Customize')) {
    class RIT_Customize
    {
        public $customizers = array();

        public $panels = array();

        public $activeCallbackFunctions = array();

        public function init()
        {
            $this->customizer();
            add_action('customize_controls_enqueue_scripts', array($this, 'rit_customizer_script'));
            add_action('customize_controls_print_scripts', array($this, 'rit_customizer_controls_print_scripts'));
            add_action('customize_register', array($this, 'rit_register_theme_customizer'));
            add_action('customize_register', array($this, 'remove_default_customize_section'), 20);
            RIT_Customize_Import_Export::getInstance();
        }

        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new RIT_Customize();
            }
            return $instance;
        }

        protected function customizer()
        {
            $this->panels = array(
                'rit_color' => array(
                    'title'          => 'Custom color',
                    'description'    => '',
                    'priority' => 6
                ),
            );

            $this->customizers = array(

                'rit_new_section_general' => array(
                    'title' => esc_html__('General Options', 'rit-core-language'),
                    'description' => '',
                    'priority' => 0,
                    'settings' => array(
                        'rit_favicon' => array(
                            'class' => 'image',
                            'label' => esc_html__('Upload Favicon', 'rit-core-language'),
                            'priority' => 0
                        ),
                        'rit_custom_css' => array(
                            'type' => 'textarea',
                            'label' => esc_html__('Custom CSS', 'rit-core-language'),
                            'priority' => 6
                        ),
                        'rit_custom_js' => array(
                            'type' => 'textarea',
                            'label' => esc_html__('Custom JS', 'rit-core-language'),
                            'priority' => 7
                        )
                    )
                ),

                'rit_new_section_header' => array(
                    'title' => esc_html__('Header Options', 'rit-core-language'),
                    'description' => '',
                    'priority' => 1,
                    'settings' => array(
                        'rit_default_header' => array(
                            'type' => 'select',
                            'label' => esc_html__('Choose Header Style', 'rit-core-language'),
                            'description' => '',
                            'priority' => 0,
                            'choices' => array(
                                'default' => esc_html__('Header Default', 'rit-core-language'),
                                'responsive' => esc_html__('Header Responsive', 'rit-core-language'),
                                'canvas' => esc_html__('Header Canvas', 'rit-core-language'),
                                'oneline' => esc_html__('Header One line', 'rit-core-language'),
                                'center' => esc_html__('Header Center', 'rit-core-language'),
                                'simpleline' => esc_html__('Header Simple Line', 'rit-core-language'),
                            ),
                            'params' => array(
                                'default' => '1',
                            ),
                        ),
                        'rit_logo' => array(
                            'class' => 'image',
                            'label' => esc_html__('Logo', 'rit-core-language'),
                            'description' => esc_html__('Upload Logo Image', 'rit-core-language'),
                            'priority' => 0
                        ),
                        'rit_logo_height' => array(
                            'type' => 'number',
                            'label' => esc_html__('Logo Height', 'rit-core-language'),
                            'description' => esc_html__('Fill Height Logo. Note: without include (px)', 'rit-core-language'),
                            'priority' => 2
                        ),
                        'rit_logo_top_spacing' => array(
                            'type' => 'number',
                            'label' => esc_html__('Logo Top spacing', 'rit-core-language'),
                            'description' => esc_html__('Fill Logo Top spacing. Note: without include (px)', 'rit-core-language'),
                            'priority' => 3
                        ),
                        'rit_logo_bottom_spacing' => array(
                            'type' => 'number',
                            'label' => esc_html__('Logo Bottom spacing', 'rit-core-language'),
                            'description' => esc_html__('Fill Logo Bottom spacing. Note: without include (px)', 'rit-core-language'),
                            'priority' => 4
                        ),
                        'rit_show_tagline' => array(
                            'type' => 'radio',
                            'label' => esc_html__('Hide Tagline', 'rit-core-language'),
                            'priority' => 2,
                            'choices' => array(
                                '1' => esc_html__('Yes', 'rit-core-language'),
                                '0' => esc_html__('No', 'rit-core-language')
                            )
                        )
                    )
                ),

                'rit_new_section_footer' => array(
                    'title' => esc_html__('Footer Options', 'rit-core-language'),
                    'description' => '',
                    'priority' => 2,
                    'settings' => array(
                        'rit_default_footer' => array(
                            'type' => 'select',
                            'label' => esc_html__('Choose Footer Style', 'rit-core-language'),
                            'description' => '',
                            'priority' => -1,
                            'choices' => array(
                                'default'		=> 'Use Default',
                                'white'		=> 'White style',
                                'big-info'		=> 'Big info',
                                'big-info-2'		=> 'Big info 2'
                            ),
                            'params' => array(
                                'default' => 'default',
                            ),
                        ),
                        'rit_enable_footer' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__('Enable Footer', 'rit-core-language'),
                            'description' => '',
                            'priority' => 0
                        ),
                        'rit_border_footer_height' => array(
                            'type' => 'number',
                            'label' => esc_html__('Footer border height', 'rit-core-language'),
                            'description' => 'ex: 5px',
                            'priority' => 0
                        ),
                        'rit_enable_copyright' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__('Enable Copyright', 'rit-core-language'),
                            'description' => '',
                            'priority' => 0
                        ),
                        'rit_copyright_text' => array(
                            'type' => 'textarea',
                            'label' => esc_html__('Footer Copyright Text', 'rit-core-language'),
                            'description' => '',
                            'priority' => 0
                        )
                    )
                ),

                'rit_new_section_font_size' => array(
                    'title' => esc_html__('Font Size Options', 'rit-core-language'),
                    'description' => '',
                    'priority' => 4,
                    'settings' => array(
                        'rit_enable_body_font_size' => array(
                            'type' => 'number',
                            'label' => esc_html__('Body Font Size', 'rit-core-language'),
                            'description' => '',
                            'priority' => 0
                        ),
                        'rit_enable_bodyline_height' => array(
                            'type' => 'number',
                            'label' => esc_html__('Body Font Line Height', 'rit-core-language'),
                            'description' => '',
                            'priority' => 1
                        ),
                        'rit_enable_menu_font_size' => array(
                            'type' => 'number',
                            'label' => esc_html__('Menu Font Size', 'rit-core-language'),
                            'description' => '',
                            'priority' => 2
                        ),
                    )
                ),

                'rit_new_section_social' => array(
                    'title' => esc_html__('Social Profiles', 'rit-core-language'),
                    'description' => '',
                    'priority' => 5,
                    'settings' => array(
                        'rit_social_twitter' => array(
                            'type' => 'text',
                            'label' => esc_html__('Twitter', 'rit-core-language'),
                            'description' => esc_html__('Your Twitter username (no @).', 'rit-core-language'),
                            'priority' => 0,
                            'params' => array(
                                'default' => 'username',
                            ),
                        ),
                        'rit_social_facebook' => array(
                            'type' => 'text',
                            'label' => esc_html__('Facebook', 'rit-core-language'),
                            'description' => esc_html__('Your facebook page/profile url', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_dribbble' => array(
                            'type' => 'text',
                            'label' => esc_html__('Dribbble', 'rit-core-language'),
                            'description' => esc_html__('Your Dribbble username', 'rit-core-language'),
                            'priority' => 2,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_vimeo' => array(
                            'type' => 'text',
                            'label' => esc_html__('Vimeo', 'rit-core-language'),
                            'description' => esc_html__('Your Vimeo username', 'rit-core-language'),
                            'priority' => 3,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_tumblr' => array(
                            'type' => 'text',
                            'label' => esc_html__('Tumblr', 'rit-core-language'),
                            'description' => esc_html__('Your Tumblr username', 'rit-core-language'),
                            'priority' => 4,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_skype' => array(
                            'type' => 'text',
                            'label' => esc_html__('Skype', 'rit-core-language'),
                            'description' => esc_html__('Your Skype username', 'rit-core-language'),
                            'priority' => 5,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_linkedin' => array(
                            'type' => 'text',
                            'label' => esc_html__('LinkedIn', 'rit-core-language'),
                            'description' => esc_html__('Your LinkedIn page/profile url', 'rit-core-language'),
                            'priority' => 6,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_googleplus' => array(
                            'type' => 'text',
                            'label' => esc_html__('Google+', 'rit-core-language'),
                            'description' => esc_html__('Your Google+ page/profile URL', 'rit-core-language'),
                            'priority' => 7,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_flickr' => array(
                            'type' => 'text',
                            'label' => esc_html__('Flickr', 'rit-core-language'),
                            'description' => esc_html__('Your Flickr page url', 'rit-core-language'),
                            'priority' => 8,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_youTube' => array(
                            'type' => 'text',
                            'label' => esc_html__('YouTube', 'rit-core-language'),
                            'description' => esc_html__('Your YouTube URL', 'rit-core-language'),
                            'priority' => 9,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_pinterest' => array(
                            'type' => 'text',
                            'label' => esc_html__('Pinterest', 'rit-core-language'),
                            'description' => esc_html__('Your Pinterest username', 'rit-core-language'),
                            'priority' => 10,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_foursquare' => array(
                            'type' => 'text',
                            'label' => esc_html__('Foursquare', 'rit-core-language'),
                            'description' => esc_html__('Your Foursqaure URL', 'rit-core-language'),
                            'priority' => 11,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_instagram' => array(
                            'type' => 'text',
                            'label' => esc_html__('Instagram', 'rit-core-language'),
                            'description' => esc_html__('Your Instagram username', 'rit-core-language'),
                            'priority' => 12,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_github' => array(
                            'type' => 'text',
                            'label' => esc_html__('GitHub', 'rit-core-language'),
                            'description' => esc_html__('Your GitHub URL', 'rit-core-language'),
                            'priority' => 13,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                        'rit_social_xing' => array(
                            'type' => 'text',
                            'label' => esc_html__('Xing', 'rit-core-language'),
                            'description' => esc_html__('Your Xing URL', 'rit-core-language'),
                            'priority' => 14,
                            'params' => array(
                                'default' => '',
                            ),
                        ),
                    )
                ),

                'rit_new_section_color_page' => array(
                    'title' => esc_html__('Color - Page', 'rit-core-language'),
                    'description' => '',
                    'priority' => 7,
                    'panel'=> 'rit_color',
                    'settings' => array(
                        'rit_page_bg' => array(
                            'class' => 'image',
                            'label' => esc_html__('Page Background Image', 'rit-core-language'),
                            'priority' => 0
                        ),
                        'rit_page_background_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Page Background Color', 'rit-core-language'),
                            'priority' => 0,
                            'params' => array(
                                'default' => 'transparent',
                            )
                        ),
                        'rit_page_text_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Page Text Color', 'rit-core-language'),
                            'priority' => 0,
                            'params' => array(
                                'default' => '#757575',
                            )
                        ),
                        'rit_page_link_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Page Link Color', 'rit-core-language'),
                            'priority' => 0,
                            'params' => array(
                                'default' => '#757575',
                            )
                        ),
                        'rit_page_link_hover_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Page Link Hover Color', 'rit-core-language'),
                            'priority' => 0,
                            'params' => array(
                                'default' => '#000',
                            )
                        )
                    )
                ),

                'rit_new_section_color_header' => array(
                    'title' => esc_html__('Color - Header', 'rit-core-language'),
                    'description' => '',
                    'priority' => 8,
                    'panel'=> 'rit_color',
                    'settings' => array(
                        'rit_header_background_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Background Color', 'rit-core-language'),
                            'priority' => 0,
                            'params' => array(
                                'default' => 'transparent',
                            ),
                        ),
                        'rit_header_page_background_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Inner background color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => 'transparent',
                            ),
                        ),
                        'rit_header_text_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Text color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_header_link_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Link color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_header_link_hover_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Link Hover color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#000',
                            ),
                        ),
                    )
                ),

                'rit_new_section_color_navigation' => array(
                    'title' => esc_html__('Color - Navigation', 'rit-core-language'),
                    'description' => '',
                    'priority' => 9,
                    'panel'=> 'rit_color',
                    'settings' => array(
                        'rit_nav_bg_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Nav Background Color', 'rit-core-language'),
                            'priority' => 0,
                            'params' => array(
                                'default' => 'transparent',
                            ),
                        ),
                        'rit_nav_text_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Nav Text Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_nav_link_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Nav Link Color', 'rit-core-language'),
                            'priority' => 2,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_nav_link_hover_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Nav Link Hover Color', 'rit-core-language'),
                            'priority' => 3,
                            'params' => array(
                                'default' => '#000',
                            ),
                        ),
                        'rit_nav_sub_bg_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Nav Drop Down Background Color', 'rit-core-language'),
                            'priority' => 4,
                            'params' => array(
                                'default' => 'transparent',
                            ),
                        ),
                        'rit_nav_sub_link_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Nav Drop Down Link Color', 'rit-core-language'),
                            'priority' => 5,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_nav_sub_link_hover_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Nav Drop Down Link Hover Color', RIT_TEXT_DOMAIN),
                            'priority' => 6,
                            'params' => array(
                                'default' => '#000',
                            ),
                        ),
                    )
                ),

                'rit_new_section_color_body' => array(
                    'title' => esc_html__('Color - Body', 'rit-core-language'),
                    'description' => '',
                    'priority' => 10,
                    'panel'=> 'rit_color',
                    'settings' => array(
                        'rit_body_bg_image' => array(
                            'class' => 'image',
                            'label' => esc_html__('Page Background Image', 'rit-core-language'),
                            'priority' => 0
                        ),
                        'rit_body_bg_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Body Background Color', 'rit-core-language'),
                            'priority' => 0,
                            'params' => array(
                                'default' => 'transparent',
                            ),
                        ),
                        'rit_body_text_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Text Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_body_link_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Link Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#353535',
                            ),
                        ),
                        'rit_body_link_hover_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Link Hover Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#000',
                            ),
                        ),
                        'rit_body_h1_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('H1 Text Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_body_h2_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('H2 Text Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_body_h3_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('H3 Text Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_body_h4_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('H4 Text Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_body_h5_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('H5 Text Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_body_h6_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('H6 Text Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        )
                    )
                ),

                'rit_new_section_color_footer' => array(
                    'title' => esc_html__('Color - Footer', 'rit-core-language'),
                    'description' => '',
                    'panel'=> 'rit_color',
                    'priority' => 11,
                    'settings' => array(
                        'rit_footer_background_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Footer Background Color', 'rit-core-language'),
                            'priority' => 0,
                            'params' => array(
                                'default' => 'transparent',
                            ),
                        ),
                        'rit_footer_border_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Footer Border Color', 'rit-core-language'),
                            'priority' => 0,
                            'params' => array(
                                'default' => '#fff',
                            ),
                        ),
                        'rit_footer_text_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Footer Text Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_footer_link_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Footer Link Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_footer_link_hover_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Footer Link Hover Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#000',
                            ),
                        ),
                        'rit_copyright_bg_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Copyright Background Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_copyright_text_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Copyright Text Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_copyright_link_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Copyright Link Color', 'rit-core-language'),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#757575',
                            ),
                        ),
                        'rit_copyright_link_hover_color' => array(
                            'class' => 'color',
                            'label' => esc_html__('Copyright Link Hover Color', RIT_TEXT_DOMAIN),
                            'priority' => 1,
                            'params' => array(
                                'default' => '#000',
                            ),
                        ),
                    )
                )
            );

        }

        public function rit_customizer_script()
        {
            // Register
            wp_enqueue_style('rit-customize-css', RIT_PLUGIN_URL . 'inc/customize/assets/css/customizer.css', array(), RIT_VERSION);
            wp_enqueue_script('rit-customize-js', RIT_PLUGIN_URL . 'inc/customize/assets/js/customizer.js', array('jquery'), RIT_VERSION, true);

            // Localize
            wp_localize_script('rit-customize-js', 'RIT_Customize_Import_Export_l10n', array(
                'emptyImport' => esc_html__('Please choose a file to import.', 'rit-core-language')
            ));

            // Config
            wp_localize_script('rit-customize-js', 'RIT_Customize_Import_Export_Config', array(
                'customizerURL' => admin_url('customize.php'),
                'exportNonce' => wp_create_nonce('rit-exporting')
            ));
        }

        /**
         * @method controls_print_scripts
         */
        public function rit_customizer_controls_print_scripts()
        {
            global $cei_error;

            if ($cei_error) {
                echo '<script> alert("' . esc_js($cei_error) . '"); </script>';
            }
        }

        public function add_customize($customizers) {
            $this->customizers = array_merge($this->customizers, $customizers);
        }

        public function add_panel($panels) {
            $this->panels = array_merge($this->panels, $panels);
        }

        // magic method for active callback function
        public function __call($func, $params){
            if(in_array($func, $this->activeCallbackFunctions)){
                $controlName = str_replace('_active_callback_function', '', $func);
                $customizeControl = $this->getCustomizeControl($controlName);
                if($customizeControl && isset($customizeControl['dependency']) && count($customizeControl['dependency']) > 0){
                    foreach($customizeControl['dependency'] as $dependency => $values){
                        if(is_array($values) &&  count($values) > 0){
                            $result = false;
                            foreach($values as $val){
                                if ($params[0]->manager->get_setting($dependency)->value() == $val){
                                    $result = true;
                                }
                            }
                            return $result;
                        } elseif ( $params[0]->manager->get_setting($dependency)->value() != $values ) {
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        private function getCustomizeControl($name){
            foreach ($this->customizers as $section => $section_params) {
                foreach ($section_params['settings'] as $setting => $params) {
                    if($setting == $name)
                        return $params;
                }
            }
            return false;
        }

        public function rit_register_theme_customizer()
        {
            global $wp_customize;

            foreach ($this->customizers as $section => $section_params) {

                //add section
                $wp_customize->add_section($section, $section_params);
                if (isset($section_params['settings']) && count($section_params['settings']) > 0) {
                    foreach ($section_params['settings'] as $setting => $params) {

                        if(isset($params['dependency']) && count($params['dependency']) > 0){

                            $callbackFunctionName = $setting.'_active_callback_function';

                            $this->activeCallbackFunctions[] =  $callbackFunctionName;

                            $params['active_callback'] = array($this, $callbackFunctionName);

                            unset($params['dependency']);
                        }

                        //add setting
                        $setting_params = array();
                        if (isset($params['params'])) {
                            $setting_params = $params['params'];
                            unset($params['params']);
                        }

                        $settings_callback_default = array(
                                    'default' => null,
                            		'sanitize_callback' => 'wp_kses_post',
                            		'sanitize_js_callback' => null
                        );
                        $setting_params = array_merge( $settings_callback_default,  $setting_params);

                        $wp_customize->add_setting($setting, $setting_params);


                        //Get class control
                        $class = 'WP_Customize_Control';
                        if (isset($params['class']) && !empty($params['class'])) {
                            $class = 'WP_Customize_' . ucfirst($params['class']) . '_Control';
                            unset($params['class']);
                        }

                        //add params section and settings
                        $params['section'] = $section;
                        $params['settings'] = $setting;

                        //add controll
                        $wp_customize->add_control(
                            new $class($wp_customize, $setting, $params)
                        );
                    }
                }
            }

            foreach($this->panels as $key => $panel){
                $wp_customize->add_panel($key, $panel);
            }

            return;
        }

        public function remove_default_customize_section()
        {
            global $wp_customize;
            // Remove Sections
            $wp_customize->remove_section('title_tagline');
            $wp_customize->remove_section('nav');
            $wp_customize->remove_section('static_front_page');
            $wp_customize->remove_section('colors');
            $wp_customize->remove_section('background_image');
        }
    }
}
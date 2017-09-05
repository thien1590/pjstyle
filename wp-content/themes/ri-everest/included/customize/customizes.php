<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 25/08/2015
 * Time: 11:35 SA
 */
if (class_exists('RIT_Customize')) {
    function rit_customize()
    {
        $rit_customize = RIT_Customize::getInstance();

        $customizers = array(
            'rit_new_section_header' => array(
                'title' => esc_html__('Header Options', 'ri-everest'),
                'description' => '',
                'priority' => 1,
                'settings' => array(
                    'rit_enable_sticky_header' => array(
                        'type' => 'checkbox',
                        'label' => esc_html__('Enable Sticky header',  'ri-everest'),
                        'description' => '',
                        'priority' => 1
                    ),
                    'rit_default_header' => array(
                        'type' => 'select',
                        'label' => esc_html__('Choose Header Style', 'ri-everest'),
                        'description' => '',
                        'priority' => 0,
                        'choices' => array(
                            'default' => esc_html__('Header Default', 'ri-everest'),
                            'default-style-2' => esc_html__('Header Default style 2', 'ri-everest'),
                            'default-style-3' => esc_html__('Header Default style 3', 'ri-everest'),
                            'oneline' => esc_html__('Header One line', 'ri-everest'),
                            'oneline-2' => esc_html__('Header One line 2', 'ri-everest'),
                            'transparent' => esc_html__('Header Transparent', 'ri-everest'),
                        ),
                        'params' => array(
                            'default' => 'default',
                        ),
                    ),
                )
            ),
            'rit_new_section_footer' => array(
                'title' => esc_html__('Footer Options', 'ri-everest'),
                'description' => '',
                'priority' => 2,
                'settings' => array(
                    'rit_enable_footer_fixed' => array(
                        'type' => 'checkbox',
                        'label' => esc_html__('Enable Footer fixed', 'ri-everest'),
                        'description' => '',
                        'priority' => -1
                    ),
                    'rit_default_footer' => array(
                        'type' => 'select',
                        'label' => esc_html__('Choose Footer Style', 'ri-everest'),
                        'description' => '',
                        'priority' => -1,
                        'choices' => array(
                            'default' => esc_html__('Footer Default', 'ri-everest'),
                            'default-2' => esc_html__('Footer Default Style 2', 'ri-everest'),
                            'white' => esc_html__('Footer White style', 'ri-everest'),
                            'dark'=>esc_html__('Dark style','ri-everest'),
                        ),
                        'params' => array(
                            'default' => 'default',
                        ),
                    ),
                )),
            'rit_new_section_export_import' => array(
                'title' => esc_html__('Export/Import', 'ri-everest'),
                'priority' => 5,
                'settings' => array(
                    'rit-setting' => array(
                        'class' => 'cei',
                        'priority' => 1
                    )
                ),
            ),
            'rit_new_section_meta' => array(
                'title' => esc_html__('Default Meta Options', 'ri-everest'),
                'description' => '',
                'priority' => 0,
                'settings' => array(
                    'rit_enable_color' => array(
                        'type' => 'checkbox',
                        'label' => esc_html__('Enable Custom Font & Color',  'ri-everest'),
                        'description' => 'Check it if you want use custom font and color. Uncheck if want continue use default setting',
                        'priority' => 0
                    ),
                    'rit_preset_style' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default preset styles', 'ri-everest'),
                        'description' => '',
                        'priority' => 0,
                        'choices' => array(
                            'default' => esc_html__('Default', 'ri-everest'),
                            'red' => esc_html__('Red', 'ri-everest'),
                            'green' => esc_html__('Green', 'ri-everest'),
                            'pink' => esc_html__('Pink', 'ri-everest'),
                            'goldenrod' => esc_html__('GoldenRod', 'ri-everest')
                        ),
                        'params' => array(
                            'default' => 'default',
                        ),
                    ),
                    'rit_default_blog_layout' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default Blog Layout Config', 'ri-everest'),
                        'description' => '',
                        'priority' => 0,
                        'choices' => array(
                            'default' => esc_html__('Default', 'ri-everest'),
                            'large' => esc_html__('Large', 'ri-everest'),
                        ),
                        'params' => array(
                            'default' => 'default',
                        ),
                    ),
                    'rit_default_sidebar' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default Sidebar Config', 'ri-everest'),
                        'description' => '',
                        'priority' => 0,
                        'choices' => array(
                            'no-sidebar' => esc_html__('No Sidebar', 'ri-everest'),
                            'left-sidebar' => esc_html__('Left Sidebar', 'ri-everest'),
                            'right-sidebar' => esc_html__('Right Sidebar', 'ri-everest'),
                            'both-sidebar' => esc_html__('Both Sidebar', 'ri-everest')
                        ),
                        'params' => array(
                            'default' => 'no-sidebar',
                        ),
                    ),
                    'rit_left_sidebar' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default Left Sidebar', 'ri-everest'),
                        'description' => '',
                        'priority' => 0,
                        'choices' => ri_everest_sidebar(),
                        'params' => array(
                            'default' => 'sidebar-1',
                        ),
                        'dependence' => array('rit_default_sidebar' => array('left-sidebar', 'both-sidebar'))
                    ),
                    'rit_right_sidebar' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default Right Sidebar', 'ri-everest'),
                        'description' => '',
                        'priority' => 0,
                        'choices' => ri_everest_sidebar(),
                        'params' => array(
                            'default' => 'sidebar-1',
                        ),
                        'dependence' => array('rit_default_sidebar' => array('right-sidebar', 'both-sidebar'))
                    )
                ),
            ),
            'rit_new_section_font_size' => array(
                'title' => esc_html__('Font Size Options', 'ri-everest'),
                'description' => '',
                'priority' => 5,
                'settings' => array(
                    'rit_body_font_select' => array(
                        'type' => 'select',
                        'label' => esc_html__('Body Font', 'ri-everest'),
                        'description' => '',
                        'priority' => -5,
                        'choices' => array(
                            'standard' => esc_html__('Standard', 'ri-everest'),
                            'google' => esc_html__('Google', 'ri-everest')
                        ),
                        'params' => array(
                            'default' => 'google',
                        ),
                    ),
                    'rit_body_font_standard' => array(
                        'type' => 'select',
                        'label' => esc_html__('Body Standard Font', 'ri-everest'),
                        'description' => '',
                        'priority' => -3,
                        'choices' => array(
                            'Arial' => esc_html__('Arial', 'ri-everest'),
                            'Courier New' => esc_html__('Courier New', 'ri-everest'),
                            'Georgia' => esc_html__('Georgia', 'ri-everest'),
                            'Helvetica' => esc_html__('Helvetica', 'ri-everest'),
                            'Lucida Sans' => esc_html__('Lucida Sans', 'ri-everest'),
                            'Lucida Sans Unicode' => esc_html__('Lucida Sans Unicode', 'ri-everest'),
                            'Myriad Pro' => esc_html__('Myriad Pro', 'ri-everest'),
                            'Palatino Linotype' => esc_html__('Palatino Linotype', 'ri-everest'),
                            'Tahoma' => esc_html__('Tahoma', 'ri-everest'),
                            'Times New Roman' => esc_html__('Times New Roman', 'ri-everest'),
                            'Trebuchet MS' => esc_html__('Trebuchet MS', 'ri-everest'),
                            'Verdana' => esc_html__('Verdana', 'ri-everest')
                        ),
                        'params' => array(
                            'default' => 'Arial',
                        ),
                        'dependency' => array('rit_body_font_select' => 'standard')
                    ),
                    'rit_spec_font_standard' => array(
                        'type' => 'select',
                        'label' => esc_html__('Special Standard Font', 'ri-everest'),
                        'description' => '',
                        'priority' => -3,
                        'choices' => array(
                            'Arial' => esc_html__('Arial', 'ri-everest'),
                            'Courier New' => esc_html__('Courier New', 'ri-everest'),
                            'Georgia' => esc_html__('Georgia', 'ri-everest'),
                            'Helvetica' => esc_html__('Helvetica', 'ri-everest'),
                            'Lucida Sans' => esc_html__('Lucida Sans', 'ri-everest'),
                            'Lucida Sans Unicode' => esc_html__('Lucida Sans Unicode', 'ri-everest'),
                            'Myriad Pro' => esc_html__('Myriad Pro', 'ri-everest'),
                            'Palatino Linotype' => esc_html__('Palatino Linotype', 'ri-everest'),
                            'Tahoma' => esc_html__('Tahoma', 'ri-everest'),
                            'Times New Roman' => esc_html__('Times New Roman', 'ri-everest'),
                            'Trebuchet MS' => esc_html__('Trebuchet MS', 'ri-everest'),
                            'Verdana' => esc_html__('Verdana', 'ri-everest')
                        ),
                        'params' => array(
                            'default' => 'Arial',
                        ),
                        'dependency' => array('rit_body_font_select' => 'standard')
                    ),
                    'rit_body_font_google' => array(
                        'type' => 'googlefont',
                        'class' => 'googlefont',
                        'label' => esc_html__('Body Google Font', 'ri-everest'),
                        'description' => '',
                        'priority' => -4,
                        'dependency' => array('rit_body_font_select' => 'google')
                    ),
                    'rit_special_font_google' => array(
                        'type' => 'googlefont',
                        'class' => 'googlefont',
                        'label' => esc_html__('Special Google Font', 'ri-everest'),
                        'description' => '',
                        'priority' => -4,
                        'dependency' => array('rit_body_font_select' => 'google')
                    ),
                    'rit_title_font_google' => array(
                        'type' => 'googlefont',
                        'class' => 'googlefont',
                        'label' => esc_html__('Special Google Font', 'ri-everest'),
                        'description' => 'Apply for some Special title of theme.',
                        'priority' => -5,
                        'dependency' => array('rit_body_font_select' => 'google')
                    ),
                )
            ),
//product custom

            'rit_product_custom_sidebar' => array(
                'title' => esc_html__('Custom product sidebar',  'ri-everest'),
                'priority' => 3,
                'panel'=> 'rit_product_panel',
                'settings' => array(
                    'rit_default_product_sidebar' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default Product Sidebar Config', 'ri-everest'),
                        'description' => '',
                        'priority' => 0,
                        'choices' => array(
                            'no-sidebar' => esc_html__('No Sidebar', 'ri-everest'),
                            'left-sidebar' => esc_html__('Left Sidebar', 'ri-everest'),
                            'right-sidebar' => esc_html__('Right Sidebar', 'ri-everest'),
                            'both-sidebar' => esc_html__('Both Sidebar', 'ri-everest')
                        ),
                        'params' => array(
                            'default' => 'no-sidebar',
                        ),
                    ),
                    'rit_left_product_sidebar' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default Product Left Sidebar', 'ri-everest'),
                        'description' => '',
                        'priority' => 0,
                        'choices' => ri_everest_sidebar(),
                        'params' => array(
                            'default' => 'sidebar-1',
                        ),
                        'dependence' => array('rit_default_product_sidebar' => array('left-sidebar', 'both-sidebar'))
                    ),
                    'rit_right_product_sidebar' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default Product Right Sidebar', 'ri-everest'),
                        'description' => '',
                        'priority' => 0,
                        'choices' => ri_everest_sidebar(),
                        'params' => array(
                            'default' => 'sidebar-1',
                        ),
                        'dependence' => array('rit_default_product_sidebar' => array('right-sidebar', 'both-sidebar'))
                    ),
                )
            ),
            'rit_product_custom' => array(
                'title' => esc_html__('Custom product display',  'ri-everest'),
                'priority' => 3,
                'panel'=> 'rit_product_panel',
                'settings' => array(
                    'rit_product_hide_cart' => array(
                        'type' => 'checkbox',
                        'label' => esc_html__('Hide cart', 'ri-everest'),
                        'description' =>  esc_html__('Hide cart button in shop page', 'ri-everest'),
                        'priority' => 0,
                    ),
                    'rit_product_layout_view' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default product Layout', 'ri-everest'),
                        'description' => '',
                        'priority' => 0,
                        'choices' => array(
                            'grid' => esc_html__('Grid', 'ri-everest'),
                            'list' => esc_html__('List', 'ri-everest')
                        ),
                        'params' => array(
                            'default' => 'grid',
                        ),
                    ),
                    'rit_product_style' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default product style', 'ri-everest'),
                        'description' => 'Default style of product display',
                        'priority' => 0,
                        'choices' => array(
                            'default' => esc_html__('Default', 'ri-everest'),
                            'product_style_1' => esc_html__('Style 1', 'ri-everest'),
                            'product_style_2' => esc_html__('Style 2', 'ri-everest'),
                            'product_style_3' => esc_html__('Style 3', 'ri-everest'),
                            'product_style_4' => esc_html__('Style 4', 'ri-everest'),
                            'product_style_5' => esc_html__('Style 5', 'ri-everest')
                        ),
                        'params' => array(
                            'default' => 'default',
                        ),
                    ),
                    'rit_woocol_min_width' => array(
                        'type' => 'number',
                        'label' => esc_html__('Columns min width', 'ri-everest'),
                        'description' => esc_html__('Min width of column, help make smart layout.', 'ri-everest'),
                        'priority' => 1,
                        'params' => array(
                            'default' => '180',
                        ),
                    ),
                    'rit_days_products_new' => array(
                        'type' => 'number',
                        'label' => esc_html__('Days for new label', 'ri-everest'),
                        'description' => 'Set days number for display product new label. Default is 30 days.',
                        'priority' => 1,
                        'params' => array(
                            'default' => '30',
                        ),
                    ),
                    'rit_number_products_display' => array(
                        'type' => 'number',
                        'label' => esc_html__('Default number products display', 'ri-everest'),
                        'description' => '',
                        'priority' => 1,
                        'params' => array(
                            'default' => '9',
                        ),
                    ),
                    'rit_number_products_related_display' => array(
                        'type' => 'number',
                        'label' => esc_html__('Default number products related display', 'ri-everest'),
                        'description' => '',
                        'priority' => 2,
                        'params' => array(
                            'default' => '4',
                        ),
                    ),
                    'rit_number_products_related_display_per_row' => array(
                        'type' => 'select',
                        'label' => esc_html__('Default number products related display per row', 'ri-everest'),
                        'description' => '',
                        'priority' => 2,
                        'choices' => array(
                            '1' => esc_html__('1', 'ri-everest'),
                            '2' => esc_html__('2', 'ri-everest'),
                            '3' => esc_html__('3', 'ri-everest'),
                            '4' => esc_html__('4', 'ri-everest'),
                            '5' => esc_html__('5', 'ri-everest'),
                            '6' => esc_html__('6', 'ri-everest')
                        ),
                        'params' => array(
                            'default' => '4',
                        ),
                    ),
                    'rit_enable_slider_related_product' => array(
                        'type' => 'select',
                        'label' => esc_html__('Enable slider related product', 'ri-everest'),
                        'description' => '',
                        'priority' => 3,
                        'choices' => array(
                            'yes' => esc_html__('Yes', 'ri-everest'),
                            'no' => esc_html__('No', 'ri-everest')
                        ),
                        'params' => array(
                            'default' => 'no',
                        ),
                    )
                )
            ),


        );
        $panel =  array(
            'rit_product_panel' => array(
                'title'          => esc_html__('Custom product display', 'ri-everest'),
                'description'    => '',
                'priority' => 3,
            ),
        );
        $rit_customize->add_customize($customizers);
        $rit_customize->add_panel($panel);
        $rit_customize->rit_register_theme_customizer();
    }
    add_action('customize_register', 'rit_customize');
}
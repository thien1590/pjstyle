<?php

if (!function_exists('rit_shortcode_image_hover')) {
    function rit_shortcode_image_hover($atts)
    {

        $atts = shortcode_atts(
            array(
                'image' => '',
                'sec_image' => '',
                'title' => '',
                'sub_title' => '',
                'custom_text'=>'',
                'link' => '#',
                'text_link' => '',
                'style' => 'default',
                'mask_color'=>'',
                'fix_height'=>'',
                'enable_parallax'=>'no',
                'align'=>'left',
                'el_class' => ''
            ), $atts);
        return rit_get_template_part('shortcode', 'image-hover', array('atts' => $atts));
    }
}

add_shortcode('rit_image_hover', 'rit_shortcode_image_hover');

add_action('vc_before_init', 'rit_image_hover_integrate_vc');

if (!function_exists('rit_image_hover_integrate_vc')) {
    function rit_image_hover_integrate_vc()
    {
        vc_map(
            array(
                'name' => esc_html__('RIT Image Hover', RIT_TEXT_DOMAIN),
                'base' => 'rit_image_hover',
                'icon' => 'icon-rit',
                'category' => esc_html__('RIT', RIT_TEXT_DOMAIN),
                'description' => esc_html__('Show Image Hover', RIT_TEXT_DOMAIN),
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Image', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'param_name' => 'image',
                    ),                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Secondary Image', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'dependency' => Array('element' => 'style', 'value' => array('style-5')),
                        "description" => esc_html__("Secondary image for Style 5.", RIT_TEXT_DOMAIN),
                        'param_name' => 'sec_image',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Style', RIT_TEXT_DOMAIN),
                        'value' => array(
                            esc_html__('Default', RIT_TEXT_DOMAIN) => 'default',
                            esc_html__('Style 1', RIT_TEXT_DOMAIN) => 'style-1',
                            esc_html__('Style 2', RIT_TEXT_DOMAIN) => 'style-2',
                            esc_html__('Style 3', RIT_TEXT_DOMAIN) => 'style-3',
                            esc_html__('Style 4', RIT_TEXT_DOMAIN) => 'style-4',
                            esc_html__('Style 5', RIT_TEXT_DOMAIN) => 'style-5',
                            esc_html__('Style 6', RIT_TEXT_DOMAIN) => 'style-6',
                            esc_html__('Style 7', RIT_TEXT_DOMAIN) => 'style-7',
                            esc_html__('Style 8', RIT_TEXT_DOMAIN) => 'style-8',
                            esc_html__('Style 9', RIT_TEXT_DOMAIN) => 'style-9',
                            esc_html__('Style 10', RIT_TEXT_DOMAIN) => 'style-10',
                            esc_html__('Style 11', RIT_TEXT_DOMAIN) => 'style-11',
                            esc_html__('Style 12', RIT_TEXT_DOMAIN) => 'style-12',
                        ),
                        'std' => 'default',
                        'param_name' => 'style',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Sub Title', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'param_name' => 'sub_title',
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Custom text', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'dependency' => Array('element' => 'style', 'value' => array('style-7','style-8','style-1')),
                        'param_name' => 'custom_text',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Text Link', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'param_name' => 'text_link',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Link', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'param_name' => 'link',
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Align", RIT_TEXT_DOMAIN),
                        "param_name" => "align",
                        'value' => array(
                            esc_html__('Left', RIT_TEXT_DOMAIN) => 'left',
                            esc_html__('center', RIT_TEXT_DOMAIN) => 'center',
                            esc_html__('Right', RIT_TEXT_DOMAIN) => 'right',
                        ),
                        'dependency' => Array('element' => 'style', 'value' => array('style-4','style-11')),
                        "description" => esc_html__("Align for cover.", RIT_TEXT_DOMAIN),
                        "std" => 'left'
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__("Enable parallax", RIT_TEXT_DOMAIN),
                        'param_name' => 'enable_parallax',
                        'std' => 'no',
                        'value' => array(esc_html__('Yes', RIT_TEXT_DOMAIN) => 'yes')
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_html__("Mask color", RIT_TEXT_DOMAIN),
                        'param_name' => 'mask_color',
                        'dependency' => Array('element' => 'style', 'value' => array('style-1','style-9','style-7','style-12')),
                        "description" => esc_html__("Color background of mask. Is background button with style 12", RIT_TEXT_DOMAIN),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__("Fix height", RIT_TEXT_DOMAIN),
                        'param_name' => 'fix_height',
                        "description" => esc_html__("Set fix height, only accept number not included px, %.", RIT_TEXT_DOMAIN),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Extra class name', RIT_TEXT_DOMAIN ),
                        'param_name' => 'el_class',
                        'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', RIT_TEXT_DOMAIN )
                    )
                    
                )
            )
        );
    }
}
<?php

if (!function_exists('rit_shortcode_images_gallery')) {
    function rit_shortcode_images_gallery($atts)
    {
        $atts = shortcode_atts(
            array(
                'title' => '',
                'font_icon'=>'',
                'layout' => 'grid',
                'columns' => '3',
                'rows' => '3',
                'images' => '',
                'links' => '',
                'target'=>'',
                'el_class' => ''
            ), $atts);
        return rit_get_template_part('shortcode', 'images-gallery', array('atts' => $atts));
    }
}

add_shortcode('rit_images_gallery', 'rit_shortcode_images_gallery');

add_action('vc_before_init', 'rit_images_gallery_integrate_vc');

if (!function_exists('rit_images_gallery_integrate_vc')) {
    function rit_images_gallery_integrate_vc()
    {
        vc_map(
            array(
                'name' => esc_html__('RIT Image Gallery', RIT_TEXT_DOMAIN),
                'base' => 'rit_images_gallery',
                'icon' => 'icon-rit',
                'category' => esc_html__('RIT', RIT_TEXT_DOMAIN),
                'description' => esc_html__('Show Image Gallery', RIT_TEXT_DOMAIN),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Class font icon', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'param_name' => 'font_icon',
                        'description'=> esc_html__('Class of font awesome icon', RIT_TEXT_DOMAIN),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Layout', RIT_TEXT_DOMAIN),
                        'value' => array(
                            esc_html__('Grid', RIT_TEXT_DOMAIN) => 'grid',
                            esc_html__('Carousel', RIT_TEXT_DOMAIN) => 'carousel',
                        ),
                        'std' => 'grid',
                        'param_name' => 'layout',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Columns', RIT_TEXT_DOMAIN),
                        'value' => array(
                            esc_html__('1', RIT_TEXT_DOMAIN) => '1',
                            esc_html__('2', RIT_TEXT_DOMAIN) => '2',
                            esc_html__('3', RIT_TEXT_DOMAIN) => '3',
                            esc_html__('4', RIT_TEXT_DOMAIN) => '4',
                            esc_html__('6', RIT_TEXT_DOMAIN) => '6',
                        ),
                        'description'=> esc_html__('Number columns of layout', RIT_TEXT_DOMAIN),
                        'std' => '3',
                        'param_name' => 'columns',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Rows', RIT_TEXT_DOMAIN),
                        'value' => array(
                            esc_html__('1', RIT_TEXT_DOMAIN) => '1',
                            esc_html__('2', RIT_TEXT_DOMAIN) => '2',
                            esc_html__('3', RIT_TEXT_DOMAIN) => '3',
                            esc_html__('4', RIT_TEXT_DOMAIN) => '4',
                            esc_html__('5', RIT_TEXT_DOMAIN) => '5',
                            esc_html__('6', RIT_TEXT_DOMAIN) => '6',
                        ),
                        'description'=> esc_html__('Number rows of grid', RIT_TEXT_DOMAIN),
                        'std' => '3',
                        'param_name' => 'rows',
                    ),
                    array(
                        'type' => 'attach_images',
                        'heading' => esc_html__('Images', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'param_name' => 'images',
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Links', RIT_TEXT_DOMAIN),
                        'value' => '',
                        'description'=> esc_html__('Enter links for each slide (Note: divide links with ",").', RIT_TEXT_DOMAIN),
                        'param_name' => 'links',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__("Open in new tab.", RIT_TEXT_DOMAIN),
                        'param_name' => 'target',
                        'std' => 'no',
                        'value' => array(esc_html__('Yes', RIT_TEXT_DOMAIN) => 'yes')
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
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

if( !function_exists('vc_field_animation_type')) {
    function vc_field_animation_type($settings, $value) {
        $param_line = '<select name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '">';

        $param_line .= '<option value="">none</option>';

        $param_line .= '<optgroup label="' . esc_html__('Attention Seekers', 'rit-core-language') . '">';
        $options = array("bounce", "flash", "pulse", "rubberBand", "shake", "swing", "tada", "wobble");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . esc_attr($option) . '"' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
        }
        $param_line .= '</optgroup>';

        $param_line .= '<optgroup label="' . esc_html__('Bouncing Entrances', 'rit-core-language') . '">';
        $options = array("bounceIn", "bounceInDown", "bounceInLeft", "bounceInRight", "bounceInUp");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . esc_attr($option) . '"' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
        }
        $param_line .= '</optgroup>';

        $param_line .= '<optgroup label="' . esc_html__('Fading Entrances', 'rit-core-language') . '">';
        $options = array("fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . esc_attr($option) . '"' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
        }
        $param_line .= '</optgroup>';

        $param_line .= '<optgroup label="' . esc_html__('Flippers', 'rit-core-language') . '">';
        $options = array("flip", "flipInX", "flipInY");//, "flipOutX", "flipOutY");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . esc_attr($option) . '"' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
        }
        $param_line .= '</optgroup>';

        $param_line .= '<optgroup label="' . esc_html__('Lightspeed', 'rit-core-language') . '">';
        $options = array("lightSpeedIn");//, "lightSpeedOut");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . esc_attr($option ) . '"' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
        }
        $param_line .= '</optgroup>';

        $param_line .= '<optgroup label="' . esc_html__('Rotating Entrances', 'rit-core-language') . '">';
        $options = array("rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . esc_attr($option ) . '"' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
        }
        $param_line .= '</optgroup>';

        $param_line .= '<optgroup label="' . esc_html__('Sliders', 'rit-core-language') . '">';
        $options = array("slideInDown", "slideInLeft", "slideInRight");//, "slideOutLeft", "slideOutRight", "slideOutUp");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . esc_attr($option ) . '"' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
        }
        $param_line .= '</optgroup>';

        $param_line .= '<optgroup label="' . esc_html__('Specials', 'rit-core-language') . '">';
        $options = array("hinge", "rollIn");//, "rollOut");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . esc_attr($option ) . '"' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
        }
        $param_line .= '</optgroup>';

        $param_line .= '</select>';

        return $param_line;
    }

}

function rit_multi_select_categories($settings, $value, $taxonomies = 'category'){
    $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
    $type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    $categories = get_terms( $taxonomies );

    $output = $selected = $ids = '';
    if ( $value !== '' ) {
        $ids = explode( ',', $value );
        $ids = array_map( 'trim', $ids );
    } else {
        $ids = array();
    }
    $output .= '<select class="rit-select-multi-category" multiple="multiple" style="min-width:200px;">';
    foreach($categories as $cat){
        if(in_array($cat->slug, $ids)){
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        $output .= '<option '.esc_attr($selected).' value="'. esc_attr($cat->slug) .'">'. esc_html__($cat->name,RIT_TEXT_DOMAIN) .'</option>';
    }
    $output .= '</select>';

    $output .= "<input type='hidden' name='". esc_attr($param_name) ."' value='".esc_attr( $value) ."' class='wpb_vc_param_value ". esc_attr($param_name) ." ".esc_attr($type) ." ". esc_attr($class) ."'>";
    $output .= '<script type="text/javascript">
							jQuery(".rit-select-multi-category").select({
								placeholder: "Select Categories",
								allowClear: true
							});
							jQuery(".rit-select-multi-category").on("change",function(){
								jQuery(this).next().val(jQuery(this).val());
							});
						</script>';
    return $output;

}

function vc_field_rit_multi_select($settings, $value){
    $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
    $type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    $options = isset($settings['value']) ? $settings['value'] : array();

    $output = $selected = $ids = '';

    if ( $value !== '' ) {
        $ids = explode( ',', $value );
        $ids = array_map( 'trim', $ids );
    } else {
        $ids = array();
    }

    $output .= '<select class="rit-select-multi" multiple="multiple" style="min-width:200px;">';
    foreach($options as $name => $val ){

        if(in_array($val, $ids)){
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        $output .= '<option '. esc_attr($selected) .' value="'.esc_attr($val).'">'. esc_html__($name, RIT_TEXT_DOMAIN) .'</option>';
    }
    $output .= '</select>';

    $output .= "<input type='hidden' name='". esc_attr($param_name) ."' value='". esc_attr($value) ."' class='wpb_vc_param_value ". esc_attr($param_name)." ".esc_attr($type)." ".esc_attr($class)."'>";
    $output .= '<script type="text/javascript">
							jQuery(".rit-select-multi").select({
								placeholder: "Select Categories",
								allowClear: true
							});
							jQuery(".rit-select-multi").on("change",function(){
								jQuery(this).next().val(jQuery(this).val());
							});
						</script>';
    return $output;
}

function vc_field_post_categories($settings, $value) {
    return rit_multi_select_categories($settings, $value, 'category');
}

function vc_field_portfolio_categories($settings, $value) {
    return rit_multi_select_categories($settings, $value, 'portfolio_category');
}

function vc_field_testimonial_categories($settings, $value) {
    return rit_multi_select_categories($settings, $value, 'testimonial_category');
}

function vc_field_product_categories($settings, $value) {
    return rit_multi_select_categories($settings, $value, 'product_cat');
}

function vc_field_image_radio($settings, $value) {
    $type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    $output = '<input class="wpb_vc_param_value '. esc_attr($settings['param_name']).' '.esc_attr($type).' '.esc_attr($class).'"  type="hidden" name="'.esc_attr($settings['param_name']).'" value="'.esc_attr($value).'">';
    $width = isset($settings['width']) ? $settings['width'] : '120px';
    $height = isset($settings['height']) ? $settings['height'] : '80px';
    if(count($settings['value']) > 0 ){
        foreach($settings['value'] as $param => $param_val) {
            $border_color = 'white';
            if($param_val == $value){
                $border_color = 'green';
            }
            $output .= '<img class="rit-image-radio-'.esc_attr($settings['param_name']).'" src="'.esc_url($param).'" data-value="'.esc_attr($param_val).'" style="width:'.$width.';height:'.$height.';border-style: solid;border-width: 5px;border-color: '.$border_color.';margin-left: 15px;">';
        }
        $output .= '<script type="text/javascript">
							jQuery(".rit-image-radio-'.esc_js($settings['param_name']).'").click(function() {
							    jQuery("input[name=\''.esc_js($settings['param_name']).'\']").val(jQuery(this).data("value"));
							    jQuery(".rit-image-radio-'.esc_js($settings['param_name']).'").css("border-color", "white");
							    jQuery(this).css("border-color", "green");
							});
						</script>';
    }
    return $output;
}


if(!function_exists('rit_make_the_plugin_load_at_last_position')){
    function rit_make_the_plugin_load_at_last_position() {
        $plugin_path = explode('/', str_replace('\\', '/', RIT_PLUGIN_PATH));

        $this_plugin = plugin_basename( trim( $plugin_path[count($plugin_path) - 2 ] . '/rit-core.php' ) );

        $active_plugins = get_option('active_plugins');

        $this_plugin_key = array_search($this_plugin, $active_plugins);

        if ($this_plugin_key >= 0) { // if it's 0 it's the plugin on the top of plugin list

            array_splice($active_plugins, $this_plugin_key, 1);

            array_push($active_plugins, $this_plugin);

            update_option('active_plugins', $active_plugins);
        }


    }
}

if (!function_exists('vc_add_shortcode_param')){
    rit_make_the_plugin_load_at_last_position();
}else{
    vc_add_shortcode_param('rit_animation_type', 'vc_field_animation_type');
    vc_add_shortcode_param('rit_post_categories', 'vc_field_post_categories');
    vc_add_shortcode_param('rit_portfolio_categories', 'vc_field_portfolio_categories');
    vc_add_shortcode_param('rit_testimonial_categories', 'vc_field_testimonial_categories');
    vc_add_shortcode_param('rit_product_categories', 'vc_field_product_categories');
    vc_add_shortcode_param('rit_image_radio', 'vc_field_image_radio');
    vc_add_shortcode_param('rit_multi_select', 'vc_field_rit_multi_select');
}

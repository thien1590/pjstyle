<?php

/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Ri Everest
 * @since Ri Everest 1.0
 */
global $post;
?>
<aside id="sidebar-right" class="sidebar col-sm-12 col-md-3">
    <?php $sidebar_right = '';
    if(is_product_category()){
        $sidebar_right = get_theme_mod('rit_right_product_sidebar', 'sidebar-1');
    }
    else {
    if(get_post_meta($post->ID, 'rit_sidebar_options', true) == 'use-default' || get_post_meta($post->ID, 'rit_sidebar_options', true)==''){
        $sidebar_right = get_theme_mod('rit_right_product_sidebar', 'sidebar-1');
    } else {
        $sidebar_right = get_post_meta($post->ID, 'rit_right_product_sidebar', true);
    }}
    dynamic_sidebar($sidebar_right); ?>
    <span class="close-sidebar"><i class=" clever-icon-close"></i></span>
</aside>

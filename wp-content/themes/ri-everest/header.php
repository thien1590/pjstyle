<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Everest
 * @since Everest 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if (function_exists('has_site_icon') && has_site_icon()) {
        wp_site_icon();
    } else {
        if (get_theme_mod('rit_favicon') != '') {
            echo '<link type="image/x-icon" href="' . esc_url(get_theme_mod('rit_favicon')) . '" rel="shortcut icon">';
        }
    }
    ?>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="wrapper">
    <div id="mobile-nav-block">
        <form role="search" method="get" id="mobile-searchform" action="<?php echo home_url(); ?>">
            <input type="text" value="<?php echo esc_attr(apply_filters('the_search_query', get_search_query())); ?>"
                   placeholder="<?php echo esc_html__('Search...', 'ri-everest') ?>" class="ipt text"
                   name="s" id="s"/>
        </form>
        <?php wp_nav_menu(array('theme_location' => 'mobile', 'container' => 'div', 'container_class' => 'wrapper-mobile-nav', 'menu_class' => 'wrapper-mobile-nav', 'menu_id' => 'mobile-menu')); ?>
    </div>
    <?php
    if (is_single() || is_page()) {
    if (get_post_meta(get_the_ID(), 'rit_header_options', true) == '' || get_post_meta(get_the_ID(), 'rit_header_options', true) == 'use-default') {
        get_template_part('included/templates/header/header', get_theme_mod('rit_default_header', 'default'));
    } else {
        get_template_part('included/templates/header/header', get_post_meta(get_the_ID(), 'rit_header_options', true));
    }
    if (get_post_meta(get_the_ID(), 'rit_slider_shortcode', true) != ''):
        echo do_shortcode(get_post_meta(get_the_ID(), 'rit_slider_shortcode', true));
    endif;
} else {
    get_template_part('included/templates/header/header', get_theme_mod('rit_default_header', 'default'));
}
<?php

/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Ri Everest
 * @since Ri Everest 1.0
 */
$sidebar_right = '';
if (is_single() || is_page()) {
    if (get_post_meta(get_the_ID(), 'rit_sidebar_options', true) == 'use-default' || get_post_meta(get_the_ID(), 'rit_sidebar_options', true) == '') {
        $sidebar_right = get_theme_mod('rit_right_sidebar', 'sidebar-1');
    } else {
        $sidebar_right = get_post_meta(get_the_ID(), 'rit_right_sidebar', true);
    }
} else
    $sidebar_right = get_theme_mod('rit_right_sidebar', 'sidebar-1');
?>
<div id="sidebar-right" class=" sidebar col-sm-12 col-md-3">
    <?php dynamic_sidebar($sidebar_right); ?>
</div>


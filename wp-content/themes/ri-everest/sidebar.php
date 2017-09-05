<?php

/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Ri Everest
 * @since Ri Everest 1.0
 */

$sidebar_left = '';
if(get_post_meta(get_the_ID(), 'rit_sidebar_options', true) == 'use-default' || get_post_meta(get_the_ID(), 'rit_sidebar_options', true) == ''){

    $sidebar_left = get_theme_mod('rit_left_sidebar', 'sidebar-1');
} else {
    $sidebar_left = get_post_meta(get_the_ID(), 'rit_left_sidebar', true);
}

?>
<?php if ( is_active_sidebar( $sidebar_left ) ) : ?>
    <div id="sidebar-left" class="col-sm-12 col-md-3 sidebar" role="complementary">
        <?php dynamic_sidebar( $sidebar_left ); ?>
    </div><!-- .widget-area -->
<?php endif; ?>

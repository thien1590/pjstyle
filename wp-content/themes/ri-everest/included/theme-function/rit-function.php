<?php
/**
 * Created by PhpStorm.
 * User: chinhbeo
 * Date: 5/14/15
 * Time: 9:29 AM
 */

/* VARIABLE DEFINITIONS ================================================== */
if (!defined('RIT_TEMPLATE_PATH')) {
    define('RIT_TEMPLATE_PATH', get_template_directory());
}
if (!defined('RIT_INCLUDES_PATH')) {
    define('RIT_INCLUDES_PATH', RIT_TEMPLATE_PATH . '/included');
}
if (!defined('RIT_TEMPLATE_PATH')) {
    define('RIT_LOCAL_PATH', get_template_directory_uri());
}

// Shortcode
// Function For RIT Theme
include(RIT_INCLUDES_PATH . '/customize/customize-style.php');

// Include Widgets
include(RIT_INCLUDES_PATH . '/widgets/recent-post.php');
include(RIT_INCLUDES_PATH . '/widgets/search.php');
include(RIT_INCLUDES_PATH . '/widgets/recent-post-sidebar.php');
include(RIT_INCLUDES_PATH . '/widgets/img-hover.php');
//Call customizer function
include(RIT_INCLUDES_PATH . '/customize/customizes.php');
include(RIT_INCLUDES_PATH . '/meta-box/meta-boxes.php');
// Author Link Social
function ri_everest_social_author($contactmethods)
{
    $contactmethods['twitter'] = 'Twitter Username';
    $contactmethods['facebook'] = 'Facebook Username';
    $contactmethods['google'] = 'Google Plus Username';
    $contactmethods['tumblr'] = 'Tumblr Username';
    $contactmethods['instagram'] = 'Instagram Username';
    $contactmethods['pinterest'] = 'Pinterest Username';
    return $contactmethods;
}

add_filter('user_contactmethods', 'ri_everest_social_author', 10, 1);

// List Sidebar
if (!function_exists('ri_everest_sidebar')) {
    function ri_everest_sidebar()
    {
        global $wp_registered_sidebars;
        $sidebar_options = array();
        foreach ($wp_registered_sidebars as $sidebar) {
            $sidebar_options[$sidebar['id']] = $sidebar['name'];
        }
        return $sidebar_options;
    }
}

// Category
if (!function_exists('ri_everest_category')) {
    function ri_everest_category($separator)
    {
        $first_time = 1;
        foreach ((get_the_category()) as $category) {
            if ($first_time == 1) {
                echo '<a href="' . esc_src(get_category_link($category->term_id)). '" title="' . sprintf(__("View all posts in %s", "ri-everest"), $category->name) . '" ' . '>' . $category->name . '</a>';
                $first_time = 0;
            } else {
                echo esc_html($separator) . '<a href="' . esc_src(get_category_link($category->term_id)) . '" title="' . sprintf(__("View all posts in %s", "ri-everest"), $category->name) . '" ' . '>' . $category->name . '</a>';
            }
        }
    }
}
//Get menu name
function ri_everest_get_menu_by_location( $location ) {
    if( empty($location) ) return false;
    $locations = get_nav_menu_locations();
    if( ! isset( $locations[$location] ) ) return false;
    $menu_obj = get_term( $locations[$location], 'nav_menu' );
    return $menu_obj;
}

// -------------------- Register Sidebar --------------------- //
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => esc_html__('Sidebar 1','ri-everest'),
        'id' => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' =>  esc_html__('Sidebar 2','ri-everest'),
        'id' => 'sidebar-2',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' =>  esc_html__('Top left header','ri-everest'),
        'id' => 'top-left-header',
        'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' =>  esc_html__('Top right header','ri-everest'),
        'id' => 'top-header',
        'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' =>  esc_html__('Main header','ri-everest'),
        'id' => 'main-header',
        'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' =>  esc_html__('Center header','ri-everest'),
        'id' => 'center-header',
        'description'=>esc_html__('Use for header default style 3','ri-everest'),
        'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' =>  esc_html__('Top Footer 1','ri-everest'),
        'id' => 'top-footer-1',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Top Footer 2','ri-everest'),
        'id' => 'top-footer-2',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer info','ri-everest'),
        'id' => 'footer-info',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 1','ri-everest'),
        'id' => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 2','ri-everest'),
        'id' => 'footer-2',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 3','ri-everest'),
        'id' => 'footer-3',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' =>  esc_html__('Footer 4','ri-everest'),
        'id' => 'footer-4',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 4 for footer white','ri-everest'),
        'id' => 'footer-4-2',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' =>  esc_html__('Bottom main footer','ri-everest'),
        'id' => 'bottom-main-footer',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' =>  esc_html__('Bottom footer','ri-everest'),
        'id' => 'bottom-footer',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' =>  esc_html__('Left product sidebar','ri-everest'),
        'id' => 'lp-sidebar',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 1 Dark footer','ri-everest'),
        'id' => 'footer-dark-1',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 2 Dark footer','ri-everest'),
        'id' => 'footer-dark-2',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 3 Dark footer','ri-everest'),
        'id' => 'footer-dark-3',
        'before_widget' => '<div id="%1$s" class="widget-item widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-widget"><span>',
        'after_title' => '</span></h3>',
    ));
}
//----Comments theme custom---//
function ri_everest_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
    if ('div' == $args['style']) {
        $add_below = 'comment';
    } else {
        $add_below = 'div-comment';
    }
    ?>
    <?php if ('li' != $args['style']) : ?>
<li id="div-comment-<?php comment_ID() ?>">
<?php endif;
    echo '<div class="wrapper-cmt-item">';
    if ($args['avatar_size'] != 0) echo '<div class="wrapper-avatar">'.get_avatar($comment, $args['avatar_size']);
    echo '</div><div class="content-comment">';
    if ($comment->comment_approved == '0') :
        echo '<em class="comment-awaiting-moderation">' . esc_html__('Your comment is awaiting moderation.', 'ri-everest') . '</em><br/>';
    endif;
    echo '<div class="info-cmmt clearfix">';
    printf( __('<h5 class="username">%s</h5>','ri-everest'), get_comment_author_link());
    printf( __('<p class="date-post">%1$s at %2$s</p>', 'ri-everest'), get_comment_date(), get_comment_time());
    echo '<div class="other-link">';
    /* translators: 1: date, 2: time */
    comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'])));
    edit_comment_link( esc_html__('Edit', 'ri-everest'), '  ', '');
    echo '</div></div>';
    comment_text();
    echo '</div></div>';
    if ('ul' != $args['style']) :
        echo '</li>';
    endif;
}

//---Add active class for nav--//
add_filter('nav_menu_css_class', 'ri_everest_special_nav_class', 10, 2);
function ri_everest_special_nav_class($classes, $item)
{
    if (in_array('current-menu-item', $classes)) {
        $classes[] = 'active ';
    }
    return $classes;
}
$defaults = array(
    'default-image'          => ''
);
// Remove Script Version
function ri_everest_remove_script_version( $src ){
    if( strpos($src, $_SERVER['SERVER_NAME']) != false ){
        $parts = explode( '?', $src );
        return $parts[0];
    }else{
        return $src;
    }
}
add_filter( 'script_loader_src', 'ri_everest_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'ri_everest_remove_script_version', 15, 1 );
add_theme_support( 'custom-header', $defaults );
add_theme_support( 'custom-background', $defaults );
add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', ri_everest_fonts_url() ) );
function ri_everest_fonts_url() {
    $fonts_url = '';
    $fonts     = array();
    $subsets   = 'latin,latin-ext';

    /*
     * Translators: If there are characters in your language that are not supported
     * by Noto Sans, translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'ri-everest' ) ) {
        $fonts[] = 'Noto Sans:400italic,700italic,400,700';
    }

    /*
     * Translators: If there are characters in your language that are not supported
     * by Noto Serif, translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'ri-everest' ) ) {
        $fonts[] = 'Noto Serif:400italic,700italic,400,700';
    }

    /*
     * Translators: If there are characters in your language that are not supported
     * by Inconsolata, translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'ri-everest' ) ) {
        $fonts[] = 'Inconsolata:400,700';
    }

    /*
     * Translators: To add an additional character subset specific to your language,
     * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
     */
    $subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'ri-everest' );

    if ( 'cyrillic' == $subset ) {
        $subsets .= ',cyrillic,cyrillic-ext';
    } elseif ( 'greek' == $subset ) {
        $subsets .= ',greek,greek-ext';
    } elseif ( 'devanagari' == $subset ) {
        $subsets .= ',devanagari';
    } elseif ( 'vietnamese' == $subset ) {
        $subsets .= ',vietnamese';
    }

    if ( $fonts ) {
        $fonts_url = add_query_arg( array(
            'family' => urlencode( implode( '|', $fonts ) ),
            'subset' => urlencode( $subsets ),
        ), 'https://fonts.googleapis.com/css' );
    }

    return $fonts_url;
}
//---End add active class---//

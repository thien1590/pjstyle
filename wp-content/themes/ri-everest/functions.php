<?php
//add js, css
//plugin required RIT_LIB::get_posst();
//defined var for template
// update check

/**
 * Everest functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage ri-everest
 * @since Ri Everest 1.0
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Everest 1.0
 */
if ( ! isset( $content_width ) ) {
    $content_width = 660;
}
// Function For RIT Theme
include('included/theme-function/rit-function.php');
/**
 * Everest only works in WordPress 4.3 or later.
 */
if ( ! function_exists( 'ri_everest_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * @since Everest 1.0
     */
    function ri_everest_setup() {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on everest, use a find and replace
         * to change 'everest' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'ri-everest', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 1600, 900, true );

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( array(
            'top' => esc_html__( 'Top Menu',      'ri-everest' ),
            'primary' => esc_html__( 'Primary Menu',      'ri-everest' ),
            'second' => esc_html__( 'Second Menu',      'ri-everest' ),
            'mobile'  => esc_html__( 'Mobile Menu', 'ri-everest' ),
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ) );

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
        ) );

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
    }
endif; // rit_setup
add_action( 'after_setup_theme', 'ri_everest_setup' );
/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since everest 1.0
 * */
function ri_everest_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'ri_everest_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since everest 1.0
 */
function ri_everest_scripts() {
    // RIT add require
    wp_enqueue_style('BOOSTRAP', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), false,'all');
    wp_enqueue_style('FONT_AWESOME', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', array(), false, 'all');
    wp_enqueue_style('RIT_FONT_ICON', get_template_directory_uri() . '/assets/cvfont-icons/cv-fonts-icons.css', array(), true, 'all');
    wp_enqueue_style('carousel', get_template_directory_uri() . '/assets/owl.carousel/owl.carousel.css', array(), false, 'all');
    wp_enqueue_style('owltheme', get_template_directory_uri() . '/assets/owl.carousel/owl.theme.css', array(), false, 'all');
    wp_enqueue_style('bxslider', get_template_directory_uri() . '/assets/bxslider/jquery.bxslider.css', array(), false, 'all');
    wp_enqueue_style('selectric', get_template_directory_uri() . '/assets/selectric/selectric.css', array(), false, 'all');
    $style_color = '';
    if (get_post_meta(get_the_ID(), 'rit_preset_style', true) == 'none' || get_post_meta(get_the_ID(), 'rit_preset_style', true) == '') {
        $style_color = get_theme_mod('rit_preset_style', 'default');
    } else {
        $style_color = get_post_meta(get_the_ID(), 'rit_preset_style', true);
    }
    wp_enqueue_style('ri_everest_PRESET_STYLES', get_template_directory_uri() . '/included/preset-styles/'.esc_attr($style_color).'.css', array(), false, 'all');
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('ri_everest_Custom_Woo_CSS', get_template_directory_uri() . '/css/everest-woocommerce.css', array(), false,'all');
    }
    if ( is_child_theme()) {
        wp_enqueue_style( 'ri_everest_parent-style', get_template_directory_uri() . '/style.css', array(), false, 'all');
        // files moved
    }
    // Load our main stylesheet.
    wp_enqueue_style( 'ri_everest-style', get_stylesheet_uri() );
    // Load the Internet Explorer specific stylesheet.
    wp_enqueue_style( 'ri_everest-ie', get_template_directory_uri() . '/css/ie.css', array( 'ri_everest-style' ), '20141010' );
    wp_style_add_data( 'ri_everest-ie', 'conditional', 'lt IE 9' );
    // Load the Internet Explorer 7 specific stylesheet.
    wp_enqueue_style( 'ri_everest-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'ri_everest-style' ), '20141010' );
    wp_style_add_data( 'ri_everest-ie7', 'conditional', 'lt IE 8' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    if ( is_singular() && wp_attachment_is_image() ) {
        wp_enqueue_script( 'ri_everest-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
    }

    wp_enqueue_script( 'ri_everest-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), false, true );

    wp_localize_script( 'ri_everest-script', 'screenReaderText', array(
        'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'ri-everest' ). '</span>',
        'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'ri-everest' ). '</span>',
    ) );

    // RIT JS ICLUDED
    wp_enqueue_script('HTML5-JS', get_template_directory_uri() . '/js/html5.js', array() , false, true);
    wp_script_add_data( 'HTML5-JS', 'conditional', 'lt IE 9' );
    wp_enqueue_script('owlcarousel', get_template_directory_uri() . '/assets/owl.carousel/owl.carousel.js', array() , false, true);
    wp_register_script('isotope', get_template_directory_uri() . '/assets/isotope/isotope.pkgd.min.js', array() , false, true);
    wp_register_script('imagesloaded', get_template_directory_uri() . '/assets/imagesloaded/imagesloaded.pkgd.min.js', array() , false, true);
    wp_enqueue_script('bxslider', get_template_directory_uri() . '/assets/bxslider/jquery.bxslider.min.js', array() , false, true);
    wp_enqueue_script('nicescroll', get_template_directory_uri() . '/assets/nicescroll/jquery.nicescroll.min.js', array() , false, true);
    wp_enqueue_script('selectric', get_template_directory_uri() . '/assets/selectric/jquery.selectric.min.js', array() , false, true);
    wp_enqueue_script('sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array() , false, true);
    if (class_exists('WooCommerce')){
        wp_enqueue_script('rit-ajax-cart', get_template_directory_uri() . '/js/ajax-cart.js', array() , false, true);
        wp_enqueue_script('carouFredSel', get_template_directory_uri() . '/assets/CarouFedsel/jquery.carouFredSel-6.2.1-packed.js', array() , false, true);
        wp_enqueue_script('zoom', get_template_directory_uri() . '/assets/Zoom/jquery.zoom.min.js', array() , false, true);
        wp_enqueue_script('countdown', get_template_directory_uri() . '/js/countdown.js', array() , false, true);
    }
    //wp_enqueue_script('RIT_JS_scrollReveal', get_template_directory_uri() . '/assets/scrollReveal/scrollReveal.min.js');
    wp_enqueue_script('ri_everest_JS_THEME', get_template_directory_uri() . '/js/rit.js', array() , false, true);
    wp_enqueue_script('ri_everest_JS_SC', get_template_directory_uri() . '/js/scripts.js', array() , false, true);
}
add_action( 'wp_enqueue_scripts', 'ri_everest_scripts' );
function ri_everest_body_class($bodyclass)
{
    $bodyclass[] = ' page';
    if (is_front_page()) {
        $bodyclass[] .= ' home-page';
    }
    if (is_single() || is_page()) {
        if (get_post_meta(get_the_ID(), 'rit_canvas_menu_options', true) == '' || get_post_meta(get_the_ID(), 'rit_canvas_menu_options', true) == 'canvas-default') {
            $bodyclass[] .= ' ' . get_theme_mod('rit_enable_canvas_menu', 'disable-canvas');
        } else {
            $bodyclass[] .= ' ' . get_post_meta(get_the_ID(), 'rit_canvas_menu_options', true);
        }
    } else {
        $bodyclass[] .= ' ' . get_theme_mod('rit_enable_canvas_menu', 'disable-canvas');
    }
    return $bodyclass;
}
/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since RIT 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function ri_everest_search_form_modify( $html ) {
    return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'ri_everest_search_form_modify' );

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';


add_action( 'tgmpa_register', 'ri_everest_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function ri_everest_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        //Rit-core
        array(
            'name'      => 'RiverTheme Core',
            'slug'      => 'rit-core', //plugin name
            'source'    => get_stylesheet_directory() . '/lib/plugins/rit-core.zip', // The plugin source.
            'required'  => true,
        ),
        ///Revolution slider
        array(
            'name'      => 'Revolution slider',
            'slug'      => 'revslider',
            'source'    =>  get_stylesheet_directory() . '/lib/plugins/revslider.zip',
            'required'  => true,
            'version'  => '5.4.5.1',
        ),
        //WPBakery Visual Composer
        array(
            'name'      => 'WPBakery Visual Compose',
            'slug'      => 'js_composer',
            'source'    => get_stylesheet_directory() . '/lib/plugins/js_composer.zip', // The plugin source.
            'required'  => true,
            'version'  => '5.2',
        ),
        //WPBakery Visual Composer
        array(
            'name'      => 'Woocommerce Product Filter',
            'slug'      => 'woocommerce-product-filter',
            'source'    => get_stylesheet_directory() . '/lib/plugins/prdctfltr.zip', // The plugin source.
            'required'  => true,
            'version'  => '6.3.0',
        ),
        //Meta-box
        array(
            'name'      => 'Meta box',
            'slug'      => 'meta-box', //plugin name
            'required'  => true,
        ),
        //woocommerce
        array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => true,
        ),
        //Contact form 7
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => true,
        ),

        //Widget import and exporter
        array(
            'name'      => 'Widget import & exporter',
            'slug'      => 'widget-importer-exporter',
            'required'  => true,
        ),
        //Mega menu
        array(
            'name'      => 'Max mega menu',
            'slug'      => 'megamenu', //plugin name
        ),
        //News letter
        array(
            'name'      => 'News letter',
            'slug'      => 'newsletter',
        ),
        //Currency
        array(
            'name'      => 'WooCommerce Currency Switcher',
            'slug'      => 'woocommerce-currency-switcher',
        ),
        //WP User Avatar
        array(
            'name'      => 'WP User Avatar',
            'slug'      => 'wp-user-avatar',
        ),
        ///breadcrumb-trail
        array(
            'name'      => 'Breadcrumb Navxt',
            'slug'      => 'breadcrumb-navxt',
            'required'  => true,
        ),

        //YITH WooCommerce Wishlist
        array(
            'name'      => 'YITH Woocommerce Wishlist',
            'slug'      => 'yith-woocommerce-wishlist',
        ),
        //YITH WooCommerce Quickview
        array(
            'name'      => 'YITH Woocommerce Quick View',
            'slug'      => 'yith-woocommerce-quick-view',
        ),
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     *
     * Some of the strings are wrapped in a sprintf(), so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'ri-everest' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'ri-everest' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'ri-everest' ), // %s = plugin name.
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'ri-everest' ),
            'notice_can_install_required'     => _n_noop(
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'ri-everest'
            ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop(
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'ri-everest'
            ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop(
                'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
                'ri-everest'
            ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop(
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                'ri-everest'
            ), // %1$s = plugin name(s).
            'notice_ask_to_update_maybe'      => _n_noop(
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'ri-everest'
            ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop(
                'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
                'ri-everest'
            ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop(
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'ri-everest'
            ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop(
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'ri-everest'
            ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop(
                'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
                'ri-everest'
            ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'ri-everest'
            ),
            'update_link' 					  => _n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'ri-everest'
            ),
            'activate_link'                   => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'ri-everest'
            ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'ri-everest' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'ri-everest' ),
            'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'ri-everest' ),
            'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'ri-everest' ),  // %1$s = plugin name(s).
            'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'ri-everest' ),  // %1$s = plugin name(s).
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'ri-everest' ), // %s = dashboard link.
            'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'ri-everest' ),
            'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
    tgmpa( $plugins, $config );
}
//Custom Functions of woo
include('woocommerce/woo-functions.php');
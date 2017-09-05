<?php
/*

RESET DEFAULT DATA WORDPRESS

*/
include('dbimexport.php');
/* Clear All Cache After Import Data */
add_action('wp_ajax_rit_clear_cache', 'rit_clear_cache');
add_action( 'wp_ajax_nopriv_rit_clear_cache', 'rit_clear_cache' );

function rit_clear_cache(){
    $wp_upload_dir = wp_upload_dir();
    $tmpcache = $wp_upload_dir ["basedir"]. '/rit_core_data';
    $filescache = glob( $tmpcache . '/*' ); // get all file names
    foreach($filescache as $file){ // iterate files
        if(is_file($file))
            unlink($file); // delete file
    }


}

add_action('wp_ajax_rit_backup_tables', 'rit_backup_tables');
add_action( 'wp_ajax_nopriv_rit_backup_tables', 'rit_backup_tables' );

function rit_backup_tables() {
    $wp_upload_dir = wp_upload_dir();
    global $wpdb;

    /* BACKUP DATA DONE */
    /* Start Reset Default WP Data */
    if(isset($_POST[enable_drop_old_data]) && $_POST[enable_drop_old_data] == 1){
        /* Reset Default WP Data Done */
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'commentmeta` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'comments` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'links` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'newsletter` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'newsletter_emails` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'newsletter_stats` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'postmeta` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'posts` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'revslider_css` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'revslider_layer_animations` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'revslider_settings` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'revslider_sliders` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'revslider_slides` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'revslider_static_slides` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'term_relationships` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'term_taxonomy` WHERE 1');
        $wpdb->query('DELETE FROM `' . $wpdb->base_prefix . 'terms` WHERE 1');
    }
    die();
}
/*
II -  Active Plugin Function
*/
add_action('wp_ajax_rit_active_plugin', 'rit_active_plugin');
add_action( 'wp_ajax_nopriv_rit_active_plugin', 'rit_active_plugin' );

function rit_active_plugin(){
    $wp_upload_dir = wp_upload_dir();
    $activate_nonce = wp_create_nonce( 'tgmpa-activate' );

    $install_nonce = wp_create_nonce( 'tgmpa-install' );

    $plugins = array(
        array(
            'name'           => 'Visual composer',
            'slug'           => 'js_composer',
            'source'         => rit_FRAMEWORK_PATH . 'extensions/plugins/js_composer.zip',
            'required'       => true,
            'file'	         => 'js_composer.php',
            'activate_nonce' => $activate_nonce,
            'install_nonce'  => $install_nonce,
        ),
        array(
            'name'           => 'WooCommerce',
            'slug'           => 'woocommerce',
            'required'       => false,
            'file'	         => 'woocommerce.php',
            'activate_nonce' => $activate_nonce,
            'install_nonce'  => $install_nonce,
            'source'         => ''
        ),
        array(
            'name'           => 'Contact Form 7', // The plugin name
            'slug'           => 'contact-form-7', // The plugin slug (typically the folder name)
            'required'       => false, // If false, the plugin is only 'recommended' instead of required
            'file'           => 'wp-contact-form-7.php',
            'activate_nonce' => $activate_nonce,
            'install_nonce'  => $install_nonce,
            'source'         => ''
        ),
        array(
            'name'     		 => 'Instagram Feed',
            'slug'     		 => 'instagram-feed',
            'required' 		 => false,
            'file'           => 'instagram-feed.php',
            'activate_nonce' => $activate_nonce,
            'install_nonce'  => $install_nonce,
            'source'         => ''
        ),
        array(
            'name'     		 => 'YITH WooCommerce Wishlist',
            'slug'     		 => 'yith-woocommerce-wishlist',
            'required' 		 => false,
            'file'           => 'init.php',
            'activate_nonce' => $activate_nonce,
            'install_nonce'  => $install_nonce,
            'source'         => ''
        ),
    );

    /**
     * Detect plugin. For use on Front End only.
     */
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    $out = array();
    /* Install Plugin */
    $i = 0;
    foreach($plugins as $pl){
        // check for plugin using plugin name
        if ( ! is_plugin_active( $pl["slug"].'/'.$pl["file"] ) ) {
            $out[$i]  = $pl;
            $i++;

        }
    }
    echo  json_encode($out);
    die();
}

add_action('wp_ajax_rit_backup_database', 'rit_backup_database');
add_action( 'wp_ajax_nopriv_rit_backup_database', 'rit_backup_database' );
function rit_backup_database(){
    $wp_upload_dir = wp_upload_dir();
    /* Upload File */
    $versionsUrl = '/rit_core_data';
    $folder = $versionsUrl;
    // Slider 4
    $upload_data = $folder.'/filter.data';
    global $wpdb;
    if(isset($_POST["ver"]) && $_POST["ver"] <> "NONE"){
        $versionsUrl =  '/rit_core_data';
        $type = $_POST["type_name"];
        $ver = $_POST["ver"];
        $upload_data = $versionsUrl . "/" . $type . "/" . $ver . "/" . $ver . "_filter.data";
    };


    $file_headers = @get_headers($upload_data);
    if( $file_headers[0] == 'HTTP/1.1 200 OK' ) {
        /* End Upload Data */
        /**/
        $tmpZip_upload_data = $wp_upload_dir["basedir"] . '/rit_core_data/filter.data';
        file_put_contents($tmpZip_upload_data, file_get_contents($upload_data));
        global $wpdb;
        $templine = '';
        // Read in entire file
        $lines = file($tmpZip_upload_data);
        // Loop through each line
        /*
            BEFORE RESTORE DATABSE
        */
        $blog_url = site_url();
        $blogname = get_option( "blogname" );
        $blogdescription = get_option( "blogdescription" );
        $admin_email = get_option( "admin_email" );
        $template = get_option( "template" );
        $stylesheet = get_option( "stylesheet" );
        $current_theme = get_option( "current_theme" );
        $current_active_plugin = serialize( get_option( "active_plugins" ) );
        //$current_theme_mod = 'a:454:{s:0:"";s:8:"404 page";s:10:"breadcrumb";b:1;s:10:"pageloader";b:1;s:13:"sidebar_width";i:30;s:11:"header_code";s:0:"";s:11:"footer_code";s:0:"";s:10:"custom_css";s:0:"";s:7:"favicon";s:0:"";s:17:"apple-iphone-icon";s:0:"";s:24:"apple-iphone-retina-icon";s:0:"";s:15:"apple-ipad-icon";s:0:"";s:22:"apple-ipad-retina-icon";s:0:"";s:21:"header-advance-import";s:288:"eyJzdGlja3ktbWVudSI6IiIsInZlcnRpY2FsLW1lbnUiOmZhbHNlLCJmaXhlZC1oZWFkZXIiOmZhbHNlLCJmdWxsLWhlYWRlciI6ZmFsc2UsInVzZS10b3AtaGVhZGVyIjpmYWxzZSwiaGVhZGVyX3NlY3Rpb25fMSI6IiIsInVzZS1taWQtaGVhZGVyIjp0cnVlLCJoZWFkZXJfc2VjdGlvbl8yIjoiIiwidXNlLWJvdC1oZWFkZXIiOmZhbHNlLCJoZWFkZXJfc2VjdGlvbl8zIjoiIn0=";s:11:"sticky-menu";s:10:"sticky_mid";s:13:"vertical-menu";s:1:"0";s:12:"fixed-header";s:1:"0";s:11:"full-header";s:1:"0";s:14:"use-top-header";s:1:"0";s:16:"header_section_1";s:0:"";s:14:"use-mid-header";b:1;s:16:"header_section_2";s:412:"{"name":"header_section_2","setting":{"bg_image":"","bg_color":"","opacity":"","fixed_abs":"fixed","custom_css":""},"columns_num":2,"htmlData":"","columns":[{"id":1,"percent":"6","value":[{"id":"1425672374616","type":"logo","value":{"custom_class":"","custom_id":""}}]},{"id":2,"value":[{"id":"1425672381632","type":"custom_menu","value":{"menu_id":"TWFpbg==","custom_class":"","custom_id":""}}],"percent":"6"}]}";s:14:"use-bot-header";s:1:"0";s:16:"header_section_3";s:0:"";s:13:"use-text-logo";s:1:"0";s:9:"text-logo";s:0:"";s:4:"logo";s:53:"[site_url]/wp-content/themes/grid/assets/img/logo.png";s:11:"retina-logo";s:56:"[site_url]/wp-content/themes/grid/assets/img/logo@2x.png";s:15:"logo-margin-top";i:19;s:17:"logo-margin-right";i:19;s:18:"logo-margin-bottom";s:1:"0";s:16:"logo-margin-left";s:1:"0";s:14:"footer-gototop";b:1;s:22:"bottom-sidebars-layout";s:8:"layout-1";s:23:"bottom-background-color";s:4:"#fff";s:23:"bottom-background-image";s:0:"";s:26:"bottom-background-position";s:0:"";s:24:"bottom-background-repeat";s:0:"";s:22:"bottom-background-size";s:0:"";s:23:"footer-background-color";s:7:"#282828";s:23:"footer-background-image";s:0:"";s:26:"footer-background-position";s:0:"";s:24:"footer-background-repeat";s:0:"";s:22:"footer-background-size";s:0:"";s:21:"footer-copyright-text";s:72:"R-theme - Design copyright © 2014 KingkongThemes® All rights reserved.";s:13:"footer-social";b:1;s:16:"offcanvas-turnon";b:1;s:15:"offcanvas-swipe";b:1;s:26:"offcanvas-sidebar-position";s:5:"right";s:17:"offcanvas-sidebar";s:15:"primary_sidebar";s:34:"offcanvas-sidebar-background-image";s:0:"";s:37:"offcanvas-sidebar-background-position";s:0:"";s:35:"offcanvas-sidebar-background-repeat";s:0:"";s:33:"offcanvas-sidebar-background-size";s:0:"";s:34:"offcanvas-sidebar-background-color";s:0:"";s:28:"offcanvas-sidebar-text-color";s:0:"";s:28:"offcanvas-sidebar-custom-css";s:0:"";s:12:"boxed-layout";s:1:"0";s:17:"use-content-width";i:1170;s:15:"titlebar-layout";s:7:"justify";s:10:"pading-top";s:0:"";s:13:"pading-bottom";s:0:"";s:16:"background-image";s:0:"";s:16:"background-color";s:0:"";s:19:"background-position";s:8:"left top";s:17:"background-repeat";s:6:"repeat";s:19:"background-parallax";s:1:"0";s:20:"titlebar-title-color";s:0:"";s:23:"titlebar-shadow-opacity";i:5;s:24:"titlebar-overlay-opacity";s:1:"0";s:25:"titlebar-clipmask-opacity";s:1:"0";s:23:"titlebar-custom-content";s:0:"";s:13:"primary-color";s:0:"";s:13:"heading-color";s:7:"#4f4f4f";s:10:"text-color";s:0:"";s:15:"footer-bg-color";s:0:"";s:10:"link-color";s:7:"#5ec5f4";s:16:"link-hover-color";s:0:"";s:12:"footer-color";s:0:"";s:17:"footer-link-color";s:0:"";s:15:"main-menu-color";s:7:"#767676";s:14:"sub-menu-color";s:7:"#767676";s:9:"body-font";s:6:"Roboto";s:12:"heading-font";s:7:"Raleway";s:12:"mainnav-font";s:7:"Raleway";s:9:"body-size";i:14;s:12:"mainnav-size";i:12;s:20:"submenu-mainnav-size";i:11;s:19:"titlebar-title-size";i:20;s:7:"h1-size";i:30;s:7:"h2-size";i:24;s:7:"h3-size";i:16;s:7:"h4-size";i:14;s:7:"h5-size";i:12;s:7:"h6-size";i:10;s:22:"mainnav-text-transform";s:9:"uppercase";s:10:"blog-style";s:5:"large";s:19:"blog-masonry-column";s:8:"column-3";s:23:"blog-masonry-full-width";s:1:"0";s:21:"blog-sidebar-position";s:13:"right_sidebar";s:12:"blog-display";s:8:"excerpts";s:14:"excerpt-length";i:40;s:15:"pagination-type";s:17:"pagination_number";s:19:"blog-timeline-image";s:0:"";s:22:"blog-categories-filter";b:1;s:14:"blog-post-link";b:1;s:9:"blog-date";b:1;s:19:"blog-number-comment";b:1;s:15:"blog-categories";b:1;s:11:"blog-author";b:1;s:12:"blog-excerpt";b:1;s:13:"blog-readmore";b:1;s:9:"blog-tags";b:1;s:17:"blog-social-share";b:1;s:20:"blog-titlebar-layout";s:8:"layout-1";s:15:"blog-pading-top";s:0:"";s:18:"blog-pading-bottom";s:0:"";s:21:"blog-background-image";s:0:"";s:21:"blog-background-color";s:0:"";s:22:"blog-background-repeat";s:9:"no-repeat";s:24:"blog-background-position";s:8:"left top";s:24:"blog-background-parallax";s:1:"0";s:28:"blog-titlebar-shadow-opacity";i:5;s:29:"blog-titlebar-overlay-opacity";s:1:"0";s:30:"blog-titlebar-clipmask-opacity";s:1:"0";s:28:"blog-titlebar-custom-content";s:0:"";s:11:"blog-social";b:1;s:20:"blog-social-facebook";b:1;s:19:"blog-social-twitter";b:1;s:23:"blog-social-google-plus";b:1;s:20:"blog-social-linkedin";b:1;s:18:"blog-social-tumblr";b:1;s:17:"blog-social-email";b:1;s:13:"single-layout";s:13:"right_sidebar";s:21:"single-custom-sidebar";s:0:"";s:17:"single-categories";b:1;s:16:"single-post-date";b:1;s:10:"single-nav";b:1;s:11:"single-tags";b:1;s:16:"single-authorbox";b:1;s:19:"single-related-post";b:1;s:25:"single-related-post-title";s:17:"You may also like";s:19:"single-commnet-form";b:1;s:22:"single-titlebar-layout";s:7:"justify";s:17:"single-pading-top";s:0:"";s:20:"single-pading-bottom";s:0:"";s:23:"single-background-image";s:0:"";s:23:"single-background-color";s:0:"";s:24:"single-background-repeat";s:9:"no-repeat";s:26:"single-background-position";s:8:"left top";s:26:"single-background-parallax";s:1:"0";s:30:"single-titlebar-shadow-opacity";i:5;s:31:"single-titlebar-overlay-opacity";s:1:"0";s:32:"single-titlebar-clipmask-opacity";s:1:"0";s:30:"single-titlebar-custom-content";s:0:"";s:13:"single-social";b:1;s:22:"single-social-facebook";b:1;s:21:"single-social-twitter";b:1;s:25:"single-social-google-plus";b:1;s:22:"single-social-linkedin";b:1;s:20:"single-social-tumblr";b:1;s:19:"single-social-email";b:1;s:23:"portfolio-category-slug";s:0:"";s:25:"portfolio-category-layout";s:13:"right_sidebar";s:24:"portfolio-custom-sidebar";s:0:"";s:26:"portfolio-display-titlebar";b:1;s:24:"portfolio-category-style";s:15:"gallery_masonry";s:30:"portfolio-category-child-style";s:4:"none";s:25:"portfolio-category-column";s:9:"3_columns";s:25:"portfolio-category-number";i:9;s:24:"portfolio-display-filter";b:1;s:34:"portfolio-category-pagination-type";s:17:"pagination_number";s:14:"portfolio-slug";s:0:"";s:22:"portfolio-related-post";b:1;s:28:"portfolio-related-post-title";s:16:"Related Projects";s:29:"single-related-post-sub-title";s:0:"";s:20:"shop-cart-menu-empty";s:4:"cart";s:25:"shop-cart-menu-empty-link";s:0:"";s:20:"product-hover-effect";s:4:"fade";s:13:"shop-template";s:13:"right_sidebar";s:15:"shop-breadcrumb";s:1:"0";s:20:"shop-display-sorting";b:1;s:25:"shop-display-result-count";b:1;s:20:"shop-products-column";i:3;s:22:"shop-products-per-page";s:0:"";s:20:"shop-single-template";s:13:"right_sidebar";s:34:"shop-single-display-share-products";b:1;s:36:"shop-single-display-related-products";b:1;s:28:"shop-related-products-number";i:4;s:35:"shop-related-products-number-tablet";i:2;s:35:"shop-related-products-number-mobile";i:1;s:9:"404-title";s:21:"OOps! Page not found!";s:9:"404-image";s:0:"";s:8:"404-text";s:138:"It seems we can’t find what you’re looking for. Perhaps searching can help or go back to <a href="[site_url]" rel="home">Homepage</a>.";s:7:"404-sub";b:1;s:13:"social-target";s:6:"_blank";s:16:"twitter-username";s:9:"themelead";s:12:"social-title";b:1;s:15:"social-facebook";s:0:"";s:14:"social-twitter";s:0:"";s:18:"social-google-plus";s:0:"";s:15:"social-linkedin";s:0:"";s:13:"social-tumblr";s:0:"";s:16:"social-pinterest";s:0:"";s:14:"social-youtube";s:0:"";s:12:"social-skype";s:0:"";s:16:"social-instagram";s:0:"";s:16:"social-delicious";s:0:"";s:13:"social-reddit";s:0:"";s:18:"social-stumbleupon";s:0:"";s:16:"social-wordpress";s:0:"";s:13:"social-joomla";s:0:"";s:14:"social-blogger";s:0:"";s:12:"social-vimeo";s:0:"";s:12:"social-yahoo";s:0:"";s:13:"social-flickr";s:0:"";s:13:"social-picasa";s:0:"";s:17:"social-deviantart";s:0:"";s:13:"social-github";s:0:"";s:20:"social-stackoverflow";s:0:"";s:11:"social-xing";s:0:"";s:13:"social-flattr";s:0:"";s:17:"social-foursquare";s:0:"";s:13:"social-paypal";s:0:"";s:11:"social-yelp";s:0:"";s:17:"social-soundcloud";s:0:"";s:13:"social-lastfm";s:0:"";s:13:"social-lanyrd";s:0:"";s:15:"social-dribbble";s:0:"";s:13:"social-forrst";s:0:"";s:12:"social-steam";s:0:"";s:14:"social-behance";s:0:"";s:11:"social-mixi";s:0:"";s:12:"social-weibo";s:0:"";s:13:"social-renren";s:0:"";s:15:"social-evernote";s:0:"";s:14:"social-dropbox";s:0:"";s:16:"social-bitbucket";s:0:"";s:13:"social-trello";s:0:"";s:9:"social-vk";s:0:"";s:11:"social-home";s:0:"";s:19:"social-envelope-alt";s:0:"";s:10:"social-rss";s:0:"";s:9:"of_backup";s:0:"";s:11:"of_transfer";s:0:"";s:18:"rit_advance_backup";s:0:"";s:9:"smof_init";s:31:"Fri, 06 Mar 2015 20:03:29 +0000";s:7:"backups";N;s:27:"rit_editor_header_section_1";s:1:" ";s:39:"custom_wp_editor_class_header_section_1";s:0:"";s:36:"custom_wp_editor_id_header_section_1";s:0:"";s:40:"custom_search_box_class_header_section_1";s:0:"";s:37:"custom_search_box_id_header_section_1";s:0:"";s:36:"custom_social_class_header_section_1";s:0:"";s:33:"custom_social_id_header_section_1";s:0:"";s:31:"custom_menu_id_header_section_1";s:4:"Main";s:41:"custom_custom_menu_class_header_section_1";s:0:"";s:38:"custom_custom_menu_id_header_section_1";s:0:"";s:34:"custom_card_class_header_section_1";s:0:"";s:31:"custom_card_id_header_section_1";s:0:"";s:26:"widget_id_header_section_1";s:15:"primary_sidebar";s:36:"custom_widget_class_header_section_1";s:0:"";s:33:"custom_widget_id_header_section_1";s:0:"";s:34:"custom_logo_class_header_section_1";s:0:"";s:31:"custom_logo_id_header_section_1";s:0:"";s:44:"custom_canvas_sidebar_class_header_section_1";s:0:"";s:41:"custom_canvas_sidebar_id_header_section_1";s:0:"";s:33:"bg_color_setting_header_section_1";s:0:"";s:33:"bg_image_setting_header_section_1";s:0:"";s:32:"opacity_setting_header_section_1";s:3:"100";s:32:"header_position_header_section_1";s:5:"Fixed";s:35:"custom_css_setting_header_section_1";s:10:"										";s:27:"rit_editor_header_section_2";s:1:" ";s:39:"custom_wp_editor_class_header_section_2";s:0:"";s:36:"custom_wp_editor_id_header_section_2";s:0:"";s:40:"custom_search_box_class_header_section_2";s:0:"";s:37:"custom_search_box_id_header_section_2";s:0:"";s:36:"custom_social_class_header_section_2";s:0:"";s:33:"custom_social_id_header_section_2";s:0:"";s:31:"custom_menu_id_header_section_2";s:4:"Main";s:41:"custom_custom_menu_class_header_section_2";s:0:"";s:38:"custom_custom_menu_id_header_section_2";s:0:"";s:34:"custom_card_class_header_section_2";s:0:"";s:31:"custom_card_id_header_section_2";s:0:"";s:26:"widget_id_header_section_2";s:15:"primary_sidebar";s:36:"custom_widget_class_header_section_2";s:0:"";s:33:"custom_widget_id_header_section_2";s:0:"";s:34:"custom_logo_class_header_section_2";s:0:"";s:31:"custom_logo_id_header_section_2";s:0:"";s:44:"custom_canvas_sidebar_class_header_section_2";s:0:"";s:41:"custom_canvas_sidebar_id_header_section_2";s:0:"";s:33:"bg_color_setting_header_section_2";s:0:"";s:33:"bg_image_setting_header_section_2";s:0:"";s:32:"opacity_setting_header_section_2";s:3:"100";s:32:"header_position_header_section_2";s:5:"Fixed";s:35:"custom_css_setting_header_section_2";s:10:"										";s:27:"rit_editor_header_section_3";s:1:" ";s:39:"custom_wp_editor_class_header_section_3";s:0:"";s:36:"custom_wp_editor_id_header_section_3";s:0:"";s:40:"custom_search_box_class_header_section_3";s:0:"";s:37:"custom_search_box_id_header_section_3";s:0:"";s:36:"custom_social_class_header_section_3";s:0:"";s:33:"custom_social_id_header_section_3";s:0:"";s:31:"custom_menu_id_header_section_3";s:4:"Main";s:41:"custom_custom_menu_class_header_section_3";s:0:"";s:38:"custom_custom_menu_id_header_section_3";s:0:"";s:34:"custom_card_class_header_section_3";s:0:"";s:31:"custom_card_id_header_section_3";s:0:"";s:26:"widget_id_header_section_3";s:15:"primary_sidebar";s:36:"custom_widget_class_header_section_3";s:0:"";s:33:"custom_widget_id_header_section_3";s:0:"";s:34:"custom_logo_class_header_section_3";s:0:"";s:31:"custom_logo_id_header_section_3";s:0:"";s:44:"custom_canvas_sidebar_class_header_section_3";s:0:"";s:41:"custom_canvas_sidebar_id_header_section_3";s:0:"";s:33:"bg_color_setting_header_section_3";s:0:"";s:33:"bg_image_setting_header_section_3";s:0:"";s:32:"opacity_setting_header_section_3";s:3:"100";s:32:"header_position_header_section_3";s:5:"Fixed";s:35:"custom_css_setting_header_section_3";s:10:"										";s:25:"header_section_1_facebook";s:1:"0";s:24:"header_section_1_twitter";s:1:"0";s:28:"header_section_1_google-plus";s:1:"0";s:25:"header_section_1_linkedin";s:1:"0";s:23:"header_section_1_tumblr";s:1:"0";s:26:"header_section_1_pinterest";s:1:"0";s:24:"header_section_1_youtube";s:1:"0";s:22:"header_section_1_skype";s:1:"0";s:26:"header_section_1_instagram";s:1:"0";s:26:"header_section_1_delicious";s:1:"0";s:23:"header_section_1_reddit";s:1:"0";s:28:"header_section_1_stumbleupon";s:1:"0";s:26:"header_section_1_wordpress";s:1:"0";s:23:"header_section_1_joomla";s:1:"0";s:24:"header_section_1_blogger";s:1:"0";s:22:"header_section_1_vimeo";s:1:"0";s:22:"header_section_1_yahoo";s:1:"0";s:23:"header_section_1_flickr";s:1:"0";s:23:"header_section_1_picasa";s:1:"0";s:27:"header_section_1_deviantart";s:1:"0";s:23:"header_section_1_github";s:1:"0";s:30:"header_section_1_stackoverflow";s:1:"0";s:21:"header_section_1_xing";s:1:"0";s:23:"header_section_1_flattr";s:1:"0";s:27:"header_section_1_foursquare";s:1:"0";s:23:"header_section_1_paypal";s:1:"0";s:21:"header_section_1_yelp";s:1:"0";s:27:"header_section_1_soundcloud";s:1:"0";s:23:"header_section_1_lastfm";s:1:"0";s:23:"header_section_1_lanyrd";s:1:"0";s:25:"header_section_1_dribbble";s:1:"0";s:23:"header_section_1_forrst";s:1:"0";s:22:"header_section_1_steam";s:1:"0";s:24:"header_section_1_behance";s:1:"0";s:21:"header_section_1_mixi";s:1:"0";s:22:"header_section_1_weibo";s:1:"0";s:23:"header_section_1_renren";s:1:"0";s:25:"header_section_1_evernote";s:1:"0";s:24:"header_section_1_dropbox";s:1:"0";s:26:"header_section_1_bitbucket";s:1:"0";s:23:"header_section_1_trello";s:1:"0";s:19:"header_section_1_vk";s:1:"0";s:21:"header_section_1_home";s:1:"0";s:29:"header_section_1_envelope-alt";s:1:"0";s:20:"header_section_1_rss";s:1:"0";s:25:"header_section_2_facebook";s:1:"0";s:24:"header_section_2_twitter";s:1:"0";s:28:"header_section_2_google-plus";s:1:"0";s:25:"header_section_2_linkedin";s:1:"0";s:23:"header_section_2_tumblr";s:1:"0";s:26:"header_section_2_pinterest";s:1:"0";s:24:"header_section_2_youtube";s:1:"0";s:22:"header_section_2_skype";s:1:"0";s:26:"header_section_2_instagram";s:1:"0";s:26:"header_section_2_delicious";s:1:"0";s:23:"header_section_2_reddit";s:1:"0";s:28:"header_section_2_stumbleupon";s:1:"0";s:26:"header_section_2_wordpress";s:1:"0";s:23:"header_section_2_joomla";s:1:"0";s:24:"header_section_2_blogger";s:1:"0";s:22:"header_section_2_vimeo";s:1:"0";s:22:"header_section_2_yahoo";s:1:"0";s:23:"header_section_2_flickr";s:1:"0";s:23:"header_section_2_picasa";s:1:"0";s:27:"header_section_2_deviantart";s:1:"0";s:23:"header_section_2_github";s:1:"0";s:30:"header_section_2_stackoverflow";s:1:"0";s:21:"header_section_2_xing";s:1:"0";s:23:"header_section_2_flattr";s:1:"0";s:27:"header_section_2_foursquare";s:1:"0";s:23:"header_section_2_paypal";s:1:"0";s:21:"header_section_2_yelp";s:1:"0";s:27:"header_section_2_soundcloud";s:1:"0";s:23:"header_section_2_lastfm";s:1:"0";s:23:"header_section_2_lanyrd";s:1:"0";s:25:"header_section_2_dribbble";s:1:"0";s:23:"header_section_2_forrst";s:1:"0";s:22:"header_section_2_steam";s:1:"0";s:24:"header_section_2_behance";s:1:"0";s:21:"header_section_2_mixi";s:1:"0";s:22:"header_section_2_weibo";s:1:"0";s:23:"header_section_2_renren";s:1:"0";s:25:"header_section_2_evernote";s:1:"0";s:24:"header_section_2_dropbox";s:1:"0";s:26:"header_section_2_bitbucket";s:1:"0";s:23:"header_section_2_trello";s:1:"0";s:19:"header_section_2_vk";s:1:"0";s:21:"header_section_2_home";s:1:"0";s:29:"header_section_2_envelope-alt";s:1:"0";s:20:"header_section_2_rss";s:1:"0";s:25:"header_section_3_facebook";s:1:"0";s:24:"header_section_3_twitter";s:1:"0";s:28:"header_section_3_google-plus";s:1:"0";s:25:"header_section_3_linkedin";s:1:"0";s:23:"header_section_3_tumblr";s:1:"0";s:26:"header_section_3_pinterest";s:1:"0";s:24:"header_section_3_youtube";s:1:"0";s:22:"header_section_3_skype";s:1:"0";s:26:"header_section_3_instagram";s:1:"0";s:26:"header_section_3_delicious";s:1:"0";s:23:"header_section_3_reddit";s:1:"0";s:28:"header_section_3_stumbleupon";s:1:"0";s:26:"header_section_3_wordpress";s:1:"0";s:23:"header_section_3_joomla";s:1:"0";s:24:"header_section_3_blogger";s:1:"0";s:22:"header_section_3_vimeo";s:1:"0";s:22:"header_section_3_yahoo";s:1:"0";s:23:"header_section_3_flickr";s:1:"0";s:23:"header_section_3_picasa";s:1:"0";s:27:"header_section_3_deviantart";s:1:"0";s:23:"header_section_3_github";s:1:"0";s:30:"header_section_3_stackoverflow";s:1:"0";s:21:"header_section_3_xing";s:1:"0";s:23:"header_section_3_flattr";s:1:"0";s:27:"header_section_3_foursquare";s:1:"0";s:23:"header_section_3_paypal";s:1:"0";s:21:"header_section_3_yelp";s:1:"0";s:27:"header_section_3_soundcloud";s:1:"0";s:23:"header_section_3_lastfm";s:1:"0";s:23:"header_section_3_lanyrd";s:1:"0";s:25:"header_section_3_dribbble";s:1:"0";s:23:"header_section_3_forrst";s:1:"0";s:22:"header_section_3_steam";s:1:"0";s:24:"header_section_3_behance";s:1:"0";s:21:"header_section_3_mixi";s:1:"0";s:22:"header_section_3_weibo";s:1:"0";s:23:"header_section_3_renren";s:1:"0";s:25:"header_section_3_evernote";s:1:"0";s:24:"header_section_3_dropbox";s:1:"0";s:26:"header_section_3_bitbucket";s:1:"0";s:23:"header_section_3_trello";s:1:"0";s:19:"header_section_3_vk";s:1:"0";s:21:"header_section_3_home";s:1:"0";s:29:"header_section_3_envelope-alt";s:1:"0";s:20:"header_section_3_rss";s:1:"0";}';
        $current_user = wp_get_current_user();
        $rit_prefix  = $wpdb->base_prefix;
        $user_role = serialize( get_option( $rit_prefix."user_roles" ) );
        /*
            END BEFORE
        */
        $wpdb->query("SET GLOBAL max_allowed_packet=10737418240");
        foreach ($lines as $line)
        {
            if (substr($line, 0, 2) == "--" || $line == ""){
                continue;
            }
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';')
            {
                //$templine = str_replace("wp-content/themes/grid/", "wp-content/themes/" . $template . "/", $templine);
                $templine = str_replace("__________YOURSITE__________", $blog_url, $templine);
                $templine = str_replace("__________BLOGNAME__________", $blogname, $templine);
                $templine = str_replace("__________BLOGDESCRIPT__________", $blogdescription, $templine);
                $templine = str_replace("__________ADMINEMAIL__________", $admin_email, $templine);
                $templine = str_replace("__________TEMPLATE__________", $template, $templine);
                $templine = str_replace("__________STYLESHEET__________", $stylesheet, $templine);
                $templine = str_replace("__________ACTIVE_PLUGIN__________", $current_active_plugin, $templine);
                //$templine = str_replace("___________THEMEMOD__________", $current_theme_mod, $templine);
                $templine = str_replace("___________PREFIX__________", "`" . $rit_prefix, $templine);
                $templine = str_replace("__________USER_ROLE__________", $user_role , $templine);
                $templine = str_replace("__________ROLE_PREFIX__________", $rit_prefix , $templine);

                $wpdb->query($templine);$templine = '';}}
    }else{
        esc_html_e( "Data Dump Not Found!!!" , 'k2t');
    }
}
add_action('wp_ajax_rit_import_data', 'rit_import_data');
add_action( 'wp_ajax_nopriv_rit_import_data', 'rit_import_data' );

function rit_import_data() {
    $wp_upload_dir = wp_upload_dir();
    // Load Importer API
    require_once ABSPATH . 'wp-admin/includes/import.php';
    $importerError = false;
    $demo_data_installed = get_option('demo_data_installed');

    if($demo_data_installed == 'yes') die();

    if ( !defined( 'WP_LOAD_IMPORTERS' ) ) define( 'WP_LOAD_IMPORTERS', true ); // we are loading importers
    //check if wp_importer, the base importer class is available, otherwise include it
    if ( !class_exists( 'WP_Importer' ) ) {
        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        if ( file_exists( $class_wp_importer ) )
            require_once($class_wp_importer);
        else
            $importerError = true;
    }
    //check if wp_importer, the base importer class is available, otherwise include it
    if ( !class_exists( 'WP_Import' ) ) {
        $WP_Import =  get_template_directory() . '/framework/k2timporter/wordpress-importer.php';
        if ( file_exists( $WP_Import ) )
            require_once($WP_Import);
        else
            $importerError = true;
    }
    if($importerError !== false) {
        esc_html_e( "The Auto importing script could not be loaded. Please use the wordpress importer and import the XML file that is located in your themes folder manually.", 'k2t' );
    } else {

        if(class_exists('WP_Importer')){
            try{

                //End Import Widget
                // Import Theme Options
                $versionsUrl =  '/rit_core_data';
                $folder = $versionsUrl;
                $options = $folder.'/options.txt';
                $file_headers = @get_headers($options);

                if($file_headers[0] == 'HTTP/1.1 200 OK') {
                    $tmpZip = $wp_upload_dir["basedir"] . '/rit_core_data/options.txt';
                    file_put_contents($tmpZip, file_get_contents($options));
                    $data = unserialize(base64_decode(file_get_contents($tmpZip)));
                    of_save_options($data);
                }else{
                    esc_html_e( "Import Theme Options False", 'k2t' );
                }
                if ( class_exists( 'Woocommerce' ) ) {

                    // Set pages
                    $woopages = array(
                        'woocommerce_shop_page_id' => 'Shop',
                        'woocommerce_cart_page_id' => 'Cart',
                        'woocommerce_checkout_page_id' => 'Checkout',
                        'woocommerce_pay_page_id' => 'Checkout &#8594; Pay',
                        'woocommerce_thanks_page_id' => 'Order Received',
                        'woocommerce_myaccount_page_id' => 'My Account',
                        'woocommerce_edit_address_page_id' => 'Edit My Address',
                        'woocommerce_view_order_page_id' => 'View Order',
                        'woocommerce_change_password_page_id' => 'Change Password',
                        'woocommerce_logout_page_id' => 'Logout',
                        'woocommerce_lost_password_page_id' => 'Lost Password'
                    );
                    if ( $woopages )
                        foreach ( $woopages as $woo_page_name => $woo_page_title ) {
                            $woopage = get_page_by_title( $woo_page_title );
                            if ( $woopage->ID ) {
                                update_option( $woo_page_name, $woopage->ID ); // Front Page
                            }
                        }
                    // We no longer need to install pages
                    delete_option( '_wc_needs_pages' );
                    delete_transient( '_wc_activation_redirect' );

                    // Flush rules after install
                    flush_rewrite_rules();
                }
                rit_update_options();

                // Import Simple Data
                die('Success!');
            } catch (Exception $e) {
                esc_html_e( "Error while importing", 'k2t' );
            }
        }
    }
    die();
}


add_action('wp_ajax_rit_install_version', 'rit_install_version');
add_action('wp_ajax_nopriv_rit_install_version', 'rit_install_version');

function rit_install_version() {
    // Load Importer API
    require_once ABSPATH . 'wp-admin/includes/import.php';
    $importerError = false;
    $demo_data_installed = get_option('demo_data_installed');

    if($demo_data_installed == 'yes') die();

    if ( !defined( 'WP_LOAD_IMPORTERS' ) ) define( 'WP_LOAD_IMPORTERS', true ); // we are loading importers

    //check if wp_importer, the base importer class is available, otherwise include it
    if ( !class_exists( 'WP_Importer' ) ) {
        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        if ( file_exists( $class_wp_importer ) )
            require_once($class_wp_importer);
        else
            $importerError = true;
    }
    //check if wp_importer, the base importer class is available, otherwise include it
    if ( !class_exists( 'WP_Import' ) ) {
        $WP_Import =  get_template_directory() . '/framework/k2timporter/wordpress-importer.php';
        if ( file_exists( $WP_Import ) )
            require_once($WP_Import);
        else
            $importerError = true;
    }

    if($importerError !== false) {
        esc_html_e( "The Auto importing script could not be loaded. Please use the wordpress importer and import the XML file that is located in your themes folder manually.", 'k2t' );
    } else {

        //do_action('et_before_data_import');
        $wp_upload_dir = wp_upload_dir();
        $versionsUrl =  '/rit_core_data';
        $type = $_POST["type_name"];
        $ver = $_POST["ver"];
        $folder = $versionsUrl . "/" . $type . "/" . $ver;
        if(class_exists('WP_Importer')){
            try{
                // Import Theme Options
                $options = $folder.'/'.$ver.'_options.txt';
                $file_headers = @get_headers($options);

                if($file_headers[0] == 'HTTP/1.1 200 OK') {
                    $tmpZip = $wp_upload_dir["basedir"] . '/rit_core_data/options.txt';
                    file_put_contents($tmpZip, file_get_contents($options));
                    $data = unserialize(base64_decode(file_get_contents($tmpZip)));
                    of_save_options($data);
                }else{
                    esc_html_e( "Import Theme Options False", 'k2t' );
                }

                //End Import Theme Options



                if ( class_exists( 'Woocommerce' ) ) {

                    // Set pages
                    $woopages = array(
                        'woocommerce_shop_page_id' => 'Shop',
                        'woocommerce_cart_page_id' => 'Cart',
                        'woocommerce_checkout_page_id' => 'Checkout',
                        'woocommerce_pay_page_id' => 'Checkout &#8594; Pay',
                        'woocommerce_thanks_page_id' => 'Order Received',
                        'woocommerce_myaccount_page_id' => 'My Account',
                        'woocommerce_edit_address_page_id' => 'Edit My Address',
                        'woocommerce_view_order_page_id' => 'View Order',
                        'woocommerce_change_password_page_id' => 'Change Password',
                        'woocommerce_logout_page_id' => 'Logout',
                        'woocommerce_lost_password_page_id' => 'Lost Password'
                    );
                    if ( $woopages )
                        foreach ( $woopages as $woo_page_name => $woo_page_title ) {
                            $woopage = get_page_by_title( $woo_page_title );
                            if ( $woopage->ID ) {
                                update_option( $woo_page_name, $woopage->ID ); // Front Page
                            }
                        }

                    // We no longer need to install pages
                    delete_option( '_wc_needs_pages' );
                    delete_transient( '_wc_activation_redirect' );

                    // Flush rules after install
                    flush_rewrite_rules();
                }
                /* Update Theme Options */
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $_POST["home_id"]);
                update_option( 'page_for_posts', $_POST["home_id"] );

                //End Import Widget

                die('Success!');
            } catch (Exception $e) {
                esc_html_e( "Error while importing", 'k2t' );
            }
        }
    }
    die();
}

function rit_update_options() {
    global $options_presets;
    /* Change To Home Page Name*/
    /* Change To Blog Page Name*/
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', '5' );
}

function rit_update_menus(){}
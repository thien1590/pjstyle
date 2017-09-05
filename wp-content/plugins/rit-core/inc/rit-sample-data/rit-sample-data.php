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
 
define('RIT_CORE_SAMPLE_DATA_PATH', RIT_PLUGIN_PATH .'/inc/rit-sample-data/');
define('RIT_CORE_SAMPLE_DATA_URL', RIT_PLUGIN_URL .'/inc/rit-sample-data/');

define('RIT_SAMPLE_DATA_PATH', get_template_directory() .'/rit-core/sample-data/');
define('RIT_SAMPLE_DATA_URL', get_template_directory_uri() .'/rit-core/sample-data/');


//include  RIT_CORE_SAMPLE_DATA_PATH . 'plugin.php';
include  RIT_CORE_SAMPLE_DATA_PATH . 'export.php';
include  RIT_CORE_SAMPLE_DATA_PATH . 'import.php';




add_action( 'admin_menu', 'rit_import_sample_data_menu' );

if(!function_exists('rit_import_sample_data_menu')){
    function rit_import_sample_data_menu() {
        add_management_page( esc_html__('RIT Import Sample Data', RIT_TEXT_DOMAIN), esc_html__('RIT Import Sample Data', RIT_TEXT_DOMAIN), 'manage_options', 'rit_import_sample_data', 'rit_import_sample_data' );
    }
}

if(!function_exists('rit_import_sample_data')){
    function rit_import_sample_data() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.', RIT_TEXT_DOMAIN) );
        }
        ?>

        <div class="wrap">
            <h1><?php echo esc_html__( 'RIT Import Sample Data', RIT_TEXT_DOMAIN  ); ?></h1>
            <div class="rit-oneclick-install">
                <div class="rit-oneclick-install-overlay">
                    <div class="rit-overlay-icon">
                        <i class="dashicons-before dashicons-wordpress-alt"></i>
                        <span><?php echo esc_html(__('Please wait a moment', RIT_TEXT_DOMAIN)); ?></span>
                    </div>
                </div>
                <div class="rit-base-install">
                    <h2><?php echo esc_html(__('Install demo content just in few clicks', RIT_TEXT_DOMAIN)); ?></h2>
                    <input type="button" class="rit-install-base" value="<?php echo esc_html__('Install Base Demo Content', RIT_TEXT_DOMAIN ); ?>">
                </div>

                <?php

                    if( file_exists( RIT_SAMPLE_DATA_PATH . 'list.json' )){

                        $versions = json_decode( file_get_contents( RIT_SAMPLE_DATA_PATH . 'list.json' ), true );

                        if(count($versions) > 0){

                            ?>

                            <div class="rit-verison-type">
                                <h2><?php echo esc_html(__('Set up one of our theme versions', RIT_TEXT_DOMAIN)); ?></h2>
                                <ul>
                                    <li class="active" data-filter="*"><?php echo esc_html__('All', RIT_TEXT_DOMAIN)?></li>
                                    <?php
                                        $type = array();

                                        foreach ($versions as $version) {
                                            $type = array_merge($type, $version['type']);
                                        }

                                        $type = array_unique($type);

                                        foreach ($type as $value_type) {
                                            ?>
                                                <li data-filter=".<?php echo esc_attr( $value_type); ?>" data-type="<?php echo esc_attr( $value_type); ?>">
                                                    <?php echo esc_html__( ucfirst( implode(' ', explode('-', $value_type)) ), RIT_TEXT_DOMAIN)?>
                                                </li>
                                            <?php
                                            
                                        }
                                    ?>
                                </ul>
                            </div>

                            <div class="rit-versions">
                            <?php

                            foreach ($versions as $key => $version) {
                                ?>
                                    <div class="rit-version-item <?php echo esc_attr( implode(' ', $version['type'])); ?>">
                                        <img class="screenshot" src="<?php echo esc_url( RIT_SAMPLE_DATA_URL . $version['path'] . '/screen.jpg' ); ?>" />
                                        <h3><?php echo esc_html( $version['name'] ); ?></h3>
                                        <span><?php echo esc_html( $version['des'] ); ?></span>
                                        <input type="button" data-version_path="<?php echo esc_attr( $version['path'] ); ?>" class="rit-install-verison" value="<?php echo esc_html__('Install', RIT_TEXT_DOMAIN ); ?>">
                                    </div>
                                <?php
                            }
                            ?>
                            </div>
                            <?php
                        }
                    }
                ?>
                </div>
            
        </div>
    <?php
    }
}


add_action( 'admin_menu', 'rit_export_sample_data_menu' );

if(!function_exists('rit_export_sample_data_menu')){
    function rit_export_sample_data_menu() {
        add_management_page( esc_html__('RIT Export Sample Data', RIT_TEXT_DOMAIN), esc_html__('RIT Export Sample Data', RIT_TEXT_DOMAIN), 'manage_options', 'rit_export_sample_data', 'rit_export_sample_data' );
    }
}

if(!function_exists('rit_export_sample_data')){
    function rit_export_sample_data() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.', RIT_TEXT_DOMAIN) );
        }
        ?>
        

        <script type="text/javascript">
            jQuery(document).ready(function($){
                var form = $('#export-filters'),
                    filters = form.find('.export-filters');
                filters.hide();
                form.find('input:radio').change(function() {
                    filters.slideUp('fast');
                    switch ( $(this).val() ) {
                        case 'posts': $('#post-filters').slideDown(); break;
                        case 'pages': $('#page-filters').slideDown(); break;
                    }
                });
            });
        </script>
        
        <?php


        

        global $wpdb, $wp_locale;

        ?>

        <div class="wrap">
        <h1><?php echo esc_html__( 'RIT Export Sample Data', RIT_TEXT_DOMAIN  ); ?></h1>

        <p><?php _e('RIT Export sample data will replace all image with a placeholder image. Please put placeholder image to rit-core directory wp-content/theme/{theme_name}/rit-core/placeholder.png', RIT_TEXT_DOMAIN ); ?></p>

        <h3><?php _e( 'Choose what to export' ); ?></h3>
        <form method="get" id="export-filters">
        <input type="hidden" name="download" value="true" />
        <input type="hidden" name="page" value="rit_export_sample_data" />
        
        <p><label><input type="radio" name="content" value="all" checked="checked" /> <?php _e( 'All content', RIT_TEXT_DOMAIN  ); ?></label></p>
        <p class="description"><?php _e( 'This will contain all of your posts, pages, comments, custom fields, terms, navigation menus and custom posts.' , RIT_TEXT_DOMAIN ); ?></p>

        <p><label><input type="radio" name="content" value="posts" /> <?php _e( 'Posts', RIT_TEXT_DOMAIN ); ?></label></p>
        <ul id="post-filters" class="export-filters">
            <li>
                <label><?php _e( 'Categories:' ); ?></label>
                <?php wp_dropdown_categories( array( 'show_option_all' => __('All', RIT_TEXT_DOMAIN ) ) ); ?>
            </li>
            <li>
                <label><?php _e( 'Authors:' ); ?></label>
        <?php
                $authors = $wpdb->get_col( "SELECT DISTINCT post_author FROM {$wpdb->posts} WHERE post_type = 'post'" );
                wp_dropdown_users( array( 'include' => $authors, 'name' => 'post_author', 'multi' => true, 'show_option_all' => __('All') ) );
        ?>
            </li>
            <li>
                <label><?php _e( 'Date range:' ); ?></label>
                <select name="post_start_date">
                    <option value="0"><?php _e( 'Start Date', RIT_TEXT_DOMAIN  ); ?></option>
                    <?php export_date_options(); ?>
                </select>
                <select name="post_end_date">
                    <option value="0"><?php _e( 'End Date', RIT_TEXT_DOMAIN  ); ?></option>
                    <?php export_date_options(); ?>
                </select>
            </li>
            <li>
                <label><?php _e( 'Status:' ); ?></label>
                <select name="post_status">
                    <option value="0"><?php _e( 'All', RIT_TEXT_DOMAIN  ); ?></option>
                    <?php $post_stati = get_post_stati( array( 'internal' => false ), 'objects' );
                    foreach ( $post_stati as $status ) : ?>
                    <option value="<?php echo esc_attr( $status->name ); ?>"><?php echo esc_html( $status->label ); ?></option>
                    <?php endforeach; ?>
                </select>
            </li>
        </ul>

        <p><label><input type="radio" name="content" value="pages" /> <?php _e( 'Pages', RIT_TEXT_DOMAIN  ); ?></label></p>
        <ul id="page-filters" class="export-filters">
            <li>
                <label><?php _e( 'Authors:' , RIT_TEXT_DOMAIN ); ?></label>
        <?php
                $authors = $wpdb->get_col( "SELECT DISTINCT post_author FROM {$wpdb->posts} WHERE post_type = 'page'" );
                wp_dropdown_users( array( 'include' => $authors, 'name' => 'page_author', 'multi' => true, 'show_option_all' => __('All') ) );
        ?>
            </li>
            <li>
                <label><?php _e( 'Date range:', RIT_TEXT_DOMAIN  ); ?></label>
                <select name="page_start_date">
                    <option value="0"><?php _e( 'Start Date', RIT_TEXT_DOMAIN ); ?></option>
                    <?php export_date_options( 'page' ); ?>
                </select>
                <select name="page_end_date">
                    <option value="0"><?php _e( 'End Date', RIT_TEXT_DOMAIN  ); ?></option>
                    <?php export_date_options( 'page' ); ?>
                </select>
            </li>
            <li>
                <label><?php _e( 'Status:', RIT_TEXT_DOMAIN  ); ?></label>
                <select name="page_status">
                    <option value="0"><?php _e( 'All', RIT_TEXT_DOMAIN  ); ?></option>
                    <?php foreach ( $post_stati as $status ) : ?>
                    <option value="<?php echo esc_attr( $status->name ); ?>"><?php echo esc_html( $status->label ); ?></option>
                    <?php endforeach; ?>
                </select>
            </li>
        </ul>

        <?php foreach ( get_post_types( array( '_builtin' => false, 'can_export' => true ), 'objects' ) as $post_type ) : ?>
        <p><label><input type="radio" name="content" value="<?php echo esc_attr( $post_type->name ); ?>" /> <?php echo esc_html( $post_type->label ); ?></label></p>
        <?php endforeach; ?>

        <?php
        /**
         * Fires after the export filters form.
         *
         * @since 3.5.0
         */
        //do_action( 'export_filters' );
        ?>

        <?php submit_button( __('Download Export File', RIT_TEXT_DOMAIN) ); ?>
        </form>
        </div>
        <script type="text/javascript">
            jQuery.download = function(url, data, method){
                //url and data options required
                if( url && data ){
                    //data can be string of parameters or array/object
                    data = typeof data == 'string' ? data : jQuery.param(data);
                    //split params into form inputs
                    var inputs = '';
                    jQuery.each(data.split('&'), function(){
                        var pair = this.split('=');
                        inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />';
                    });
                    //send request
                    jQuery('<form action="'+ url +'" method="'+ (method||'GET') +'">'+inputs+'</form>')
                    .appendTo('body').submit().remove();
                };
            };

            jQuery(document).ready(function($){

                $('input[name="submit"]').on('click', function(e){
                    e.preventDefault();

                    var data = '';
                    var $inputs = $( 'form input:checked, form select' );

                    $inputs.each(function() {
                        data += '&'+$(this).attr('name')+'='+$(this).val();
                    });
                   
                    $.download( RITScript.ajax_url, '&action=rit_ajax_export_sample_data&download=true&page=rit_export_sample_data'+ data);

                
                });
            });
        </script>
    <?php
    }
}


add_action( 'admin_init', 'rit_sample_data_script');

if(!function_exists('rit_sample_data_script')){
    function rit_sample_data_script(){
        
        wp_enqueue_script('rit-sample-data-script', RIT_CORE_SAMPLE_DATA_URL . 'assets/js/rit-sample-data.js');
        wp_enqueue_script('rit-isotope-script', RIT_CORE_SAMPLE_DATA_URL . 'assets/js/isotope.pkgd.min.js');
        wp_enqueue_style('rit-sample-data-style', RIT_CORE_SAMPLE_DATA_URL . 'assets/css/rit-sample-data.css');

        $translation_array = array(
            'home_url' => esc_url( home_url( '/' ) ),
            'ajax_url' => wp_nonce_url(admin_url('admin-ajax.php')),
            'admin_theme_url' => wp_nonce_url(admin_url('themes.php'))
        );
        wp_localize_script( 'rit-sample-data-script', 'RITScript', $translation_array );

    }    
}

if(!function_exists('update_theme_option')){
    function update_theme_option($rit_path){
        
        $page_id = 0;
        if(file_exists( RIT_SAMPLE_DATA_PATH . $rit_path . '/content.xml' )){
            if($rit_path != 'basic-demo'){
                $data = simplexml_load_string(trim(file_get_contents( RIT_SAMPLE_DATA_PATH . $rit_path . '/content.xml' )));
                
                if(isset($data->channel->item->guid)){
                    $page_id_element = explode('page_id=', $data->channel->item->guid);
                    if(isset($page_id_element[1])){
                        $page_id = $page_id_element[1];
                    }
                }

            }
        }

        if($page_id > 0){
            // setting > reading area
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $page_id );
            update_option( 'page_for_posts', 0 );
        }
        
        
        // menu to themes location
        $nav_id = 0;
        $navs = get_terms('nav_menu', array( 'hide_empty' => true ));

        foreach( $navs as $nav ){
            if($nav->slug == 'main-menu'){
                $nav_id = $nav->term_id; break;
            }
        }

        if($nav_id > 0){
            set_theme_mod('nav_menu_locations', array('main_menu' => $nav_id, 'primary' => $nav_id ));
        } 
    }
}


add_action('wp_ajax_rit_install_sample_data', 'rit_install_sample_data');
add_action('wp_ajax_nopriv_rit_install_sample_data', 'rit_install_sample_data');

if( !function_exists('rit_install_sample_data') ){

    function rit_install_sample_data(){


        if(file_exists( RIT_SAMPLE_DATA_PATH . $_POST['rit_path'] . '/content.xml' )){

            rit_import_data( RIT_SAMPLE_DATA_PATH . $_POST['rit_path'] . '/content.xml' );

            update_theme_option($_POST['rit_path']);
        }

        if(file_exists( RIT_SAMPLE_DATA_PATH . $_POST['rit_path'] . '/customizer.dat' )){
            rit_import_customizer(RIT_SAMPLE_DATA_PATH . $_POST['rit_path'] . '/customizer.dat');        
        }

        if(file_exists( RIT_SAMPLE_DATA_PATH . $_POST['rit_path'] . '/widgets.wie' )){
            rit_import_widget(RIT_SAMPLE_DATA_PATH . $_POST['rit_path'] . '/widgets.wie');        
        }

        if(is_dir( RIT_SAMPLE_DATA_PATH . $_POST['rit_path'])){

            if( count( glob( RIT_SAMPLE_DATA_PATH . $_POST['rit_path'] . "/slider*.zip") ) ){
                foreach( glob( RIT_SAMPLE_DATA_PATH . $_POST['rit_path'] . "/slider*.zip") as $slider){
                    if(file_exists($slider)){
                        rit_import_slider($slider);
                    }
                } 
            }       
        }

        if(file_exists( RIT_SAMPLE_DATA_PATH . $_POST['rit_path'] . '/megamenu.json' )){
            rit_import_megamenu( RIT_SAMPLE_DATA_PATH . $_POST['rit_path'] . '/megamenu.json' );        
        }
    }
}

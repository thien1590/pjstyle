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

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

if (!class_exists('RIT_Plugin')) {
    class RIT_Plugin
    {
        public $plugins = array();

        public $config = array();

        public $activate_nonce;

        public $install_nonce;

        public function __construct()
        {
            //$this->activate_nonce = wp_create_nonce('tgmpa-activate');

            //$this->install_nonce = wp_create_nonce('tgmpa-install');

            $this->init();
        }


        public function my_theme_register_required_plugins() {

            $this->plugins = array(

                array(
                    'name'               => 'Rit Core Plugin', // The plugin name.
                    'slug'               => 'rit-core-plugin', // The plugin slug (typically the folder name).
                    'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
                    'file'               => 'rit-core.php',
                    'install_nonce'      => $this->install_nonce,
                    'activate_nonce'     => $this->activate_nonce,

                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                    'external_url'       => '', // If set, overrides default API URL and points to an external URL.
                    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
                ),
                array(
                    'name'               => 'Visual composer',
                    'slug'               => 'js_composer',
                    'source'             => RIT_SAMPLE_DATA_PATH . 'plugins/js_composer.zip',
                    'required'           => true,
                    'file'               => 'js_composer.php',
                    'redirect'           => true,
                    'install_nonce'      => $this->install_nonce,
                    'activate_nonce'     => $this->activate_nonce,
                ),
                array(
                    'name'               => 'WooCommerce',
                    'slug'               => 'woocommerce',
                    'required'           => false,
                    'file'               => 'woocommerce.php',
                    'source'             => '',
                    'redirect'           => true,
                    'install_nonce'      => $this->install_nonce,
                    'activate_nonce'     => $this->activate_nonce,
                ),
                array(
                    'name'               => 'Contact Form 7',
                    'slug'               => 'contact-form-7',
                    'required'           => false,
                    'file'               => 'wp-contact-form-7.php',
                    'source'             => '',
                    'install_nonce'      => $this->install_nonce,
                    'activate_nonce'     => $this->activate_nonce,
                ),
                array(
                    'name'               => 'Instagram Feed',
                    'slug'               => 'instagram-feed',
                    'required'           => false,
                    'file'               => 'instagram-feed.php',
                    'source'             => '',
                    'install_nonce'      => $this->install_nonce,
                    'activate_nonce'     => $this->activate_nonce,
                ),
                array(
                    'name'               => 'YITH WooCommerce Wishlist',
                    'slug'               => 'yith-woocommerce-wishlist',
                    'required'           => false,
                    'file'               => 'init.php',
                    'source'             => '',
                    'install_nonce'      => $this->install_nonce,
                    'activate_nonce'     => $this->activate_nonce,
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
            $this->config = array(
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
                    'page_title'                      => __( 'Install Required Plugins', 'theme-slug' ),
                    'menu_title'                      => __( 'Install Plugins', 'theme-slug' ),
                    'installing'                      => __( 'Installing Plugin: %s', 'theme-slug' ), // %s = plugin name.
                    'oops'                            => __( 'Something went wrong with the plugin API.', 'theme-slug' ),
                    'notice_can_install_required'     => _n_noop(
                        'This theme requires the following plugin: %1$s.',
                        'This theme requires the following plugins: %1$s.',
                        'theme-slug'
                    ), // %1$s = plugin name(s).
                    'notice_can_install_recommended'  => _n_noop(
                        'This theme recommends the following plugin: %1$s.',
                        'This theme recommends the following plugins: %1$s.',
                        'theme-slug'
                    ), // %1$s = plugin name(s).
                    'notice_cannot_install'           => _n_noop(
                        'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
                        'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
                        'theme-slug'
                    ), // %1$s = plugin name(s).
                    'notice_ask_to_update'            => _n_noop(
                        'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                        'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                        'theme-slug'
                    ), // %1$s = plugin name(s).
                    'notice_ask_to_update_maybe'      => _n_noop(
                        'There is an update available for: %1$s.',
                        'There are updates available for the following plugins: %1$s.',
                        'theme-slug'
                    ), // %1$s = plugin name(s).
                    'notice_cannot_update'            => _n_noop(
                        'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
                        'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
                        'theme-slug'
                    ), // %1$s = plugin name(s).
                    'notice_can_activate_required'    => _n_noop(
                        'The following required plugin is currently inactive: %1$s.',
                        'The following required plugins are currently inactive: %1$s.',
                        'theme-slug'
                    ), // %1$s = plugin name(s).
                    'notice_can_activate_recommended' => _n_noop(
                        'The following recommended plugin is currently inactive: %1$s.',
                        'The following recommended plugins are currently inactive: %1$s.',
                        'theme-slug'
                    ), // %1$s = plugin name(s).
                    'notice_cannot_activate'          => _n_noop(
                        'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
                        'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
                        'theme-slug'
                    ), // %1$s = plugin name(s).
                    'install_link'                    => _n_noop(
                        'Begin installing plugin',
                        'Begin installing plugins',
                        'theme-slug'
                    ),
                    'update_link' 					  => _n_noop(
                        'Begin updating plugin',
                        'Begin updating plugins',
                        'theme-slug'
                    ),
                    'activate_link'                   => _n_noop(
                        'Begin activating plugin',
                        'Begin activating plugins',
                        'theme-slug'
                    ),
                    'return'                          => __( 'Return to Required Plugins Installer', 'theme-slug' ),
                    'plugin_activated'                => __( 'Plugin activated successfully.', 'theme-slug' ),
                    'activated_successfully'          => __( 'The following plugin was activated successfully:', 'theme-slug' ),
                    'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'theme-slug' ),  // %1$s = plugin name(s).
                    'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'theme-slug' ),  // %1$s = plugin name(s).
                    'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'theme-slug' ), // %s = dashboard link.
                    'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'tgmpa' ),

                    'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
                )
            );

            tgmpa( $this->plugins, $this->config );

        }

        public function init(){
            add_action('wp_ajax_rit_get_plugin_inactive', array($this, 'rit_get_plugin_inactive'));
            add_action('wp_ajax_nopriv_rit_get_plugin_inactive', array($this, 'rit_get_plugin_inactive' ));

            /**
             * Include the TGM_Plugin_Activation class.
             */
            add_action( 'tgmpa_register',  array($this, 'my_theme_register_required_plugins' ));
        }

        

        public function rit_get_plugin_inactive()
        {
            $inactive_plugins = array();

            foreach ($this->plugins as $plugin) {
                if(!function_exists('is_plugin_active')){
                    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                }

                if (!is_plugin_active($plugin["slug"] . '/' . $plugin["file"])) {


                    $inactive_plugins[] = $plugin;
                }
            }
            echo json_encode($inactive_plugins);
            die();
        }
    }
}

new RIT_Plugin();




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

if ( ! defined( 'RIT_VERSION' ) ){
    define('RIT_VERSION', '2.0');
}
if ( ! defined( 'RIT_PLUGIN_PATH' ) ){
    define('RIT_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
}
if ( ! defined( 'RIT_PLUGIN_URL' ) ){
    define('RIT_PLUGIN_URL', plugins_url( '/', __FILE__ ));
}
if ( ! defined( 'RIT_DIRECTORY_NAME' ) ){
    $plugin_path = explode('/', str_replace('\\', '/', RIT_PLUGIN_PATH));
    define('RIT_DIRECTORY_NAME', $plugin_path[count($plugin_path) - 2 ]);
}
if ( ! defined( 'RIT_TEXT_DOMAIN' ) ){
    define('RIT_TEXT_DOMAIN', 'rit-language');
}


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

require_once( ABSPATH . WPINC . '/class-wp-customize-control.php' );
require_once('classes/customize-googlefont.php');
require_once('classes/customize-category.php');
require_once('classes/customize-multi.php');
require_once('classes/customize-sidebar.php');
require_once('classes/customize-import-export.php');

require_once('includes/customize-import-export.php');
require_once('includes/customize-controller.php');
require_once('includes/customize-reset.php');

$rit_customize = RIT_Customize::getInstance();
$rit_customize->init();


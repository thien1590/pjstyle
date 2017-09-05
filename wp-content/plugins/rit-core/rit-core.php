<?php
/**
* Plugin Name: RiverTheme Core
* Plugin URI: http://www.zootemplate.com/
* Description: This is not just a plugin, it is a package with many tools a website needed.
* Author: Zootemplate
* Version: 2.0.2
* Author URI: http://www.zootemplate.com/
*
* Text Domain: rit-core
*/

//Define global variable
require_once('rit-config.php');

require_once('inc/helpers/rit.php');
require_once('inc/helpers/vc.php');
require_once('inc/helpers/wc.php');

//Theme customize
require_once('inc/customize/customize.php');

// Widget
require_once('inc/widgets/widget-recent-post.php');
require_once('inc/widgets/widget-dribbble.php');
require_once('inc/widgets/widget-facebook.php');
require_once('inc/widgets/widget-flickr.php');
require_once('inc/widgets/widget-social-icons.php');
require_once('inc/widgets/widget-testimonial.php');
require_once('inc/widgets/widget-twitter.php');
require_once('inc/widgets/widget-tab.php');

// Meta Box
require_once('inc/meta-boxes/meta-boxes.php');

// Post format
require_once('inc/post-format/post-format.php');

//Custom post type
require_once 'inc/post-types/portfolio.php';
require_once 'inc/post-types/banner.php';
require_once 'inc/post-types/testimonial.php';
require_once 'inc/post-types/cause.php';

//Shortcode
require_once('inc/shortcode/product.php');
require_once('inc/shortcode/product-deal.php');
require_once('inc/shortcode/portfolio.php');
require_once('inc/shortcode/news.php');
require_once('inc/shortcode/blog.php');
require_once('inc/shortcode/recent-post.php');
require_once('inc/shortcode/banner-slider.php');
require_once('inc/shortcode/image-hover.php');
require_once('inc/shortcode/images-gallery.php');
require_once('inc/shortcode/testimonial.php');
require_once('inc/shortcode/social-share.php');
require_once('inc/shortcode/demo-box.php');

//Sample data
require_once('inc/rit-sample-data/rit-sample-data.php');

//Social counter
require_once('inc/social-counter/social-counter.php');

//Custom Menu
require_once('inc/menu/menu.php');
?>
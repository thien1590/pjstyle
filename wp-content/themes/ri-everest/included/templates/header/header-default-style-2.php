<?php
// Header Default Style 2
if(is_single()||is_page()){
    if (get_post_meta(get_the_ID(), 'rit_header_options', true) == 'use-default' || get_post_meta(get_the_ID(), 'rit_header_options', true) == '') {
        get_theme_mod('rit_enable_sticky_header') ? $enable_sticky = true : $enable_sticky = false;
        //get_theme_mod('rit_enable_main_widget') ? $enable_main_wd = true : $enable_main_wd = false;
    } else {
        get_post_meta(get_the_ID(), 'rit_enable_sticky_header', true) ? $enable_sticky = true : $enable_sticky = false;
        //get_post_meta(get_the_ID(), 'rit_enable_main_widget', true) ? $enable_main_wd = true : $enable_main_wd = false;
    }
}
else{
    get_theme_mod('rit_enable_sticky_header') ? $enable_sticky = true : $enable_sticky = false;
    //get_theme_mod('rit_enable_main_widget') ? $enable_main_wd = true : $enable_main_wd = false;
}

?>

<header id="header-page" class="header-default header-default-style-2">
    <?php if(is_active_sidebar('top-left-header')||is_active_sidebar('top-header')):?>
    <div id="top-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 top-header-left">
                    <?php dynamic_sidebar('top-left-header') ?>
                </div>
                <div class="col-xs-12 col-sm-6 top-header-right">
                    <?php dynamic_sidebar('top-header') ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <div id="rit-main-header">
        <div class="container">
            <div class="row">
                <div id="rit-logo" class="col-xs-12 col-sm-4">
                    <?php get_template_part('included/templates/logo'); ?>
                </div>
                <div id="top-search" class=" <?php echo esc_attr(class_exists('WooCommerce')?'col-xs-10 col-sm-5 col-md-6':'col-xs-12 col-sm-8')?> ">
                    <?php get_template_part('included/templates/search');?>
                </div>
                <?php if (class_exists('WooCommerce')) {?>
                    <div class="col-xs-2 col-sm-3 col-md-2  right-main-header">
                        <?php  get_template_part('included/templates/topheadcart');?>
                    </div>
                    <?php
                } ?>
            </div>
        </div>
    </div>
    <div id="rit-bottom-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 sec-nav-block everest-stick-nav">
                    <div class="wrapp-sec-nav">
                        <?php
                        $menu_obj = ri_everest_get_menu_by_location('second');
                        if($menu_obj!=null) {
                            echo "<h3><span class='table-icon'><i></i><i></i></span> " . esc_html($menu_obj->name) . "</h3>";
                            wp_nav_menu(array('theme_location' => 'second', 'container' => false, 'menu_class' => 'sec-nav-menu', 'menu_id' => 'second-menu'));
                        }?>
                    </div>
                </div>
                <nav id="primary-nav" class="col-sm-6 col-xs-3 primary-nav-block">
                    <div class="mobile-nav"><span></span></div>
                    <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu')); ?>
                </nav>
                <div class="col-xs-9 col-sm-3 right-bottom-header">
                    <?php dynamic_sidebar('main-header') ?>
                </div>
            </div>
        </div>
    </div>
    <?php if($enable_sticky){?>
        <script>
            (function ($) {
                "use strict";
                $(document).ready(function () {
                    $("#rit-bottom-header").sticky();
                })
            })(jQuery)
        </script>
    <?php }?>
</header>

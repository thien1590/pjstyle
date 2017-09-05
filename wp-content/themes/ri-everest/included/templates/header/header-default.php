<?php
if(is_single()||is_page()){
    if (get_post_meta(get_the_ID(), 'rit_header_options', true) == 'use-default' || get_post_meta(get_the_ID(), 'rit_header_options', true) == '') {
        get_theme_mod('rit_enable_sticky_header') ? $enable_sticky = true : $enable_sticky = false;
    } else {
        get_post_meta(get_the_ID(), 'rit_enable_sticky_header', true) ? $enable_sticky = true : $enable_sticky = false;
    }
}
else{
    get_theme_mod('rit_enable_sticky_header') ? $enable_sticky = true : $enable_sticky = false;
}
?>
<header id="header-page" class="header-default">
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
                <div class="wrap-mobile-nav">
                <div class="mobile-nav"><span></span></div>
                </div>
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
                <nav id="primary-nav" class="col-sm-12 col-xs-3 primary-nav-block">
                    <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu')); ?>
                </nav>
                <div class="right-bottom-header">
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
                    $(window).resize(function () {
                        if($(window).width()>769){
                            if($('#rit-main-header-sticky-wrapper')[0]){
                                $("#rit-main-header").unstick();
                            }
                            if(!$('#rit-bottom-header-sticky-wrapper')[0]){
                                $("#rit-bottom-header").sticky();
                            }
                        }else{
                            if($('#rit-bottom-header-sticky-wrapper')[0]){
                                $("#rit-bottom-header").unstick();
                            }
                            if(!$('#rit-main-header-sticky-wrapper')[0]){
                                $('#rit-main-header').sticky();
                            }
                        }
                    }).resize();
                })
            })(jQuery)
        </script>
    <?php }?>
</header>

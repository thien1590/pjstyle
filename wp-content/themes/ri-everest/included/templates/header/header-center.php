<?php
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
<header id="header-page" class="header-center">
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
                <div id="rit-search-block" class="col-xs-12 col-sm-4">
                    <form role="search" method="get" id="top-searchform" action="<?php echo home_url(); ?>">
                        <input type="text"
                               value="<?php echo esc_attr(apply_filters('the_search_query', get_search_query())); ?>"
                               placeholder="<?php echo esc_html__('Search...', 'ri-everest') ?>" class="ipt text"
                               name="s" id="s"/>

                        <i class="clever-icon-search-4"> </i>
                    </form></div>
                <div id="rit-logo" class="col-xs-12 col-sm-4">
                    <?php get_template_part('included/templates/logo'); ?>
                </div>
                <?php if (class_exists('WooCommerce')) {?>
                    <div class="col-xs-12 col-sm-4 cart-block">
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
                <nav id="primary-nav" class="col-sm-12 col-xs-12 primary-nav-block">
                    <div id="rit-mobile-cart">
                        <?php if (class_exists('WooCommerce')) {
                            get_template_part('included/templates/topheadcart');
                        } ?>
                    </div>
                    <div class="mobile-nav"><span></span></div>
                    <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu')); ?>
                </nav>
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

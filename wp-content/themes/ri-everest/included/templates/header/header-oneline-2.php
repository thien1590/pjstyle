<?php
if (is_single() || is_page()) {
    if (get_post_meta(get_the_ID(), 'rit_header_options', true) == 'use-default' || get_post_meta(get_the_ID(), 'rit_header_options', true) == '') {
        get_theme_mod('rit_enable_sticky_header') ? $enable_sticky = true : $enable_sticky = false;
        //get_theme_mod('rit_enable_main_widget') ? $enable_main_wd = true : $enable_main_wd = false;
    } else {
        get_post_meta(get_the_ID(), 'rit_enable_sticky_header', true) ? $enable_sticky = true : $enable_sticky = false;
        //get_post_meta(get_the_ID(), 'rit_enable_main_widget', true) ? $enable_main_wd = true : $enable_main_wd = false;
    }
} else {
    get_theme_mod('rit_enable_sticky_header') ? $enable_sticky = true : $enable_sticky = false;
    //get_theme_mod('rit_enable_main_widget') ? $enable_main_wd = true : $enable_main_wd = false;
}
?>
<header id="header-page" class="header-transparent black-style header-oneline-2">
    <div id="rit-bottom-header" class="wrapper-header-transparent">
                <nav id="primary-nav" class="primary-nav-block">
                    <div class="mobile-nav pull-left"><span></span></div>
                    <div id="rit-logo" class="pull-left">
                        <?php get_template_part('included/templates/logo'); ?>
                    </div>
                    <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu')); ?>
                </nav>
                <div class="right-bottom-header">
                    <ul class="list-btn-header">
                        <?php if (class_exists('WooCommerce')) { ?>
                            <li><?php
                                get_template_part('included/templates/topheadcart'); ?>
                            </li>
                        <?php } ?>
                        <li>
                            <span class="btn-header" id="activesearch"><i class="clever-icon-search-4"> </i></span>
                        </li>
                    </ul>
                </div>
                <div id="header-search">
                    <form role="search" method="get" id="top-searchform" action="<?php echo home_url(); ?>">
                        <input type="text"
                               value="<?php echo esc_attr(apply_filters('the_search_query', get_search_query())); ?>"
                               placeholder="<?php echo esc_attr__('Type & Hit Enter...', 'ri-everest') ?>"
                               class="ipt text"
                               name="s" id="s"/>
                        <div id="close-search"><span></span></div>
                    </form>
                </div>
    </div>
    <?php if ($enable_sticky) { ?>
        <script>
            (function ($) {
                "use strict";
                $(document).ready(function () {
                    $("#rit-bottom-header").sticky();
                })
            })(jQuery)
        </script>
    <?php } ?>
</header>
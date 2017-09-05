<header id="header-page" class="simpleline-header">
    <div id="main-header" class="container-fluid">
        <div class="row">
            <div class="mobile-nav pull-left"><span></span></div>
            <div class="col-sm-4 col-xs-12 left-main-header">
                <?php dynamic_sidebar('top-header') ?>
            </div>
            <div id="rit-logo" class="col-sm-4 col-xs-12 center-main-header">
                <?php get_template_part('included/templates/logo'); ?>
            </div>
            <div class="col-sm-4 col-xs-12 right-main-header">
                <ul class="list-btn-header">
                    <li>
                        <span class="btn-header" id="activesearch"><i class="clever-icon-search-4"> </i></span>
                    </li>
                    <?php if (class_exists('WooCommerce')) { ?>
                        <li><?php
                        get_template_part('included/templates/topheadcart');
                        ?></li><?php } ?>

                </ul>
                <div id="header-search">
                    <form role="search" method="get" id="top-searchform" action="<?php echo home_url(); ?>">
                        <input type="text"
                               value="<?php echo esc_attr(apply_filters('the_search_query', get_search_query())); ?>"
                               placeholder="<?php echo esc_html__('Type & Hit Enter...', 'ri-everest') ?>"
                               class="ipt text"
                               name="s" id="s"/>

                        <div id="close-search"><span></span></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="rit-bottom-header">
        <div class="container">
            <nav id="primary-nav" class="primary-nav-block">
                <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu')); ?>
            </nav>
        </div>
    </div>
</header>
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
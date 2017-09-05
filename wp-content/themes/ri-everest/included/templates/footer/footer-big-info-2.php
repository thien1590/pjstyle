<div id="top-rit-footer" class="rit-footer-big-info rit-footer-big-info-2">
    <div class="top-footer">
        <div class="container">
            <?php dynamic_sidebar('top-footer-2');
            get_template_part('included/templates/socail');
            ?>
            <script>
                jQuery(document).ready(function () {
                    jQuery(window).resize(function () {
                        var tw = jQuery('.top-footer .container').outerWidth();
                        if(tw>768) {
                            jQuery('.top-footer .widget_newsletterwidget').width(tw - jQuery('.top-footer').find('.rit-socail-page').outerWidth() - 30);
                            jQuery('.top-footer .widget_newsletterwidget .newsletter-widget').width(jQuery('.top-footer .widget_newsletterwidget').outerWidth() - jQuery('.top-footer .widget_newsletterwidget .title-widget').outerWidth());
                        }
                        else{
                            jQuery('.top-footer .widget_newsletterwidget .newsletter-widget').width(tw - jQuery('.top-footer').find('.rit-socail-page').outerWidth() - 31);
                        }
                    }).resize();
                });
            </script>
        </div>
    </div>
    <div class="container">
        <div class="right-footer">
            <div class="row">
                <section class="col-xs-12 col-sm-6">
                    <?php dynamic_sidebar('footer-info'); ?>
                </section>
                <section class="col-xs-12 col-sm-2">
                    <?php dynamic_sidebar('footer-1') ?>
                </section>
                <section class="col-xs-12 col-sm-2">
                    <?php dynamic_sidebar('footer-2') ?>
                </section>
                <section class="col-xs-12 col-sm-2">
                    <?php dynamic_sidebar('footer-3') ?>
                </section>
            </div>
        </div>
    </div>
</div>
<div id="rit-bottom-footer">
    <div class="container">
        <?php if (get_theme_mod('rit_enable_copyright', '1')) { ?>
            <div class="copy-right" id="copy-right">
                <?php if (get_theme_mod('rit_copyright_text')) {
                    echo get_theme_mod('rit_copyright_text');
                } ?>
            </div>
        <?php } ?>
    </div>
</div>
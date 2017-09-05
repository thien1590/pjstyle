<div id="top-rit-footer" class="rit-footer-big-info">
    <div class="container">
        <div class=" row">
            <div class="col-xs-12 col-sm-6">
                <?php dynamic_sidebar('footer-info'); ?>
            </div>
            <div class="col-xs-12 col-sm-6 right-footer">
                <div class="row">
                    <section class="col-xs-12 top-footer">
                        <div class="row">
                            <?php dynamic_sidebar('top-footer-2');
                            get_template_part('included/templates/socail');
                            ?>
                            <script type="text/javascript">
                                jQuery(document).ready(function(){
                                    var tw=jQuery('.top-footer').outerWidth();
                                    jQuery('.top-footer .newsletter-widget').width(tw-jQuery('.top-footer .rit-socail-page').outerWidth()-15);
                                });
                            </script>
                        </div>
                    </section>
                    <section class="col-xs-12 col-sm-4">
                        <?php dynamic_sidebar('footer-1') ?>
                    </section>
                    <section class="col-xs-12 col-sm-4">
                        <?php dynamic_sidebar('footer-2') ?>
                    </section>
                    <section class="col-xs-12 col-sm-4">
                        <?php dynamic_sidebar('footer-3') ?>
                    </section>
                </div>
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
<div id="top-rit-footer">
    <div class="container">
        <div class=" row">
            <div class="col-xs-12">
                <div class="socail-top-footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <?php dynamic_sidebar('top-footer-1'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <?php get_template_part('/included/templates/socail'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-top-footer">
                <section class="col-xs-12 col-sm-6 col-md-3">
                    <?php dynamic_sidebar('footer-1') ?>
                </section>
                <section class="col-xs-12 col-sm-6 col-md-3">
                    <?php dynamic_sidebar('footer-2') ?>
                </section>
                <section class="col-xs-12 col-sm-6 col-md-3">
                    <?php dynamic_sidebar('footer-3') ?>
                </section>
                <section class="col-xs-12 col-sm-6 col-md-3">
                    <?php dynamic_sidebar('footer-4') ?>
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
                }?>
            </div>
        <?php } ?>
    </div>
</div>
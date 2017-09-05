<div id="top-rit-footer">
    <div class="container">
        <div class="main-top-footer">
            <div class=" row">
                <aside class="col-xs-12 col-sm-3 col-md-4">
                    <?php dynamic_sidebar('footer-1') ?>
                </aside>
                <aside class="col-xs-12 col-sm-3 col-md-2">
                    <?php dynamic_sidebar('footer-2') ?>
                </aside>
                <aside class="col-xs-12 col-sm-3 col-md-2">
                    <?php dynamic_sidebar('footer-3') ?>
                </aside>
                <aside class="col-xs-12 col-sm-3 col-md-4">
                    <?php dynamic_sidebar('footer-4-2') ?>
                    <?php get_template_part('/included/templates/socail') ?>
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- End top rit footer -->
<div id="rit-bottom-footer">
    <div class="container">
        <?php if (get_theme_mod('rit_enable_copyright', '1')) { ?>
            <div class="copy-right" id="copy-right">
                <?php if (get_theme_mod('rit_copyright_text')) {
                    echo get_theme_mod('rit_copyright_text');
                } ?>
            </div><!-- .site-info -->
        <?php } ?>
    </div>
</div>
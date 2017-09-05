<div id="top-rit-footer">
    <div class="container">
        <?php if(is_active_sidebar('footer-dark-1')||is_active_sidebar('footer-dark-2')||is_active_sidebar('footer-dark-3')):?>
        <div class="main-top-footer">
            <div class=" row">
                <section class="col-xs-12 col-sm-4">
                    <?php dynamic_sidebar('footer-dark-1') ?>
                </section>
                <section class="col-xs-12 col-sm-4">
                    <?php dynamic_sidebar('footer-dark-2') ?>
                </section>
                <section class="col-xs-12 col-sm-4">
                    <?php dynamic_sidebar('footer-dark-3') ?>
                </section>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>
<div id="rit-bottom-footer">
    <div class="container">
        <div class="row">
        <?php if (get_theme_mod('rit_enable_copyright', '1') && get_theme_mod('rit_copyright_text')) {?>
            <div class="copy-right col-xs-12 col-sm-6" id="copy-right">
                  <?php  echo get_theme_mod('rit_copyright_text');?>
            </div>
        <?php }?>
        <div class="col-xs-12 col-sm-6 bottom-right-widget pull-right">
            <?php get_template_part('/included/templates/socail') ?>
        </div>
    </div>
    </div>
</div>
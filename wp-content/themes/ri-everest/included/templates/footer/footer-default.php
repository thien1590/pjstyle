
<div id="top-rit-footer">
    <div class="container">
        <?php if(is_active_sidebar('footer-1')||is_active_sidebar('footer-2')||is_active_sidebar('footer-3')||is_active_sidebar('footer-4')):?>
        <div class="main-top-footer">
            <div class=" row">
                <section class="col-xs-12 col-sm-3 col-md-6">
                    <?php dynamic_sidebar('footer-1') ?>
                </section>
                <section class="col-xs-12 col-sm-3 col-md-2">
                    <?php dynamic_sidebar('footer-2') ?>
                </section>
                <section class="col-xs-12 col-sm-3 col-md-2">
                    <?php dynamic_sidebar('footer-3') ?>
                </section>
                <section class="col-xs-12 col-sm-3 col-md-2">
                    <?php dynamic_sidebar('footer-4') ?>
                </section>
            </div>
        </div>
        <?php endif;?>
        <div class="bottom-main-top-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <?php get_template_part('/included/templates/socail') ?>
                </div>
                <div class="col-xs-12 col-sm-6 right-widget">
                    <?php dynamic_sidebar('bottom-main-footer') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(is_active_sidebar('footer-1')||(get_theme_mod('rit_enable_copyright', '1') && get_theme_mod('rit_copyright_text'))){?>
<div id="rit-bottom-footer">
    <div class="container">
        <div class="row">
        <?php if (get_theme_mod('rit_enable_copyright', '1') && get_theme_mod('rit_copyright_text')) {?>
            <div class="copy-right col-xs-12 col-sm-6" id="copy-right">
                  <?php  echo get_theme_mod('rit_copyright_text');?>
            </div>
        <?php }?>
        <div class="col-xs-12 col-sm-6 bottom-right-widget pull-right">
            <?php dynamic_sidebar('bottom-footer') ?>
        </div>
    </div>
    </div>
</div>
<?php }?>
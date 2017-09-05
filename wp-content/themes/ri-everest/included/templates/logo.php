<div class="wrapper-logo">
    <?php
    $hasLogo = false;
    if (is_single() || is_page()) {
        if (get_post_meta(get_the_ID(), 'rit_logo_page', true) != '' && get_post_meta(get_the_ID(), 'rit_logo_page', true) != 0):
            $hasLogo = true;
        endif;
    }
    if ($hasLogo):?>
        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" title="<?php bloginfo('name'); ?>">
            <img src="<?php echo esc_url(wp_get_attachment_url(get_post_meta(get_the_ID(), 'rit_logo_page', true))) ?>"
                 alt="<?php bloginfo('name'); ?>"/></a>
        <?php
    else:
        ?>
            <?php if (!get_theme_mod('rit_logo')) { ?>
                <h1><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"
                       title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
            <?php } else { ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" title="<?php bloginfo('name'); ?>"><img
                        src="<?php echo esc_url(get_theme_mod('rit_logo')) ?>" alt="<?php bloginfo('name'); ?>"/></a>
            <?php } ?>
    <?php endif;
    if (get_theme_mod('rit_show_tagline') != 1):
        $description = get_bloginfo('description', 'display');
        if ($description || is_customize_preview()) { ?>
            <p class="site-description"><?php echo esc_html($description); ?></p>
        <?php }
    endif; ?>
</div>
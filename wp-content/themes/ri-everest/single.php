<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header();

$sidebar = $class_main = $class_content = $class_sidebar = '';
if (get_post_meta(get_the_ID(), 'rit_sidebar_options', true) == 'use-default') {
    $sidebar = get_theme_mod('rit_default_sidebar', 'no-sidebar');
} else {
    $sidebar = get_post_meta(get_the_ID(), 'rit_sidebar_options', true);
}
$class_content = $sidebar;
if (get_post_type(get_the_ID()) == 'portfolio') {
    $class_main = 'col-sm-12 col-md-12';
} else {
    if ($sidebar == 'no-sidebar' || $sidebar == '') {
        $class_main = 'col-sm-12 col-md-12';
    } elseif ($sidebar == 'left-sidebar' || $sidebar == 'right-sidebar') {
        $class_main = 'col-sm-12 col-md-9 ';
    } else {
        $class_main = 'col-sm-12 col-md-6 ';
    }
}
if (is_single()) {
    $class_main .= ' body-content';
}
?>
<?php if (function_exists('bcn_display') && !get_post_meta(get_the_ID(), 'rit_disable_breadcrumb', true)) { ?>
    <div class="wrapper-breadcrumb">
        <div class="container"><?php
            bcn_display();
            ?>
        </div>
    </div>
    <?php
}else{
    $class_content.=' no-breadcrumb';
}
?>
<main id="rit-main" class="<?php echo esc_attr($class_content); ?>">
    <div class="container">
        <div class="wrapper-content row post-page">
            <?php if ($sidebar == 'left-sidebar' || $sidebar == 'both-sidebar') { ?>
                <?php get_template_part('sidebar') ?>
            <?php } ?>
            <div class="main-content site-main <?php echo esc_attr($class_main); ?>">

                <?php
                // Start the loop.
                while (have_posts()) : the_post();

                    /*
                     * Include the post format-specific template for the content. If you want to
                     * use this in a child theme, then include a file called called content-___.php
                     * (where ___ is the post format) and that will be used instead.
                     */
                    get_template_part('content', 'single');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (is_single()):
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                    endif;

                    // End the loop.
                endwhile;
                ?>

            </div>
            <!-- .site-main -->
            <?php if ($sidebar == 'right-sidebar' || $sidebar == 'both-sidebar') { ?>
                <?php get_template_part('sidebar','right') ?>
            <?php } ?>
        </div>
    </div>
    <!-- .content-area -->
</main>
<?php get_footer(); ?>

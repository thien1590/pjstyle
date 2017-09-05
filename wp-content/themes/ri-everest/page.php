<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Ri Everest
 * @since Ri Everest 1.0
 */

get_header();

$sidebar = $class_main = $class_content = $class_sidebar = '';
if (get_post_meta(get_the_ID(), 'rit_sidebar_options', true) == 'use-default' || get_post_meta(get_the_ID(), 'rit_sidebar_options', true) == '') {
    $sidebar = get_theme_mod('rit_default_sidebar', 'right-sidebar');
} else {
    $sidebar = get_post_meta(get_the_ID(), 'rit_sidebar_options', true);
}
$class_content = $sidebar;
$class_content.='page';
if ($sidebar == 'no-sidebar' || $sidebar == '') {
    $class_main = 'col-xs-12 col-sm-12';
} elseif ($sidebar == 'left-sidebar' || $sidebar == 'right-sidebar') {
    $class_main = 'col-xs-12 col-sm-9 ';
} else {
    $class_main = 'col-xs-12 col-sm-6 ';
}
$wrapp_class='';
if ($sidebar != 'no-sidebar' && $sidebar != ''){
    $wrapp_class.='post-page';
}
?>
<?php if(! is_front_page()){
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
    } ?>
<?php }?>
<main id="rit-main" class="<?php echo esc_attr($class_content); ?>">
    <div class="container">
        <div class="row <?php echo esc_attr($wrapp_class);?>">
            <!--begin sidebar-->
            <?php if ($sidebar == 'left-sidebar' || $sidebar == 'both-sidebar') { ?>
                <?php get_template_part('sidebar') ?>
            <?php } ?>
            <div class="site-main <?php echo esc_attr($class_main); ?>">
                <?php
                // Start the loop.
                while (have_posts()) : the_post();
                    // Include the page content template.
                    get_template_part('content', 'page');
                    // If comments are open or we have at least one comment, load up the comment template.
                    //if (is_single()):
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    //endif;
                    // End the loop.
                endwhile;
                ?>
            </div>
            <!-- .site-main -->
            <?php if ($sidebar == 'right-sidebar' || $sidebar == 'both-sidebar') { ?>
                <?php get_template_part('sidebar', 'right') ?>
            <?php } ?>
        </div>
        <!-- .content-area -->
    </div>
</main>
<?php get_footer();
?>

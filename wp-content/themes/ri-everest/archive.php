<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage everest
 * @since  1.0
 */

get_header();

$sidebar = $class_main = $class_content = $class_sidebar = '';

$sidebar = get_theme_mod('rit_default_sidebar', 'no-sidebar');
$class_content = $sidebar;

if ($sidebar == 'no-sidebar' || $sidebar == '') {
    $class_main = 'col-sm-12 col-md-12';
} elseif ($sidebar == 'left-sidebar' || $sidebar == 'right-sidebar') {
    $class_main = 'col-sm-12 col-md-9';
} else {
    $class_main = 'col-sm-12 col-md-6';
}

?>

<?php if (function_exists('bcn_display')) { ?>
<div class="wrapper-breadcrumb">
    <div class="container"><?php
        bcn_display();
        ?>
    </div>
</div>
    <?php
} ?>
<main id="rit-main" class="archive-page <?php echo esc_attr($class_content); ?>">
    <div class="container">
        <div class="row post-page">
            <!--begin sidebar-->
            <?php if ($sidebar == 'left-sidebar' || $sidebar == 'both-sidebar') { ?>
                <?php get_template_part('sidebar') ?>
            <?php } ?>
            <div class="site-main <?php echo esc_attr($class_main); ?>">
                <?php if (have_posts()) : ?>
                    <?php
                    // Start the Loop.
                    while (have_posts()) : the_post();
                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'content', get_theme_mod('rit_default_blog_layout', 'default') );
                        // End the loop.
                    endwhile;
                    if (function_exists("rit_pagination")) :
                        echo '<div class="wrapper-pagination">';
                        rit_pagination(3,'','','<i class=" clever-icon-arrow-left-regular"></i>','<i class=" clever-icon-arrow-right-regular"></i>');
                        echo '</div>';
                    else: ?>
                        <div class="nav-previous default-paging alignleft primary-font"><?php previous_posts_link( esc_html__('Newer posts','ri-everest') ); ?></div>
                        <div class="nav-next default-paging alignright primary-font"><?php next_posts_link( esc_html__('Older posts','ri-everest') ); ?></div>
                    <?php endif;
                // If no content, include the "No posts found" template.
                else:
                    get_template_part('content', 'none');
                endif;
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

<?php get_footer(); ?>

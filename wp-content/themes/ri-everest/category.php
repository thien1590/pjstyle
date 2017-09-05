<?php
/**
 * The template for displaying Category pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage ri-everest
 * @since Ri Everest 1.0
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
<div id="primary" class="content-area <?php echo esc_attr($class_content); ?>">
    <div class="container">
        <div class="row post-page">
            <?php if ($sidebar == 'left-sidebar' || $sidebar == 'both-sidebar') {
                get_template_part('sidebar');
            } ?>
            <main class="site-main <?php echo esc_attr($class_main); ?>">

                <?php if (have_posts()) : ?>

                    <header class="archive-header">

                        <?php
                        // Show an optional term description.
                        $term_description = term_description();
                        if (!empty($term_description)) :
                            printf('<div class="taxonomy-description">%s</div>', $term_description);
                        endif;
                        ?>
                    </header><!-- .archive-header -->

                    <?php
                    // Start the Loop.
                    while (have_posts()) : the_post();

                        /*
                         * Include the post format-specific template for the content. If you want to
                         * use this in a child theme, then include a file called called content-___.php
                         * (where ___ is the post format) and that will be used instead.
                         */
                        get_template_part('content', get_theme_mod('rit_default_blog_layout', 'default'));

                    endwhile;
                    if (function_exists("rit_pagination")) :
                        echo '<div class="wrapper-pagination">';
                        rit_pagination(3,'','','<i class=" clever-icon-arrow-left-regular"></i>','<i class=" clever-icon-arrow-right-regular"></i>');
                        echo '</div>';
                    else: ?>
                        <div class="nav-previous alignleft"><?php next_posts_link( esc_html__('Older posts','ri-everest') ); ?></div>
                        <div class="nav-next alignright"><?php previous_posts_link(  esc_html__('Newer posts','ri-everest') ); ?></div>
                    <?php endif;
                else :
                    // If no content, include the "No posts found" template.
                    get_template_part('content', 'none');

                endif;
                ?>
            </main>
            <!-- .site-main -->
            <?php if ($sidebar == 'right-sidebar' || $sidebar == 'both-sidebar') {
                get_template_part('sidebar', 'right');
            } ?>
        </div>
    </div>
    <!-- .content-area -->
<?php
get_footer();
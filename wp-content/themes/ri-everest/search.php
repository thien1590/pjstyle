<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage everest
 * @since everest 1.0
 */
?>
<?php get_header();
$class_content='search-result ';
if (function_exists('bcn_display') && !get_post_meta(get_the_ID(), 'rit_disable_breadcrumb', true)) { ?>
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
<main id="rit-main" <?php post_class($class_content)?>>
    <div class="container">
    <?php if (have_posts()) : ?>

            <header class="page-header">
                <h1 class="page-title"><?php printf(esc_html__('Search Results for: %s','ri-everest'), get_search_query()); ?></h1>
            </header>
            <!-- .page-header -->

            <?php
            // Start the loop.
            while (have_posts()) : the_post(); ?>

                <?php
                /*
                 * Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called content-search.php and that will be used instead.
                 */
                get_template_part( 'content', get_theme_mod('rit_default_blog_layout', 'default') );

                // End the loop.
            endwhile;

            // Previous/next page navigation.
        if (function_exists("rit_pagination")) :
            echo '<div class="wrapper-pagination">';
            rit_pagination(3,'','','<i class=" clever-icon-arrow-left-regular"></i>','<i class=" clever-icon-arrow-right-regular"></i>');
            echo '</div>';
        else: ?>
            <div class="nav-previous alignleft"><?php next_posts_link( esc_html__('Older posts','ri-everest') ); ?></div>
            <div class="nav-next alignright"><?php previous_posts_link(  esc_html__('Newer posts','ri-everest') ); ?></div>
        <?php endif;?>

    <?php // If no content, include the "No posts found" template.
    else :?>

            <?php
            get_template_part('content', 'none'); ?>
        <?php
    endif;
    ?>
        </div>
</main>
<?php get_footer(); ?>

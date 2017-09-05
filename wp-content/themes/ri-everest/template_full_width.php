<?php
/**
 * Created by PhpStorm.
 * User: ntk
 * Date: 11/06/2015
 * Time: 15:48
 * Template Name:Full width
 */
get_header();
?>
    <main id="rit-main" class="<?php echo esc_attr('page'); ?>">
                <div class="site-main page-full-width">
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
    </main>
<?php get_footer();
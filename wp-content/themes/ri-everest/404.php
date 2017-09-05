<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage everest
 * @since everest 1.0
 */

get_header(); ?>
<main id="rit-main">
    <div class="container">
        <section class="error-404 not-found">
            <h1 class="page-name">
                404
            </h1>
            <!-- .page-header -->
            <h2 class="page-des"><?php echo esc_html__('Oops! That page can&rsquo;t be found.', 'ri-everest'); ?></h2>

            <p><a href="<?php echo get_home_url(); ?>" class="back-home"
                  title="<?php echo esc_html__('back to homepage', 'ri-everest'); ?>"> <?php echo esc_html__('back to homepage', 'ri-everest'); ?></a>
            </p>
        </section>
        <!-- .error-404 -->
    </div>
</main><!-- .site-main -->

<?php get_footer(); ?>

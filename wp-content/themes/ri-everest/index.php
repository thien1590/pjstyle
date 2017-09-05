<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage everest
 * @since everest 1.0
 */

get_header();

$sidebar = $class_main = $class_content = $class_sidebar = '';
$sidebar = get_theme_mod('rit_default_sidebar', 'right-sidebar');
$class_content = $sidebar;

if($sidebar == 'no-sidebar' || $sidebar ==''){
    $class_main = 'col-sm-12 col-md-12';
} elseif ($sidebar == 'left-sidebar' || $sidebar == 'right-sidebar'){
    $class_main = 'col-sm-12 col-md-9 ';
} else{
    $class_main = 'col-sm-12 col-md-6 ';
}
 if (function_exists('bcn_display')) { ?>
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
<main id="rit-main" class="<?php echo esc_attr($class_content); ?>">
	<div class="container">
		<div class="row post-page">
			<!--begin sidebar-->
			<?php if ($sidebar == 'left-sidebar' || $sidebar == 'both-sidebar') { ?>
				<?php get_template_part('sidebar') ?>
			<?php } ?>
			<div class="site-main <?php echo esc_attr($class_main); ?>">
				<?php if ( have_posts() ) : ?>
					<?php

					// Start the loop.
					while ( have_posts() ) : the_post();

						/*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
						get_template_part( 'content', get_theme_mod('rit_default_blog_layout', 'default') );

						// End the loop.
					endwhile;

					// Previous/next page navigation.
					//if (function_exists("pagination")) :
					//   pagination(get_option('posts_per_page'));
					//endif;
					if (function_exists("rit_pagination")) :
						echo '<div class="wrapper-pagination">';
						rit_pagination(3,'','','<i class=" clever-icon-arrow-left-regular"></i>','<i class=" clever-icon-arrow-right-regular"></i>');
						echo '</div>';
					else: ?>
						<div class="nav-previous default-paging alignleft primary-font"><?php previous_posts_link( esc_html__('Newer posts','ri-everest') ); ?></div>
						<div class="nav-next default-paging alignright primary-font"><?php next_posts_link( esc_html__('Older posts','ri-everest') ); ?></div>
					<?php endif;
				// If no content, include the "No posts found" template.
				else :
					get_template_part( 'content', 'none' );
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

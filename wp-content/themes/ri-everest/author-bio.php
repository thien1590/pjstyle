<?php
/**
 * The template for displaying Author bios
 *
 * @package WordPress
 * @subpackage everest
 * @since everest 1.0
 */
?>

<div class="author-info">
	<h2 class="author-heading"><?php echo esc_html__( 'Published by', 'ri-everest' ); ?></h2>
	<div class="author-avatar">
		<?php
		echo get_avatar( get_the_author_meta('email'), '220' );
		?>
	</div><!-- .author-avatar -->

	<div class="author-description">
		<h3 class="author-title"><?php echo get_the_author(); ?></h3>

		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( esc_html__( 'View all posts by %s', 'ri-everest' ), get_the_author() ); ?>
			</a>
		</p><!-- .author-bio -->

	</div><!-- .author-description -->
</div><!-- .author-info -->

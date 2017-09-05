<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage everest
 * @since everest 1.0
 */
?>
<div class="content-page">
<?php the_content(); ?>
</div>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'ri-everest' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'ri-everest' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	<?php edit_post_link( esc_html__( 'Edit', 'ri-everest' ), '<footer class="entry-footer"><span class="edit-link"><i class="fa fa-edit"></i> ', '</span></footer><!-- .entry-footer -->' ); ?>


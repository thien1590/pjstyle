<?php 

$orig_post = $post;
$post;

$categories = get_the_category(get_the_ID());

if ($categories) {

	$category_ids = array();

	foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
	
	$args = array(
		'category__in'     => $category_ids,
		'post__not_in'     => array(get_the_ID()),
		'posts_per_page'   => 3, // Number of related posts that will be shown.
		'ignore_sticky_posts' => 1,
		'orderby' => 'rand'
	);

	$my_query = new wp_query( $args );
	if( $my_query->have_posts() ) { ?>
		<div class="post-related">
        <h3 class="title-widget"><?php echo esc_html__('Related posts', 'ri-everest'); ?></h3>
        <div class="row">
		<?php while( $my_query->have_posts() ) {
			$my_query->the_post();?>
				<div class="item-related col-sm-4 col-md-4">
					<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) : ?>
					<a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('medium'); ?></a>
					<?php endif; ?>
					<span class="date"><?php the_time( get_option('date_format') ); ?></span>
					<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
				</div>
		<?php
		}
		echo '</div></div>';
	}
}
$post = $orig_post;
wp_reset_postdata();

?>
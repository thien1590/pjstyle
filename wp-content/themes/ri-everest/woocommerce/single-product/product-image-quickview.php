<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

?>
<div class="wrapp-images">
	<div id="rit-wrapper-main-img" class="col-xs-12 ">
			<?php
			if (has_post_thumbnail()) {

				$image_title = esc_attr(get_the_title(get_post_thumbnail_id()));
				$image_caption = get_post(get_post_thumbnail_id())->post_excerpt;
				$image_link = wp_get_attachment_url(get_post_thumbnail_id());
				$image = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
					'title' => $image_title,
					'alt' => $image_title
				));

				$attachment_count = count($product->get_gallery_attachment_ids());

				if ($attachment_count > 0) {
					$gallery = '[product-gallery]';
				} else {
					$gallery = '';
				}

				echo apply_filters('woocommerce_single_product_image_html', sprintf('<div class="woocommerce-main-image"><a href="%s" title="%s" rel="lightbox[]">%s</a></div>', $image_link, $image_caption, $image), $post->ID);

			}
			?>
	</div>
</div>
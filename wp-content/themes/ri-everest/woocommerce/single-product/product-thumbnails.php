<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

$attachment_ids = $product->get_gallery_image_ids();
?>

<div class="thumbnails">
    <ul class="list-thumbnails">
        <?php
        if (has_post_thumbnail()) {

            $image_title = esc_attr(get_the_title(get_post_thumbnail_id()));
            $image_caption = get_post(get_post_thumbnail_id())->post_excerpt;
            $image_link = wp_get_attachment_url(get_post_thumbnail_id());
            $image = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
                'title' => $image_title,
                'alt' => $image_title
            ));

            $attachment_count = count($product->get_gallery_image_ids());

            if ($attachment_count > 0) {
                $gallery = '[product-gallery]';
            } else {
                $gallery = '';
            }

            echo apply_filters('woocommerce_single_product_image_html', sprintf('<li class="active"><a href="%s" title="%s" rel="lightbox[]">%s</a></li>', $image_link, $image_caption, $image), $post->ID);

        }
        if ( $attachment_ids && has_post_thumbnail() ) {
            foreach ( $attachment_ids as $attachment_id ) {
                $full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
                $thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
                $attributes = array(
                    'title' => get_post_field('post_title', $attachment_id),
                    'data-caption' => get_post_field('post_excerpt', $attachment_id),
                    'data-src'                => $full_size_image[0],
                    'data-large_image'        => $full_size_image[0],
                    'data-large_image_width'  => $full_size_image[1],
                    'data-large_image_height' => $full_size_image[2],
                );

                $html  = '<li><a href="' . esc_url( $full_size_image[0] ) . '">';
                $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
                $html .= '</a></li>';

                echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
            }
        }

        ?>
    </ul>
    <span id="slide-up" class="slider-control"><i class="clever-icon-up"></i> </span>
    <span id="slide-down" class="slider-control"><i class="clever-icon-down"></i> </span>
</div>
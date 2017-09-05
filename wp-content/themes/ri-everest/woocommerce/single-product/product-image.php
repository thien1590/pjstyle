<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . $placeholder,
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );
?>
<div class="wrapp-images row">
	<div id="rit-wrapper-list-thumbs"class="col-xs-1-5 "><?php do_action( 'woocommerce_product_thumbnails' ); ?></div>
	<div id="rit-wrapper-main-img" class="col-xs-4-5 ">
		<ul class="list-imgs woocommerce-main-image">
            <?php
            $attributes = array(
			'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
			'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
                'data-src'                => $full_size_image[0],
                'data-large_image'        => $full_size_image[0],
                'data-large_image_width'  => $full_size_image[1],
                'data-large_image_height' => $full_size_image[2],
            );

            if ( has_post_thumbnail() ) {
                $html  = '<li><a href="' . esc_url( $full_size_image[0] ) . '">';
                $html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
                $html .= '</a></li>';
            } else {
                $html  = '<li>';
                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
                $html .= '</li>';
            }

            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
            $attachment_ids = $product->get_gallery_image_ids();
			if ($attachment_ids) {
				$loop = 0;
				$columns = apply_filters('woocommerce_product_thumbnails_columns', 3);

				foreach ($attachment_ids as $attachment_id) {

					$classes = array('zoom');

					$image_link = wp_get_attachment_url($attachment_id);

					if (!$image_link)
						continue;

					$image = wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', 'shop_single'));
					$image_class = esc_attr(implode(' ', $classes));
					$image_title = esc_attr(get_the_title($attachment_id));
					echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<li><a href="%s" title="%s" rel="lightbox[]" >%s</a></li>', $image_link, $image_title, $image), $post->ID);

					$loop++;
				}
			}
			?>
		</ul>
		<script>
			(function ($) {
				'use strict';
			jQuery(document).ready(function(){
				jQuery('#rit-wrapper-main-img .list-imgs li').zoom({
					duration:0
				});
				var main_caroul=jQuery('#rit-wrapper-main-img .list-imgs');
				main_caroul.owlCarousel({
					items: '1',
					itemsCustom: false,
					itemsDesktop: [1199, 1],
					itemsDesktopSmall: [980,1],
					itemsTablet: [768, 1],
					itemsTabletSmall: false,
					itemsMobile: [479, 1],
					navigation: true,
					navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
					autoPlay : false,
					pagination: false,
					addClassActive:true,
					afterMove:function(elem){
						jQuery('.list-thumbnails li').removeClass('active');
						jQuery('.list-thumbnails li[index='+elem.find('.owl-item.active').index()+']').addClass('active');
					}
				});
				//Add index for thumbnails
				jQuery('.list-thumbnails li').each(function(){
					$(this).attr('index',$(this).index())
				});
				VaritionImg();
			});
			function VaritionImg(){
				var orginal_image = $('.list-thumbnails li.active img').attr('src');
				var orginal_alt = $('.list-thumbnails li.active img').attr('alt');
				jQuery( "form.variations_form" ).on( "show_variation", function (event, variation) {
                    if (variation.image.full_src != ''){
						var newimg=variation.image.full_src;
						var title=variation.image.image_title;
						jQuery(' .woocommerce-main-image .active img').attr('src',newimg);
						jQuery(' .woocommerce-main-image .active img').attr('srcset',newimg);
						jQuery(' .woocommerce-main-image .active a').attr('href', newimg);
						jQuery(".list-thumbnails .active").removeClass('active');
						jQuery('.list-thumbnails img[alt='+title+']').parents('li').addClass('active');
					} else {
						jQuery(' .woocommerce-main-image .active').attr('src',orginal_image);
						jQuery(' .woocommerce-main-image .active').attr('srcset',orginal_image);
						jQuery(' .woocommerce-main-image .active a').attr('href', orginal_image);
						jQuery(".list-thumbnails .active").removeClass('active');
						jQuery('.list-thumbnails img[alt="'+orginal_alt+'"]').parents('li').addClass('active');
					}
				});
			}
			jQuery(window).load(function () {
				var main_caroul=jQuery('#rit-wrapper-main-img .list-imgs');
				ModalZoom();
				var newimg=jQuery(' .woocommerce-main-image .active a').attr('href');
				jQuery(' .woocommerce-main-image .active .zoomImg').attr('srcset',newimg);
				jQuery(window).resize(function () {
					//Resize
					var h = jQuery('#rit-wrapper-main-img').outerHeight();
					jQuery('.thumbnails').height(h);
					var item_h = jQuery('.list-thumbnails li').innerHeight();
					var item_per_page = Math.floor(h / item_h);
					var padding = (h - item_per_page * item_h) / (2 * item_per_page);
					jQuery('.list-thumbnails li').css('padding', padding + 'px 0px');
					// Using custom configuration
					jQuery('#rit-wrapper-list-thumbs .list-thumbnails').carouFredSel({
						items: item_per_page,
						direction: "up",
						auto: false,
						scroll: {
							items: 1,
							easing: "linear",
							duration: 500,
							pauseOnHover: true
						},
						prev: {
							button: "#slide-up",
							key: "up"
						},
						next: {
							button: "#slide-down",
							key: "down"
						},
					});
				}).resize();
				//Load image
				jQuery('.list-thumbnails li a').removeAttr('data-rel');
				jQuery('.list-thumbnails li').click(function (event) {
					event.preventDefault();
					jQuery('.list-thumbnails li').removeClass('active');
					jQuery(this).addClass('active');
					main_caroul.trigger('owl.goTo', jQuery(this).attr('index'));
				});
			});
			function ModalZoom() {
				(function ($) {
					"use strict";
					$('.woocommerce-main-image').on('click', function (e) {
						e.preventDefault();
					});
					var modalcontent = $('#rit-wrapper-list-thumbs .list-thumbnails').html();
					var modalhtml = '<div id="rit-modalzoom" class="active" ><div id="rit-inner-modalzoom"><img id="rit-modal-img" src="' + $('.woocommerce-main-image').attr('href') + '" alt=""/><ul class="list-modal-item"> ' + modalcontent + '</ul></div> <span class="close-modalzoom"><i class="clever-icon-close"></i></span> <span id="rit-modal-prev" class="rit-modal-control"><i class="clever-icon-preview"></i></span> <span id="rit-modal-next" class="rit-modal-control"><i class="clever-icon-next"></i> </span></div>';
					$('.zoom-label').on('click', function () {
						$('body').append(modalhtml);
						$('#rit-modal-img').attr('src', $('.woocommerce-main-image .active a').attr('href'));
						$('#rit-modal-img').css('max-height', $(window).height() - 60);
						$('#rit-inner-modalzoom a[href="' + $('.woocommerce-main-image').attr('href') + '"]').parents('li').first().addClass('active');
						// Using custom configuration
					});
					jQuery(window).resize(function () {
						$('#rit-modal-img').css('max-height', $(window).height() - 60);
					});
					$(document).on('click', '#rit-modal-next', function () {
						modalNext();
					});
					$(document).on('click', '#rit-modal-prev', function () {
						modalPrev();
					});
					$(document).on('click', '.close-modalzoom', function (e) {
						$('#rit-modalzoom').remove();
					});
					function modalNext() {
						if ($('.list-modal-item').find('.active').is(':last-child')) {
							$('.list-modal-item').find('.active').removeClass('active');
							$('.list-modal-item li:first-child').addClass('active');
							$('#rit-modal-img').attr('src', $('.list-modal-item .active').find('a').attr('href'));
						}
						else {
							$('.list-modal-item').find('.active').removeClass('active').next().addClass('active');
							$('#rit-modal-img').attr('src', $('.list-modal-item .active').find('a').attr('href'));
						}
					}

					function modalPrev() {
						if ($('.list-modal-item').find('.active').is(':first-child')) {
							$('.list-modal-item').find('.active').removeClass('active');
							$('.list-modal-item li:last-child').addClass('active');
							$('#rit-modal-img').attr('src', $('.list-modal-item .active').find('a').attr('href'));
						}
						else {
							$('.list-modal-item').find('.active').removeClass('active').prev().addClass('active');
							$('#rit-modal-img').attr('src', $('.list-modal-item .active').find('a').attr('href'));
						}
					}
				})(jQuery);
			}
			})(jQuery)
		</script>
		<span class="zoom-label"><i class="clever-icon-search-4"></i> </span>
	</div>
</div>
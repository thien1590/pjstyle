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
<div class="wrapp-images row">
	<div id="rit-wrapper-list-thumbs"class="col-xs-1-5 "><?php do_action( 'woocommerce_product_thumbnails' ); ?></div>
	<div id="rit-wrapper-main-img" class="col-xs-4-5 ">
		<ul class="list-imgs woocommerce-main-image">
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

				echo apply_filters('woocommerce_single_product_image_html', sprintf('<li><a href="%s" title="%s" rel="lightbox[]">%s</a></li>', $image_link, $image_caption, $image), $post->ID);

			}
			if ($attachment_ids) {
				$loop = 0;
				$columns = apply_filters('woocommerce_product_thumbnails_columns', 3);

				foreach ($attachment_ids as $attachment_id) {

					$classes = array('zoom');

					if ($loop == 0 || $loop % $columns == 0)
						$classes[] = 'first';

					if (($loop + 1) % $columns == 0)
						$classes[] = 'last';

					$image_link = wp_get_attachment_url($attachment_id);

					if (!$image_link)
						continue;

					$image = wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', 'shop_single'));
					$image_class = esc_attr(implode(' ', $classes));
					$image_title = esc_attr(get_the_title($attachment_id));
					echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<li><a href="%s" title="%s" rel="lightbox[]" >%s</a></li>', $image_link, $image_title, $image), $post->ID);
					//echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a></li>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );

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
					if(variation){
						var newimg=variation.image_link;
						var title=variation.image_title;
						//console.log(newimg);
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
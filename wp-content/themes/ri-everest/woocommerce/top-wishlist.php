<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 01/09/2015
 * Time: 3:09 CH
 */
/* WISHLIST DROPDOWN
================================================== */
if (!function_exists('ct_get_wishlist')) {
    function ct_get_wishlist() {
        if(defined('YITH_WCWL_TABLE')) {
            global $wpdb, $yith_wcwl, $woocommerce;

            $wishlist_output = "";

            if ( is_user_logged_in() ) {
                $user_id = get_current_user_id();
            }

            $count = array();

            if( is_user_logged_in() ) {
                $count = $wpdb->get_results( $wpdb->prepare( 'SELECT COUNT(*) as `cnt` FROM `' . YITH_WCWL_TABLE . '` WHERE `user_id` = %d', $user_id  ), ARRAY_A );
                $count = $count[0]['cnt'];
            } elseif( yith_usecookies() ) {
                $count[0]['cnt'] = count( yith_getcookie( 'yith_wcwl_products' ) );
                $count = $count[0]['cnt'];
            } else {
                $count[0]['cnt'] = count( $_SESSION['yith_wcwl_products'] );
                $count = $count[0]['cnt'];
            }

            if (is_array($count)) {
                $count = 0;
            }

            $wishlist_output .= '<li class="parent wishlist-item"><a class="wishlist-link" href="'.$yith_wcwl->get_wishlist_url().'" title="'.esc_attr("View your wishlist", "ri-Everest").'"><span><i class="fa-heart-o"></i>Wishlist&nbsp;(&nbsp;'.$count.'&nbsp;&nbsp;Item)</span></a>';
            $wishlist_output .= '<ul class="sub-menu">';
            $wishlist_output .= '<li>';
            $wishlist_output .= '<div class="wishlist-bag">';

            $current_page = 1;
            $limit_sql = '';
            $count_limit = 0;

            if( is_user_logged_in() )
            { $wishlist = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `" . YITH_WCWL_TABLE . "` WHERE `user_id` = %s" . $limit_sql, $user_id ), ARRAY_A ); }
            elseif( yith_usecookies() )
            { $wishlist = yith_getcookie( 'yith_wcwl_products' ); }
            else
            { $wishlist = isset( $_SESSION['yith_wcwl_products'] ) ? $_SESSION['yith_wcwl_products'] : array(); }

            do_action( 'yith_wcwl_before_wishlist_title' );

            //			$wishlist_title = get_option( 'yith_wcwl_wishlist_title' );
            //			if( !empty( $wishlist_title ) ) {
            //			$wishlist_output .= '<div class="bag-header">'.$wishlist_title.'</div>';
            //			}
            $wishlist_output .= '<div class="bag-contents">';

            $wishlist_output .= do_action( 'yith_wcwl_before_wishlist' );

            if ( count( $wishlist ) > 0 ) :

                foreach( $wishlist as $values ) :

                    if ($count_limit < 4) {

                        if( !is_user_logged_in() ) {
                            if( isset( $values['add-to-wishlist'] ) && is_numeric( $values['add-to-wishlist'] ) ) {
                                $values['prod_id'] = $values['add-to-wishlist'];
                                $values['ID'] = $values['add-to-wishlist'];
                            } else {
                                $values['prod_id'] = $values['product_id'];
                                $values['ID'] = $values['product_id'];
                            }
                        }

                        $product_obj = get_product( $values['prod_id'] );

                        if( $product_obj !== false && $product_obj->exists() ) :

                            $wishlist_output .= '<div id="wishlist-'.$values['ID'].'" class="bag-product clearfix">';

                            if ( has_post_thumbnail($product_obj->id) ) {
                                $image_link  		= wp_get_attachment_url( get_post_thumbnail_id($product_obj->id) );
                                $image = aq_resize( $image_link, 70, 70, true, false);

                                if ($image) {
                                    $wishlist_output .= '<figure><a class="bag-product-img" href="'.esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $values['prod_id'] ) ) ).'"><img itemprop="image" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" /></a></figure>';
                                }
                            }

                            $wishlist_output .= '<div class="bag-product-details">';
                            $wishlist_output .= '<div class="bag-product-title"><a href="'.esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $values['prod_id'] ) ) ).'">'. apply_filters( 'woocommerce_in_cartproduct_obj_title', $product_obj->get_title(), $product_obj ) .'</a></div>';

                            if( get_option( 'woocommerce_display_cart_prices_excluding_tax' ) == 'yes' ) {
                                $wishlist_output .= '<div class="bag-product-price">'.apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price_excluding_tax() ), $values, '' ).'</div>';
                            } else {
                                $wishlist_output .= '<div class="bag-product-price">'.apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price() ), $values, '' ).'</div>';
                            }
                            $wishlist_output .= '</div>';
                            $wishlist_output .= '</div>';

                        endif;

                        $count_limit++;
                    }

                endforeach;

            else :
                $wishlist_output .= '<div class="wishlist-empty">'. __( 'Your wishlist is currently empty.', 'ri-everest' ) .'</div>';
            endif;

            $wishlist_output .= '</div>';
            if(count( $wishlist ) > 0){

                $wishlist_output .= '<div class="bag-buttons">';

                $wishlist_output .= '<a class="ct-button standard grey wishlist-button" href="'.$yith_wcwl->get_wishlist_url().'"><span>'.__('My wishlist', 'ri-everest').'</span></a>';

                $wishlist_output .= '</div>';
            }


            do_action( 'yith_wcwl_after_wishlist' );

            $wishlist_output .= '</div>';
            $wishlist_output .= '</li>';
            $wishlist_output .= '</ul>';
            $wishlist_output .= '</li>';

            return $wishlist_output;
        }
    }
}

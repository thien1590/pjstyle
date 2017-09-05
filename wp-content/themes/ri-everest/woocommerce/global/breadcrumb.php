<?php
/**
 * Shop breadcrumb
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $breadcrumb ) {

    echo('<ul class="breadcrumbs primary-font">');
	foreach ( $breadcrumb as $key => $crumb ) {
		echo $before;
		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			if($key!=0){
				echo '<li><a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a></li>';
			}
			else{
				echo '<li><a href="' . esc_url( $crumb[1] ) . '"><i class="fa fa-home"></i></a></li>';
			}
		} else {
			echo '<li><strong>'.esc_html($crumb[0]).'</strong></li>' ;
		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<li><i class="clever-icon-arrow-right-light"></i></li>';
		}

	}
echo('</ul>');

}
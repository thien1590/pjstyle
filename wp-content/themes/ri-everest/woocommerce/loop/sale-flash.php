<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ($product->is_on_sale()) :
	//var_dump($product);
	$sale='';
	$regular_price=$product->regular_price;
	$sale_price=$product->sale_price;
	if(empty($regular_price)){
		$regular_price=$product->get_variation_regular_price( 'max', true );
	}
	if(empty($sale_price)){
		$sale_price=$product->get_price();
	}
	$percent=round( ( ($regular_price - $sale_price ) / $regular_price ) * 100 );
	?>

	<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">-'.$percent.'%</span>', $post, $product); ?>

<?php endif; ?>
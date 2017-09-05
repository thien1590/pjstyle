<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 19-Feb-16
 * Time: 4:32 PM
 */
// get meta box of product
$class = '';
switch ($atts['column']) {
    case 'columns1':
        $class = 'col-xs-12';
        break;
    case 'columns2':
        $class = 'col-xs-12 col-sm-6';
        break;
    case 'columns3':
        $class = 'col-xs-12 col-sm-4';
        break;
    case 'columns4':
        $class = 'col-xs-12 col-sm-3';
        break;
    case 'columns5':
        $class = 'col-xs-12 col-sm-1-5';
        break;
    case 'columns6':
        $class = 'col-xs-12 col-sm-2';
        break;
    default:
        $class = 'col-xs-12 col-sm-4';
        break;
}
//get id product
$productID = get_the_ID();
$product = new WC_Product($productID);
// get time deal product
$date_sale = get_post_meta( $productID, '_sale_price_dates_to', true );
?>
<?php
if($date_sale > time()){
    $deals[] = $product;
    $total = count($deals);?>
    <li <?php post_class($class.' product '); ?>>
        <div class="wrapper-top-product">
            <?php do_action('woocommerce_before_shop_loop_item'); ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php
                /**
                 * ri_everest_woocommerce_show_product_loop_sale_flash hook custom
                 */
                do_action('ri_everest_woocommerce_show_product_loop_sale_flash');
                echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), $atts['products_img_size']);
                ?>
            </a>
        </div>
        <div class="product-info">
            <div class="deal-countdown clearfix" data-countdown="countdown"
                 data-date="<?php echo date('m',$date_sale).'-'.date('d',$date_sale).'-'.date('Y',$date_sale).'-'. date('H',$date_sale) . '-' . date('i',$date_sale) . '-' .  date('s',$date_sale) ; ?>">
            </div>
            <h3 class="product-name"><a href="<?php the_permalink(); ?>"
                                        title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
            <div class="other-info">
                <?php
                /**
                 * woocommerce_after_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
                do_action('woocommerce_after_shop_loop_item_title');
                ?>
            </div>
        </div>
    </li>
<?php }?>
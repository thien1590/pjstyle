<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 19-Feb-16
 * Time: 4:17 PM
 */

$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'paged' => 1
);
$deals_product =  new WP_Query($args);
?>
<div class="wrapper-products-shortcode rit-product-deal <?php echo esc_attr($atts['element_custom_class'] . ' ' . $atts['product_style']) ?>"
<?php if(isset($atts['padding_bottom_module']) && $atts['padding_bottom_module']!=''){?>
    style="padding-bottom:<?php echo esc_attr($atts['padding_bottom_module'])?>"
    <?php }?>>
    <?php if (isset($atts['title']) && $atts['title'] != ''):?>
        <h3 class="title"><span>
            <?php if(isset($atts['class_icon_block']) && $atts['class_icon_block'] != ''){?>
                <i class="<?php echo esc_attr($atts['class_icon_block']);?>"></i>
            <?php } echo esc_html($atts['title']);?>
            </span></h3>
        <?php
    endif;
if ($deals_product->have_posts()):
    //config shortcode layout product on the deal
    $item=4;
    $class='';
    switch ($atts['column']) {
        case 'columns1':
            $item = 1;
            break;
        case 'columns2':
            $item = 2;
            break;
        case 'columns3':
            $item = 3;
            break;
        case 'columns4':
            $item = 4;
            break;
        case 'columns5':
            $item = 5;
            break;
        case 'columns6':
            $item = 6;
            break;
        default:
            $item = 3;
            break;
    }
    $carousel_style=$atts['carousel_style'];
    if(($carousel_style == 'true') && !empty($carousel_style)){
    $owlCarousel = 'owlCarousel';
    $class='products-carousel-list';
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery(".rit-product-deal<?php if($atts['element_custom_class']!='') echo '.'.$atts['element_custom_class'].' ';?> .products-carousel-list").owlCarousel({
                // Most important owl features
                items: '<?php echo esc_js($item) ?>',
                itemsCustom: false,
                itemsDesktop: [1199, <?php echo esc_js($item); ?>],
                itemsDesktopSmall: [980, <?php if($item>1) { echo esc_js($item-1); }else{echo 2;} ?>],
                itemsTablet: [768, <?php if($item>2) { echo esc_js($item-2); }else{echo 2;} ?>],
                itemsTabletSmall: false,
                itemsMobile: [479, 1],
                singleItem: false,
                itemsScaleUp: false,
                // Navigation
                pagination:false,
                navigation: true,
                <?php if($atts['product_style']=='product_style_3'||$atts['product_style']=='product_style_4'){?>
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                <?php }else{?>
                navigationText: ['<span class="custom-arrow-left custom-arrow"></span>', '<span class="custom-arrow custom-arrow-right"></span>'],
                <?php }?>
                rewindNav: true,
                scrollPerPage: false
            })
        });
    </script>
<?php }?>
    <!-- Wrapper for slides -->
    <div class="<?php echo esc_attr($owlCarousel) ?> row">
        <ul class="rit-products clearfix grid-layout <?php echo esc_attr($class); ?>">
            <?php
            $deals="";
            // Start.loop
            while ( $deals_product->have_posts() ) : $deals_product->the_post();
                echo rit_get_template_part('woocommerce-item/deal', 'item', array('atts' => $atts));
            endwhile;
            //End.loop
            ?>
        </ul>
    </div>
<?php endif;?>
</div>
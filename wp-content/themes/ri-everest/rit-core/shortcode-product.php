<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     2.0.1
 * @author      CleverSoft
 * @link        http://cleversoft.co
 * @copyright   Copyright (c) 2015 CleverSoft
 * @license     GPL v2
 */

$owlCarousel = $class = $wrappclass = '';
if ($atts['products_type'] == 'products_list') {
    $class .= 'list-layout';
} elseif ($atts['products_type'] == 'products_grid') {
    $class .= 'grid-layout';
    $wrappclass = 'new-products';
}
$item = 1;
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
$varid = mt_rand();
if ($atts['products_type'] == 'products_carousel') {
    add_action('wp_footer', 'products_carousel_script');
    $wrappclass = 'new-products';
    $class .= $atts['products_carousel_style'] . '-layout';
    $owlCarousel = 'owlCarousel';
    if ($atts['product_slider_pagination'] == 1) {
        $owlCarousel .= ' rit-slider-pagination';
    }
    $class .= ' products-carousel-list';
    $itemwrapp = 1;
    if ($atts['products_carousel_style'] == 'list') {
        $itemwrapp = $item;
        $item = 1;
    }
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery("<?php if ($atts['element_custom_class'] != '') echo '.' . $atts['element_custom_class'] . ' ';?> .rit-products-wrap_<?php echo esc_attr($varid); ?> .products-carousel-list").owlCarousel({
                // Most important owl features
                items: '<?php echo esc_js($item) ?>',
                itemsCustom: false,
                itemsDesktop: [1199, <?php echo esc_js($item); ?>],
                itemsDesktopSmall: [980, <?php if ($item > 1) {
                    echo esc_js($item - 1);
                } else {
                    echo 2;
                } ?>],
                itemsTablet: [768, <?php if ($item > 2) {
                    echo esc_js(2);
                } else {
                    echo 2;
                } ?>],
                itemsTabletSmall: false,
                itemsMobile: [479, 1],
                singleItem: false,
                itemsScaleUp: false,
                // Navigation
                pagination: <?php if ($atts['product_slider_pagination'] == 1) {
                echo 'true';
            } else {
                echo 'false';
            }?>,
                navigation: <?php if ($atts['product_slider_nav'] == 1) {
                echo 'true';
            } else {
                echo 'false';
            }?>,
                <?php if($atts['product_style'] == 'product_style_3' || $atts['product_style'] == 'product_style_4'){?>
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                <?php }else{?>
                navigationText: ['<i class="clever-icon-line-triangle fa-rotate-180"></i>', '<i class="clever-icon-line-triangle"></i>'],
                <?php }?>
                rewindNav: true,
                scrollPerPage: false
            })
        });
    </script>
    <?php
}

?>
<div
    class="wrapper-products-shortcode <?php echo esc_attr($atts['element_custom_class'] . ' ' . $atts['product_style'] . ' ' . $wrappclass) ?>"
    style="padding-bottom:<?php echo esc_attr($atts['padding_bottom_module']) ?>">
    <?php if (isset($atts['title']) && $atts['title'] != '') { ?>
        <h3 class="title"><span>
            <?php if (isset($atts['class_icon_block']) && $atts['class_icon_block'] != '') { ?>
                <i class="<?php echo esc_attr($atts['class_icon_block']) ?>"></i>
            <?php }
            echo esc_html($atts['title']); ?>
            </span></h3>
        <?php
    }
    ?>
    <div class="rit-products-wrap rit-products-wrap_<?php echo esc_attr($varid); ?>">
        <?php
        if (!isset($_POST['show'])) {
            echo '<input name="rit-filter-page-baseurl" type="hidden" value="' . rit_current_url() . '">';
            $init_atts = $atts;
            unset($init_atts['wc_attr']);
            echo '<script type="text/javascript">var data_' . $varid . ' = jQuery.parseJSON(\'' . json_encode($init_atts) . '\')</script>';
        } else {
            echo '<script type="text/javascript">var data_' . $varid . ' = jQuery.parseJSON(\'' . json_encode($_POST) . '\')</script>';
        }
        if ($atts['show_filter']) {
            echo '<div class="rit-product-filter">';
            echo rit_get_template_part('woocommerce-item/filter', 'block', array('atts' => $atts, 'varid' => $varid));
            echo '</div>';
        }
        $product_query = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $atts['wc_attr']));
        $product_query->query($atts['wc_attr']);
        remove_filter('posts_clauses', array('WC_Shortcodes', 'order_by_rating_post_clauses'));
        ?>
        <div class="<?php echo esc_attr($owlCarousel) ?> row">
            <ul class="rit-products clearfix <?php echo esc_attr($class) ?>">
                <?php
                $i = 0;
                while ($product_query->have_posts()) {
                    $product_query->the_post();
                    $i++;
                    if ($atts['products_carousel_style'] == 'list' && $atts['products_type'] == 'products_carousel') {
                        if ($i == 1) {
                            echo '<div class="product-carousel-list-item">';
                        }
                    }
                    global $product;
                    ?>
                    <?php
                    if ($atts['products_type'] == 'products_list') {
                        echo rit_get_template_part('woocommerce-item/list', 'item', array('atts' => $atts));
                    } elseif ($atts['products_type'] == 'products_grid') {
                        echo rit_get_template_part('woocommerce-item/grid', 'item', array('atts' => $atts));
                    } else {
                        echo rit_get_template_part('woocommerce-item/' . $atts['products_carousel_style'], 'item', array('atts' => $atts));
                    }
                    ?>
                    <?php
                    if ($atts['products_carousel_style'] == 'list' && $atts['products_type'] == 'products_carousel') {
                        if ($i == $itemwrapp) {
                            echo '</div>';
                            $i = 0;
                        }
                    }
                    if ($atts['products_type'] == 'products_grid' && ($i % $item) == 0) {
                        echo '<div class="clearfix"></div>';
                    }
                }
                ?>
            </ul>
        </div>
        <?php if ($atts['show_loadmore']): ?>
            <script type="text/javascript">
                var max_num_pages_<?php echo esc_js($varid); ?> = <?php echo esc_js($product_query->max_num_pages);?>;
            </script>
        <?php endif; ?>
        <?php
        if (!isset($_POST['ajax'])):
            if ($atts['show_loadmore'] && $product_query->max_num_pages > $atts['wc_attr']['paged']):
                echo '<a class="rit_ajax_load_more_button">' . esc_html__('Load more', 'ri-everest') . '</a>';

                ?>
                <script type="text/javascript">

                    jQuery(document).ready(function ($) {
                        if (typeof filter_links_<?php echo esc_js($varid); ?> == 'undefined') {

                            var wrap = $('.rit-products-wrap_<?php echo esc_js($varid); ?>');

                            var rit_ajax_load_more_button = wrap.find('.rit_ajax_load_more_button');

                            var data = data_<?php echo esc_js($varid);?>;

                            rit_ajax_load_more_button.click(function (e) {
                                e.preventDefault();

                                if (data['paged'] < max_num_pages_<?php echo esc_js($varid); ?>) {

                                    data['action'] = 'rit_ajax_product_filter';

                                    data['paged'] = parseInt(data['paged']) + parseInt(1);
                                    data_<?php echo esc_js($varid);?> = data;
                                    $.ajax({
                                        url: '<?php echo admin_url('admin-ajax.php')?>',
                                        data: data,
                                        type: 'POST',
                                    }).success(function (response) {
                                        wrap('.products').append($(response).find('.products').html());
                                        if (max_num_pages_<?php echo esc_js($varid); ?> == data['paged']) {
                                            wrap('.rit_ajax_load_more_button').hide();
                                        } else {
                                            wrap('.rit_ajax_load_more_button').show();
                                        }
                                    })
                                }

                            });
                        }
                    });


                </script>
            <?php endif; ?>
        <?php endif; ?>
        <?php
        wp_reset_postdata();
        wp_reset_query();
        ?>
    </div>
</div>
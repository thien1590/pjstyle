<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     2.0.2
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2015 Zootemplate
 * @license     GPL v2
 */
if(!isset($_POST['show'])){
    echo '<input name="rit-filter-page-baseurl" type="hidden" value="'.rit_current_url().'">';
}
$varid = mt_rand();
?>
<div class="rit-products-wrap rit-products-wrap_<?php echo $varid; ?>" >
<?php

    if($atts['show_filter']){
        //list category

        if($atts['filter_categories'] != ''){
            $product_categories = explode(',', $atts['filter_categories'] );
            echo '<ul class="rit-ajax-load rit-list-product-category">';
            foreach ($product_categories as $product_cat_slug)
            {
                $product_cat = get_term_by( 'slug',$product_cat_slug, 'product_cat' );
                $selected = '';
                if(isset($atts['wc_attr']['product_cat'] ) && $atts['wc_attr']['product_cat'] == $product_cat->slug ){
                    $selected = 'rit-selected';
                }
                echo '<li><a class="'. esc_attr($selected) .'"
                            data-type="product_cat" data-value="'.esc_attr($product_cat->slug).'"
                            href="' . esc_url(get_term_link( $product_cat->slug, 'product_cat' )) . '"
                            title="' . esc_attr($product_cat->name) . '">' . esc_html($product_cat->name) . '</a></li>';

            }

            echo '</ul>';
        }
        //end of list category


        //list tags
        if($atts['filter_tags'] != ''){
            $product_tags = explode(',', $atts['filter_tags'] );
            echo '<ul class="rit-ajax-load rit-list-product-tag">';
            foreach ($product_tags as $product_tag_slug)
            {
                $selected = '';
                $product_tag = get_term_by( 'slug',$product_tag_slug, 'product_tag' );
                if(isset($atts['wc_attr']['product_tag']) && $atts['wc_attr']['product_tag'] == $product_tag->slug){
                    $selected = 'rit-selected';
                }
                echo '<li><a class="'. esc_attr($selected) .'"
                            data-type="product_tag"
                            data-value="'.esc_attr($product_tag->slug).'"
                            title="' . esc_attr($product_tag->name) . '">' . esc_html($product_tag->name) . '</a></li>';

            }

            echo '</ul>';
        }
        //end if list tag


        //list featured filter
        if($atts['show_featured_filter']){
            $filter_arrs = array(
                esc_html__('All', RIT_TEXT_DOMAIN) => 'all',
                esc_html__('Featured product', RIT_TEXT_DOMAIN) => 'featured',
                esc_html__('Onsale product', RIT_TEXT_DOMAIN) => 'onsale',
                esc_html__('Best Selling', RIT_TEXT_DOMAIN) => 'best-selling',
                esc_html__('Latest product', RIT_TEXT_DOMAIN) => 'latest',
                esc_html__('Top rate product', RIT_TEXT_DOMAIN) => 'toprate ',
                esc_html__('Sort by price: low to high', RIT_TEXT_DOMAIN) => 'price',
                esc_html__('Sort by price: high to low', RIT_TEXT_DOMAIN) => 'price-desc',
            );

            echo '<ul class="rit-ajax-load rit-list-filter">';
            foreach ($filter_arrs as $key => $value)
            {
                $selected = '';
                if(isset($atts['show']) &&  $atts['show'] == $value){
                    $selected = 'rit-selected';
                }
                echo '<li><a  class="'. esc_attr($selected) .'"
                            data-type="show"
                            data-value="'.esc_attr($value).'"
                            href="" title="'.esc_attr($key).'">' . esc_html($key) . '</a></li>';

            }
            echo '</ul>';
        }
        //end list tags


        //Filter price
        if($atts['show_price_filter'] && intval($atts['price_filter_level']) > 0){
            echo '<ul class="rit-ajax-load rit-price-filter">';

            $price_format = get_woocommerce_price_format();
            $price_currency = get_woocommerce_currency();

            for ($i = 1; $i <= intval($atts['price_filter_level']); $i++)
            {
                $min = ($i - 1)*intval($atts['price_filter_range']);
                $max = $i*intval($atts['price_filter_range']);

                $min_price = sprintf( $price_format, wc_format_decimal( $min, 2 ), $price_currency );
                $max_price = sprintf( $price_format, wc_format_decimal( $max, 2 ), $price_currency );

                $price_text = $min_price . ' - ' .$max_price;
                if($i == intval($atts['price_filter_level'])){
                    $price_text = $min_price.'+';
                }

                $selected = '';
                $removed = '';
                if(isset($_POST['price_filter']) &&  $_POST['price_filter'] == $i){
                    $selected = 'rit-selected';
                    $removed  = '<span data-type="rit-remove-price" class="rit-remove-attribute"><i class="fa fa-times"></i></span>';
                }
                echo '<li>'.$removed.'<a  class="'. esc_attr($selected) .'"
                            data-type="price_filter"
                            data-value="'.esc_attr($i).'"
                            href="" title="'.esc_attr($key).'">' . esc_html($price_text) . '</a></li>';

            }
            echo '</ul>';
        }

        //End filter price



        //list product_attributes
        if($atts['filter_attributes'] != ''){
            $product_attribute_taxonomies = explode(',', $atts['filter_attributes'] );


            if(count($product_attribute_taxonomies) > 0){
                foreach ($product_attribute_taxonomies as $product_attribute_taxonomie_slug) {

                    global $wpdb;

                    $attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies where attribute_name='".$product_attribute_taxonomie_slug."'" );

                    if(isset($attribute_taxonomies[0])){
                        $product_attribute_taxonomie = $attribute_taxonomies[0];
                        //$product_terms = get_terms( 'pa_'.$product_attribute_taxonomie->attribute_name, 'hide_empty=0' );
                        $product_terms = get_terms( 'pa_'.$product_attribute_taxonomie->attribute_name);

                        if(count($product_terms) > 0){
                            echo '<h3>'.esc_html($product_attribute_taxonomie->attribute_label).'</h3>';
                            echo '<ul class="rit-ajax-load rit-product-attribute-filter">';
                            foreach ($product_terms as $product_term) {

                                $selected = '';
                                $removed = '';
                                if(isset($atts['wc_attr']['tax_query']) && count($atts['wc_attr']['tax_query']) > 0){
                                    foreach ($atts['wc_attr']['tax_query'] as $tax_query) {
                                        if($tax_query['taxonomy'] == $product_term->taxonomy && $tax_query['terms'] == $product_term->slug ){
                                            $selected = 'rit-selected';
                                            $removed  = '<span data-type="rit-remove-attr" class="rit-remove-attribute"><i class="fa fa-times"></i></span>';
                                        }
                                    }

                                }
                                echo '<li>' . $removed . '<a class="rit-product-attribute '. esc_attr($selected) .'"
                                            data-type="product_attribute"
                                            data-attribute_value="'.esc_attr($product_term->slug).'"
                                            data-value="'.esc_attr($product_term->taxonomy).'"
                                            title="'.esc_attr($product_term->name).'">' . esc_html($product_term->name) . '</a></li>';
                            }
                            echo '</ul>';
                        }
                    }
                }
            }
        }
        //end list product_attributes


        //reset filter
        echo '<div class="rit-ajax-load"><a data-type="rit-reset-filter" href="'.rit_current_url().'">'.esc_html__('Reset Filter', RIT_TEXT_DOMAIN).'</a></div>';
        //end reset filter

        //shortcode agurgument
        if(!isset($_POST['show'])){
            $init_atts = $atts;
            unset($init_atts['wc_attr']);

            echo '<script type="text/javascript">var data_'.$varid.' = jQuery.parseJSON(\''.json_encode($init_atts).'\')</script>';
        }else{
            echo '<script type="text/javascript">var data_'.$varid.' = jQuery.parseJSON(\''.json_encode($_POST).'\')</script>';
        }
        ?>

        <script type="text/javascript">
            jQuery(document).ready(function($){
                function rit_ajax_filter(){
                    if(typeof filter_links == 'undefined'){

                        var filter_links = $('.rit-ajax-load a, .rit-remove-attribute');

                        filter_links.click(function(e) {
                            e.preventDefault();


                            var $this = $(this);
                            var link  = $this.attr('href');
                            var title = $this.attr('title');

                            data['action'] = 'rit_ajax_product_filter';


                            if($this.hasClass('rit-product-attribute')){
                                if(typeof data['product_attribute'] == 'object'){
                                    data['product_attribute'].push($this.data('value'));

                                    data['attribute_value'].push( $this.data('attribute_value'));
                                }else{
                                    data['product_attribute'] = [];
                                    data['product_attribute'].push($this.data('value'));

                                    data['attribute_value'] = [];
                                    data['attribute_value'].push( $this.data('attribute_value'));
                                }

                            }else {

                                data[$this.data('type')] = $this.data('value');

                            }

                            data['paged'] = 1;

                            if($this.data('type') == 'product_cat'){
                                data['product_attribute'] = [];
                                data['attribute_value'] = [];
                                data['product_tag'] = '';
                                data['show'] = '';
                            }

                            if($this.data('type') == 'rit-reset-filter'){
                                data['product_attribute'] = [];
                                data['attribute_value'] = [];
                                data['product_tag'] = '';
                                data['product_cat'] = '<?php echo $atts['filter_categories']; ?>';
                                data['show'] = '';
                                data['price_filter'] = 0;
                            }

                            if($this.data('type') == 'rit-remove-attr'){
                                var product_attribute = $this.next().data('value');
                                var attribute_value = $this.next().data('attribute_value');


                                var index = data['attribute_value'].indexOf(attribute_value);
                                if (index > -1) {
                                    data['attribute_value'].splice(index, 1);
                                    data['product_attribute'].splice(index, 1);
                                }
                            }

                            if($this.data('type') == 'rit-remove-price'){
                                data['price_filter'] = 0;
                            }

                            $.ajax({
                                url: '<?php echo  admin_url( 'admin-ajax.php')?>',
                                data: data,
                                type: 'POST',
                            }).success(function(response){


                                if($this.data('type') == 'rit-reset-filter'){
                                    link = $('input[name="rit-filter-page-baseurl"]').val();

                                    window.history.pushState(null, title, link);
                                }else{
                                    if(link != ''){
                                        window.history.pushState(null, title, link);
                                    }
                                }

                                $('.rit-products-wrap').html($(response).html());

                                if(max_num_pages == data['paged']){
                                    $('.rit_ajax_load_more_button').hide();
                                }else{
                                    $('.rit_ajax_load_more_button').show();
                                }
                            })
                        })
                    }
                }

                rit_ajax_filter();
            }(jQuery));

        </script>
        <?php
    }

    $owlCarousel = '';
    $class = ''; ?>
    <div class="rit-wrapper-products-shortcode"  style="padding-bottom:<?php echo esc_attr($atts['padding_bottom_module']) ?>">
        <?php


        if ($atts['products_type'] == 'products_list') {
            $class .= 'list-layout';
        } else {
            $class .= 'grid-layout';
        }
        if ($atts['products_type'] == 'products_carousel') {
            add_action('wp_footer', 'products_carousel_script');
            $owlCarousel = 'owlCarousel';
            $class .= ' products-carousel-list';
            $item;
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
                    $item = 4;
                    break;
            }
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery(".products-carousel-list").owlCarousel({
                        // Most important owl features
                        items: '<?php echo esc_js($item) ?>',
                        itemsCustom: false,
                        itemsDesktop: [1199, <?php echo esc_js($item); ?>],
                        itemsDesktopSmall: [980, <?php if($item>1) { echo esc_js($item-1); }else{echo 1;} ?>],
                        itemsTablet: [768, <?php if($item>2) { echo esc_js($item-2); }else{echo 1;} ?>],
                        itemsTabletSmall: false,
                        itemsMobile: [479, 1],
                        singleItem: false,
                        itemsScaleUp: false,
                        // Navigation
                        pagination: false,
                        navigation: true,
                        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                        rewindNav: true,
                        scrollPerPage: false
                    });
                });
            </script>
            <?php
        }
        if(isset($atts['element_custom_class']))
        $class .= ' ' . $atts['element_custom_class'];

        $product_query = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $atts['wc_attr']));

        $product_query->query($atts['wc_attr']);

        remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
        ?>

        <?php if (isset($atts['title'])&& $atts['title']!='')
            echo '<h3 class="title"><span>' . esc_html($atts['title']) . '</span></h3>';
        ?>
        <div class="<?php echo esc_attr($owlCarousel) ?>">
            <ul class="products clearfix <?php echo esc_attr($class) ?>">
                <?php while ($product_query->have_posts()) {
                    $product_query->the_post();
                    global $product;
                    ?>
                    <?php
                    if ($atts['products_type'] == 'products_list') {
                        echo rit_get_template_part('woocommerce-item/list', 'item', array('atts' => $atts));
                    } else {
                        echo rit_get_template_part('woocommerce-item/grid', 'item', array('atts' => $atts));
                    }
                    ?>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php if($atts['show_loadmore']):?>
            <script type="text/javascript">
                var max_num_pages_<?php echo $varid; ?> = <?php echo esc_js($product_query->max_num_pages);?>;
            </script>
        <?php endif; ?>
    </div>
    <?php
    if(!isset($_POST['ajax'])):
        if($atts['show_loadmore'] && $product_query->max_num_pages > $atts['wc_attr']['paged']):
            echo '<a class="rit_ajax_load_more_button">'.esc_html__('Load more', RIT_TEXT_DOMAIN).'</a>';

            ?>
            <script type="text/javascript">

                jQuery(document).ready(function ($) {
                    if(typeof filter_links_<?php echo $varid; ?> == 'undefined'){

                        var wrap = $('.rit-products-wrap_<?php echo $varid; ?>');

                        var rit_ajax_load_more_button = wrap.find('.rit_ajax_load_more_button');

                        var data = data_<?php echo $varid;?>;

                        rit_ajax_load_more_button.click(function(e){


                            e.preventDefault();

                            if(data['paged'] < max_num_pages_<?php echo $varid; ?>){

                                data['action'] = 'rit_ajax_product_filter';

                                data['paged'] = parseInt(data['paged'])+parseInt(1);

                                data_<?php echo $varid;?> = data;

                                $.ajax({
                                    url: '<?php echo  admin_url( 'admin-ajax.php')?>',
                                    data: data,
                                    type: 'POST',
                                }).success(function(response){

                                    wrap.find('.products').append($(response).find('.products').html());

                                    if(max_num_pages_<?php echo $varid; ?> == data['paged']){
                                        wrap.find('.rit_ajax_load_more_button').hide();
                                    }else{
                                        wrap.find('.rit_ajax_load_more_button').show();
                                    }
                                })
                            }

                        });
                    }
                });


            </script>
        <?php endif;?>
    <?php endif;?>
<?php
wp_reset_postdata();
wp_reset_query();
?>
</div>
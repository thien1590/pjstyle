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
//list category
if ($atts['filter_categories'] != '' && $atts['show_cat_filter']!='0') {
    $product_categories = explode(',', $atts['filter_categories']);
    echo '<ul class="rit-ajax-load rit-list-product-category">';
    echo '<li class="active"><a title="'.esc_attr__('All','ri-everest').'" href="#" data-value="all" data-type="product_cat">'.esc_html__('All','ri-everest').'</a></li>';
    foreach ($product_categories as $product_cat_slug) {
        $product_cat = get_term_by('slug', $product_cat_slug, 'product_cat');
        $selected = '';
        if (isset($atts['wc_attr']['product_cat']) && $atts['wc_attr']['product_cat'] == $product_cat->slug) {
            $selected = 'rit-selected';
        }
        echo '<li><a class="' . esc_attr($selected) . '"
                            data-type="product_cat" data-value="' . esc_attr($product_cat->slug) . '"
                            href="' . esc_url(get_term_link($product_cat->slug, 'product_cat')) . '"
                            title="' . esc_attr($product_cat->name) . '">' . esc_html($product_cat->name) . '</a></li>';
    }
    echo '</ul>';
}
//end of list category
//list tags
if ($atts['filter_tags'] != '' && $atts['show_tags_filter']!='0') {
    $product_tags = explode(',', $atts['filter_tags']);
    echo '<ul class="rit-ajax-load rit-list-product-tag">';
    foreach ($product_tags as $product_tag_slug) {
        $selected = '';
        $product_tag = get_term_by('slug', $product_tag_slug, 'product_tag');
        if (isset($atts['wc_attr']['product_tag']) && $atts['wc_attr']['product_tag'] == $product_tag->slug) {
            $selected = 'rit-selected';
        }
        echo '<li><a class="' . esc_attr($selected) . '"
                            data-type="product_tag"
                            data-value="' . esc_attr($product_tag->slug) . '"
                            title="' . esc_attr($product_tag->name) . '">' . esc_html($product_tag->name) . '</a></li>';
    }
    echo '</ul>';
}
//end if list tag


//list featured filter
if ($atts['show_featured_filter']) {
    $filter_arrs = array(
        esc_html__('All', 'ri-everest') => 'all',
        esc_html__('Featured product', 'ri-everest') => 'featured',
        esc_html__('Onsale product', 'ri-everest') => 'onsale',
        esc_html__('Best Selling', 'ri-everest') => 'best-selling',
        esc_html__('Latest product', 'ri-everest') => 'latest',
        esc_html__('Top rate product', 'ri-everest') => 'toprate ',
        esc_html__('Sort by price: low to high', 'ri-everest') => 'price',
        esc_html__('Sort by price: high to low', 'ri-everest') => 'price-desc',
    );
    echo '<ul class="rit-ajax-load rit-list-filter">';
    foreach ($filter_arrs as $key => $value) {
        $selected = '';
        if (isset($atts['show']) && $atts['show'] == $value) {
            $selected = 'rit-selected';
        }
        echo '<li><a  class="' . esc_attr($selected) . '"
                            data-type="show"
                            data-value="' . esc_attr($value) . '"
                            href="" title="' . esc_attr($key) . '">' . esc_html($key) . '</a></li>';
    }
    echo '</ul>';
}
//end list tags
//Filter price
if ($atts['show_price_filter'] && intval($atts['price_filter_level']) > 0) {
    echo '<ul class="rit-ajax-load rit-price-filter">';

    $price_format = get_woocommerce_price_format();
    $price_currency = get_woocommerce_currency();

    for ($i = 1; $i <= intval($atts['price_filter_level']); $i++) {
        $min = ($i - 1) * intval($atts['price_filter_range']);
        $max = $i * intval($atts['price_filter_range']);

        $min_price = sprintf($price_format, wc_format_decimal($min, 2), $price_currency);
        $max_price = sprintf($price_format, wc_format_decimal($max, 2), $price_currency);

        $price_text = $min_price . ' - ' . $max_price;
        if ($i == intval($atts['price_filter_level'])) {
            $price_text = $min_price . '+';
        }

        $selected = '';
        $removed = '';
        if (isset($_POST['price_filter']) && $_POST['price_filter'] == $i) {
            $selected = 'rit-selected';
            $removed = '<span data-type="rit-remove-price" class="rit-remove-attribute"><i class="fa fa-times"></i></span>';
        }
        echo '<li>' . $removed . '<a  class="' . esc_attr($selected) . '"
                            data-type="price_filter"
                            data-value="' . esc_attr($i) . '"
                            href="" title="' . esc_attr($key) . '">' . esc_html($price_text) . '</a></li>';

    }
    echo '</ul>';
}
//End filter price
//list product_attributes
if ($atts['filter_attributes'] != '' && $atts['show_attributes_filter']!='0') {
    $product_attribute_taxonomies = explode(',', $atts['filter_attributes']);
    if (count($product_attribute_taxonomies) > 0) {
        foreach ($product_attribute_taxonomies as $product_attribute_taxonomie_slug) {
            global $wpdb;
            $attribute_taxonomies = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies where attribute_name='" . $product_attribute_taxonomie_slug . "'");
            if (isset($attribute_taxonomies[0])) {
                $product_attribute_taxonomie = $attribute_taxonomies[0];
                //$product_terms = get_terms( 'pa_'.$product_attribute_taxonomie->attribute_name, 'hide_empty=0' );
                $product_terms = get_terms('pa_' . $product_attribute_taxonomie->attribute_name);
                if (count($product_terms) > 0) {
                    echo '<h3>' . esc_html($product_attribute_taxonomie->attribute_label) . '</h3>';
                    echo '<ul class="rit-ajax-load rit-product-attribute-filter">';
                    foreach ($product_terms as $product_term) {
                        $selected = '';
                        $removed = '';
                        if (isset($atts['wc_attr']['tax_query']) && count($atts['wc_attr']['tax_query']) > 0) {
                            foreach ($atts['wc_attr']['tax_query'] as $tax_query) {
                                if ($tax_query['taxonomy'] == $product_term->taxonomy && $tax_query['terms'] == $product_term->slug) {
                                    $selected = 'rit-selected';
                                    $removed = '<span data-type="rit-remove-attr" class="rit-remove-attribute"><i class="fa fa-times"></i></span>';
                                }
                            }

                        }
                        echo '<li>' . $removed . '<a class="rit-product-attribute ' . esc_attr($selected) . '"
                                            data-type="product_attribute"
                                            data-attribute_value="' . esc_attr($product_term->slug) . '"
                                            data-value="' . esc_attr($product_term->taxonomy) . '"
                                            title="' . esc_attr($product_term->name) . '">' . esc_html($product_term->name) . '</a></li>';
                    }
                    echo '</ul>';
                }
            }
        }
    }
}
//end list product_attributes
//reset filter
if($atts['show_reset_filter']=='1'){
    echo '<div class="rit-ajax-load reset-filter"><a data-type="rit-reset-filter" href="' . rit_current_url() . '">' . esc_html__('Reset Filter', 'ri-everest') . '</a></div>';
}
//end reset filter
//shortcode agurgument
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
            function rit_ajax_filter_<?php echo esc_js($varid); ?>(){
                if(typeof filter_links_<?php echo esc_js($varid); ?> == 'undefined'){

                    var wrap = $('.rit-products-wrap_<?php echo esc_js($varid); ?>');

                    var filter_links_<?php echo esc_js($varid); ?> = wrap.find('.rit-ajax-load a, .rit-remove-attribute');

                    var data = data_<?php echo  esc_js($varid);?>;
                    filter_links_<?php echo esc_js($varid); ?>.click(function(e) {

                    e.preventDefault();
                    var $this = $(this);
                    $this.parents('.rit-products-wrap').addClass('loading');
                    $this.parents('ul.rit-ajax-load').find('.active').removeClass('active');
                    $(this).parent('li').addClass('active');
                    var link = $this.attr('href');
                    var title = $this.attr('title');
                    data['action'] = 'rit_ajax_product_filter';
                    if ($this.hasClass('rit-product-attribute')) {
                        if (typeof data['product_attribute'] == 'object') {
                            data['product_attribute'].push($this.data('value'));

                            data['attribute_value'].push($this.data('attribute_value'));
                        } else {
                            data['product_attribute'] = [];
                            data['product_attribute'].push($this.data('value'));

                            data['attribute_value'] = [];
                            data['attribute_value'].push($this.data('attribute_value'));
                        }

                    } else {

                        data[$this.data('type')] = $this.data('value');

                    }

                    data['paged'] = 1;

                    if ($this.data('type') == 'product_cat' ) {
                        data['product_attribute'] = [];
                        data['attribute_value'] = [];
                        data['product_tag'] = '';
                        data['show'] = '';
                    }

                    if ($this.data('type') == 'rit-reset-filter' || $this.data('value')=='all') {
                        data['product_attribute'] = [];
                        data['attribute_value'] = [];
                        data['product_tag'] = '';
                        data['product_cat'] = '<?php echo esc_js($atts['filter_categories']); ?>';
                        data['show'] = '';
                        data['price_filter'] = 0;
                    }

                    if ($this.data('type') == 'rit-remove-attr') {
                        var product_attribute = $this.next().data('value');
                        var attribute_value = $this.next().data('attribute_value');
                        var index = data['attribute_value'].indexOf(attribute_value);
                        if (index > -1) {
                            data['attribute_value'].splice(index, 1);
                            data['product_attribute'].splice(index, 1);
                        }
                    }

                    if ($this.data('type') == 'rit-remove-price') {
                        data['price_filter'] = 0;
                    }
                    data_<?php echo esc_js($varid);?> = data;
                    $.ajax({
                        url: '<?php echo  admin_url( 'admin-ajax.php')?>',
                        data: data,
                        type: 'POST',
                    }).success(function (response) {
                        if ($this.data('type') == 'rit-reset-filter') {
                            link = $('input[name="rit-filter-page-baseurl"]').val();
                        }
                        wrap.find('.rit-products').html($(response).find('.rit-products').html());
                        if(typeof  max_num_pages_<?php echo esc_js($varid); ?> !='undefined') {
                            if (max_num_pages_<?php echo esc_js($varid); ?> == data['paged']) {
                                wrap.find('.rit_ajax_load_more_button').hide();
                            } else {
                                wrap.find('.rit_ajax_load_more_button').show();
                            }
                        }
                        wrap.removeClass('loading');
                    })
                })
            }
        }

        rit_ajax_filter_<?php echo esc_js($varid); ?>();
    }(jQuery));
</script>
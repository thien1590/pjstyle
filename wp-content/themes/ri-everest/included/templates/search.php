<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 12-Jan-16
 * Time: 9:14 AM
 */ ?>
<div class="search-header">
    <form role="search" method="get" id="top-searchform" action="<?php echo home_url(); ?>">
        <input type="text" value="<?php echo esc_attr(apply_filters('the_search_query', get_search_query())); ?>"
               placeholder="<?php echo esc_html__('Search for products...', 'ri-everest') ?>" class="ipt text"
               name="s" id="s"/>
        <?php
        if (class_exists('WooCommerce')) { ?>
            <input type="hidden" value="" name="product_cat" id="product_cat"/>
            <?php
        }
        ?>
    </form>
<?php
if (class_exists('WooCommerce')) {
    $args = array(
        'taxonomy' => 'product_cat',
        'orderby' => 'name',
        'show_count' => 0,
        'pad_counts' => 0,
        'hierarchical' => 1,
        'title_li' => '',
        'hide_empty' => 1
    );
    $all_categories = get_categories($args);
    if (!empty($all_categories)) {
        ?>
        <select id="list-cat-search">
            <option selected="selected" value="all"><?php echo esc_html__('All categories', 'ri-everest'); ?></option>
            <?php
            foreach ($all_categories as $cat) {
                if ($cat->category_parent == 0) {
                    $category_id = $cat->term_id;
                    echo '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
                    $args2 = array(
                        'taxonomy' => 'product_cat',
                        'child_of' => 0,
                        'parent' => $category_id,
                        'orderby' => 'name',
                        'show_count' => 0,
                        'pad_counts' => 0,
                        'hierarchical' => 1,
                        'title_li' => '',
                        'hide_empty' => 1
                    );
                    $sub_cats = get_categories($args2);
                    if ($sub_cats) {
                        foreach ($sub_cats as $sub_category) {
                            echo '<option value="' . $sub_category->slug . '">' . $sub_category->name . '</option>';
                        }
                    }
                }
            }
            ?>
        </select>
        <?php
    }
    ?>
    <script>
        (function ($) {
            'use strict';
            $(document).ready(function () {
                var cat;
                $('#list-cat-search').on('change', function () {
                    cat = $(this).find('option:selected').attr('value');
                    if (cat != 'all') {
                        $('#product_cat').attr('value', $(this).find('option:selected').attr('value'));
                    }
                })
            })
        })(jQuery)
    </script>
    <?php
}?>
</div>

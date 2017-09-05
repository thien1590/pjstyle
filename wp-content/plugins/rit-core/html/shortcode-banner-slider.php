<ul class="rit_banner_slider <?php echo  esc_attr($atts['el_class']) ?>">
    <?php

    $args = array(
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'posts_per_page' => $atts['posts_per_page'],
        'post_type' => 'banner');

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post();

            $banner_id = get_post_thumbnail_id();
            $banner = wp_get_attachment_image_src($banner_id, $atts['size'], true);
            $banner_alt = get_post_meta($banner_id, '_wp_attachment_image_alt', true);
            $banner_url = get_post_meta(get_the_ID(), 'rit_banner_url', true);
            $banner_class = get_post_meta(get_the_ID(), 'rit_banner_class', true);
            ?>
            <li class="banner_item <?php echo  esc_attr($banner_class); ?>" id="banner_item_<?php echo  esc_attr($banner_id); ?>">
                <a href="<?php echo esc_url($banner_url); ?>" target="<?php echo  esc_attr($atts['target']); ?>"><img
                        src="<?php echo esc_url($banner[0]); ?>" alt="<?php echo  esc_attr($banner_url); ?>"/></a>
            </li>
        <?php
        endwhile;
    endif;

    wp_reset_postdata();

    ?>
</ul>
<script type="text/javascript">
    jQuery(document).ready(function () {
        "use strict";
        jQuery('.<?php echo esc_js(($atts['el_class'] != '') ? $atts['el_class'] : 'rit_banner_slider') ?>').owlCarousel({

            autoPlay: <?php echo esc_js(($atts['auto'] != '') ? $atts['auto'] : 'false') ?>,
            items: <?php echo esc_js($atts['number'] != '' ? $atts['number'] : 2 ) ?>,
            stopOnHover: true,
            navigation: <?php echo esc_js(($atts['arrow'] != '') ? $atts['arrow'] : 'false') ?>,
            pagination: <?php echo esc_js(($atts['arrow'] != '') ? $atts['arrow'] : 'false') ?>,
            slideSpeed: <?php echo esc_js($atts['speed']) ?>

        });
    });
</script>
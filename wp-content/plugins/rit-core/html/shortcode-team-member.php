<ul class="rit_member_slider <?php echo  esc_attr($atts['el_class']) ?>">
    <?php

    $args = array(
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'posts_per_page' => $atts['posts_per_page'],
        'post_type' => 'member');

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post();

            $member_id = get_post_thumbnail_id();
            $member = wp_get_attachment_image_src($member_id, $atts['size'], true);
            $member_alt = get_post_meta($member_id, '_wp_attachment_image_alt', true);
            $member_url = get_post_meta(get_the_ID(), 'rit_member_url', true);
            $member_class = get_post_meta(get_the_ID(), 'rit_member_class', true);
            ?>
            <li class="member_item <?php echo  esc_attr($member_class); ?>" id="member_item_<?php echo  esc_attr($member_id); ?>">
                <a href="<?php echo esc_url($member_url); ?>" target="<?php echo  esc_attr($atts['target']); ?>"><img
                        src="<?php echo esc_url($member[0]); ?>" alt="<?php echo  esc_attr($member_url); ?>"/></a>
            </li>
            <?php
        endwhile;
    endif;

    wp_reset_postdata();

    ?>
</ul>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.<?php echo esc_js(($atts['el_class'] != '') ? $atts['el_class'] : 'rit_member_slider') ?>').owlCarousel({

            autoPlay: <?php echo esc_js(($atts['auto'] != '') ? $atts['auto'] : 'false') ?>,
            items: <?php echo esc_js($atts['number'] != '' ? $atts['number'] : 2 ) ?>,
            stopOnHover: true,
            navigation: <?php echo esc_js(($atts['arrow'] != '') ? $atts['arrow'] : 'false') ?>,
            pagination: <?php echo esc_js(($atts['arrow'] != '') ? $atts['arrow'] : 'false') ?>,
            slideSpeed: <?php echo esc_js($atts['speed']) ?>

        });
    });
</script>
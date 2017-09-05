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

$args = array(
    'post_type' => 'testimonial',
    'order_by' => $atts['order_by'],
    'posts_per_page' => ($atts['item_count'] > 0) ? $atts['item_count'] : get_option('posts_per_page'),
);
if ($atts['category']) {
    $catid=array();
    foreach(explode(',', $atts['category'])as $catslug){
        $catid[].=get_term_by('slug',$catslug,'testimonial_category')->term_id;
    }
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'testimonial_category',
            'field' => 'id',
            'terms' => $catid,
        )
    );
}
$background = '';
if ($atts['background'] != '') {
    $background = 'background:url(' . wp_get_attachment_image_url($atts['background'], 'full') . ') center center/cover no-repeat';
}
if ($atts['background_color'] != '') {
    ?>
    <style type="text/css" media="all">
        .rit-testimonial-shortcode::after {
            background-color: <?php echo esc_attr($atts['background_color'])?>;
        }
    </style>
    <?php
}
?>
<div class="rit-testimonial-shortcode <?php echo esc_attr($atts['el_class'] . ' ' . $atts['preset_style'] . ' ');
echo esc_attr($atts['style']) . '-testimonial' ?>" style="<?php echo esc_attr($background); ?>">
    <?php
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()):
    if ($atts['title'] != '') { ?>
        <h3 class="title"><?php echo esc_attr($atts['title']); ?></h3>
    <?php }
    if ($atts['style'] == 'carousel') {
        $item = $atts['columns'];
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("<?php echo($atts['el_class']!=''?  '.'.esc_js($atts['el_class']):''); ?> .wrapper-testimonial-block").owlCarousel({
                    // Most important owl features
                    items: '<?php echo esc_js($item) ?>',
                    itemsCustom: false,
                    itemsDesktop: [1199, <?php echo esc_js($item); ?>],
                    itemsDesktopSmall: [980, <?php if($item>2) { echo esc_js($item-1); }else{echo esc_js($item);} ?>],
                    itemsTablet: [768, 2],
                    itemsTabletSmall: false,
                    itemsMobile: [479, 1],
                    singleItem: <?php  echo esc_attr($item==1? 'true':'false'); ?>,
                    itemsScaleUp: false,
                    // Navigation
                    pagination: <?php  echo esc_attr($atts['carousel_pag']=='yes'? 'true':'false'); ?>,
                    navigation: <?php  echo esc_attr($atts['carousel_nav']=='yes'? 'true':'false'); ?>,
                    navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    rewindNav: true,
                    scrollPerPage: false,
                    autoPlay: 3000
                })
            });
        </script>
        <?php
    }
    echo '<div class="wrapper-testimonial-block">';
    while ($the_query->have_posts()):$the_query->the_post(); ?>
        <article class="rit-testimonial-item" id="testimonial-<?php the_ID(); ?>">
            <?php
            if ($atts['preset_style'] != 'style-3'&&$atts['preset_style'] != 'style-4'&&$atts['preset_style'] != 'style-5') {
                if ($atts['page_link'] == 'yes' && !$atts['hide_avatar']) {
                    ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php
                }
                if (get_post_meta(get_the_ID(), 'rit_author_img', true) != '' && !$atts['hide_avatar']) {
                    ?>
                    <img
                        src="<?php echo wp_get_attachment_image_url(get_post_meta(get_the_ID(), 'rit_author_img', true), 'full') ?>"
                        alt="<?php the_title(); ?>" class="avatar-circus"/>
                <?php }
                if ($atts['page_link'] == 'yes' && !$atts['hide_avatar']) {
                    ?>
                    </a> <?php }
            } ?>
            <div class="testimonial-content">
                <?php if ($atts['output_type'] == 'excerpt') {
                    echo rit_excerpt($atts['excerpt_length']);
                } else {
                    the_content();
                } ?>
            </div>
            <?php
            if ($atts['preset_style'] == 'style-3'|| $atts['preset_style'] == 'style-4' || $atts['preset_style'] == 'style-5'){
            ?>
            <div class="wrap-author">
                <div class="wrap-avatar">
                    <?php
                    if ($atts['page_link'] == 'yes' && !$atts['hide_avatar']){
                    ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php
                        }
                        if (get_post_meta(get_the_ID(), 'rit_author_img', true) != '' && !$atts['hide_avatar']) {
                            ?>
                            <img
                                src="<?php echo wp_get_attachment_image_url(get_post_meta(get_the_ID(), 'rit_author_img', true), 'full') ?>"
                                alt="<?php the_title(); ?>" class="avatar-circus"/>
                        <?php }
                        if ($atts['page_link'] == 'yes' && !$atts['hide_avatar']){
                        ?>
                    </a> <?php } ?>
                </div>
                <div class="wrap-author-info">
                    <?php
                    } ?>
                    <h3 class="testimonial-author">
                        <?php
                        if ($atts['page_link'] == 'yes'){
                        ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <?php
                            }
                            if (get_post_meta(get_the_ID(), 'rit_author', true) != '') {
                                echo esc_html(get_post_meta(get_the_ID(), 'rit_author', true));
                            }
                            if ($atts['page_link'] == 'yes'){
                            ?>
                        </a> <?php } ?>
                    </h3>
                    <?php
                    if (get_post_meta(get_the_ID(), 'rit_author_des', true) != '') { ?>
                        <h4 class="testimonial-des"><?php
                            echo esc_html(get_post_meta(get_the_ID(), 'rit_author_des', true)); ?>
                        </h4>
                        <?php
                    }
                    if ($atts['preset_style'] == 'style-3'||$atts['preset_style'] == 'style-4'||$atts['preset_style'] == 'style-5') {
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
        </article>
        <?php
    endwhile; ?>
</div>
<?php
endif;
wp_reset_postdata(); ?>
</div>
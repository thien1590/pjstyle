<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     0.1
 * @author      CleverSoft
 * @link        http://cleversoft.co
 * @copyright   Copyright (c) 2015 CleverSoft
 * @license     GPL v2
 */

$args = array(
    'post_type' => 'post',
    'posts_per_page' => ($atts['number'] > 0) ? $atts['number'] : get_option('posts_per_page')
);
if ($atts['cat'] != '') {
    if ($atts['parent'])
    {
        $args['category_name'] = $atts['cat'];
    }
    else
    {
        $catid=array();
        foreach(explode(',', $atts['cat'])as $catslug){
            $catid[].=get_category_by_slug($catslug)->term_id;
        }
        $args['category__in'] = $catid;
    }
}
if ($atts['post_in'] != '')
    $args['post_in'] = $atts['post_in'];
$args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
$the_query = new WP_Query($args);
//class for option columns

add_action('wp_footer', 'products_carousel_script');
$item = $atts['columns'];
$class='';
$itemclass='';
if ($atts['pagination'] == 'ajax'|| $atts['pagination'] == 'infinite-scroll') :
    $class.=' rit-wrapper-ajax-load';
    $itemclass.='rit-ajax-item';
endif;
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("<?php if($atts['el_class']!=''){echo esc_js('.'.$atts['el_class']);}?> .blog-carousel").owlCarousel({
            // Most important owl features
            items: '<?php echo esc_js($item) ?>',
            itemsCustom: false,
            itemsDesktop: [1199, <?php echo esc_js($item); ?>],
            itemsDesktopSmall: [980, <?php if($item>2) { echo esc_js($item-1); }else{echo esc_js($item);} ?>],
            itemsTablet: [768, 2],
            itemsTabletSmall: false,
            itemsMobile: [479, 1],
            singleItem: false,
            itemsScaleUp: false,
            // Navigation
            pagination: <?php echo esc_js($atts['carousel_pag']!=''?'true':'false');?>,
            navigation: <?php echo esc_js($atts['carousel_nav']!=''?'true':'false');?>,
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            rewindNav: true,
            scrollPerPage: false
        })
    });
</script>
<div
    class="<?php echo esc_attr('rit-blog-' . $atts['post_layout'] . '-layout rit-blog-grid-layout ' . $atts['el_class'] . ' ' . $atts['post_style']) ?>">
    <?php if ($atts['title'] != '') { ?>
        <h3 class="title"><span><?php echo esc_html($atts['title']); ?></span></h3>
    <?php } ?>
    <?php if ($the_query->have_posts()): ?>
        <ul class="blog-carousel row <?php echo esc_attr($class)?>">
            <?php while ($the_query->have_posts()): $the_query->the_post();
                ?>
                <li class="rit-news-item <?php echo esc_attr($itemclass)?>" id="post-<?php the_ID(); ?>">
                    <div class="wrapper">
                        <?php echo rit_get_template_part('post-format/post', 'default', array('atts' => $atts)) ?>

                        <div class="rit-news-info">
                            <?php
                            if ($atts['post_style'] == 'blog_style_2') {
                                ?>
                                <div class="post-info">
                                    <?php echo get_the_date('M jS, Y'); ?>
                                    <span>|</span><?php echo get_the_term_list(get_the_ID(), 'category', '', ', ', ' '); ?>
                                </div>
                                <?php
                            }elseif($atts['post_style'] == 'blog_style_4'){
                                ?>
                                <div class="post-info">
                                    <?php echo get_the_date('M jS, Y'); ?>
                                </div>
                                <?php
                            }
                            ?>
                            <h3 class="title-news"><a href="<?php the_permalink(); ?>"
                                                      title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

                            <?php
                            if ($atts['output_type'] != 'no') { ?>
                                <div class="description"><?php
                                    if ($atts['output_type'] == 'excerpt') {
                                        echo rit_excerpt($atts['excerpt_lenght']);
                                    } else {
                                        the_content();
                                    } ?>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if ($atts['post_style'] == 'blog_style_2'||$atts['post_style'] == 'blog_style_4') { ?>
                                <?php if (!empty($atts['view_more'])) { ?>
                                    <a class="Everest-readmore" href="<?php the_permalink(); ?>"
                                       title="<?php the_title(); ?>"><?php echo esc_html__("read more", 'ri-everest') ?><i
                                            class="fa fa-angle-double-right"></i> </a>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="post-info">
                                <span class="date-post pull-left"><i
                                        class="fa fa-calendar-check-o"></i> <?php echo get_the_date('M jS, Y'); ?></span>
                                    <?php if (!empty($atts['view_more'])) { ?>
                                        <a class="Everest-readmore pull-right" href="<?php the_permalink(); ?>"
                                           title="<?php the_title(); ?>"><?php echo esc_html__("Read more", 'ri-everest') ?></a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php
//paging
        if ($atts['pagination'] != 'none'):
            if ($atts['pagination'] == 'standard') :
                if (function_exists("rit_pagination")) :
                    rit_pagination(3, $query_shop);
                endif;

            elseif ($atts['pagination'] == 'ajax') :
                if (function_exists("rit_ajax_load_more")) :
                    rit_ajax_load_more($query_shop);
                    echo '<div class="wrapper-loadmore"><a id="loadmore-button" href="#">'.__('Load more','ri-everest').' <i class="fa clever-icon-next"></i></a></div> ';
                endif;
            elseif ($atts['pagination'] == 'infinite-scroll') :
                if (function_exists("rit_infinity_scroll")) :
                    rit_infinity_scroll($query_shop);
                endif;
            endif;
        endif;
        //end paging
    endif;
    wp_reset_postdata(); ?>
</div>

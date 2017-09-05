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
    if ($atts['parent']) {
        $args['category_name'] = $atts['cat'];
    } else {
        $catid = array();
        foreach (explode(',', $atts['cat']) as $catslug) {
            $catid[] .= get_category_by_slug($catslug)->term_id;
        }
        $args['category__in'] = $catid;
    }
}
if ($atts['post_in'] != '')
    $args['post_in'] = $atts['post_in'];
$args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
$the_query = new WP_Query($args);
//class for option columns
$class = '';
switch ($atts['columns']) {
    case '1':
        $class .= "col-xs-12";
        break;
    case '2':
        $class .= "col-xs-12 col-sm-6 col-md-6";
        break;
    case '3':
        $class .= "col-xs-12 col-sm-6 col-md-4";
        break;
    case '4':
        $class .= "col-xs-12 col-sm-6 col-md-3";
        break;
    case '6':
        $class .= "col-xs-12 col-sm-6 col-md-2";
        break;
}
$wrapperclass = '';
if ($atts['pagination'] == 'ajax' || $atts['pagination'] == 'infinite-scroll') :
    $wrapperclass .= ' rit-wrapper-ajax-load';
    $class .= ' rit-ajax-item';
endif;
?>
<div
    class="<?php echo esc_attr('rit-blog-' . $atts['post_layout'] . '-layout ' . $atts['el_class'] . ' ' . $atts['post_style']) ?>">
    <?php if ($atts['title'] != '') { ?>
        <h3 class="title"><span><?php echo esc_html($atts['title']); ?></span></h3>
    <?php } ?>
    <div class="row <?php echo esc_attr($wrapperclass) ?>">
        <?php if ($the_query->have_posts()):
            while ($the_query->have_posts()): $the_query->the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" class="rit-news-item <?php echo esc_attr($class); ?>">
                    <div class="wrapper">
                        <?php echo rit_get_template_part('post-format/post', 'default', array('atts' => $atts)) ?>
                        <div class="wrapper-post-info">
                            <div class="info-post">
                                <?php echo get_the_date('F jS, Y'); ?>
                            </div>
                            <?php if (get_theme_mod('rit_enable_page_heading', '1')) {
                                the_title(sprintf('<h3 class="title-news"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>');
                            }
                            if ($atts['output_type'] != 'no') { ?>
                                <div class="description">
                                    <?php if ($atts['output_type'] == 'excerpt') {
                                        echo rit_excerpt($atts['excerpt_lenght']);
                                    } else {
                                        the_content();
                                    } ?></div>
                            <?php }
                            if (!empty($atts['view_more'])) { ?>
                                <a class="primary-font btn-arrow" href="<?php the_permalink(); ?>"
                                   title="<?php the_title(); ?>"><?php _e("Read more ", 'ri-everest') ?><i class=" clever-icon-arrow-empty"></i> </a>
                            <?php } ?>

                        </div>
                    </div>
                </article>
            <?php endwhile;
//paging
            if ($atts['pagination'] != 'none'):
                if ($atts['pagination'] == 'standard') :
                    if (function_exists("rit_pagination")) :
                        echo '<div class="wrapper-pagination">';
                        rit_pagination(3,'','','<i class=" clever-icon-arrow-left-regular"></i>','<i class=" clever-icon-arrow-right-regular"></i>');
                        echo '</div>';
                    endif;

                elseif ($atts['pagination'] == 'ajax') :
                    if (function_exists("rit_ajax_load_more")) :
                        rit_ajax_load_more($the_query);
                        echo '<div class="wrapper-loadmore"><a id="loadmore-button" href="#">' . __('Load more', 'ri-everest') . ' <i class="fa clever-icon-next"></i></a></div> ';
                    endif;
                elseif ($atts['pagination'] == 'infinite-scroll') :
                    if (function_exists("rit_infinity_scroll")) :
                        rit_infinity_scroll($the_query);
                    endif;
                endif;
            endif;
            //end paging
        endif;
        wp_reset_postdata(); ?>
    </div>
</div>

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
$class='';
$itemclass='';
$args = array(
    'post_type' => 'post',
    'posts_per_page' => ($atts['number'] > 0) ? $atts['number'] : get_option('posts_per_page'),
    'post_status' => 'publish'
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
    $args['post__in'] = explode(',', $atts['post_in']);
if($atts['pagination']==1){
    $args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
}
$the_query=new WP_Query($args);
if ($atts['pagination'] == 'ajax'|| $atts['pagination'] == 'infinite-scroll') :
    $class.=' rit-wrapper-ajax-load';
    $itemclass.='rit-ajax-item';
endif;
?>
<div class="<?php echo esc_attr('rit-recent-post-shortcode'); ?>">
    <?php
    if(isset($atts['title'])) echo '<h3 class="title"><span>'.$atts['title'].'</span></h3>';
    if ($the_query->have_posts()):
        echo '<ul class="'.esc_attr($class).'">';
    while ($the_query->have_posts()):
        $the_query->the_post();
        ?>
        <li class=" <?php echo esc_attr($class) ?>">
            <div class="rit-recent-post-shortcode-item row">

                <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : ?>
                    <div class="side-image col-xs-5">
                        <a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_post_thumbnail('thumbnail', array('class' => 'side-item-thumb')); ?></a>
                    </div>
                <?php endif; ?>
                <div class="side-item-text <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : echo 'col-xs-7'; else: echo 'col-xs-12'; endif; ?>">
                    <h3><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h3>
                    <span class="side-item-meta"><?php the_time( get_option('date_format') ); ?></span>
                </div>
            </div>

        </li>
    <?php
    endwhile;
        echo '</ul>';
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
                    echo '<div class="wrapper-loadmore"><a id="loadmore-button" href="#">'.__('Load more','ri-everest').' <i class="fa clever-icon-next"></i></a></div> ';
                endif;
            elseif ($atts['pagination'] == 'infinite-scroll') :
                if (function_exists("rit_infinity_scroll")) :
                    rit_infinity_scroll($the_query);
                endif;
            endif;
        endif;
        //end paging
    endif;
    wp_reset_postdata();
    ?>
</div>

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

$args = array(
    'post_type' => 'post',
    'posts_per_page' => ($atts['number'] > 0) ? $atts['number'] : get_option('posts_per_page'),
    'post_status' => 'publish'
);
if ($atts['cat'] != ''){
    if($atts['parent'])
        $args['cat'] = $atts['cat'];
    else
        $args['category__in'] = explode(',', $atts['cat']);
}

if ($atts['post_in'] != '')
    $args['post__in'] = explode(',', $atts['post_in']);
if($atts['pagination']==1){
    $args['paged'] = (rit_get_query_var('paged')) ? rit_get_query_var('paged') : 1;
}
$the_query=new WP_Query($args);
?>
<div class="<?php echo esc_attr('rit-recent-post-shortcode'); ?>">
    <?php
    if(isset($atts['title'])) echo '<h3 class="title"><span>'.esc_html($atts['title']).'</span></h3>';
    if ($the_query->have_posts()):
        echo '<ul>';
    while ($the_query->have_posts()):
        $the_query->the_post();
        ?>
        <li>
            <div class="rit-recent-post-shortcode-item row">

                <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : ?>
                    <div class="side-image col-xs-5 col-sm-4 col-md-4">
                        <a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_post_thumbnail('thumbnail', array('class' => 'side-item-thumb')); ?></a>
                    </div>
                <?php endif; ?>
                <div class="side-item-text col-xs-7 col-sm-8 col-md-8">
                    <h4><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h4>
                    <span class="side-item-meta"><?php the_time( get_option('date_format') ); ?></span>
                </div>
            </div>

        </li>
    <?php
    endwhile;
        echo '</ul>';
        if (function_exists("posts_nav")&& $atts['pagination']==1) :
            posts_nav($the_query->max_num_pages);
        endif;
    endif;
    wp_reset_postdata();
    ?>
</div>

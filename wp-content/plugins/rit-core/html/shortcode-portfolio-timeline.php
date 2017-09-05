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
    'post_type' => 'portfolio',
    'posts_per_page' => ($atts['number'] > 0) ? $atts['number'] : get_option('posts_per_page')
);
if ($atts['cat']) {
    $catid=array();
    foreach(explode(',', $atts['cat'])as $catslug){
        $catid[].=get_term_by('slug',$catslug,'portfolio_category')->term_id;
    }
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'portfolio_category',
            'field' => 'id',
            'terms' => $catid,
        )
    );
}
if ($atts['post_in'] != '') {
    $args['post__in'] = explode(',', $atts['post_in']);
}
$args['paged'] = (rit_get_query_var('paged')) ? rit_get_query_var('paged') : 1;
$start_timeline = 0;
?>

<div id="portfolio-timeline-layout" class="rit-timeline-layout">
    <?php $the_query = new WP_Query($args);
    if ($the_query->have_posts()):
        while ($the_query->have_posts()):$the_query->the_post();
            global $prev_post_year, $prev_post_month, $post_count;

            $post_month = get_the_date('n');
            $post_year = get_the_date('o');
            $current_date = get_the_date('o-n');
            ?>
            <?php if ($prev_post_month != $post_month || ($prev_post_month == $post_month && $prev_post_year != $post_year) || $start_timeline == 0) : ?>
                <?php
                $post_count = 1;
                $start_timeline = 1;
                ?>
                <div class="clear"></div>
                <div class="timeline-date"><h3><?php echo get_the_date('F Y'); ?></h3></div>
            <?php endif;
            $classes = 'timeline-box ';
            $classes .= ($post_count % 2 == 1 ? 'left' : 'right');
            ?>

            <article class="rit-news-item col-xs-12 col-sm-6 <?php echo esc_attr($classes) ?>" id="post-<?php the_ID(); ?>">
                <?php echo rit_get_template_part('post-format/portfolio', 'default', array('atts' => $atts)) ?>
                <div class="rit-news-info">

                    <h3 class="title-news"><a href="<?php the_permalink(); ?>"
                                              title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

                    <p class="info-post"><a class="author-link"
                                            href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                                            rel="author">
                            <?php echo(get_the_author()); ?>
                        </a> / <?php echo get_the_date('F jS, Y'); ?>
                        /  <?php comments_number(esc_html__('0 Comment', RIT_TEXT_DOMAIN), esc_html__('1 Comment', RIT_TEXT_DOMAIN), esc_html__('% Comments, RIT_TEXT_DOMAIN'));?> /  <?php echo get_the_term_list(get_the_ID(), 'portfolio_category', '<i class="fa fa-tags"></i> ', ' ' ); ?></p>

                    <div class="description"><?php the_excerpt(); ?></div>
                </div>
            </article>
            <?php
            $prev_post_year = $post_year;
            $prev_post_month = $post_month;
            $post_count++;
        endwhile;
        if($atts['pagination' == 'standard']) :
            if (function_exists("rit_pagination")) :
                rit_pagination(3, $the_query);
            endif;
        endif;
    endif;
    wp_reset_postdata();
    ?>
</div>
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
    'port_type' => 'post',
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
if ($atts['post_in'])
    $args['post__in'] = explode(',', $atts['post_in']);
$args['paged'] = (rit_get_query_var('paged')) ? rit_get_query_var('paged') : 1;
$the_query = new WP_Query($args);?>
<div class="rit-blog-large-alt-layout">
    <?php
    if ($the_query->have_posts()):
        while ($the_query->have_posts()): $the_query->the_post();
            ?>
            <article <?php post_class('rit-news-item ')?> id="post-<?php the_ID(); ?>">
                <?php echo rit_get_template_part('post-format/post', 'default', array('atts' => $atts)) ?>
                <div class="rit-news-info row">
                    <div class="alt col-md-2 col-sm-2 col-xs-4">
                        <span class="date"> <?php echo get_the_date('F jS, Y'); ?> </span>
                        <a class="author-link"
                           href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                            <?php echo(get_the_author()); ?>
                        </a>

                        < class="comment-count"><?php comments_number(esc_html__('0 Comment', RIT_TEXT_DOMAIN), esc_html__('1 Comment', RIT_TEXT_DOMAIN), esc_html__('% Comments', RIT_TEXT_DOMAIN));?></p>
                    </div>
                    <div class="wrapper-news-info col-md-10 col-sm-10 col-xs-8">
                        <h3 class="title-news"><a href="<?php the_permalink(); ?>"
                                                  title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

                        <div class="description"><?php the_excerpt(); ?></div>
                    </div>
                </div>
            </article>
        <?php
        endwhile;
        if (function_exists("posts_nav")) :
            posts_nav($the_query->max_num_pages);
        endif;
    endif;
    wp_reset_postdata();
    ?>
</div>
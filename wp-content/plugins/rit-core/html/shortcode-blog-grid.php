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
$args['paged'] = (rit_get_query_var('paged')) ? rit_get_query_var('paged') : 1;
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
$i = 0;
?>
<div class="<?php echo esc_attr('rit-blog-' . $atts['post_layout'] . '-layout') ?>">
    <div class="row">
        <?php if ($the_query->have_posts()):
            while ($the_query->have_posts()): $the_query->the_post();
                $i++;
                ?>
                <article class="rit-news-item <?php echo esc_attr($class); ?>" id="post-<?php the_ID(); ?>">
                    <?php echo rit_get_template_part('post-format/post', 'default', array('atts' => $atts)) ?>
                    <div class="rit-news-info">
                        <h3 class="title-news"><a href="<?php the_permalink(); ?>"
                                                  title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

                        <p class="info-post">
                            <a class="author-link"
                               href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                               rel="author">
                                <?php echo(get_the_author()); ?>
                            </a> / <?php echo get_the_date('F jS, Y'); ?>
                            /  <?php comments_number(esc_html__('0 Comment', RIT_TEXT_DOMAIN), esc_html__('1 Comment', RIT_TEXT_DOMAIN), esc_html__('% Comments', RIT_TEXT_DOMAIN));?></p>

                        <div class="description"><?php
                            if($atts['output_type']!='no'){
                                if($atts['output_type']=='excerpt'){
                                   echo rit_excerpt($atts['excerpt_lenght']);
                                }
                                else{
                                    the_content();
                                }
                            }
                            ?></div>
                    </div>
                </article>
                <?php if ($i % $atts['columns'] == 0): ?>
                    <div class="clear"></div>
                <?php endif; ?>
            <?php endwhile;
            //paging
            if($atts['pagination'] == 'standard') :
                if (function_exists("rit_pagination")) :
                    rit_pagination(3, $the_query);
                endif;
            endif;
        //end paging
        endif;
        wp_reset_postdata(); ?>
    </div>
</div>

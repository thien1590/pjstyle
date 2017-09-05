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

$args=array(
    'post_type'=>'portfolio',
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
if($atts['post_in']!=''){
    $args['post__in']=explode(',',$atts['post_in']);
}
$class='';
switch($atts['columns']){
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
}
$the_query=new WP_Query($args);
$i=0;
?>
<div class="rit-grid-layout">
    <?php if ($the_query->have_posts()):
        while ($the_query->have_posts()): $the_query->the_post();
            $i++;
            ?>
            <article class="rit-news-item <?php echo esc_attr($class); ?>" id="post-<?php esc_attr(the_ID()); ?>">
                <?php echo rit_get_template_part('post-format/portfolio', 'default', array('atts' => $atts)) ?>
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

                    <div class="description"><?php the_excerpt(); ?></div>
                </div>
            </article>
            <?php if ($i % $atts['columns'] == 0): ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endwhile;
        if($atts['pagination'] == 'standard') :
            if (function_exists("rit_pagination")) :
                rit_pagination(3, $the_query);
            endif;
        endif;
    endif;
    wp_reset_postdata(); ?>
</div>

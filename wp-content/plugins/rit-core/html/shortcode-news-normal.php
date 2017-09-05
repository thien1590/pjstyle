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
    'posts_per_page' => ($atts['posts_per_page'] > 0) ? $atts['posts_per_page'] : get_option('posts_per_page')
);
if ($atts['post__in'] != '')
    $args['post__in'] = $atts['post__in'];
if ($atts['post__not_in'] != '')
    $args['post__not_in'] = $atts['post__not_in'];
if ($atts['order'] != '')
    $args['order'] = $atts['order'];
if ($atts['orderby'] != '')
    $args['orderby'] = $atts['orderby'];

$args['paged'] = (rit_get_query_var('paged')) ? rit_get_query_var('paged') : 1;

$cats = explode(',', $atts['cat']);
$class = '';
switch ($atts['columns']):
    case 2:
        $class = 'col-xs-12 col-sm-6';
        break;
    case 3:
        $class = 'col-xs-12 col-sm-4';
        break;
    case 4:
        $class = 'col-xs-12 col-sm-3';
        break;
    default:
        $class = 'col-xs-12';
        break;

endswitch; ?>
<div class="rit-wrapper-news clearfix rit-news-normal">
    <?php
    //no tab
    if (empty($atts['cat']) || count($cats) == 1) {
        $args['cat'] = $atts['cat'];
        $the_query = new WP_Query($args);
    if ($the_query->have_posts()):?>
        <div class="rit-head-block-news row">
            <h3 class="title col-xs-12"><span><?php echo esc_attr($atts['title']); ?></span></h3>
        </div><?php
        $i = 0;
    while ($the_query->have_posts()):$the_query->the_post();
        $i++;
        ?>
        <article class="rit-news-item <?php if ($i == 1) {
            echo 'col-xs-12';
        } else echo esc_attr($class); ?>">
            <div class="row">
                <div class="col-xs-4">
                    <?php echo rit_get_template_part('post-format/news', 'default', array('atts' => $atts)) ?>
                </div>
                <div class="col-xs-8">
                    <h3 class="rit-title-news"><a href="<?php the_permalink()?>"
                                                  title="<?php the_title(); ?>"><?php the_title()?></a></h3>
                    <?php if ($i == 1): ?>
                        <p class="rit-news-info"><a class="author-link"
                                                    href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                                                    rel="author">
                                <?php echo(get_the_author()); ?>
                            </a> / <?php echo get_the_date('F jS, Y'); ?>
                            /  <?php comments_number(esc_html__('0 Comment'), esc_html__('1 Comment'), esc_html__('% Comments')); ?></p>
                    <?php endif;?>
                    <div class="rit-description">
                        <?php the_excerpt();?>
                        <?php if (!empty($atts['view_more']) && $i == 1) { ?>
                            <a class="rit-readmore" href="<?php the_permalink(); ?>"
                               title="<?php the_title(); ?>">
                                <span><?php echo esc_html__('Read more', RIT_TEXT_DOMAIN) ?> </span></a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </article>
    <?php
    endwhile;
    endif;
    wp_reset_postdata();
    } //have tab
    else {
    $terms = array();
    $term_ids = explode(',', $atts['cat']);
    if (count($term_ids) > 0) {
        foreach ($term_ids as $id) {
            $terms[] = get_term($id, 'category');
        }
    }
    ?>
        <script>
            jQuery(document).ready(function () {
                "use strict";
                jQuery('.rit-news-group').each(function () {
                    jQuery(this).css('height', jQuery(this).outerHeight());
                });
                jQuery('.rit-control-tabs-news li:first-child').addClass('active');
                var t = jQuery('.rit-control-tabs-news .active').attr('data-id');
                jQuery('.rit-news-group').addClass('unvisible');
                jQuery('.rit-news-group.' + t).removeClass('unvisible');

                jQuery('.rit-control-tabs-news li').on('click',function () {
                    var target = jQuery(this).attr('data-id');
                    jQuery('.rit-control-tabs-news li.active').removeClass('active');
                    jQuery(this).addClass('active');
                    jQuery('.rit-news-group:visible').addClass('unvisible');
                    jQuery('.rit-wrapper-news').find('.' + target).removeClass('unvisible');
                });
            });
        </script>
        <div class="rit-head-block-news row">
            <h3 class="title col-xs-12"><span><?php echo esc_attr($atts['title']); ?></span></h3>
            <?php if (!empty($terms) && !is_wp_error($terms)): ?>
                <ul class="rit-control-tabs-news col-xs-12">
                    <?php if (count($terms) > 1) : ?>
                        <?php foreach ($terms as $term) : ?>
                            <li data-id="<?php echo esc_attr($term->slug) ?>"><span><?php echo esc_html($term->name); ?></span></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php
    foreach ($cats as $cat) {
    $args['cat'] = $cat;
    $catgroup = get_term($cat, 'category');
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()):
    ?>
        <div class="rit-news-group <?php echo esc_attr($catgroup->slug)?>">
            <?php
            $i = 0;
            while ($the_query->have_posts()):$the_query->the_post();
                $i++;
                ?>
                <article class="rit-news-item <?php if ($i == 1) {
                    echo 'col-xs-12';
                } else echo esc_attr($class); ?>">
                    <div class="row">
                        <div class="col-xs-4">
                            <?php echo rit_get_template_part('post-format/news', 'default', array('atts' => $atts)) ?>
                        </div>
                        <div class="col-xs-8">
                            <h3 class="rit-title-news"><a href="<?php the_permalink()?>"
                                                          title="<?php the_title(); ?>"><?php the_title()?></a></h3>
                            <?php if ($i == 1): ?>
                                <p class="rit-news-info"><a class="author-link"
                                                            href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                                                            rel="author">
                                        <?php echo(get_the_author()); ?>
                                    </a> / <?php echo get_the_date('F jS, Y'); ?>
                                    /  <?php comments_number(esc_html__('0 Comment', RIT_TEXT_DOMAIN), esc_html__('1 Comment', RIT_TEXT_DOMAIN), esc_html__('% Comments', RIT_TEXT_DOMAIN));?></p>
                            <?php endif;?>
                            <div class="rit-description">
                                <?php the_excerpt();?>
                                <?php if (!empty($atts['view_more']) && $i == 1) { ?>
                                    <a class="rit-readmore" href="<?php the_permalink(); ?>"
                                       title="<?php the_title(); ?>">
                                        <span><?php echo esc_html__('Read more', RIT_TEXT_DOMAIN) ?> </span></a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </article>
            <?php
            endwhile;?>
        </div>
    <?php
    endif;
        wp_reset_postdata();
    }
    }
    ?>
</div>


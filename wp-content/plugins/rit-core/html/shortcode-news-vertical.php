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
<div class="rit-wrapper-news clearfix rit-news-vertical">
    <div class="rit-head-block-news row">
        <h3 class="title col-xs-12"><span><?php echo esc_attr($atts['title']); ?></span></h3>
    </div>
    <?php
    //no tab
    if (empty($atts['cat']) || count($cats) == 1) {
        $args['cat'] = $atts['cat'];
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()):
            $i = 0;
            $c = 0;
            while ($the_query->have_posts()):$the_query->the_post();
                $i++;
                if ($i == 2) {
                    echo '<div class="rit-second-col col-xs-12 col-sm-4">';
                    $c = 1;
                }
                ?>
                <article class="rit-news-item <?php if ($i == 1) {
                    echo 'col-xs-12 col-sm-8';
                }?>">
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
                                <?php if ($i == 1): the_excerpt();endif; ?>
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
            if ($c == 1) echo '</div>';
        endif;
        wp_reset_postdata();
    } //have tab
    else {
        foreach ($cats as $cat) {
            $args['cat'] = $cat;
            $catgroup=get_term($cat, 'category');
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()):
        ?>
        <div class="rit-news-group <?php echo esc_attr($catgroup->slug)?>">
            <h3 class="title"><?php echo esc_attr($catgroup->name) ?></h3>
            <?php
                $i = 0;
                $c = 0;
                while ($the_query->have_posts()):$the_query->the_post();
                    $i++;
                    if ($i == 2) {
                        echo '<div class="rit-second-col col-xs-12 col-sm-4">';
                        $c = 1;
                    }
                    ?>
                    <article class="rit-news-item <?php if ($i == 1) {
                        echo 'col-xs-12 col-sm-8';
                    }?>">
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
                                    <?php if ($i == 1): the_excerpt();endif; ?>
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
                if ($c == 1) echo '</div>';?>
        </div>
            <?php
            endif;
            wp_reset_postdata();

        }
    }
    ?>
</div>


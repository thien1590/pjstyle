<?php
/**
 * The template displaying content follow large layout
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage everest
 * @since everest 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('rit-news-item rit-blog-medium-layout'); ?>>
    <div class="row">
            <?php
            $hasmedia=false;
            if (has_post_format('gallery')) : ?>

                <?php $images = get_post_meta(get_the_ID(), '_format_gallery_images', true); ?>
                <?php if ($images) :
                    $hasmedia=true;
                    ?>
            <div class="col-xs-12 col-sm-6">
                    <div class="wrapper-media <?php echo esc_attr((is_single()) ? ' single-image' : ''); ?>">
                        <ul class="post-slider">
                            <?php foreach ($images as $image) : ?>
                                <?php $the_image = wp_get_attachment_image_src($image, 'full-thumb'); ?>
                                <?php $the_caption = get_post_field('post_excerpt', $image); ?>
                                <li><img src="<?php echo esc_url($the_image[0]); ?>"
                                         <?php if ($the_caption) : ?>title="<?php echo esc_attr($the_caption); ?>"<?php endif; ?> />
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
            </div>
                <?php endif; ?>
            <?php elseif (has_post_format('video')) :
                $sp_video = get_post_meta(get_the_ID(), '_format_video_embed', true);
                if($sp_video!=''):
                    $hasmedia=true;
                ?>
            <div class="col-xs-12 col-sm-6">
                <div class="wrapper-video wrapper-media<?php echo esc_attr(is_single() ? ' single-video' : ''); ?>">
                    <?php if (wp_oembed_get($sp_video)) : ?>
                        <?php echo(wp_oembed_get($sp_video)); ?>
                    <?php else :
                        ?>
                        <?php echo ent2ncr($sp_video); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php
                endif;
                elseif (has_post_format('audio')) :
                ?>
                <?php $sp_audio = get_post_meta(get_the_ID(), '_format_audio_embed', true);
                if($sp_audio!=''):
                    $hasmedia=true;
                ?>
            <div class="col-xs-12 col-sm-6">
                <div class="wrapper-media audio<?php echo esc_attr(is_single() ? ' single-audio' : ''); ?>">
                    <?php if (wp_oembed_get($sp_audio)) : ?>
                        <?php echo(wp_oembed_get($sp_audio)); ?>
                    <?php else : ?>
                        <?php echo ent2ncr($sp_audio); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; else : ?>
                <?php if (has_post_thumbnail()) :
                        $hasmedia=true;
                        ?>
        <div class="col-xs-12 col-sm-6">
                        <div class="wrapper-img">
                            <a href="<?php echo get_permalink() ?>"
                               title="<?php the_title(); ?>"><?php the_post_thumbnail('full-thumb'); ?></a>
                        </div>
            </div>
                <?php endif; ?>
            <?php endif; ?>
        <div class="rit-news-info col-xs-12 <?php echo esc_attr($hasmedia?'col-sm-6':'') ?> ">
            <div class="list-cat">
                <?php
                echo get_the_term_list(get_the_ID(), 'category', '', ', ', ' ');
                ?>
            </div>
            <?php if (get_theme_mod('rit_enable_page_heading', '1')) { ?>
                <?php
                the_title(sprintf('<h3 class="title-news"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>');
                ?>
            <?php } ?>
            <ul class="info-post">
                <li><i class="fa fa-clock-o"></i> <?php echo get_the_date('F jS, Y'); ?> </li>
            </ul>
            <div class="description">
                <?php
                if(function_exists('rit_excerpt')){ echo rit_excerpt(25);}
                else
                the_excerpt();
                ?>
            </div>
            <a class="btn-readmore pull-left" href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo esc_html__("Continue reading...",'ri-everest')?></a>
            <!-- .entry-content -->

        </div>

    </div>
    <div class="more-option">
        <?php comments_number(esc_html__('0 Comment','ri-everest'), esc_html__('1 Comment','ri-everest'), esc_html__('% Comments','ri-everest')); ?>
        <?php get_template_part('/included/templates/share')?>
    </div>
</article><!-- #post-## -->

<?php
/**
 * The default template for displaying content
 *
 * Used for single post.
 *
 * @package WordPress
 * @subpackage Everest
 * @since Everest 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('detail-post'); ?>>

    <?php
    if (has_post_format('gallery')) : ?>

        <?php $images = get_post_meta(get_the_ID(), '_format_gallery_images', true); ?>

        <?php if ($images) : ?>
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
        <?php endif; ?>

    <?php elseif (has_post_format('video')) : ?>

        <div class="wrapper-video <?php echo (is_single()) ? ' single-video' : ''; ?>">
            <?php $sp_video = get_post_meta(get_the_ID(), '_format_video_embed', true); ?>
            <?php if (wp_oembed_get($sp_video)) : ?>
                <?php echo wp_oembed_get($sp_video); ?>
            <?php else : ?>
                <?php echo ent2ncr($sp_video); ?>
            <?php endif; ?>
        </div>

    <?php elseif (has_post_format('audio')) : ?>

        <div class="wrapper-media audio<?php echo (is_single()) ? ' single-audio' : ''; ?>">
            <?php $sp_audio = get_post_meta(get_the_ID(), '_format_audio_embed', true); ?>
            <?php if (wp_oembed_get($sp_audio)) : ?>
                <?php echo wp_oembed_get($sp_audio); ?>
            <?php else : ?>
                <?php echo ent2ncr($sp_audio); ?>
            <?php endif; ?>
        </div>

    <?php else : ?>

        <?php if (has_post_thumbnail()) : ?>
            <?php if (!get_theme_mod('sp_post_thumb')) : ?>
                <div class="wrapper-img img-animation">
                    <div class="inner-wrapper-img">
                        <a href="<?php echo get_permalink() ?>"
                           title="<?php the_title(); ?>"><?php the_post_thumbnail('full-thumb'); ?></a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>
    <div class="news-info">
        <?php
        echo get_the_term_list(get_the_ID(), 'category', '<div class="list-cat">', ' -', '</div>');
        ?>
        <div class="info-post">
            <?php echo get_the_date('F jS, Y'); ?>
        </div>
        <?php if (get_theme_mod('rit_enable_page_heading', '1')) { ?>
            <?php

            the_title('<h1 class="title-post">', '</h1>');
            ?>
        <?php } ?>
        <div class="post-content">
            <?php
            the_content();
            ?>
        </div>
        <!-- .entry-content -->
    </div>
    <div class="post-more-info">
        <?php
        $tags = get_the_tags();
        if ($tags) { ?>
            <div class="tags-list">
            <h3 class="tag-title"><?php echo esc_html__('Tags: ', 'ri-everest') ?></h3><?php the_tags(' ', ' ', ' '); ?>
            </div><?php } ?>
        <div class="row">
        <div class="col-xs-12 col-sm-6 pull-left">
            <a href="#comments" class="comment-btn primary-font">
                <i class="ion-chatboxes"></i>
                <?php comments_number( esc_html__('0 Comment','ri-everest'), esc_html__('1 Comment','ri-everest'),esc_html__('% Comments','ri-everest') ); ?>
            </a>
        </div>
        <div class="col-xs-12 col-sm-6 pull-right">
            <?php get_template_part('included/templates/share'); ?>
        </div>
        </div>
    </div>
    <?php
    // Author bio.
    if (is_single()) :
        get_template_part('included/templates/about_author');
        get_template_part('included/templates/related_posts');
    endif;
    ?>
</article><!-- #post-## -->

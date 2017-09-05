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

<article id="post-<?php the_ID(); ?>" <?php post_class('post-item post-full-width rit-news-item rit-post-large') ?>>
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

        <div class="wrapper-video wrapper-media<?php echo esc_attr(is_single() ? ' single-video' : ''); ?>">
            <?php $sp_video = get_post_meta(get_the_ID(), '_format_video_embed', true); ?>
            <?php if (wp_oembed_get($sp_video)) : ?>
                <?php echo wp_oembed_get($sp_video); ?>
            <?php else : ?>
                <?php echo $sp_video; ?>
            <?php endif; ?>
        </div>

    <?php elseif (has_post_format('audio')) : ?>

        <div class="wrapper-media audio<?php echo esc_attr(is_single() ? ' single-audio' : ''); ?>">
            <?php $sp_audio = get_post_meta(get_the_ID(), '_format_audio_embed', true); ?>
            <?php if (wp_oembed_get($sp_audio)) : ?>
                <?php echo wp_oembed_get($sp_audio); ?>
            <?php else : ?>
                <?php echo esc_attr($sp_audio); ?>
            <?php endif; ?>
        </div>

    <?php else : ?>

        <?php if (has_post_thumbnail()) : ?>
            <?php if (!get_theme_mod('sp_post_thumb')) : ?>
                <div class="wrapper-media <?php echo esc_attr((is_single()) ? ' single-image' : ''); ?>">
                    <a href="<?php echo get_permalink() ?>"
                       title="<?php the_title(); ?>"><?php the_post_thumbnail('full-thumb'); ?></a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>
    <div class="wrapper-post-info">
        <?php
        echo get_the_term_list(get_the_ID(), 'category', '<div class="list-cat">', ' -', '</div>');
        ?>
        <div class="info-post">
            <?php echo get_the_date('F jS, Y'); ?>
        </div>
        <?php if (get_theme_mod('rit_enable_page_heading', '1')) { ?>
            <?php
            the_title(sprintf('<h3 class="title-news"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>');
            ?>
        <?php } ?>
        <div class="description">
            <?php
            the_excerpt();
            ?>
        </div>
        <a class="btn-readmore primary-font" href="<?php the_permalink(); ?>"
           title="<?php the_title(); ?>"><?php echo esc_html__("Continue reading...", 'ri-everest') ?></a>
    </div>
</article><!-- #post-## -->

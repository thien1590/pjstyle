<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage everest
 * @since everest 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php (is_single()) ? post_class('single-post news-item') : post_class('post-item'); ?>>

    <?php
    if(has_post_format('gallery')) : ?>

        <?php $images = get_post_meta( get_the_ID(), '_format_gallery_images', true ); ?>

        <?php if($images) : ?>
            <div class="post-image<?php echo esc_attr((is_single()) ? ' single-image' : ''); ?>">
                <ul class="post-slider">
                    <?php foreach($images as $image) : ?>

                        <?php $the_image = wp_get_attachment_image_src( $image, 'full-thumb' ); ?>
                        <?php $the_caption = get_post_field('post_excerpt', $image); ?>
                        <li><img src="<?php echo esc_url($the_image[0]); ?>" <?php if($the_caption) : ?>title="<?php echo esc_attr($the_caption); ?>"<?php endif; ?> /></li>

                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

    <?php elseif(has_post_format('video')) : ?>

        <div class="post-image<?php echo esc_attr(is_single() ? ' single-video' : ''); ?>">
            <?php $sp_video = get_post_meta( get_the_ID(), '_format_video_embed', true ); ?>
            <?php if(wp_oembed_get( $sp_video )) : ?>
                <?php echo esc_html(wp_oembed_get($sp_video)); ?>
            <?php else : ?>
                <?php echo esc_html($sp_video); ?>
            <?php endif; ?>
        </div>

    <?php elseif(has_post_format('audio')) : ?>

        <div class="post-image audio<?php echo esc_attr(is_single() ? ' single-audio' : ''); ?>">
            <?php $sp_audio = get_post_meta( get_the_ID(), '_format_audio_embed', true ); ?>
            <?php if(wp_oembed_get( $sp_audio )) : ?>
                <?php echo esc_html(wp_oembed_get($sp_audio)); ?>
            <?php else : ?>
                <?php echo esc_html($sp_audio); ?>
            <?php endif; ?>
        </div>

    <?php else : ?>

        <?php if(has_post_thumbnail()) : ?>
            <?php if(!get_theme_mod('sp_post_thumb')) : ?>
            <div class="wrapper-img <?php echo esc_attr((is_single()) ? ' single-image' : ''); ?>">
                    <a href="<?php echo get_permalink() ?>" title="<?php the_title();?>"><?php the_post_thumbnail('full-thumb'); ?></a>
                    <?php if (!is_single()): ?>
                        <div class="wrapper-mask">
                            <div class="mask" data-link="<?php the_permalink(); ?>">
                                <span class="readmore">
                                    <a href="<?php echo get_permalink() ?>" title="<?php echo esc_html__('Read more', 'ri-everest' )?>"><?php echo esc_html__('Read more', 'ri-everest' )?></a>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>
    <div class="news-info">
    <?php if(get_theme_mod('rit_enable_page_heading', '1')) { ?>
        <?php
        if (is_single()) :
            the_title('<h3 class="title-news">', '</h3>');
        else :
            the_title(sprintf('<h3 class="title-news"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>');
        endif;
        ?>
    <?php } ?>
        <p class="info-post">
                <a class="author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                   rel="author">
                    <?php echo(get_the_author()); ?>
                </a>
            / <?php echo get_the_date('F jS, Y'); ?>
            /  <?php comments_number('0 Comment', '1 Comment', '% Comments'); ?></p>
    <div class="description">
		<?php
            if(is_single()){
                the_content();
            } else {
                the_excerpt();
            }
        ?>
	</div><!-- .entry-content -->
    </div>

    <?php if (is_single()):?>
    <div class="row">
        <?php
        $tags = get_the_tags(); if ($tags) { ?> <div class="tags-list col-xs-12 col-sm-6 pull-left">
        <span><?php echo esc_html__('Tags: ','ri-everest')?></span><?php the_tags(' ',', ', ' '); ?> </div><?php } ?>
        <div class="col-xs-12 col-sm-6 pull-right">
       <?php get_template_part('included/templates/share');?>
        </div>
    </div>
    <?php endif;?>


    <?php
    // Author bio.
    if (is_single()) :
        get_template_part('included/templates/about_author');
        get_template_part('included/templates/related_posts');
    endif;
    ?>
</article><!-- #post-## -->

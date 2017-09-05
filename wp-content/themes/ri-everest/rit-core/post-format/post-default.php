<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     0.1
 * @author      CleverSoft
 * @link        http://cleversoft.co
 * @copyright   Copyright (c) 2015 CleverSoft
 * @license     GPL v2
 */

$class = '';
if ($atts['post_layout'] == 'medium') {
    $class .= 'col-sm-6 col-xs-12';
}


if (has_post_format('video')):
    if ($atts['post_layout'] == 'medium') echo '<div class="' .  esc_attr($class) . '">'?>
    <div class="wrapper-video wrapper-img">
        <?php $sp_video = get_post_meta(get_the_ID(), '_format_video_embed', true); ?>
        <?php if (wp_oembed_get($sp_video)) : ?>
            <?php echo wp_oembed_get($sp_video); ?>
        <?php else : ?>
            <?php echo ent2ncr($sp_video); ?>
        <?php endif; ?>
    </div>
    <?php if ($atts['post_layout'] == 'medium'): echo '</div>'; endif;
elseif (has_post_format('audio')) :
    if ($atts['post_layout'] == 'medium') echo '<div class="' .  esc_attr($class) . '">'?>
    <div class="post-image ">
        <?php $sp_audio = get_post_meta(get_the_ID(), '_format_audio_embed', true); ?>
        <?php if (wp_oembed_get($sp_audio)) : ?>
            <?php echo wp_oembed_get($sp_audio); ?>
        <?php else : ?>
            <?php echo ent2ncr($sp_audio); ?>
        <?php endif; ?>
    </div>
    <?php
    if ($atts['post_layout'] == 'medium'): echo '</div>'; endif;
elseif (has_post_format('gallery')&&$atts['post_layout']!='carousel') : if ($atts['post_layout'] == 'medium') echo '<div class="' .  esc_attr($class) . '">' ?>

    <?php $images = get_post_meta(get_the_ID(), '_format_gallery_images', true); ?>

    <?php if ($images) : ?>
        <div class="wrapper-img">
            <ul class="post-slider">
                <?php foreach ($images as $image) : ?>
                    <?php $the_image = wp_get_attachment_image_src($image, 'full-thumb'); ?>
                    <?php $the_caption = get_post_field('post_excerpt', $image); ?>
                    <li><img src="<?php echo esc_url($the_image[0]) ; ?>"
                             <?php if ($the_caption) : ?>title="<?php echo  esc_attr($the_caption); ?>"<?php endif; ?> />
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php
    if ($atts['post_layout'] == 'medium'): echo '</div>'; endif;
else: if (get_the_post_thumbnail()) :
    if ($atts['post_layout'] == 'medium') {
        echo '<div class="' .  esc_attr($class) . '">';
    }
    ?>
    <div class="wrapper-img"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php the_post_thumbnail($atts['blog_img_size']); ?><?php
            ?>
        </a>
    </div>
    <?php
    if ($atts['post_layout'] == 'medium'): echo '</div>'; endif;
endif; endif; ?>
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
?>
<div class="rit-demo-box <?php echo esc_attr($atts['type'] . 'style ' . $atts['el_class']) ?>"
     animation="<?php echo esc_attr($atts['animation_type']) ?>">
    <?php if ($atts['type'] == 'text'): ?>
        <div class="rit-header-demo-box">
            <?php if ($atts['type'] != '') { ?>
                <i class="circus-box <?php echo esc_attr($atts['icon']) ?>"></i>
            <?php } ?>
            <?php if ($atts['title'] != '') { ?>
                <h3 class="title-demo-box">
                    <?php echo esc_html($atts['title']) ?>
                </h3>
            <?php } ?>
        </div>
        <?php if ($atts['description'] != '') { ?>
            <div class="description">
                <?php echo esc_html($atts['description']) ?>
            </div>
        <?php } ?>
    <?php else: ?>
        <div class="rit-wrap-img">
            <div class="mask primary-font <?php echo esc_attr($atts['coming_label'] != ''? 'coming-soon':'') ?>" style="background:<?php echo esc_attr($atts['mask_color']); ?>">
                <?php if ($atts['coming_label'] == ''){?>
                    <a href="<?php echo esc_url($atts['link']); ?>" class="btn btn-view" title="<?php echo esc_attr($atts['title']) ?>">
                        <?php echo($atts['text_link'] != '' ? esc_html($atts['text_link']) : esc_html__('View Demo', RIT_TEXT_DOMAIN)); ?>
                    </a>
                <?php }else{
                echo esc_html__('Coming soon', RIT_TEXT_DOMAIN); }?>
            </div>
            <?php if ($atts['hot_label'] != '') { ?><span
                class="circus-box primary-font hot-label"><?php echo esc_html__('Hot', RIT_TEXT_DOMAIN); ?></span>
            <?php }
            if ($atts['new_label'] != '') { ?><span
                class="circus-box primary-font new-label"><?php echo esc_html__('New', RIT_TEXT_DOMAIN); ?></span>
            <?php } ?><a href="<?php echo esc_url($atts['link']); ?>"
                         title="<?php echo esc_attr($atts['title']) ?>"><?php echo wp_get_attachment_image($atts['image'], 'full'); ?>
            </a>
        </div>
        <?php if ($atts['title'] != '') { ?>
            <h3 class="title-demo-box">
                <a href="<?php echo esc_url($atts['link']); ?>" title="<?php echo esc_attr($atts['title']) ?>">
                    <?php echo esc_html($atts['title']) ?>
                </a>
            </h3>
        <?php } ?>
    <?php endif; ?>
</div>

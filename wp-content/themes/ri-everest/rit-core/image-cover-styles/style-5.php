<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     1.0
 * @author      CleverSoft
 * @link        http://cleversoft.co
 * @copyright   Copyright (c) 2015 CleverSoft
 * @license     GPL v2
 */
$allowed_html_array=array(
    'i'=>array(
        'class'=>true,
    ),
    'a'=>array(
        'class'=>true,
        'href'=>true,
        'title'=>true,
    ),
    'h3',
    'h4'=>array(
        'class'=>true,
    )
)
?>
<div class="rit-element-builder rit-element-image-hover <?php echo esc_attr(($atts['el_class']) ? $atts['el_class'] : '');
        echo esc_attr(' ' . $atts['style']) ?>" <?php echo esc_attr(($atts['fix_height']!=''||$atts['fix_height']!=0)? 'style=height:'.$atts['fix_height'].'px;':'') ?>>
        <div
            class="image-hover-inner <?php echo esc_attr(($atts['enable_parallax']) == 'yes' ? 'rit-parallax' : ''); ?>" <?php if ($atts['enable_parallax'] == 'yes') echo 'data-img="' . wp_get_attachment_url($atts['image'], 'full') . '"' ?> >
<?php if ($atts['image'] && $atts['enable_parallax'] != 'yes') { ?>
    <a href="<?php echo esc_url($atts['link']); ?>">
        <?php echo wp_get_attachment_image($atts['image'], 'full'); ?>
    </a>
<?php } ?>
<?php if ($atts['title'] || $atts['sub_title'] || $atts['text_link'] || $atts['sec_image']) { ?>
    <div class="image-content-hover">
        <div class="border-mask"></div>
        <div class="content">
            <div class="head-content">
                <?php
                echo wp_get_attachment_image($atts['sec_image'], 'full'); ?>
                <?php
                $html = '';
                if ($atts['title']) {
                    echo '<h3><a href="' . esc_attr($atts['link']) . '">' . ($atts['title']) . '</a></h3>';
                } ?>
            </div>
            <?php
            if ($atts['sub_title']) {
                $html .= '<h4 class="sub_title">' . ($atts['sub_title']) . '</h4>';
            }
            if ($atts['text_link']) {
                $html .= '<a href="' . esc_attr($atts['link']) . '" class="btn-img-hover">' . ($atts['text_link']) . '</a>';
            }
            echo wp_kses($html,$allowed_html_array);
            ?>
        </div>
    </div>
<?php } ?>

</div>
</div>
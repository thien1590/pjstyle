<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 05-Nov-15
 * Time: 5:10 PM
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
    ),
    'div'=>array(
        'class'=>true,
    )
)
?>
<div class="wrapper-image-hover style-8<?php echo esc_attr(($atts['el_class']) ? $atts['el_class'] : '');?> <?php echo esc_attr(($atts['enable_parallax']) == 'yes' ? 'rit-parallax-s8' : ''); ?>" <?php echo esc_attr(($atts['fix_height']!=''||$atts['fix_height']!=0)? 'style=height:'.$atts['fix_height'].'px;':'') ?>>
    <div class="wrapper-text">
        <div class="h7-textblock">
            <?php
            $html = '<div class="wrapper-title">';
            if ($atts['title']) {
                $html .= '<h4><a href="' . esc_attr($atts['link']) . '">' . ($atts['title']) . '</a></h4>';
            }

            if ($atts['sub_title']) {
                $html .= '<h2>' . ($atts['sub_title']) . '</h2>';
            }
            if ($atts['text_link']) {
                $html .= '<a href="' . esc_attr($atts['link']) . '" class="btn-img-hover">' . ($atts['text_link']) . '</a>';
            }
            $html.='</div>';
            echo wp_kses($html,$allowed_html_array);
            if ($atts['custom_text']) {?>
                <div class="caption">
               <?php echo esc_html($atts['custom_text'])?>
                </div>
           <?php }
            ?>
        </div>
    </div>
    <div class="wrapper-image">
        <?php if ($atts['image']) { ?>
            <a href="<?php echo esc_url($atts['link']); ?>">
                <?php echo wp_get_attachment_image($atts['image'], 'full'); ?>
            </a>
        <?php } ?>
    </div>
</div>
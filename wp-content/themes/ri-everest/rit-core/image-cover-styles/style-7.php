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
    'h3'=>array(
        'class'=>true,
    ),
    'h4'=>array(
        'class'=>true,
    ),
    'div'=>array(
        'class'=>true,
    )
)
?>
<div class="wrapper-image-hover">
    <div class="rit-element-builder rit-element-image-hover <?php echo esc_attr(($atts['el_class']) ? $atts['el_class'] : '');
        echo esc_attr(' ' . $atts['style']) ?>" <?php echo esc_attr(($atts['fix_height']!=''||$atts['fix_height']!=0)? 'style=height:'.$atts['fix_height'].'px;':'') ?> <?php echo ($atts['mask_color']!=''? 'style="background:'.esc_attr($atts['mask_color']).'"':''); ?> >
        <div class="image-hover-inner  <?php if ($atts['style'] == 'style-4') echo esc_attr($atts['align']) ?> <?php echo esc_attr(($atts['enable_parallax']) == 'yes' ? 'rit-parallax' : ''); ?>"
        >
            <?php if ($atts['image']) { ?>
                <a href="<?php echo esc_url($atts['link']); ?>">
                    <?php echo wp_get_attachment_image($atts['image'], 'full'); ?>
                </a>
            <?php } ?>
            <?php if ($atts['title'] || $atts['sub_title'] || $atts['text_link']) { ?>
                <div class="image-content-hover">
                    <div class="content">
                        <?php
                        $html = '';
                        if ($atts['title']) {
                            $html .= '<h3>' . ($atts['title']) . '</h3>';
                        }

                        if ($atts['sub_title']) {
                            $html .= '<h4><a href="' . esc_attr($atts['link']) . '">' . ($atts['sub_title']) . '</a></h4>';
                        }
                        if ($atts['custom_text']) {
                            $html .= '<div class="custom-text">'.esc_html($atts['custom_text']).'</div>';
                       }
                        if ($atts['text_link']) {
                            $html .= '<a href="' . esc_attr($atts['link']) . '" class="btn-img-hover">' . ($atts['text_link']) . '</a>';
                        }
                        echo wp_kses($html,$allowed_html_array);?>
                    </div>
                </div>
            <?php }
            ?>

        </div>
    </div>
</div>
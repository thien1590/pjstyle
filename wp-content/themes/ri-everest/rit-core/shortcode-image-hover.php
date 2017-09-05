<?php
switch ($atts['style']) {
    case 'style-7':
        echo rit_get_template_part('image-cover-styles/style', '7', array('atts' => $atts));
        break;
    case 'style-8':
        echo rit_get_template_part('image-cover-styles/style', '8', array('atts' => $atts));
        break;
    case 'style-9':
        echo rit_get_template_part('image-cover-styles/style', '9', array('atts' => $atts));
        break;
    case 'style-5':
        echo rit_get_template_part('image-cover-styles/style', '5', array('atts' => $atts));
        break;
    default:
        ?>
        <div class="rit-element-builder rit-element-image-hover  <?php echo esc_attr(($atts['fix_height']!=''||$atts['fix_height']!=0)?'fix-height ':''); echo esc_attr(($atts['enable_parallax']) == 'yes' ? 'rit-wrapper-parallax ' : ' '); ?><?php echo esc_attr(($atts['el_class']) ? $atts['el_class'] : '');
            echo esc_attr(' ' . $atts['style']) ?>" <?php echo esc_attr(($atts['fix_height']!=''||$atts['fix_height']!=0)? 'style=height:'.$atts['fix_height'].'px;':'') ?>>
            <div class="image-hover-inner  <?php if ($atts['style'] == 'style-4' || $atts['style'] == 'style-11') echo esc_attr($atts['align']) ?> <?php echo esc_attr(($atts['enable_parallax']) == 'yes' ? 'rit-parallax' : ''); ?>" <?php if ($atts['enable_parallax'] == 'yes') echo 'data-img="' . wp_get_attachment_url($atts['image'], 'full') . '"' ?>
                <?php if ($atts['style'] == 'style-4') echo 'data-align="' . esc_attr($atts['align']) . '"' ?>
                <?php if($atts['style']=='style-1'){echo ($atts['image']!=''? 'style="background:url('.wp_get_attachment_image_url($atts['image'], 'full').') center center/cover no-repeat"':''); }?>>
                <?php if ($atts['image'] && $atts['enable_parallax'] != 'yes' && $atts['style']!='style-1') { ?>
                    <a href="<?php echo esc_url($atts['link']); ?>">
                        <?php echo wp_get_attachment_image($atts['image'], 'full'); ?>
                    </a>
                <?php } ?>
                <?php if ($atts['title'] || $atts['sub_title'] || $atts['text_link'] || $atts['custom_text']) { ?>
                    <div class="image-content-hover">
                        <div class="border-mask" <?php echo ($atts['mask_color']!=''&&$atts['style'] != 'style-12'? 'style="background:'.esc_attr($atts['mask_color']).'"':''); ?>></div>
                        <div class="content">
                            <?php
                            $html = '';
                            if ($atts['style'] == 'style-4') {
                                $html .= '<div class="caption">';
                            }
                            if ($atts['sub_title']) {
                                $html .= '<h4>' . ($atts['sub_title']) . '</h4>';
                            }
                            if ($atts['title']) {
                                $html .= '<h3><a href="' . esc_attr($atts['link']) . '">' . ($atts['title']) . '</a></h3>';
                            }
                            if ($atts['custom_text']) {
                                $html .= '<div class="custom-text">' . $atts['custom_text'] . '</div>';
                            }
                            if ($atts['text_link']) {
                                if($atts['style']!= 'style-12'){
                                    $html .= '<a href="' . esc_attr($atts['link']) . '" class="btn-img-hover">' . ($atts['text_link']) . '</a>';
                                }else{
                                    $html .= '<a href="' . esc_attr($atts['link']) . '" class="btn-img-hover" style="background:'.esc_attr($atts['mask_color']).'"><span>' . ($atts['text_link']) . '</span><span><i class="clever-icon-arrow-right-light"></i></span></a>';
                                }

                            }
                            if ($atts['style'] == 'style-4') {
                                $html .= '</div>';
                            }
                            echo ent2ncr($html);

                            if($atts['style']== 'style-12'){?>

                               <?php
                            }?>
                        </div>
                    </div>
                <?php }
                if ($atts['style'] == 'style-4' && $atts['image'] != '') {
                    ?>
                    <div class="cover"
                         style="background: url(<?php echo wp_get_attachment_url($atts['image'], 'full') ?>) no-repeat scroll center center / cover "></div>
                    <?php
                }
                ?>

            </div>
        </div>
        <?php
        break;
}
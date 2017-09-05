<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 05-Nov-15
 * Time: 5:10 PM
 */
?>
<div class="rit-element-builder rit-element-image-hover  <?php echo esc_attr(($atts['fix_height']!=''||$atts['fix_height']!=0)?'fix-height ':''); echo esc_attr(($atts['enable_parallax']) == 'yes' ? 'rit-wrapper-parallax' : ''); ?><?php echo esc_attr(($atts['el_class']) ? $atts['el_class'] : '');
echo esc_attr(' ' . $atts['style']) ?>" <?php echo esc_attr(($atts['fix_height']!=''||$atts['fix_height']!=0)? 'style=height:'.$atts['fix_height'].'px;':'') ?>>
    <div class="image-hover-inner  <?php echo esc_attr(($atts['enable_parallax']) == 'yes' ? 'rit-parallax' : ''); ?>" <?php if ($atts['enable_parallax'] == 'yes') echo 'data-img="' . wp_get_attachment_url($atts['image'], 'full') . '"' ?>
        <?php if($atts['fix_height']!=''||$atts['fix_height']!=0){
            if($atts['image']!=''){
                ?>
                style="background:url('<?php echo wp_get_attachment_image_url($atts['image'], 'full');?>') center center/cover no-repeat"
        <?php
            }
        }
        ?>>
        <?php if ($atts['image'] && $atts['enable_parallax'] != 'yes') {
            if($atts['fix_height']=='' && $atts['fix_height']==0){
            ?>
            <a href="<?php echo esc_url($atts['link']); ?>">
                <?php echo wp_get_attachment_image($atts['image'], 'full'); ?>
            </a>
        <?php }} ?>
        <?php if ($atts['title'] || $atts['sub_title'] || $atts['text_link'] || $atts['custom_text']) { ?>
            <div class="image-content-hover">
                <div class="border-mask"></div>
                <div class="content">
                    <?php
                    $style='';
                    $atts['mask_color']!=''? $style='style="background:'.esc_attr($atts['mask_color']).'"':'';
                    $html = '';
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
                        $html .= '<a href="' . esc_attr($atts['link']) . '" '.$style.' class="btn-img-hover">' . ($atts['text_link']) . '</a>';
                    }
                    echo ent2ncr($html);
                    ?>
                </div>
            </div>
        <?php }?>
    </div>
</div>
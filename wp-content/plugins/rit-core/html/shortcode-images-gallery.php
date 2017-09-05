<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     2.0.1
 * @author      CleverSoft
 * @link        http://cleversoft.co
 * @copyright   Copyright (c) 2015 CleverSoft
 * @license     GPL v2
 */
$wrapper_class = $atts['el_class'];
$class = '';
if ($atts['layout'] == 'grid' || $atts['layout'] == 'carousel') {
    switch ($atts['columns']) {
        case '1':
            $class .= "col-xs-12";
            break;
        case '2':
            $class .= "col-xs-12 col-sm-6";
            break;
        case '3':
            $class .= "col-xs-12 col-sm-4";
            break;
        case '4':
            $class .= "col-xs-12 col-sm-3";
            break;
        case '6':
            $class .= "col-xs-12 col-sm-2";
            break;
    }
}
$links = $imgs = array();
$imgs= explode(',', $atts['images']);
$links= explode(',', $atts['links']);
if (count($imgs) > 0):
    ?>
<div class="rit-imgs-gallery <?php echo esc_attr($wrapper_class.' rit-' . $atts['layout'] . '-gallery ') ?>">
    <?php if ($atts['title'] != '') { ?>
    <h3 class="title-shortcode"><?php
        if($atts['font_icon']!=''){
            ?>
            <i class="fa <?php echo esc_attr($atts['font_icon']);?>"></i>
            <?php
        }
        echo esc_html($atts['title']);
        ?></h3>
<?php }
    //Carousel js
    if($atts['layout'] == 'carousel'){
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery(".rit-imgs-gallery<?php echo ($wrapper_class!=''? '.'.esc_js($wrapper_class):'');?> .wrapper-imgs-gallery").owlCarousel({
                    // Most important owl features
                    items: '1',
                    itemsCustom: false,
                    itemsDesktop: [1199, 1],
                    itemsDesktopSmall: [980, 1],
                    itemsTablet: [768, 1],
                    itemsTabletSmall: false,
                    itemsMobile: [479, 1],
                    singleItem: false,
                    itemsScaleUp: false,
                    // Navigation
                    pagination: false,
                    navigation: true,
                    navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    rewindNav: true,
                    scrollPerPage: false
                });
            });
        </script>
        <?php
        $maxitem=$atts['columns']*$atts['rows'];
    }
    //End carousel js
if ($atts['layout'] == 'grid' || $atts['layout'] == 'carousel'){
    ?>
    <div class="row wrapper-imgs-gallery">
    <?php
}
    $i = $j = 0;
    foreach ($imgs as $img) {
        if($atts['layout'] == 'carousel' && $j==0){
            echo '<div class="row rit-wrap-gallery-item">';
        }
        ?>
        <div class="rit-gallery-item <?php echo esc_attr($class) ?>">
            <?php
            if (isset($links[$i])){
            ?>
            <a href="<?php echo esc_attr($links[$i]) ?>">
                <?php } ?>
                <?php echo wp_get_attachment_image($img, 'full'); ?>
                <?php
                if (isset($links[$i])){
                ?>
            </a>
        <?php } ?>
        </div>
        <?php
        $i++;
        $j++;
        if($atts['layout'] == 'carousel' && ($j==$maxitem || $i==count($imgs))){
            echo '</div>';
            $j=0;
        }
    }
if ($atts['layout'] == 'grid' || $atts['layout'] == 'carousel'){
    ?>
    </div>
    <?php
}
    ?>
    </div><?php
endif;
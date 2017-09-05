<?php
//////////////////////////////////////////////////////////////////
// Customizer - Add CSS
//////////////////////////////////////////////////////////////////

function rit_customizer_css()
{
    if (!get_theme_mod('rit_enable_color')){
        ?>
        <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300,300italic,400,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Poppins:300,400,500,600' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Dancing+Script:700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway:700' rel='stylesheet' type='text/css'>
        <?php
    }
    ?>
    <style type="text/css">
        <?php
        $hasLogo = false;
        if (is_single() || is_page()) {

        if (get_post_meta(get_the_ID(), 'rit_logo_page', true) != '' && get_post_meta(get_the_ID(), 'rit_logo_page', true) != 0):
            $hasLogo = true;
        endif;
      $main_bg='';
      if (get_post_meta(get_the_ID(), 'rit_inner_background_color', true) != '') {
          $main_bg .= 'background-color:' . get_post_meta(get_the_ID(), 'rit_inner_background_color', true) . ';';
      }
      if (get_post_meta(get_the_ID(), 'rit_inner_background_image', true) != 0) {

          $main_bg .= 'background-image:url(' . wp_get_attachment_url(get_post_meta(get_the_ID(), 'rit_inner_background_image', true)) . '); ';
          $main_bg .= 'background-position:' . get_post_meta(get_the_ID(), 'rit_background_image_position', true) . ';';
          $main_bg .= get_post_meta(get_the_ID(), 'rit_background_image_size', true) == 'full' ? 'background-size:100% auto;' : 'background-size:' . get_post_meta(get_the_ID(), 'rit_background_image_size', true) . ';';
          $main_bg .= 'background-repeat:' . get_post_meta(get_the_ID(), 'rit_background_image_repeat', true) . ';';

      }
      if ($main_bg != '') {
          ?>
        #rit-main {
        <?php echo esc_attr($main_bg);?>
        }
        <?php
    }
}

        if(get_theme_mod('header_image','')!=''){?>
#header-page.header-oneline #rit-bottom-header, .header-default #rit-main-header, .header-oneline-2 #rit-bottom-header{
    background:url('<?php echo esc_url(get_theme_mod('header_image','')) ?>') center center/cover no-repeat;
}
        <?php }

if($hasLogo){
?>
        .wrapper-logo {
            height: <?php if(get_post_meta(get_the_ID(),'rit_logo_page_height')){ echo esc_attr(get_post_meta(get_the_ID(),'rit_logo_page_height',true).'px');}else{echo '100%';}?>;
            padding-top: <?php echo esc_attr(get_post_meta(get_the_ID(),'rit_logo_page_top', 10).'px')?>;
            padding-bottom: <?php echo esc_attr(get_post_meta(get_the_ID(),'rit_logo_page_bottom', 10).'px');;?>;
        }

        <?php
        }
        else{
        ?>
        .wrapper-logo {
            height: <?php if(get_theme_mod('rit_logo_height')){ echo esc_attr(get_theme_mod('rit_logo_height').'px');}else{echo '100%';}?>;
            padding-top: <?php echo esc_attr(get_theme_mod('rit_logo_top_spacing', 10).'px')?>;
            padding-bottom: <?php echo esc_attr(get_theme_mod('rit_logo_bottom_spacing', 10).'px');;?>;
        }
        <?php
}
//Font and color
         if (!get_theme_mod('rit_enable_color')){
        ?>
        .rit-element-image-hover.style-1 h3 {
            font-family: Raleway; }

        body {
            font-family: 'Alegreya Sans';
        }

        .rit-element-image-hover.style-12 h4, .rit-element-image-hover.style-12 h3, .rit-element-image-hover.style-12 h3 a,dl.variation, td.product-name, .testimonial-des, .cart-item-detail .amount, .countdown-times > div b, .rit-element-image-hover.style-6 h4, .sec-font, .rit-post-large .description {
            font-family: 'Alegreya Sans'; }
        .woocommerce-MyAccount-navigation, .btn-coupon, .form-row label, .input-text, .primary-font, .rit-news-item .title-news a, .sec-nav-block, .product-name, .newsletter-submit, .wrapper-breadcrumb, .pagination, .btn-border, .search-header .label, .primary-nav-block, .woocommerce-result-count, .woocommerce-pagination, .button.yith-wcqv-button, .woo-summary .product_meta label, .entry-summary .product_meta label,
        .button, [class^='btn-'], .btn-black, #ship-to-different-address label, tfoot .shipping th:first-child, .cart-empty, .added_to_cart, .rit-product-filter, .rit-testimonial-shortcode.style-2 .testimonial-des, .countdown-times > div, [class^='title'], h1, h2, h3, h4, h5 {
            font-family: 'Poppins'; }

        .special-font, .rit-element-image-hover.style-3 h4, .rit-element-image-hover.style-1 h4, .default:not(.rit-testimonial-shortcode) .title, .rit-element-image-hover.style-11 h4 {
            font-family: 'Playfair Display', serif; }

        .product_style_5 .title, .dacing-font, .rit-element-image-hover.style-9 .btn-img-hover, .title-fslider, .product_style_1 .title, .rit-testimonial-shortcode.style-1 .title, .rit-blog-grid-layout.blog_style_1 .title, .rit-testimonial-shortcode.style-4 .title, .product_style_5 .title {
            font-family: 'Dancing Script', cursive;
            font-weight: 700; }

        .button, .added_to_cart {
            font-family: 'Poppins' !important;
        }
        <?php
         }
         else{
         // ---------  Accent Color ------------ // ?>
        <?php // ---------  Body ------------ //
         if(get_theme_mod('rit_body_font_select', 'google') == 'google'){
        $body_gg_font = json_decode(get_theme_mod('rit_body_font_google', '{"family":"Hind","variants":["300","regular","500","600","700"],"subsets":[]}'),true);
        $font_family = $body_gg_font['family'];
        $google_font = '//fonts.googleapis.com/css?family='. $font_family.':' . implode(',', $body_gg_font['variants']). implode(',', $body_gg_font['subsets']);?>
        @import url(<?php echo esc_url($google_font); ?>);
        <?php
            $spec_gg_font = json_decode(get_theme_mod('rit_body_font_google', '{"family":"Hind","variants":["300","regular","500","600","700"],"subsets":[]}'),true);
            $spec_font_family = $spec_gg_font['family'];
            $spec_google_font = '//fonts.googleapis.com/css?family='. $spec_font_family.':' . implode(',', $spec_gg_font['variants']). implode(',', $spec_gg_font['subsets']);?>
        @import url(<?php echo esc_url($spec_google_font); ?>);
        <?php $spec_title_gg_font = json_decode(get_theme_mod('rit_body_font_google', '{"family":"Hind","variants":["300","regular","500","600","700"],"subsets":[]}'),true);
            $spec_title_font_family = $spec_title_gg_font['family'];
            $spec_title_google_font = '//fonts.googleapis.com/css?family='. $spec_title_font_family.':' . implode(',', $spec_title_gg_font['variants']). implode(',', $spec_title_gg_font['subsets']);?>
        @import url(<?php echo esc_url($spec_title_google_font); ?>);
        <?php
                }
                else{
                   $spec_title_font_family = $spec_font_family=get_theme_mod('rit_spec_font_standard', 'Arial');
                    $font_family=get_theme_mod('rit_body_font_standard', 'Arial');
                }

        ?>
        body {
            font-family: "<?php echo esc_attr($font_family); ?>";
            color:<?php echo get_theme_mod('rit_body_text_color', '#7d7d7d'); ?>;
            font-size: <?php echo get_theme_mod('rit_enable_body_font_size', '16'); ?>px;
            line-height: <?php echo get_theme_mod('rit_enable_bodyline_height', '24'); ?>px;
            background-color: <?php echo get_theme_mod('rit_body_bg_color', 'rgba(0,0,0,0)'); ?>;
        <?php
        if(get_post_meta(get_the_ID(), 'rit_inner_background_image', true)!=''&&(is_single()||is_page())):?> background-image: url(<?php echo wp_get_attachment_url(get_post_meta(get_the_ID(), 'rit_inner_background_image', true)); ?>);
        <?php
        else:
         if(get_theme_mod('rit_body_bg_image', '')){ ?> background-image: url(<?php echo get_theme_mod('rit_body_bg_image', ''); ?>);
        <?php } ?><?php
           endif;
            ?>
        }
        /*Specail font*/
        .woocommerce-MyAccount-navigation, .btn-coupon, .form-row label, .input-text, .primary-font, .rit-news-item .title-news a, .sec-nav-block, .product-name, .newsletter-submit, .wrapper-breadcrumb, .pagination, .btn-border, .search-header .label, .primary-nav-block, .woocommerce-result-count, .woocommerce-pagination, .button.yith-wcqv-button, .woo-summary .product_meta label, .entry-summary .product_meta label,
        .button, [class^='btn-'],[class^='title'], .btn-black, #ship-to-different-address label, tfoot .shipping th:first-child, .cart-empty, .added_to_cart, .rit-product-filter, .rit-testimonial-shortcode.style-2 .testimonial-des, .countdown-times > div, [class^='title'], h1, h2, h3, h4, h5 {
            font-family: "<?php echo esc_attr($spec_font_family); ?>";
        }
        .button, .added_to_cart{
            font-family: "<?php echo esc_attr($spec_font_family); ?>" !Important;
        }
        /*Main font*/
        .rit-element-image-hover.style-12 h4, .rit-element-image-hover.style-12 h3, .rit-element-image-hover.style-12 h3 a,dl.variation, td.product-name, .testimonial-des, .cart-item-detail .amount, .countdown-times > div b, .rit-element-image-hover.style-6 h4, .sec-font, .rit-post-large .description {
            font-family: "<?php echo esc_attr($font_family); ?>";
        }
        /*Specail title font*/
         .special-font, .rit-element-image-hover.style-3 h4, .rit-element-image-hover.style-1 h4, .default:not(.rit-testimonial-shortcode) .title, .rit-element-image-hover.style-11 h4 ,
        .dacing-font, .rit-element-image-hover.style-9 .btn-img-hover, .title-fslider, .product_style_1 .title, .rit-testimonial-shortcode.style-1 .title, .rit-blog-grid-layout.blog_style_1 .title, .rit-testimonial-shortcode.style-4 .title, .product_style_5 .title {
            font-family: "<?php echo esc_attr($spec_title_font_family); ?>";
        }
        .accent, .accent-color {
            color: <?php echo get_theme_mod('rit_accent_color', '#252525'); ?>;
        }

        a {
            color: <?php echo get_theme_mod('rit_body_link_color', '#252525'); ?>;
        }

        a:hover {
            color: <?php echo get_theme_mod('rit_body_link_hover_color', '#000'); ?>;
        }

        h1 {
            color: <?php echo get_theme_mod('rit_body_h1_color', '#252525'); ?>;
        }

        h2 {
            color: <?php echo get_theme_mod('rit_body_h2_color', '#252525'); ?>;
        }

        h3 {
            color: <?php echo get_theme_mod('rit_body_h3_color', '#252525'); ?>;
        }

        h4 {
            color: <?php echo get_theme_mod('rit_body_h4_color', '#252525'); ?>;
        }

        h5 {
            color: <?php echo get_theme_mod('rit_body_h5_color', '#252525'); ?>;
        }

        h6 {
            color: <?php echo get_theme_mod('rit_body_h6_color', '#252525'); ?>;
        }
        <?php // ---------  Header ------------ // ?>
        #header-page {
            background-color: <?php echo get_theme_mod('rit_header_background_color', 'transparent'); ?> !important;
            color: <?php echo get_theme_mod('rit_header_text_color', '#252525'); ?> !important;
        }

        #header-page a {
            color: <?php echo get_theme_mod('rit_header_link_color', '#252525'); ?> !important;
        }

        #header-page a:hover {
            color: <?php echo get_theme_mod('rit_header_link_hover_color', '#000'); ?> !important;
        }

        <?php // ---------  Main Navigation ------------ // ?>
        #primary-nav li a {
            font-size: <?php echo get_theme_mod('rit_enable_menu_font_size', '14'); ?>px !important
        }

        .header-default #rit-bottom-header-sticky-wrapper {
            background: <?php echo get_theme_mod('rit_nav_bg_color', 'transparent'); ?> !important
        }

        #primary-nav > div > ul > li {
            color: <?php echo get_theme_mod('rit_nav_text_color', '#353535'); ?> !important
        }

        #primary-nav > div > ul > li a {
            color: <?php echo get_theme_mod('rit_nav_link_color', '#353535'); ?> !important
        }

        #primary-nav > div > ul > li a:hover {
            color: <?php echo get_theme_mod('rit_nav_link_hover_color', '#000'); ?> !important
        }

        #primary-nav > div > ul > li a:hover:after {
            background-color: <?php echo get_theme_mod('rit_nav_link_hover_color', '#000'); ?> !important
        }

        #primary-nav ul li ul {
            background-color: <?php echo get_theme_mod('rit_nav_sub_bg_color', 'rgba(0,0,0,0)'); ?> !important
        }

        #primary-nav ul li ul li a {
            color: <?php echo get_theme_mod('rit_nav_sub_link_color', '#353535'); ?> !important
        }

        #primary-nav ul li ul li a:hover {
            color: <?php echo get_theme_mod('rit_nav_sub_link_hover_color', '#000'); ?> !important
        }

        <?php // ---------  Logo ------------ // ?>
        #logo {
            padding-top: <?php echo get_theme_mod('rit_logo_top_spacing', '0') ?> !important;
            padding-bottom: <?php echo get_theme_mod('rit_logo_bottom_spacing', '0') ?> !important;
        }

        #logo img {
            height: <?php echo get_theme_mod('rit_logo_height', 'auto') ?>px !important;
        }

        <?php // ---------  Footer ------------ // ?>
        .rit-footer {
            background-color: <?php echo get_theme_mod('rit_footer_background_color', 'transparent'); ?> !important;
            color: <?php echo get_theme_mod('rit_footer_text_color', '#757575'); ?> !important;
        }

        .rit-footer a {
            color: <?php echo get_theme_mod('rit_footer_link_color', '#757575'); ?> !important;
        }

        .rit-footer a:hover {
            color: <?php echo get_theme_mod('rit_footer_link_hover_color', '#000'); ?> !important;
        }

        .rit-footer {
            border-top: <?php echo get_theme_mod('rit_border_footer_height', '0'); ?>px solid <?php echo get_theme_mod('rit_footer_border_color', 'transparent'); ?> !important
        }

        <?php // ---------  Copy Right ------------ // ?>
        #copy-right {
            background-color: <?php echo get_theme_mod('rit_copyright_bg_color', 'transparent'); ?> !important;
            color: <?php echo get_theme_mod('rit_copyright_text_color', '#757575'); ?> !important;
        }

        #copy-right a {
            color: <?php echo get_theme_mod('rit_copyright_link_color', '#ffff'); ?> !important;
        }

        #copy-right a:hover {
            color: <?php echo get_theme_mod('rit_copyright_link_hover_color', '#000'); ?> !important;
        }

        <?php // ---------  Custom Style ------------ //
        }?>
        <?php if(get_theme_mod( 'rit_custom_css' )) : ?>
        <?php echo get_theme_mod( 'rit_custom_css' ); ?>
        <?php endif; ?>

    </style>
    <?php
}

add_action('wp_head', 'rit_customizer_css');

?>
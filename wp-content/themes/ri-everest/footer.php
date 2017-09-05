<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Ri Everest
 * @since Ri Everest 1.0
 */
?>
</div>
<?php

$class="";
if(is_single()|| is_page()){
    if (get_post_meta(get_the_ID(), 'rit_footer_options', true) == '' || get_post_meta(get_the_ID(), 'rit_footer_options', true) == 'use-default') {
        if(get_theme_mod('rit_enable_footer_fixed')){
            $class="footer-fixed";
        }
    } else {
        if(get_post_meta(get_the_ID(),'rit_enable_footer_fixed',true)=='1'){
            $class="footer-fixed";
        }
    }
}else{
    if(get_theme_mod('rit_enable_footer_fixed')){
        $class="footer-fixed";
    }
}
?>
<footer class="rit-footer <?php echo esc_attr($class)?>" id="rit-footer-<?php if(get_post_meta( get_the_ID(), 'rit_footer_options', true )==''|| get_post_meta( get_the_ID(), 'rit_footer_options', true )=='use-default')echo  get_theme_mod('rit_default_footer', 'default'); else echo get_post_meta( get_the_ID(), 'rit_footer_options', true );?>">
   <span class="footer-btn primary-font"><?php esc_html_e('Show More','ri-everest');?></span>
    <?php
    if(get_post_meta( get_the_ID(), 'rit_footer_options', true )==''|| get_post_meta( get_the_ID(), 'rit_footer_options', true )=='use-default'){
        get_template_part('included/templates/footer/footer', get_theme_mod('rit_default_footer', 'default'));
    }
    else{
        get_template_part('included/templates/footer/footer', get_post_meta( get_the_ID(), 'rit_footer_options', true ));
    }
    ?>
</footer>
<div id="back-to-top"><i class="fa fa-angle-up fa-2x"></i></div>
<?php wp_footer(); ?>
</body>
</html>
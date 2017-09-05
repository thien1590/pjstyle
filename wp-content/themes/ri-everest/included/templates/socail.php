<?php
/**
 * Socail template
 * @package WordPress
 * @subpackage Ri Everest
 * @since Ri Everest 1.0
 */
?>
<div class="rit-socail-page">
    <?php
    if (get_theme_mod('rit_social_facebook', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_facebook', '') . '" class="socail-item" target="_blank" title="Facebook"><i class="fa fa-facebook"></i> </a>';
    }
    if (get_theme_mod('rit_social_twitter', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_twitter', '') . '" class="socail-item" target="_blank" title="Twitter"><i class="fa fa-twitter"></i> </a>';
    }
    if (get_theme_mod('rit_social_googleplus', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_googleplus', '') . '" class="socail-item" target="_blank" title="Google plus"><i class="fa fa-google-plus"></i> </a>';
    }
    if (get_theme_mod('rit_social_dribbble', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_dribbble', '') . '" class="socail-item" target="_blank" title="Dribble"><i class="fa fa-dribbble"></i> </a>';
    }
    if (get_theme_mod('rit_social_vimeo', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_vimeo', '') . '" class="socail-item" target="_blank" title="Vimeo"><i class="fa fa-vimeo"></i> </a>';
    }
    if (get_theme_mod('rit_social_tumblr', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_tumblr', '') . '" class="socail-item" target="_blank" title="Tumblr"><i class="fa fa-tumblr"></i> </a>';
    }
    if (get_theme_mod('rit_social_skype', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_skype', '') . '" class="socail-item" target="_blank" title="Skype"><i class="fa fa-skype"></i> </a>';
    }
    if (get_theme_mod('rit_social_linkedin', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_linkedin', '') . '" class="socail-item" target="_blank" title="Linkin"><i class="fa fa-linkedin"></i> </a>';
    }
    if (get_theme_mod('rit_social_flickr', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_flickr', '') . '" class="socail-item" target="_blank" title="Flick"><i class="fa fa-flickr"></i> </a>';
    }
    if (get_theme_mod('rit_social_youTube', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_youTube', '') . '" class="socail-item" target="_blank" title="YouTube"><i class="fa fa-youtube"></i> </a>';
    }
    if (get_theme_mod('rit_social_foursquare', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_foursquare', '') . '" class="socail-item" target="_blank" title="Foursquare"><i class="fa fa-foursquare"></i> </a>';
    }
    if (get_theme_mod('rit_social_instagram', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_instagram', '') . '" class="socail-item" target="_blank" title="Instagram"><i class="fa fa-instagram"></i> </a>';
    }
    if (get_theme_mod('rit_social_github', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_github', '') . '" class="socail-item" target="_blank" title="Github"><i class="fa fa-github"></i> </a>';
    }
    if (get_theme_mod('rit_social_xing', '') != '') {
        echo '<a href="' . get_theme_mod('rit_social_xing', '') . '" class="socail-item" target="_blank" title="Xing"><i class="fa fa-xing"></i> </a>';
    }
    ?>
</div>

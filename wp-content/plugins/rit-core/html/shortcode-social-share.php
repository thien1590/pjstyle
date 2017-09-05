<?php

$rit_social_counter = RIT_SOCIAL_COUNTER::getInstance();

$params = $rit_social_counter->rit_sc_settings;

$social_list = explode(',', $atts['social_list']);

$format = isset($atts['counter_format']) ? $atts['counter_format'] : 'comma';

$cache_time = isset($atts['cache_time']) ? $atts['cache_time'] : 600;
$cache_time = intval($cache_time);

?>
<div class="clearfix rit-social-share">
    <?php
    global $post;

    if($post){

        foreach ($social_list as $social) {
            ?>
            <div class="rit-sc-each-profile">
            <?php
            switch ($social) {
                case 'facebook':
                    $fb_count = $rit_social_counter->rit_get_facebook_share(get_the_permalink(), $cache_time);
                            
                    ?>
                    <a  class="rit-sc-facebook-icon clearfix rit_popup" href="https://www.facebook.com/sharer.php?u=<?php echo esc_url(get_the_permalink()); ?>">
                        <div class="rit-sc-inner-block">
                            <span class="social-icon"><i class="fa fa-facebook rit-sc-facebook"></i>
                                <span class="media-name"><?php esc_html_e('Facebook', 'rit-core-language');?></span>
                            </span>
                            <span class="rit-sc-count"><?php echo esc_html($rit_social_counter->get_formatted_count($fb_count,$format) ); ?></span>
                        </div>
                    </a>
                    <?php
                    break;
                case 'twitter':
                    ?>
                    <a  class="rit-sc-twitter-icon clearfix rit_popup"  href="https://twitter.com/home?status=<?php echo esc_url(get_the_permalink()); ?>" target="_blank">
                        <div class="rit-sc-inner-block">
                            <span class="social-icon"><i class="fa fa-twitter rit-sc-twitter"></i><span class="media-name"><?php esc_html_e('Twitter', 'rit-core-language');?></span></span>
                            <span class="rit-sc-count"></span>
                        </div>
                    </a>
                    <?php
                    break;
                case 'googlePlus':
                    $gg_count = $rit_social_counter->rit_get_google_plus_share(get_the_permalink(), $cache_time);

                    ?>
                    <a  class="rit-sc-google-plus-icon clearfix rit_popup" href="https://plus.google.com/share?url=<?php echo esc_url(get_the_permalink()); ?>" target="_blank">
                        <div class="rit-sc-inner-block">
                            <span class="social-icon"><i class="rit-sc-googlePlus fa fa-google-plus"></i><span class="media-name"><?php esc_html_e('Google+', 'rit-core-language');?></span></span>
                            <span class="rit-sc-count"><?php echo esc_html($rit_social_counter->get_formatted_count($gg_count,$format) ); ?></span>
                        </div>
                    </a>
                    <?php
                    break;

                case 'pinterest':
                    $pin_count = $rit_social_counter->rit_get_pinterest_share(get_the_permalink(), $cache_time);

                    ?>
                    <a  class="rit-sc-pinterest-icon clearfix rit_popup" href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_the_permalink()); ?>" target="_blank">
                        <div class="rit-sc-inner-block">
                            <span class="social-icon"><i class="rit-sc-pinterest fa fa-pinterest"></i><span class="media-name"><?php esc_html_e('Pinterest', 'rit-core-language');?></span></span>
                            <span class="rit-sc-count"><?php echo esc_html($rit_social_counter->get_formatted_count($pin_count,$format) ); ?></span>
                        </div>
                    </a>
                    <?php
                    break;

                case 'linkedIn':
                    $linkedin_count = $rit_social_counter->rit_get_linkedin_share(get_the_permalink(), $cache_time);

                    ?>
                    <a  class="rit-sc-linkedin-icon clearfix rit_popup" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url(get_the_permalink()); ?>&title=<?php echo esc_url(get_the_title()); ?>&summary=<?php echo esc_url(get_the_excerpt()); ?>&source=<?php echo esc_url(get_the_permalink()); ?>" target="_blank">
                        <div class="rit-sc-inner-block">
                            <span class="social-icon"><i class="rit-sc-linkedin fa fa-linkedin"></i><span class="media-name"><?php esc_html_e('LinkedIn', 'rit-core-language');?></span></span>
                            <span class="rit-sc-count"><?php echo esc_html($rit_social_counter->get_formatted_count($linkedin_count, $format) ); ?></span>
                        </div>
                    </a>
                    <?php
                    break;
                case 'reddit':
                    $reddit_count = $rit_social_counter->rit_get_reddit_share(get_the_permalink(), $cache_time);

                    ?>
                    <a  class="rit-sc-reddit-icon clearfix rit_popup" href="//www.reddit.com/submit?url=<?php echo esc_url(get_the_permalink()); ?>" target="_blank">
                        <div class="rit-sc-inner-block">
                            <span class="social-icon"><i class="rit-sc-reddit fa fa-reddit"></i><span class="media-name"><?php esc_html_e('Reddit', 'rit-core-language');?></span></span>
                            <span class="rit-sc-count"><?php echo esc_html($rit_social_counter->get_formatted_count($reddit_count, $format) ); ?></span>
                        </div>
                    </a>
                    <?php
                    break;
                case 'slack':
                    ?>
                    <a  class="rit-sc-slack-icon clearfix rit_popup" href="http://slackbutton.herokuapp.com/post/new?url=<?php echo esc_url(get_the_permalink()); ?>">
                        <div class="rit-sc-inner-block">
                            <span class="social-icon"><i class="rit-sc-slack fa fa-slack"></i><span class="media-name"><?php esc_html_e('Slack', 'rit-core-language');?></span></span>
                        </div>
                    </a>
                    <?php
                    break;
                case 'email':
                    ?>
                    <a  class="rit-sc-email-icon clearfix rit_popup" href="mailto:?subject=<?php echo esc_url(get_the_title()); ?>&body=<?php echo esc_url(get_the_permalink()); ?>">
                        <div class="rit-sc-inner-block">
                            <span class="social-icon"><i class="rit-sc-email fa fa-envelope-o"></i><span class="media-name"><?php esc_html_e('Email', 'rit-core-language');?></span></span>
                        </div>
                    </a>
                    <?php
                    break;
                }
                ?>
            </div><?php
            }
        }
        
            ?>
</div>


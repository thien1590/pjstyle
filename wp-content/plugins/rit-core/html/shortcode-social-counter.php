<?php

$rit_social_counter = RIT_SOCIAL_COUNTER::getInstance();

$params = $rit_social_counter->rit_sc_settings;

$social_list = explode(';', $atts['social_list']);

$format = isset($atts['counter_format']) ? $atts['counter_format'] : 'comma';
?>
<div class="rit-sc-icons-wrapper clearfix rit-social-counter" >
    <?php
    foreach ($social_list as $social) {
        if (isset($params[$social]['active']) && $params[$social]['active'] == 1) {
            ?>
            <div class="rit-sc-each-profile">
                <?php
                
                $count = $rit_social_counter->get_count($social);

                $count = ($count!=0) ? $rit_social_counter->get_formatted_count($count,$format) : $count;
                
                switch ($social) {
                    case 'facebook':
                        $facebook_page_id = $params['facebook']['page_id'];
                        ?>
                        <a  class="rit-sc-facebook-icon clearfix" href="<?php echo "http://facebook.com/" . $facebook_page_id; ?>" target="_blank">
                            <div class="rit-sc-inner-block">
                                <span class="social-icon"><i class="fa fa-facebook rit-sc-facebook"></i><span class="media-name"><?php esc_html_e('Facebook', RIT_TEXT_DOMAIN);?></span></span>
                                <span class="rit-sc-count"><?php echo esc_html($count); ?></span><span class="rit-social-counter-text"><?php esc_html_e('Fans', RIT_TEXT_DOMAIN);?></span>
                            </div>
                        </a>
                            <?php
                            break;
                    case 'twitter':
                              ?>
                        <a  class="rit-sc-twitter-icon clearfix"  href="<?php echo 'http://twitter.com/'.$params['twitter']['username'];?>" target="_blank">
                            <div class="rit-sc-inner-block">
                                <span class="social-icon"><i class="fa fa-twitter rit-sc-twitter"></i><span class="media-name"><?php esc_html_e('Twitter', RIT_TEXT_DOMAIN);?></span></span>
                                <span class="rit-sc-count"><?php echo esc_html($count); ?></span><span class="rit-social-counter-text"><?php esc_html_e('Followers', RIT_TEXT_DOMAIN);?></span>
                            </div>
                        </a>
                        <?php
                        break;
                    case 'googlePlus':
                        $social_url = 'https://plus.google.com/' . $params['googlePlus']['page_id'];
                        ?>
                        <a  class="rit-sc-google-plus-icon clearfix" href="<?php echo $social_url; ?>" target="_blank">
                            <div class="rit-sc-inner-block">
                                <span class="social-icon"><i class="rit-sc-googlePlus fa fa-google-plus"></i><span class="media-name"><?php esc_html_e('Google+', RIT_TEXT_DOMAIN);?></span></span>
                                <span class="rit-sc-count"><?php echo esc_html($count); ?></span><span class="rit-social-counter-text"><?php esc_html_e('Followers', RIT_TEXT_DOMAIN);?></span>
                            </div>
                        </a>
                        <?php
                            break;
                    case 'instagram':
                        $username = $params['instagram']['username'];
                        $user_id = $params['instagram']['user_id'];
                        $social_url = 'https://instagram.com/' . $username;
                        ?>
                        <a  class="rit-sc-instagram-icon clearfix" href="<?php echo $social_url; ?>" target="_blank">
                            <div class="rit-sc-inner-block">
                                <span class="social-icon"><i class="rit-sc-instagram fa fa-instagram"></i><span class="media-name"><?php esc_html_e('Instagram', RIT_TEXT_DOMAIN);?></span></span>
                                <span class="rit-sc-count"><?php echo esc_html($count); ?></span><span class="rit-social-counter-text"><?php esc_html_e('Followers', RIT_TEXT_DOMAIN);?></span>
                            </div>
                        </a>
                        <?php
                        break;
                    case 'youtube':
                        $social_url = esc_url($params['youtube']['channel_url']);
                        ?>
                        <a class="rit-sc-youtube-icon clearfix" href="<?php echo $social_url; ?>" target="_blank">
                            <div class="rit-sc-inner-block">
                                <span class="social-icon"><i class="rit-sc-youtube fa fa-youtube"></i><span class="media-name"><?php esc_html_e('Youtube', RIT_TEXT_DOMAIN);?></span></span>
                                <span class="rit-sc-count"><?php echo esc_html($count); ?></span><span class="rit-social-counter-text"><?php esc_html_e('Subscriber', RIT_TEXT_DOMAIN);?></span>
                            </div>
                        </a>
                        <?php
                        break;
                    case 'soundcloud':
                        $username = $params['soundcloud']['username'];
                        $social_url = 'https://soundcloud.com/' . $username;
                        ?>
                        <a class="rit-sc-soundcloud-icon clearfix" href="<?php echo $social_url; ?>" target="_blank">
                            <div class="rit-sc-inner-block">
                                <span class="social-icon"><i class="rit-sc-soundcloud fa fa-soundcloud"></i><span class="media-name"><?php esc_html_e('Soundcloud', RIT_TEXT_DOMAIN);?></span></span>
                                <span class="rit-sc-count"><?php echo esc_html($count); ?></span><span class="rit-social-counter-text"><?php esc_html_e('Followers', RIT_TEXT_DOMAIN);?></span>
                            </div>
                        </a>
                        <?php
                        break;
                    case 'dribbble':
                        $social_url = 'http://dribbble.com/'.$params['dribbble']['username'];
                        ?>
                        <a class="rit-sc-dribble-icon clearfix" href="<?php echo $social_url; ?>" target="_blank">
                            <div class="rit-sc-inner-block">
                                <span class="social-icon"><i class="rit-sc-dribbble fa fa-dribbble"></i><span class="media-name"><?php esc_html_e('Dribble', RIT_TEXT_DOMAIN);?></span></span>
                                <span class="rit-sc-count"><?php echo esc_html($count); ?></span><span class="rit-social-counter-text"><?php esc_html_e('Followers', RIT_TEXT_DOMAIN);?></span>
                            </div>
                        </a>
                        <?php
                        break;
                    case 'posts':
                        ?>
                        <a class="rit-sc-edit-icon clearfix" href="javascript:void(0);">
                            <div class="rit-sc-inner-block">
                                <span class="social-icon"><i class="rit-sc-posts fa fa-edit"></i><span class="media-name"><?php esc_html_e('Post', RIT_TEXT_DOMAIN);?></span></span>
                                <span class="rit-sc-count"><?php echo esc_html($count); ?></span><span class="rit-social-counter-text"><?php esc_html_e('Post', RIT_TEXT_DOMAIN);?></span>
                            </div>
                        </a>
                        <?php
                        break;
                    case 'comments':
                        ?>
                        <a class="rit-sc-comment-icon clearfix" href="javascript:void(0);">
                            <div class="rit-sc-inner-block">
                                <span class="social-icon"><i class="rit-sc-comments fa fa-comments"></i><span class="media-name"><?php esc_html_e('Comment', RIT_TEXT_DOMAIN);?></span></span>
                                <span class="rit-sc-count"><?php echo esc_html($count); ?></span><span class="rit-social-counter-text"><?php esc_html_e('Comments', RIT_TEXT_DOMAIN);?></span>
                            </div>
                        </a>
                        <?php
                        break;
                    default:
                        break;
                    }
                    ?>
            </div><?php
                }
            }
            ?>
</div>


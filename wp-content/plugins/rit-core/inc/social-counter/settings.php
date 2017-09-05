<?php 

$rit_sc_settings = $this->rit_sc_settings;

?>
<div class="wrap">
    <div class="rit-sc-add-set-wrapper clearfix">
        <div class="rit-sc-panel">
           
            <?php if(isset($_SESSION['rit_sc_message'])){?><div class="rit-sc-success-message"><p><?php echo $_SESSION['rit_sc_message'];unset($_SESSION['rit_sc_message']);?></p></div><?php }?>
            <div class="rit-sc-boards-wrapper">
               
                <div class="metabox-holder">
                    <div class="postbox">
                        <form class="rit-sc-settings-form" method="post" action="<?php echo admin_url() . 'admin-post.php' ?>">
                            <input type="hidden" name="action" value="rit_sc_settings_action"/>


                        <div class="rit-sc-boards-tabs" id="rit-sc-board-social-profile-settings">
                            <div class="rit-sc-tab-wrapper">
                                <!---Facebook-->
                                <div class="rit-sc-option-outer-wrapper">
                                    <h4><?php _e('Facebook', RIT_TEXT_DOMAIN) ?></h4>
                                    <div class="rit-sc-option-inner-wrapper">
                                        <label><?php _e('Display Counter', RIT_TEXT_DOMAIN) ?></label>
                                        <div class="rit-sc-option-field"><label><input type="checkbox" name="social_profile[facebook][active]" value="1" class="rit-sc-counter-activation-trigger" <?php if(isset($rit_sc_settings['facebook']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', RIT_TEXT_DOMAIN); ?></label></div>
                                    </div>
                                    <div class="rit-sc-option-extra">
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Facebook Page ID', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[facebook][page_id]" value="<?php echo esc_attr($rit_sc_settings['facebook']['page_id']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the page ID or page name.For example:If your page url is https://www.facebook.com/zuck then your page ID is zuck.', RIT_TEXT_DOMAIN); ?></div>
                                                
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Facebook Default Count', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[facebook][default_count]" value="<?php echo isset($rit_sc_settings['facebook']['default_count'])?esc_attr($rit_sc_settings['facebook']['default_count']):'';?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the default count for facebook to show whenever the API is unavailable.', RIT_TEXT_DOMAIN); ?></div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---Facebook-->
                                
                                <!--Twitter-->
                                <div class="rit-sc-option-outer-wrapper">
                                    <h4><?php _e('Twitter', RIT_TEXT_DOMAIN) ?></h4>
                                    <div class="rit-sc-option-inner-wrapper">
                                        <label><?php _e('Display Counter', RIT_TEXT_DOMAIN) ?></label>
                                        <div class="rit-sc-option-field"><label><input type="checkbox" name="social_profile[twitter][active]" value="1" class="rit-sc-counter-activation-trigger" <?php if(isset($rit_sc_settings['twitter']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', RIT_TEXT_DOMAIN); ?></label></div>
                                    </div>
                                    <div class="rit-sc-option-extra">
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Twitter Username', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[twitter][username]" value="<?php echo esc_attr($rit_sc_settings['twitter']['username']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the twitter username.For example:taylor', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Twitter Consumer Key', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[twitter][consumer_key]" value="<?php echo esc_attr($rit_sc_settings['twitter']['consumer_key']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please create an app on Twitter through this link:', RIT_TEXT_DOMAIN); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a><?php _e(' and get this information.'); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Twitter Consumer Secret', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[twitter][consumer_secret]" value="<?php echo esc_attr($rit_sc_settings['twitter']['consumer_secret']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please create an app on Twitter through this link:', RIT_TEXT_DOMAIN); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps </a><?php _e(' and get this information.'); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Twitter Access Token', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[twitter][access_token]" value="<?php echo esc_attr($rit_sc_settings['twitter']['access_token']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please create an app on Twitter through this link:', RIT_TEXT_DOMAIN); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps </a><?php _e(' and get this information.'); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Twitter Access Token Secret', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[twitter][access_token_secret]" value="<?php echo esc_attr($rit_sc_settings['twitter']['access_token_secret']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please create an app on Twitter through this link:', RIT_TEXT_DOMAIN); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps </a><?php _e(' and get this information.'); ?></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--Twitter-->
                                
                                <!--Google Plus-->
                                <div class="rit-sc-option-outer-wrapper">
                                    <h4><?php _e('Google Plus', RIT_TEXT_DOMAIN); ?></h4>
                                    <div class="rit-sc-option-inner-wrapper">
                                        <label><?php _e('Display Counter', RIT_TEXT_DOMAIN) ?></label>
                                        <div class="rit-sc-option-field"><label><input type="checkbox" name="social_profile[googlePlus][active]" value="1" class="rit-sc-counter-activation-trigger" <?php if(isset($rit_sc_settings['googlePlus']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', RIT_TEXT_DOMAIN); ?></label></div>
                                    </div>
                                    <div class="rit-sc-option-extra">
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Google Plus Page Name or Profile ID', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[googlePlus][page_id]" value="<?php echo esc_attr($rit_sc_settings['googlePlus']['page_id']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the page name or profile ID.For example:If your page url is https://plus.google.com/+BBCNews then your page name is +BBCNews', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Google API Key', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[googlePlus][api_key]" value="<?php echo esc_attr($rit_sc_settings['googlePlus']['api_key']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('To get your API Key, first create a project/app in <a href="https://console.developers.google.com/project" target="_blank">https://console.developers.google.com/project</a> and then turn on Google+ API from "APIs & auth >APIs inside your project.Then again go to "APIs & auth > APIs > Credentials > Public API access" and then click "CREATE A NEW KEY" button, select the "Browser key" option and click in the "CREATE" button, and then copy your API key and paste in above field.', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Google Plus-->
                                
                                <!--Instagram-->
                                <div class="rit-sc-option-outer-wrapper">
                                    <h4><?php _e('Instagram', RIT_TEXT_DOMAIN) ?></h4>
                                    <div class="rit-sc-option-inner-wrapper">
                                        <label><?php _e('Display Counter', RIT_TEXT_DOMAIN) ?></label>
                                        <div class="rit-sc-option-field"><label><input type="checkbox" name="social_profile[instagram][active]" value="1" class="rit-sc-counter-activation-trigger" <?php if(isset($rit_sc_settings['instagram']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', RIT_TEXT_DOMAIN); ?></label></div>
                                    </div>
                                    <div class="rit-sc-option-extra">
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Instagram Username', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[instagram][username]" value="<?php echo esc_attr($rit_sc_settings['instagram']['username']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the instagram username', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Instagram User ID', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[instagram][user_id]" value="<?php  echo esc_attr($rit_sc_settings['instagram']['user_id']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the instagram user ID.You can get this information from <a href="http://www.pinceladasdaweb.com.br/instagram/access-token/" target="_blank">http://www.pinceladasdaweb.com.br/instagram/access-token/</a>', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Instagram Access Token', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[instagram][access_token]" value="<?php echo esc_attr($rit_sc_settings['instagram']['access_token']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the instagram Access Token.You can get this information from <a href="http://www.pinceladasdaweb.com.br/instagram/access-token/" target="_blank">http://www.pinceladasdaweb.com.br/instagram/access-token/</a>', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Instagram-->
                                
                                <!--Youtube-->
                                <div class="rit-sc-option-outer-wrapper">
                                    <h4><?php _e('Youtube', RIT_TEXT_DOMAIN) ?></h4>
                                
                                    <div class="rit-sc-option-inner-wrapper">
                                        <label><?php _e('Display Counter', RIT_TEXT_DOMAIN) ?></label>
                                        <div class="rit-sc-option-field"><label><input type="checkbox" name="social_profile[youtube][active]" value="1" class="rit-sc-counter-activation-trigger" <?php if(isset($rit_sc_settings['youtube']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', RIT_TEXT_DOMAIN); ?></label></div>
                                    </div>
                                    <div class="rit-sc-option-extra">
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Youtube Channel ID', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[youtube][channel_id]" value="<?php echo isset($rit_sc_settings['youtube']['channel_id'])?esc_attr($rit_sc_settings['youtube']['channel_id']):'';?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the youtube channel ID.Your channel ID looks like: UC4WMyzBds5sSZcQxyAhxJ8g. And please note that your channel ID is different from username.Please go <a href="https://support.google.com/youtube/answer/3250431?hl=en" target="_blank">here</a> to know how to get your channel ID.', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Youtube Channel URL', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[youtube][channel_url]" value="<?php echo esc_attr($rit_sc_settings['youtube']['channel_url']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the youtube channel URL.For example:https://www.youtube.com/user/accesspressthemes', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Youtube API Key', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[youtube][api_key]" value="<?php echo isset($rit_sc_settings['youtube']['api_key'])?esc_attr($rit_sc_settings['youtube']['api_key']):'';?>"/>
                                                <div class="rit-sc-option-note"><?php _e('To get your API Key, first create a project/app in <a href="https://console.developers.google.com/project" target="_blank">https://console.developers.google.com/project</a> and then turn on both Youtube Data and Analytics API from "APIs & auth >APIs inside your project.Then again go to "APIs & auth > APIs > Credentials > Public API access" and then click "CREATE A NEW KEY" button, select the "Browser key" option and click in the "CREATE" button, and then copy your API key and paste in above field.', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Default Subscribers Count', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[youtube][subscribers_count]" value="<?php echo isset($rit_sc_settings['youtube']['subscribers_count'])?esc_attr($rit_sc_settings['youtube']['subscribers_count']):0;?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter total number of subscribers that your youtube channel has in case the API fetching is failed for automatic update.', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Youtube-->
                                
                                <!--Sound Cloud-->
                                <div class="rit-sc-option-outer-wrapper">
                                    <h4><?php _e('Sound Cloud', RIT_TEXT_DOMAIN) ?></h4>
                                    <div class="rit-sc-option-inner-wrapper">
                                        <label><?php _e('Display Counter', RIT_TEXT_DOMAIN) ?></label>
                                        <div class="rit-sc-option-field"><label><input type="checkbox" name="social_profile[soundcloud][active]" value="1" class="rit-sc-counter-activation-trigger" <?php if(isset($rit_sc_settings['soundcloud']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', RIT_TEXT_DOMAIN); ?></label></div>
                                    </div>
                                    <div class="rit-sc-option-extra">
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('SoundCloud Username', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[soundcloud][username]" value="<?php echo $rit_sc_settings['soundcloud']['username'];?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the SoundCloud username.For example:bchettri', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('SoundCloud Client ID', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[soundcloud][client_id]" value="<?php echo esc_attr($rit_sc_settings['soundcloud']['client_id']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter the SoundCloud APP Client ID.You can get this information from <a href="http://soundcloud.com/you/apps/new">http://soundcloud.com/you/apps/new</a> after creating a new app', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Sound Cloud-->
                                
                                <!--Dribbble-->
                                <div class="rit-sc-option-outer-wrapper">
                                    <h4><?php _e('Dribbble', RIT_TEXT_DOMAIN) ?></h4>
                                    <div class="rit-sc-option-inner-wrapper">
                                        <label><?php _e('Display Counter', RIT_TEXT_DOMAIN) ?></label>
                                        <div class="rit-sc-option-field"><label><input type="checkbox" name="social_profile[dribbble][active]" value="1" class="rit-sc-counter-activation-trigger" <?php if(isset($rit_sc_settings['dribbble']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', RIT_TEXT_DOMAIN); ?></label></div>
                                    </div>
                                    <div class="rit-sc-option-extra">
                                        <div class="rit-sc-option-inner-wrapper">
                                            <label><?php _e('Dribbble Username', RIT_TEXT_DOMAIN); ?></label>
                                            <div class="rit-sc-option-field">
                                                <input type="text" name="social_profile[dribbble][username]" value="<?php echo esc_attr($rit_sc_settings['dribbble']['username']);?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Please enter your dribbble username.For example:Creativedash', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Dribbble-->
                                
                                <!--Posts-->
                                <div class="rit-sc-option-outer-wrapper">
                                    <h4><?php _e("Posts",RIT_TEXT_DOMAIN)?></h4>
                                    <div class="rit-sc-option-inner-wrapper">
                                        <label><?php _e('Display Counter',RIT_TEXT_DOMAIN);?></label>
                                        <div class="rit-sc-option-field"><label><input type="checkbox" name="social_profile[posts][active]" value="1" class="rit-sc-counter-activation-trigger" <?php if(isset($rit_sc_settings['posts']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', RIT_TEXT_DOMAIN); ?></label></div>
                                    </div>
                                </div>
                                <!--Posts-->
                                
                                <!--Comments-->
                                <div class="rit-sc-option-outer-wrapper">
                                    <h4><?php _e("Comments",RIT_TEXT_DOMAIN);?></h4>
                                    <div class="rit-sc-option-inner-wrapper">
                                        <label><?php _e('Display Counter',RIT_TEXT_DOMAIN);?></label>
                                        <div class="rit-sc-option-field"><label><input type="checkbox" name="social_profile[comments][active]" value="1" class="rit-sc-counter-activation-trigger" <?php if(isset($rit_sc_settings['comments']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', RIT_TEXT_DOMAIN); ?></label></div>
                                    </div>
                                </div>
                                <!--Comments-->
                                

                                <div class="rit-sc-option-outer-wrapper">
                                    <h4><?php _e("Cache",RIT_TEXT_DOMAIN);?></h4>
                                    <div class="rit-sc-option-inner-wrapper">
                                        <label><?php _e('Cache Time', RIT_TEXT_DOMAIN) ?></label>
                                        <div class="rit-sc-option-field">
                                                <input type="text" name="rit_sc_cache_time" value="<?php echo esc_html(get_option('rit_sc_cache_time', 0));?>"/>
                                                <div class="rit-sc-option-note"><?php _e('Cache Time-To-Live Values( second )', RIT_TEXT_DOMAIN); ?></div>
                                            </div>
                                    </div>
                                </div>
                              </div>

                        </div>
                 
                    <?php
                    /**
                     * Nonce field
                     * */
                    wp_nonce_field('rit_sc_settings_action', 'rit_sc_settings_nonce');
                    ?>
                    <div id="optionsframework-submit" class="ap-settings-submit">
                    <input type="submit" class="button button-primary" value="Save all changes" name="rit_settings_submit"/>
                        <?php
                        $nonce = wp_create_nonce('rit-sc-restore-default-nonce');
                        $cache_nonce = wp_create_nonce('rit-sc-cache-nonce');
                        ?>
                        <a href="<?php echo admin_url() . 'admin-post.php?action=rit_sc_restore_default&_wpnonce=' . $nonce; ?>" onclick="return confirm('<?php _e('Are you sure you want to restore default settings?', RIT_TEXT_DOMAIN); ?>')"><input type="button" value="<?php _e('Restore Default Settings',RIT_TEXT_DOMAIN);?>" class="rit-reset-button button button-primary"/></a>
                        
                    </div>
                </form>   
            </div><!--optionsframework-->
</div>
        </div>
    
</div>

</div><!--div class wrap-->
<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     2.0.2
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2015 Zootemplate
 * @license     GPL v2
 */

add_action('widgets_init', 'rit_tweets_load_widgets');

add_action('wp_ajax_rit_twitter_tweets', 'rit_twitter_tweets');
add_action('wp_ajax_nopriv_rit_twitter_tweets', 'rit_twitter_tweets');

function rit_tweets_load_widgets()
{
    register_widget('RIT_Twitter_Tweets_Widget');
}

function rit_twitter_tweets()
{
    if (!isset($_POST['id'])) die;

    $widget_array = get_option('widget_tweets-widget');

    $instance = $widget_array[$_POST['id']];

    require_once(RIT_PLUGIN_PATH . '/vendor/tweet-php/TweetPHP.php');

    $consumer_key = $instance['consumer_key'];
    $consumer_secret = $instance['consumer_secret'];
    $access_token = $instance['access_token'];
    $access_secret = $instance['access_token_secret'];
    $twitter_screen_name = $instance['screen_name'];
    $tweets_to_display = $instance['count'];

    $TweetPHP = new TweetPHP(array(
        'consumer_key' => $consumer_key,
        'consumer_secret' => $consumer_secret,
        'access_token' => $access_token,
        'access_token_secret' => $access_secret,
        'twitter_screen_name' => $twitter_screen_name,
        'cache_file' => dirname(__FILE__) . '/tweet-php/cache/twitter.txt', // Where on the server to save the cached formatted tweets
        'cache_file_raw' => dirname(__FILE__) . '/tweet-php/cache/twitter-array.txt', // Where on the server to save the cached raw tweets
        'cachetime' => 60, // Seconds to cache feed
        'tweets_to_display' => $tweets_to_display, // How many tweets to fetch
        'ignore_replies' => true, // Ignore @replies
        'ignore_retweets' => true, // Ignore retweets
        'twitter_style_dates' => true, // Use twitter style dates e.g. 2 hours ago
        'twitter_date_text' => array('seconds', 'minutes', 'about', 'hour', 'ago'),
        'date_format' => '%I:%M %p %b %d%O', // The defult date format e.g. 12:08 PM Jun 12th. See: http://php.net/manual/en/function.strftime.php
        'date_lang' => get_locale(), // Language for date e.g. 'fr_FR'. See: http://php.net/manual/en/function.setlocale.php
        'format' => 'array', // Can be 'html' or 'array'
        'twitter_wrap_open' => '<ul>',
        'twitter_wrap_close' => '</ul>',
        'tweet_wrap_open' => '<li><span class="status"><i class="fa fa-twitter"></i> ',
        'meta_wrap_open' => '</span><span class="meta"> ',
        'meta_wrap_close' => '</span>',
        'tweet_wrap_close' => '</li>',
        'error_message' => esc_html__('Oops, our twitter feed is unavailable right now.', RIT_TEXT_DOMAIN),
        'error_link_text' => esc_html__('Follow us on Twitter', RIT_TEXT_DOMAIN),
        'debug' => false
    ));

    echo $TweetPHP->get_tweet_list();

    die();
}

class RIT_Twitter_Tweets_Widget extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array('classname' => 'twitter-tweets', 'description' => esc_html__('The most recent tweets from twitter.', RIT_TEXT_DOMAIN));

        $control_ops = array('id_base' => 'tweets-widget');

        parent::__construct('tweets-widget', esc_html__('RIT: Twitter Tweets', RIT_TEXT_DOMAIN), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $consumer_key = $instance['consumer_key'];
        $consumer_secret = $instance['consumer_secret'];
        $access_token = $instance['access_token'];
        $access_token_secret = $instance['access_token_secret'];
        $screen_name = $instance['screen_name'];
        $count = (int)$instance['count'];

        echo $before_widget;

        if ($title) {
            echo $before_title . $title . $after_title;
        }

        if ($screen_name && $consumer_key && $consumer_secret && $access_token && $access_token_secret && $count) {
            ?>
            <div class="tweets-box">
                <p><?php esc_html_e('Please wait...', RIT_TEXT_DOMAIN) ?></p>
            </div>

            <script type="text/javascript">
                /* <![CDATA[ */
                jQuery(function ($) {
                    $.post(js_rit_vars.ajax_url, {
                            id: '<?php echo str_replace('tweets-widget-', '', $widget_id) ?>',
                            action: 'rit_twitter_tweets'
                        },
                        function (data) {
                            if (data) {
                                $('#<?php echo esc_js($widget_id); ?> .tweets-box').html(data);
                                $("#<?php echo esc_js($widget_id); ?> .twitter-slider").owlCarousel({
                                    pagination: false,
                                    navigation: true,
                                    navigationText: false,
                                    singleItem: true,
                                    //transitionStyle : "fade"
                                    autoPlay: 5000
                                });
                            }
                        }
                    );
                });
                /* ]]> */
            </script>
        <?php
        } else {
            echo '<p>' . esc_html__('Please configure widget options.', RIT_TEXT_DOMAIN) . '</p>';
        }

        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['consumer_key'] = $new_instance['consumer_key'];
        $instance['consumer_secret'] = $new_instance['consumer_secret'];
        $instance['access_token'] = $new_instance['access_token'];
        $instance['access_token_secret'] = $new_instance['access_token_secret'];
        $instance['screen_name'] = $new_instance['screen_name'];
        $instance['count'] = $new_instance['count'];

        return $instance;
    }

    function form($instance)
    {
        $defaults = array('title' => esc_html__('Latest Tweets', RIT_TEXT_DOMAIN), 'screen_name' => '', 'count' => 2, 'consumer_key' => '', 'consumer_secret' => '', 'access_token' => '', 'access_token_secret' => '');
        $instance = wp_parse_args((array)$instance, $defaults); ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <strong><?php echo esc_html__('Title', RIT_TEXT_DOMAIN) ?>:</strong>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                       value="<?php if (isset($instance['title'])) echo esc_attr($instance['title']); ?>"/>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('consumer_key')); ?>">
                <strong><?php echo esc_html__('Consumer Key', RIT_TEXT_DOMAIN) ?>:</strong>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('consumer_key')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('consumer_key')); ?>"
                       value="<?php if (isset($instance['consumer_key'])) echo esc_attr($instance['consumer_key']); ?>"/>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('consumer_secret')); ?>">
                <strong><?php echo esc_html__('Consumer Secret', RIT_TEXT_DOMAIN) ?>:</strong>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('consumer_secret')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('consumer_secret')); ?>"
                       value="<?php if (isset($instance['consumer_secret'])) echo esc_attr($instance['consumer_secret']); ?>"/>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('access_token')); ?>">
                <strong><?php echo esc_html__('Access Token', RIT_TEXT_DOMAIN) ?>:</strong>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('access_token')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('access_token')); ?>"
                       value="<?php if (isset($instance['access_token'])) echo esc_attr($instance['access_token']); ?>"/>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('access_token_secret')); ?>">
                <strong><?php echo esc_html__('Access Token Secret', RIT_TEXT_DOMAIN) ?>:</strong>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('access_token_secret')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('access_token_secret')); ?>"
                       value="<?php if (isset($instance['access_token_secret'])) echo esc_attr($instance['access_token_secret']); ?>"/>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('screen_name')); ?>">
                <strong><?php echo esc_html__('Twitter Screen Name', RIT_TEXT_DOMAIN) ?>:</strong>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('screen_name')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('screen_name')); ?>"
                       value="<?php if (isset($instance['screen_name'])) echo esc_attr($instance['screen_name']); ?>"/>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">
                <strong><?php echo esc_html__('Number of Tweets', RIT_TEXT_DOMAIN) ?>:</strong>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('count')); ?>"
                       value="<?php if (isset($instance['count'])) echo esc_attr($instance['count']); ?>"/>
            </label>
        </p>

        <p><strong><?php echo esc_html__('Info', RIT_TEXT_DOMAIN) ?>
                :</strong><br/><?php echo esc_html__('You can find or create <a href="http://dev.twitter.com/apps" target="_blank">Twitter App here</a>.', RIT_TEXT_DOMAIN) ?>
        </p>

    <?php
    }
}
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

if (!class_exists('RITFlickr')) {
    class RITFlickr extends WP_Widget
    {

        function __construct()
        {
            $widget_ops = array(
                'classname' => 'flickr_widget',
                'description' => 'Images from your Flickr account.'
            );
            $control_ops = array('width' => 80, 'height' => 80);
            parent::__construct(false, 'RIT Flickr', $widget_ops, $control_ops);
        }

        function form($instance)
        {
            $instance = wp_parse_args((array)$instance, array('flickr_title' => ''));
            $flickr_title = isset($instance['flickr_title']) ? strip_tags($instance['flickr_title']) : '';
            $flickr_type = isset($instance['flickr_type']) ? strip_tags($instance['flickr_type']) : '';
            $flickr_userid = isset($instance['flickr_userid']) ? strip_tags($instance['flickr_userid']) : '';
            $flickr_num = isset($instance['flickr_num']) ? strip_tags($instance['flickr_num']) : '';
            ?>
            <p><label
                    for="<?php echo esc_attr($this->get_field_id('flickr_title')); ?>"><?php esc_html_e('Title:', RIT_TEXT_DOMAIN); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr_title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('flickr_title')); ?>" type="text"
                       value="<?php echo esc_attr($flickr_title); ?>"/></p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('flickr_type')); ?>">Type (user or group):</label>
                <select id="<?php echo esc_attr($this->get_field_id('flickr_type')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('flickr_type')); ?>" class="widefat">
                    <option <?php if ('user' == $flickr_type) echo 'selected="selected"'; ?>>user</option>
                    <option <?php if ('group' == $flickr_type) echo 'selected="selected"'; ?>>group</option>
                </select>
            </p>
            <p><label
                    for="<?php echo esc_attr($this->get_field_id('flickr_userid')); ?>"><?php esc_html_e('Flickr user ID:', RIT_TEXT_DOMAIN); ?></label>
                <br>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr_userid')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('flickr_userid')); ?>" type="text"
                       value="<?php echo esc_attr($flickr_userid); ?>"/>
                <br>
                <?php /* ?><small><em>Find ID <a href="http://idgettr.com/" target="_blank">http://idgettr.com/</a></em></small><?php */ ?>
                <small><em>Find ID <a href="<?php echo esc_url(esc_html__('http://idgettr.com/', RIT_TEXT_DOMAIN)); ?>"
                                      target="_blank"><?php esc_html_e('http://idgettr.com/', RIT_TEXT_DOMAIN); ?></a></em>
                </small>
            </p>

            <p><label
                    for="<?php echo esc_attr($this->get_field_id('flickr_num')); ?>"><?php esc_html_e('How many pictures display:', RIT_TEXT_DOMAIN); ?></label>
                <input maxlength="3" class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr_num')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('flickr_num')); ?>" type="text"
                       value="<?php echo esc_attr($flickr_num); ?>"/>
            </p>
        <?php
        }

        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['flickr_title'] = strip_tags($new_instance['flickr_title']);
            $instance['flickr_type'] = strip_tags($new_instance['flickr_type']);
            $instance['flickr_userid'] = strip_tags($new_instance['flickr_userid']);
            $instance['flickr_num'] = strip_tags($new_instance['flickr_num']);
            return $instance;
        }

        function widget($args, $instance)
        {
            extract($args);
            $flickr_title = apply_filters('widget_flickr_title', empty($instance['flickr_title']) ? '' : $instance['flickr_title'], $instance);
            $flickr_type = apply_filters('widget_flickr_type', empty($instance['flickr_type']) ? '' : $instance['flickr_type'], $instance);
            $flickr_userid = apply_filters('widget_flickr_userid', empty($instance['flickr_userid']) ? '' : $instance['flickr_userid'], $instance);
            $flickr_num = apply_filters('widget_flickr_num', empty($instance['flickr_num']) ? '' : $instance['flickr_num'], $instance);
            $class = apply_filters('widget_class', empty($instance['class']) ? '' : $instance['class'], $instance);

            echo htmlspecialchars_decode(esc_html($before_widget));

            $flickr_title = $flickr_title;

            if (!empty($flickr_title)) {
                echo htmlspecialchars_decode(esc_html($before_title . $flickr_title . $after_title));
            }
            echo '<div class="flickr-widget">';
            echo '<div class="flickr-channel">'; ?>
            <script type="text/javascript"
                    src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo esc_js($flickr_num); ?>&amp;size=s&amp;layout=v&amp;source=<?php echo esc_js($flickr_type); ?>&amp;<?php echo esc_js($flickr_type); ?>=<?php echo esc_js($flickr_userid); ?>"></script><?php
            echo '</div>';
            echo '</div>';
            echo htmlspecialchars_decode(esc_html($after_widget));
        }
    }
}

add_action('widgets_init', 'rit_flickr_load_widgets');

function rit_flickr_load_widgets()
{
    register_widget('RITFlickr');
}
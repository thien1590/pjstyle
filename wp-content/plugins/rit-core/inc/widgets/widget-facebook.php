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

if (!class_exists('RITFacebook')) {
    class RITFacebook extends WP_Widget
    {

        public function __construct()
        {
            parent::__construct('facebook_widget', 'RIT Facebook', array('description' => esc_html__('Facebook Social widget', RIT_TEXT_DOMAIN),));
        }

        public function form($instance)
        {
            $title = isset($instance['title']) ? $instance['title'] : esc_html__('Facebook widget', RIT_TEXT_DOMAIN);

            $width = isset($instance['width']) ? $instance['width'] : 255;

            $color = isset($instance['color']) ? $instance['color'] : 'dark';

            $stream = isset($instance['stream']) ? $instance['stream'] : 'false';

            $faces = isset($instance['faces']) ? $instance['faces'] : 'true';

            $url = isset($instance['url']) ? $instance['url'] : '';

            $header = isset($instance['header']) ? $instance['header'] : 'false';
            ?>

            <p>
                <label
                    for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', RIT_TEXT_DOMAIN); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>"/>
            </p>

            <p>

                <label
                    for="<?php echo esc_attr($this->get_field_id('url')); ?>"><?php esc_html_e('Facebook Name: ( facebook.com/ * Type into field * )', RIT_TEXT_DOMAIN); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('url')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text"
                       value="<?php echo esc_attr($url); ?>"/>

            </p>

            <p>

                <label
                    for="<?php echo esc_attr($this->get_field_id('width')); ?>"><?php esc_html_e('Width(px):', RIT_TEXT_DOMAIN); ?></label>

                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('width')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('width')); ?>" type="text"
                       value="<?php echo esc_attr($width); ?>"/>

            </p>


            <p>

                <label
                    for="<?php echo esc_attr($this->get_field_id('color')); ?>"><?php esc_html_e('Color scheme:', RIT_TEXT_DOMAIN); ?></label>

                <select id="<?php echo esc_attr($this->get_field_id('color')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('color')); ?>"
                        value="<?php echo esc_attr($color); ?>">

                    <option value='light' <?php if (esc_attr($color) == 'light') echo 'selected'; ?>>Light</option>

                    <option value='dark' <?php if (esc_attr($color) == 'dark') echo 'selected'; ?>>Dark</option>

                </select>


            </p>

            <p>

                <label
                    for="<?php echo esc_attr($this->get_field_id('stream')); ?>"><?php esc_html_e('Show stream:', RIT_TEXT_DOMAIN); ?></label>

                <select id="<?php echo esc_attr($this->get_field_id('stream')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('stream')); ?>"
                        value="<?php echo esc_attr($stream); ?>">

                    <option value='true' <?php if (esc_attr($stream) == 'true') echo 'selected'; ?>>Yes</option>

                    <option value='false' <?php if (esc_attr($stream) == 'false') echo 'selected'; ?>>No</option>

                </select>

            </p>

            <p>

                <label
                    for="<?php echo esc_attr($this->get_field_id('faces')); ?>"><?php esc_html_e('Show faces:', RIT_TEXT_DOMAIN); ?></label>

                <select id="<?php echo esc_attr($this->get_field_id('faces')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('faces')); ?>"
                        value="<?php echo esc_attr($faces); ?>">

                    <option value='true' <?php if (esc_attr($faces) == 'true') echo 'selected'; ?>>Yes</option>

                    <option value='false' <?php if (esc_attr($faces) == 'false') echo 'selected'; ?>>No</option>

                </select>

            </p>

            <p>

                <label
                    for="<?php echo esc_attr($this->get_field_id('header')); ?>"><?php esc_html_e('Show header:', RIT_TEXT_DOMAIN); ?></label>

                <select id="<?php echo esc_attr($this->get_field_id('header')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('header')); ?>"
                        value="<?php echo esc_attr($header); ?>">

                    <option value='true' <?php if (esc_attr($header) == 'true') echo 'selected'; ?>>Yes</option>

                    <option value='false' <?php if (esc_attr($header) == 'false') echo 'selected'; ?>>No</option>

                </select>

            </p>


        <?php
        }

        public function update($new_instance, $old_instance)
        {

            $instance = array();

            $instance['title'] = strip_tags($new_instance['title']);

            $instance['color'] = strip_tags($new_instance['color']);

            $instance['stream'] = strip_tags($new_instance['stream']);

            $instance['width'] = strip_tags($new_instance['width']);

            $instance['faces'] = strip_tags($new_instance['faces']);

            $instance['url'] = strip_tags($new_instance['url']);

            $instance['header'] = strip_tags($new_instance['header']);

            return $instance;
        }

        public function widget($args, $instance)
        {
            wp_enqueue_script('Evatheme_facebook_widget_script');

            extract($args);

            $title = apply_filters('widget_title', $instance['title']);

            $width = $instance['width'];

            $color = $instance['color'];

            $stream = $instance['stream'];

            $faces = $instance['faces'];

            $url = $instance['url'];

            $header = $instance['header'];

            echo htmlspecialchars_decode(esc_html($before_widget));

            if ($title) {
                echo htmlspecialchars_decode(esc_html($before_title . $title . $after_title));
            }
            ?>

            <div class="facebookOuter">
                <div class="facebookInner">
                    <div class="fb-like-box"
                         data-width="<?php echo esc_attr($width); ?>" data-height="300"
                         data-href="http://www.facebook.com/<?php echo esc_attr($url); ?>"
                         data-colorscheme="<?php echo esc_attr($color); ?>"
                         data-show-border="false"
                         data-show-faces="<?php echo esc_attr($faces); ?>"
                         data-stream="<?php echo esc_attr($stream); ?>"
                         data-header="<?php echo esc_attr($header); ?>">
                    </div>
                </div>
            </div>

            <div id="fb-root"></div>

            <script>
                (function (d, s, id) {
                    "use strict";

                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id))
                        return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>

            <?php
            echo htmlspecialchars_decode(esc_html($after_widget));
        }
    }
}

add_action('widgets_init', 'rit_facebook_load_widgets');

function rit_facebook_load_widgets()
{
    register_widget('RITFacebook');
}
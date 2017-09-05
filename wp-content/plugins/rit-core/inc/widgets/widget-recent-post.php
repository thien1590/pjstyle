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

if (!class_exists('RITRecentPosts')) {
    class RITRecentPosts extends WP_Widget
    {
        public function __construct()
        {
            $widget_ops = array('classname' => 'widget-recent-posts', 'description' => esc_html__('Show recent posts.', RIT_TEXT_DOMAIN));

            $control_ops = array('id_base' => 'recent_posts-widget');

            parent::__construct('recent_posts-widget', esc_html__('RIT: Recent Posts', RIT_TEXT_DOMAIN), $widget_ops, $control_ops);
        }

        public function widget($args, $instance)
        {
            extract($args);
            $title = apply_filters('widget_title', $instance['title']);
            $number = $instance['number'];
            $items = $instance['items'];
            $view = $instance['view'];
            $cat = $instance['cat'];
            $show_image = $instance['show_image'];

            if ($items == 0)
                $items = 3;

            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $number
            );

            if ($cat)
                $args['cat'] = $cat;

            $posts = new WP_Query($args);

            if ($posts->have_posts()) :

                echo $before_widget;

                if ($title) {
                    echo $before_title . $title . $after_title;
                }

                ?>
                <div class="row">
                    <div<?php if ($number > $items) : ?> class="post-carousel owl-carousel" data-cols-lg="1" data-cols-md="3" data-cols-sm="2" data-single="<?php echo ($view == 'small' ? '1' : '0') ?>"<?php endif; ?>>
                        <?php
                        $count = 0;
                        while ($posts->have_posts()) {
                            $posts->the_post();
                            global $previousday;
                            unset($previousday);

                            if ($count % $items == 0) echo '<div class="post-slide">';

                            if ($show_image) {
                                get_template_part('content', 'post-item' . ($view == 'small' ? '-small' : ''));
                            } else {
                                get_template_part('content', 'post-item-no-image' . ($view == 'small' ? '-small' : ''));
                            }

                            if ($count % $items == $items - 1) echo '</div>';

                            $count++;
                        }
                        ?>
                    </div>
                </div>
                <?php

                echo $after_widget;

            endif;
            wp_reset_postdata();
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['title'] = strip_tags($new_instance['title']);
            $instance['number'] = $new_instance['number'];
            $instance['items'] = $new_instance['items'];
            $instance['view'] = $new_instance['view'];
            $instance['cat'] = $new_instance['cat'];
            $instance['show_image'] = $new_instance['show_image'];

            return $instance;
        }

        public function form($instance)
        {
            $defaults = array('title' => esc_html__('Recent Posts', RIT_TEXT_DOMAIN), 'number' => 6, 'items' => 3, 'view' => 'small', 'cat' => '', 'show_image' => 'on');
            $instance = wp_parse_args((array)$instance, $defaults); ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <strong><?php esc_html_e('Title', RIT_TEXT_DOMAIN) ?>:</strong>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                           value="<?php if (isset($instance['title'])) echo esc_attr($instance['title']); ?>"/>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('number')); ?>">
                    <strong><?php esc_html_e('Number of posts to show', RIT_TEXT_DOMAIN) ?>:</strong>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('number')); ?>"
                           value="<?php if (isset($instance['number'])) echo esc_attr($instance['number']); ?>"/>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('view')); ?>">
                    <strong><?php esc_html_e('View Type', RIT_TEXT_DOMAIN) ?>:</strong>
                    <select class="widefat" id="<?php echo esc_attr($this->get_field_id('type')); ?>"
                            name="<?php echo esc_attr($this->get_field_name('view')); ?>">
                        <option
                            value="small"<?php echo (isset($instance['view']) && $instance['view'] == 'small') ? ' selected="selected"' : '' ?>><?php esc_html_e('Small', RIT_TEXT_DOMAIN) ?></option>
                        <option
                            value="large"<?php echo (isset($instance['view']) && $instance['view'] == 'large') ? ' selected="selected"' : '' ?>><?php esc_html_e('Large', RIT_TEXT_DOMAIN) ?></option>
                    </select>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('items')); ?>">
                    <strong><?php esc_html_e('Number of items per slide', RIT_TEXT_DOMAIN) ?>:</strong>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('items')); ?>"
                           value="<?php if (isset($instance['items'])) echo esc_attr($instance['items']); ?>"/>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('cat')); ?>">
                    <strong><?php esc_html_e('Category IDs', RIT_TEXT_DOMAIN) ?>:</strong>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('cat')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('cat')); ?>"
                           value="<?php if (isset($instance['cat'])) echo esc_attr($instance['cat']); ?>"/>
                </label>
            </p>
            <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['show_image'], 'on'); ?>
                       id="<?php echo esc_attr($this->get_field_id('show_image')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('show_image')); ?>"/>
                <label
                    for="<?php echo esc_attr($this->get_field_id('show_image')); ?>"><?php echo esc_html__('Show Post Image', RIT_TEXT_DOMAIN) ?></label>
            </p>
            <div class="wrap_banner">
                <div class="banner_title">Footer banner 3</div>
                <div class="banner_content">
                    <img src="">
                    <input type="button" value="Sửa ảnh" class="edit_banner">

                </div>
            </div>
        <?php
        }
    }
}
add_action('widgets_init', 'rit_recent_posts_load_widgets');

function rit_recent_posts_load_widgets()
{
    register_widget('RITRecentPosts');
}
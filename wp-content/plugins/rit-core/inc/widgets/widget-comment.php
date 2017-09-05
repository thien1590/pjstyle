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

add_action('widgets_init', 'RITComment_load_widget');

function RITComment_load_widget()
{
    register_widget('RITComment');
}

class RITComment extends WP_Widget
{

    /**
     * widget construct
     *
     */
    function __construct()
    {

        $widget_ops = array('classname' => 'rit_comments', 'description' => esc_html__('Widget display Recent Comments with avatar', RIT_TEXT_DOMAIN));
        parent::__construct('rit_comments', esc_html__('RIT - Recent Comments', RIT_TEXT_DOMAIN), $widget_ops);

        add_action('wp_insert_comment', array($this, 'invalidate_widget_cache'));

    }

    /**
     * widget
     *
     * @param mixed $args
     * @param mixed $instance
     */
    function widget($args, $instance)
    {
        extract($args);

        $title = apply_filters('widget_title', $instance['title']);
        $count = $instance['count'];

        $output = get_transient($this->id);
        $output = false;
        if ($output == false) {
            ob_start();

            echo $before_widget;

            if ($title)
                echo $before_title . $title . $after_title;

            ?>
            <ul class="latest-comment-list">
                <?php
                global $wpdb;

                $sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,45) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $count";
                $comments = $wpdb->get_results($sql);
                foreach ($comments as $comment) :
                    $has_avatar = '';
                    if (get_avatar($comment->comment_author_email) != '') {
                        $has_avatar = 'class="has_avatar"';
                    }
                    ?>
                    <li <?php echo esc_html($has_avatar); ?>>
                        <?php if (get_avatar($comment->comment_author_email) != '') { ?>
                            <figure><a
                                    href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo esc_attr($comment->comment_ID); ?>"><?php echo esc_html(get_avatar($comment->comment_author_email, '70')); ?></a>
                            </figure>
                        <?php } ?>
                        <cite>
                            <a rel="author" href="<?php echo comment_author_url($comment->comment_ID); ?>"
                                 target="_blank"><?php echo comment_author($comment->comment_ID); ?>
                            </a>
                        </cite>
                        <span><?php esc_html_e('on', RIT_TEXT_DOMAIN); ?> <?php echo get_comment_date(rit_option('date_format'), $comment->comment_ID); ?></span>
                        <span><?php esc_html_e('in :', RIT_TEXT_DOMAIN); ?>
                            <a href="<?php echo get_permalink($comment->ID); ?>" rel="bookmark"><?php $excerpt = $comment->post_title; echo wp_html_excerpt($excerpt, 25);?> ...</a>
                        </span>

                        <div class="comment-body">
                            <p><?php
                                $excerpt = $comment->com_excerpt;
                                echo wp_html_excerpt($excerpt, 145);
                                ?> ...</p>
                        </div>
                    </li>
                <?php endforeach; ?>
                <?php wp_reset_query(); ?>
            </ul>

            <?php

            echo $after_widget;

            $output = ob_get_contents();
            ob_end_clean();
        }

        echo $output;

    }

    /**
     * update settings
     *
     * @param mixed $new_instance
     * @param mixed $old_instance
     * @return array
     */
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'];
        delete_transient($this->id);

        return $instance;
    }


    /**
     * widget form
     *
     * @param mixed $instance
     */
    function form($instance)
    {

        $defaults = array(
            'title' => esc_html__('Comments', RIT_TEXT_DOMAIN),
            'count' => '5'
        );
        $instance = wp_parse_args((array)$instance, $defaults); ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('title:', RIT_TEXT_DOMAIN); ?></label>
            <input type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>"
                   class="widefat"/>
        </p>

        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php esc_html_e('Number of comments', RIT_TEXT_DOMAIN); ?></label>
            <input type="text" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>" value="<?php echo esc_attr($instance['count']); ?>"
                   class="widefat"/>
        </p>


    <?php
    }

    public function invalidate_widget_cache()
    {
        delete_transient($this->id);
    }
}
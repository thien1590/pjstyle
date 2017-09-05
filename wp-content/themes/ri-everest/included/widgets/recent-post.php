<?php
/**
 * Plugin Name: Latest Posts Widget
 */

add_action( 'widgets_init', 'dgt_latest_news_load_widget' );

function dgt_latest_news_load_widget() {
    register_widget( 'dgt_latest_news_widget' );
}

class dgt_latest_news_widget extends WP_Widget {

    /**
     * Widget setup.
     */
    public function __construct() {
        /* Widget settings. */
        $widget_ops = array( 'classname' => 'dgt_latest_news_widget', 'description' => __('A widget that displays your latest posts from all categories or a certain', 'ri-everest') );

        /* Widget control settings. */
        $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'ri-everest' );

        /* Create the widget. */
        parent::__construct(  'dgt_latest_news_widget', __('Bunga: Latest Posts', 'ri-everest'), $widget_ops, $control_ops);
    }

    /**
     * How to display the widget on the screen.
     */
    function widget( $args, $instance ) {
        extract( $args );

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $categories = $instance['categories'];
        $number = $instance['number'];

        $query = array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'cat' => $categories);
        echo ent2ncr($args['before_widget']);
        $loop = new WP_Query($query);
        if ($loop->have_posts()) :

            /* Display the widget title if one was input (before and after defined by themes). */
            if ( $title ) {
                echo ent2ncr($args['before_title'] . $title . $args['after_title']);
            }?>
            <ul class="recent-post-widgets">

            <?php  while ($loop->have_posts()) : $loop->the_post(); ?>

            <li>

                <div class="side-item row">

                    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : ?>
                        <div class="side-image col-sm-5 col-md-5">
                            <a href="<?php echo esc_url(get_permalink()) ?>" rel="bookmark" title="<?php echo esc_attr__('Permanent Link: ','ri-everest'); the_title(); ?>"><?php the_post_thumbnail('thumb', array('class' => 'side-item-thumb')); ?></a>
                        </div>
                    <?php endif; ?>
                    <div class="side-item-text col-sm-7 col-md-7 pl0">
                        <h4><a href="<?php echo esc_url(get_permalink()) ?>" rel="bookmark"  title="<?php echo esc_attr__('Permanent Link: ','ri-everest'); the_title(); ?>"><?php the_title(); ?></a></h4>
                        <span class="side-item-meta"><?php the_time( get_option('date_format') ); ?></span>
                    </div>
                </div>

            </li>

        <?php endwhile; ?>
            <?php wp_reset_query(); ?>
            </ul>
        <?php endif; ?>

        <?php

        /* After widget (defined by themes). */
        echo ent2ncr($args['after_widget']);
    }

    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['categories'] = $new_instance['categories'];
        $instance['number'] = strip_tags( $new_instance['number'] );

        return $instance;
    }


    function form( $instance ) {

        /* Set up some default widget settings. */
        $defaults = array( 'title' => esc_html__('Latest Posts', 'ri-everest'), 'number' => 5, 'categories' => '');
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__('Title:', 'ri-everest'); ?></label>
            <input  type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>"  />
        </p>

        <!-- Category -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php echo esc_html__('Filter by Category:','ri-everest')?></label>
            <select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
                <option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_html__('All categories','ri-everest')?></option>
                <?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
                <?php foreach($categories as $category) { ?>
                    <option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
                <?php } ?>
            </select>
        </p>

        <!-- Number of posts -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php  echo esc_html__('Number of posts to show:', 'ri-everest'); ?></label>
            <input  type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" value="<?php echo $instance['number']; ?>" size="3" />
        </p>


    <?php
    }
}

?>
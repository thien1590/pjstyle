<?php
/**
 * Plugin Name: Recent post widget
 */

add_action( 'widgets_init', 'rit_rpw_widget' );

function rit_rpw_widget() {
    register_widget( 'RIT_RPW' );
}

class RIT_RPW extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => ' rpw', 'description' => __( "Display recent posts in sidebar.",'ri-everest') );
        parent::__construct( 'recent_post', __( 'RIT: Recent Posts for sidebar', 'ri-everest' ), $widget_ops );
    }

    public function widget( $args, $instance ) {

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo ent2ncr($args['before_widget']);
        if ( $title ) {
            echo ent2ncr($args['before_title'] . $title . $args['after_title']);
        }

        $query=array(
            'numberposts' => $instance['totalpost'],
            'category'=>$instance['categories']
        );
        $recent_posts = wp_get_recent_posts( $query );

        if($recent_posts!=''):
            echo '<ul class="rit_rpw">';
        foreach( $recent_posts as $recent ){
            echo '<li><div class="rit_rpw_img"> <a href="' . get_permalink($recent["ID"]) . '">'.get_the_post_thumbnail( $recent["ID"], 'thumbnail' ).'</a> </div> <div class="rit_rpw_info"><h4 class="rit_rpw_title"><a href="' . get_permalink($recent["ID"]) . '" title="' .   $recent["post_title"].'">' .   $recent["post_title"].'</a> </h4><span>'.get_the_date( 'F j, Y ',$recent["ID"]).'</span></div></li> ';
        }
            echo '</ul>';
        endif;
        echo ent2ncr($args['after_widget']);
    }


    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => 'Recent post','totalpost'=>5,'categories'=>'') );
        $title = $instance['title'];
        $totalpost=$instance['totalpost'];
        $categories=$instance['categories']
        ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_html__('Title:','ri-everest'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('categories')); ?>">Filter by Category:</label>
            <select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
                <option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>> <?php echo esc_html__('All categories', 'ri-everest')?></option>
                <?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
                <?php foreach($categories as $category) { ?>
                    <option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_html($category->cat_name); ?></option>
                <?php } ?>
            </select>
        </p>
        <p><label for="<?php echo esc_attr($this->get_field_id('totalpost')); ?>"><?php echo esc_html__('Total posts display:','ri-everest'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('totalpost')); ?>" name="<?php echo esc_attr($this->get_field_name('totalpost')); ?>" type="text" value="<?php echo esc_attr($totalpost); ?>" /></label></p>

    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['categories']=$new_instance['categories'];
        $instance['totalpost']=$new_instance['totalpost'];
        return $instance;
    }

}

?>
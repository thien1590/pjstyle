<?php
/**
 * Plugin Name: About Widget
 */

add_action( 'widgets_init', 'rit_search_widget' );

function rit_search_widget() {
    register_widget( 'RIT_Widget_Search' );
}

class RIT_Widget_Search extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => ' widget_search', 'description' => __( "A search form for your site.",'ri-everest') );
        parent::__construct( 'search', __( 'RIT: Search', 'ri-everest'), $widget_ops );
    }

    public function widget( $args, $instance ) {

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo ent2ncr($args['before_widget']);
        if ( $title ) {
            echo ent2ncr($args['before_title'] . $title . $args['after_title']);
        }?>
        <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">

        <input type="search" class="search-field" placeholder="<?php echo esc_html__( 'Search...', 'ri-everest' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
        <input type="submit" class="search-submit" value=" " />
            <span class="btn btn-search"><i class="fa fa-search"></i></span>
        </form>
        <?php
        // Use current theme search form if it exists
        //get_search_form();

        echo ent2ncr($args['after_widget']);
    }


    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = $instance['title'];
        ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_html__('Title:','ri-everest'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

}

?>
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

class RITTestimonials extends WP_Widget
{

    var $animate = false;

    /**
     * widget construct
     *
     */
    function __construct()
    {
        parent::__construct( false, $name = 'RIT Testimonials Widget' );
    }

    /**
     * update settings
     *
     * @param mixed $new_instance
     * @param mixed $old_instance
     * @return array
     */
    function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags( esc_html( $new_instance['title'] ) );
        $instance['display_count'] = filter_var( $new_instance['display_count'], FILTER_VALIDATE_INT, array( 'default' => 3, 'min_range' => 1 ) );
        $instance['timer_interval'] = filter_var( $new_instance['timer_interval'], FILTER_VALIDATE_INT, array( 'default' => 5, 'min_range' => 1 ) );
        $instance['transition_interval'] = filter_var( $new_instance['transition_interval'], FILTER_VALIDATE_INT, array( 'default' => 1, 'min_range' => 1 ) );
        $instance['loop_all'] = filter_var( $new_instance['loop_all'], FILTER_VALIDATE_BOOLEAN, array( 'default' => 0 ) );
        $instance['order'] = esc_html( $new_instance['order'] );
        $instance['orderby'] = esc_html( $new_instance['orderby'] );
        $instance['transition'] = esc_html( $new_instance['transition'] );
        $instance['template'] = esc_html( $new_instance['template'] );

        $x = 0;
        foreach( get_terms( 'testimonial_category', array( 'hide_empty' => false) ) as $term )
        {
            if( isset( $new_instance[ 'category_' . ++$x ] ) && ! empty( $new_instance[ 'category_' . $x ] ) )
            {
                if( isset( $instance[ 'category_' . $x ] ) )
                {
                    unset( $instance[ 'category_' . $x ] );
                }

                $instance[ 'categories' ][ 'category_' . $x ] = esc_html( $new_instance[ 'category_' . $x ] );
            }
            else
            {
                if( isset( $instance['categories'][ 'category_' . $x ] ) )
                {
                    unset( $instance['categories'][ 'category_' . $x ] );
                }
            }
        }

        return $instance;
    }

    /**
     * widget form
     *
     * @param mixed $instance
     */
    function form( $instance )
    {
        global $testimonials;

        if( ! isset( $instance['orderby'] ) || empty( $instance['orderby'] ) )
            $instance['orderby'] = 'ID';

        if( ! isset( $instance['order'] ) || empty( $instance['order'] ) )
            $instance['order'] = 'desc';

        if( ! isset( $instance['transition'] ) || empty( $instance['transition'] ) )
            $instance['transition'] = 'fade';

        if( ! isset( $instance['template'] ) || empty( $instance['template'] ) )
            $instance['template'] = 'widget';

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:' ); ?>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" 
                name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" 
                type="text" 
                value="<?php echo isset( $instance['title'] ) ? esc_attr($instance['title']) : ''; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'display_count' )); ?>"><?php esc_html_e( 'Display Count:' ); ?> <small><?php esc_html_e( '(-1 shows all testimonials)' ); ?></small>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'display_count' )); ?>" 
                name="<?php echo esc_attr($this->get_field_name( 'display_count' )); ?>" 
                type="text" 
                value="<?php echo isset( $instance['display_count'] ) ? esc_attr($instance['display_count']) : 3; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'timer_interval' )); ?>"><?php esc_html_e( 'Timer Interval:' ); ?>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'timer_interval' )); ?>" 
                name="<?php echo esc_attr($this->get_field_name( 'timer_interval' )); ?>" 
                type="text" 
                value="<?php echo isset( $instance['timer_interval'] ) ? esc_attr($instance['timer_interval']) : 5; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'transition_interval' )); ?>"><?php esc_html_e( 'Transition Interval:' ); ?>
                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id( 'transition_interval' )); ?>" 
                name="<?php echo esc_attr($this->get_field_name( 'transition_interval' )); ?>" 
                type="text" 
                value="<?php echo isset( $instance['transition_interval'] ) ? esc_attr($instance['transition_interval']) : 1; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'template' )); ?>"><?php esc_html_e( 'Output Template:' ); ?></label>
            <select name="<?php echo esc_attr($this->get_field_name( 'template' )); ?>" 
                id="<?php echo esc_attr($this->get_field_id); ?>" class="widefat">
                <?php foreach( $testimonials->templates as $template_id => $template ) : ?>
                    <option value="<?php echo esc_attr($template_id); ?>" <?php selected( $template_id, $instance['template'] ); ?> ><?php echo esc_html($template->name()); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <?php if( ! isset( $instance['loop_all'] ) ) $instance['loop_all'] = 'true'; ?>
            <label for="<?php echo esc_attr($this->get_field_id( 'loop_all' )); ?>">
                <input id="<?php echo esc_attr($this->get_field_id( 'loop_all' )); ?>" 
                value="true" 
                name="<?php echo esc_attr($this->get_field_name( 'loop_all' )); ?>" 
                type="checkbox"<?php checked( true, $instance['loop_all'] ); ?> />
                <?php esc_html_e( 'Loop through all testimonials' ); ?>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><?php esc_html_e( 'Order By:' ); ?></label>

            <select name="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>" 
                id="<?php echo esc_attr($this->get_field_id); ?>">
                <option value="author"<?php selected( 'author', $instance['orderby'] ); ?>><?php esc_html_e( 'Author' ); ?></option>
                <option value="date"<?php selected( 'date', $instance['orderby'] ); ?>><?php esc_html_e( 'Date' ); ?></option>
                <option value="title"<?php selected( 'title', $instance['orderby'] ); ?>><?php esc_html_e( 'Title' ); ?></option>
                <option value="modified"<?php selected( 'modified', $instance['orderby'] ); ?>><?php esc_html_e( 'Modified' ); ?></option>
                <option value="menu_order"<?php selected( 'menu_order', $instance['orderby'] ); ?>><?php esc_html_e( 'Menu Order' ); ?></option>
                <option value="parent"<?php selected( 'parent', $instance['orderby'] ); ?>><?php esc_html_e( 'Parent' ); ?></option>
                <option value="ID"<?php selected( 'ID', $instance['orderby'] ); ?>><?php esc_html_e( 'ID' ); ?></option>
                <option value="rand"<?php selected( 'rand', $instance['orderby'] ); ?>><?php esc_html_e( 'Random' ); ?></option>
                <option value="none"<?php selected( 'none', $instance['orderby'] ); ?>><?php esc_html_e( 'None' ); ?></option>
            </select>

            <select name="<?php echo esc_attr($this->get_field_name( 'order' )); ?>" id="<?php echo esc_attr($this->get_field_id); ?>">
                <option value="asc"<?php selected( 'asc', $instance['order'] ); ?>><?php esc_html_e( 'ASC' ); ?></option>
                <option value="desc"<?php selected( 'desc', $instance['order'] ); ?>><?php esc_html_e( 'DESC' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'transition' )); ?>"><?php esc_html_e( 'Transition:' ); ?></label>

            <select name="<?php echo esc_attr($this->get_field_name( 'transition' )); ?>" id="<?php echo esc_attr($this->get_field_id); ?>">
                <option value="none"<?php selected( 'none', $instance['transition'] ); ?>><?php esc_html_e( 'None' ); ?></option>
                <option value="fade"<?php selected( 'fade', $instance['transition'] ); ?>><?php esc_html_e( 'Fade' ); ?></option>
                <option value="fadeZoom"<?php selected( 'fadeZoom', $instance['transition'] ); ?>><?php esc_html_e( 'FadeZoom' ); ?></option>
                <option value="blindX"<?php selected( 'blindX', $instance['transition'] ); ?>><?php esc_html_e( 'Blind-X' ); ?></option>
                <option value="blindY"<?php selected( 'blindY', $instance['transition'] ); ?>><?php esc_html_e( 'Blind-Y' ); ?></option>
                <option value="blindZ"<?php selected( 'blindZ', $instance['transition'] ); ?>><?php esc_html_e( 'Blind-Z' ); ?></option>
                <option value="cover"<?php selected( 'cover', $instance['transition'] ); ?>><?php esc_html_e( 'Cover' ); ?></option>
                <option value="curtainX"<?php selected( 'curtainX', $instance['transition'] ); ?>><?php esc_html_e( 'Curtain-X' ); ?></option>
                <option value="curtainY"<?php selected( 'curtainY', $instance['transition'] ); ?>><?php esc_html_e( 'Curtain-Y' ); ?></option>
                <option value="growX"<?php selected( 'growX', $instance['transition'] ); ?>><?php esc_html_e( 'Grow-X' ); ?></option>
                <option value="growY"<?php selected( 'growY', $instance['transition'] ); ?>><?php esc_html_e( 'Grow-Y' ); ?></option>
                <option value="scrollUp"<?php selected( 'scrollUp', $instance['transition'] ); ?>><?php esc_html_e( 'Scroll Up' ); ?></option>
                <option value="scrollDown"<?php selected( 'scrollDown', $instance['transition'] ); ?>><?php esc_html_e( 'Scroll Down' ); ?></option>
                <option value="scrollLeft"<?php selected( 'scrollLeft', $instance['transition'] ); ?>><?php esc_html_e( 'Scroll Left' ); ?></option>
                <option value="scrollRight"<?php selected( 'scrollRight', $instance['transition'] ); ?>><?php esc_html_e( 'Scroll Right' ); ?></option>
                <option value="scrollHorz"<?php selected( 'scrollHorz', $instance['transition'] ); ?>><?php esc_html_e( 'Scroll Horizontally' ); ?></option>
                <option value="scrollVert"<?php selected( 'scrollVert', $instance['transition'] ); ?>><?php esc_html_e( 'Scroll Vertically' ); ?></option>
                <option value="shuffle"<?php selected( 'shuffle', $instance['transition'] ); ?>><?php esc_html_e( 'Shuffle' ); ?></option>
                <option value="slideX"<?php selected( 'slideX', $instance['transition'] ); ?>><?php esc_html_e( 'Slide-X' ); ?></option>
                <option value="slideY"<?php selected( 'slideY', $instance['transition'] ); ?>><?php esc_html_e( 'Slide-Y' ); ?></option>
                <option value="toss"<?php selected( 'toss', $instance['transition'] ); ?>><?php esc_html_e( 'Toss' ); ?></option>
                <option value="turnUp"<?php selected( 'turnUp', $instance['transition'] ); ?>><?php esc_html_e( 'Turn Up' ); ?></option>
                <option value="turnDown"<?php selected( 'turnDown', $instance['transition'] ); ?>><?php esc_html_e( 'Turn Down' ); ?></option>
                <option value="turnLeft"<?php selected( 'turnLeft', $instance['transition'] ); ?>><?php esc_html_e( 'Turn Left' ); ?></option>
                <option value="turnRight"<?php selected( 'turnRight', $instance['transition'] ); ?>><?php esc_html_e( 'Turn Right' ); ?></option>
                <option value="uncover"<?php selected( 'uncover', $instance['transition'] ); ?>><?php esc_html_e( 'Uncover' ); ?></option>
                <option value="wipe"<?php selected( 'wipe', $instance['transition'] ); ?>><?php esc_html_e( 'Wipe' ); ?></option>
                <option value="zoom"<?php selected( 'zoom', $instance['transition'] ); ?>><?php esc_html_e( 'Zoom' ); ?></option>
            </select>
        </p>

        <h4>Categories to display</h4>
        <p><small>Due to current limitations only 1 category at a time is supported.</small></p>
        <?php

        $x = 0;
        $categories = isset( $instance['categories'] ) ? $instance['categories'] : array();

        foreach( get_terms( 'testimonial_category', array( 'hide_empty' => false ) ) as $term ) : ++$x; ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'category_' . $x )); ?>">
                    <input id="<?php echo esc_attr($this->get_field_id( 'category_' . $x )); ?>" 
                    type="checkbox" 
                    value="<?php echo esc_attr($term->term_id); ?>" 
                    name="<?php echo esc_attr($this->get_field_name( 'category_' . $x )); ?>" <?php echo checked( true, in_array( $term->term_id, $categories ) ); ?> />
                    <?php esc_html_e( $term->name ); ?> <small>(<?php echo esc_html($term->count); ?>)</small>
                </label>
            </p>
        <?php endforeach;
    }

    /**
     * widget
     *
     * @param mixed $args
     * @param mixed $instance
     */
    function widget( $args, $instance )
    {
        extract( $args );

        echo $before_widget;

        if( isset( $instance['title'] ) )
            printf( '%s%s%s', $before_title, esc_attr( $instance['title'] ), $after_title );

        if( intval( $instance['display_count'] ) == 0 )
            $instance['display_count'] = -1;

        if( ! isset( $instance['template'] ) || empty( $instance['template'] ) )
            $instance['template'] = 'widget';

        $testimonial_args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => isset( $instance['display_count'] ) ? intval( $instance['display_count'] ) : 3,
            'post_status' => 'publish',
            'orderby' => isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : 'ID',
            'order' => isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 'DESC',
        );

        # displaying category only?
        if( isset( $instance['categories'] ) && count( $instance['categories'] ) > 0 )
        {
            sort( $instance['categories'] ); # remove associative keys. category_1, category_2, etc.

            /**
             * As of right now, only one taxonomy can be queried at a time.
             * see http://core.trac.wordpress.org/ticket/12891 for more information
             *
             * so here we get the term name of the first category in the array and
             * pass that as the value for testimonial_category
             */
            $term = get_term( $instance['categories'][0], 'testimonial_category' );
            $testimonial_args['testimonial_category'] = $term->name;

        }

        # loop all
        if( 1 == (int)$instance['loop_all'] ){
            $testimonial_args['posts_per_page'] = -1;
            $this->animate = true;
        }

        $testimonials = new WP_Query( $testimonial_args );

        # widget settings ?>
        <script type="text/javascript">/* <![CDATA[ */
            var testimonial_settings = {
                transition_interval:  <?php echo (int)$instance['transition_interval']; ?>,
                timer_interval: <?php echo (int)$instance['timer_interval']; ?>,
                display_count: <?php echo (int)$instance['display_count']; ?>,
                loop_all:  <?php echo (int)$instance['loop_all']; ?>,
                animate: <?php echo (int)$this->animate; ?>,
                transition: '<?php echo esc_js($instance['transition']); ?>'
            };
            /*]]>*/</script>
        <?php

        if( $testimonials->have_posts() )
        {
            ?>

            <ul id="testimonials-widget">
            <?php

            $x = 0;
            $t = array();

            while( $testimonials->have_posts() )
            {
                $testimonials->the_post();
                $t[] = $testimonials->prepare_testimonial( $instance['template'] );
            }

            if( intval( $instance['display_count'] ) > 0 )
                $pages = array_chunk( $t, isset( $instance['display_count'] ) ? intval( $instance['display_count'] ) : 3, true );
            else
            {
                $pages = array();
                $pages[] = $t;
            }

            $p = 0;
            foreach( $pages as $page )
            {
                $class = ++$p > 1 ? 'testimonial-slide hidden-testimonial' : 'testimonial-slide';
                printf( '<li class="%s"><ul>', $class );

                foreach( $page as $item )
                    if( ! empty( $item ) ) printf('%s', $item );

                printf( '</ul></li>' );
            }

            ?></ul><?php
        }

        wp_reset_query();
        echo $after_widget;
    }
}

add_action('widgets_init', 'rit_social_load_widgets');

function rit_testimonial_load_widgets()
{
    register_widget('RITTestimonials');
}
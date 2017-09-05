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

class RITTab extends WP_Widget {

    var $defaults = array(
        'sidebar' => '',
        'class' => ''
    );

    /**
     * widget construct
     *
     */
    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        parent::__construct('rit_tab', esc_html__('RIT Widget Tab', RIT_TEXT_DOMAIN), array('description' => esc_html__('Sidebar into tabbed widget.', RIT_TEXT_DOMAIN)));
    }


    /**
     * widget
     *
     * @param mixed $args
     * @param mixed $instance
     */
    public function widget($args, $instance) {
        add_filter('dynamic_sidebar_params', array(&$this, 'widget_sidebar_params'));

        extract($args, EXTR_SKIP);

        echo $before_widget;

        if ($args['id'] != $instance['sidebar']) {
            ?>
            <div class="main_tabs">
                <ul class="widget-tabbed-header"></ul>
                <div class="widget-tabbed-body">
                    <?php esc_html(dynamic_sidebar($instance["sidebar"])); ?>
                </div>
            </div>

        <?php
        } else {
            esc_html_e('Tabbed widget is not properly configured.', RIT_TEXT_DOMAIN);
        }
        echo $after_widget;

        remove_filter('dynamic_sidebar_params', array(&$this, 'widget_sidebar_params'));
    }

    /**
     * widget form
     *
     * @param mixed $instance
     */
    public function form($instance) {
        global $wp_registered_sidebars;

        $instance = wp_parse_args((array)$instance, $this->defaults);

        ?>
        <p><label>Sidebar:</label>
            <select style="background-color: white;" class="widefat d4p-tabber-sidebars" 
                id="<?php echo esc_attr($this->get_field_id('sidebar')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('sidebar')); ?>">
                <?php

                foreach ($wp_registered_sidebars as $id => $sidebar) {
                    if ($id != 'wp_inactive_widgets') {
                        $selected = $instance['sidebar'] == $id ? ' selected="selected"' : '';
                        echo sprintf('<option value="%s"%s>%s</option>', esc_attr($id), esc_attr($selected), esc_html($sidebar['name']));
                    }
                }

                ?>
            </select><br/>
            <em><?php esc_html_e('Make sure not to select Sidebar holding this widget. If you do that, Tabber will not be visible.', RIT_TEXT_DOMAIN); ?></em>
        </p>
        <p><label><?php esc_html_e('CSS Class:', RIT_TEXT_DOMAIN); ?></label>
            <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('class')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('class')); ?>" 
                type="text" 
                value="<?php echo esc_attr($instance['class']); ?>" />
        </p>

    <?php
    }



    /**
     * update settings
     *
     * @param mixed $new_instance
     * @param mixed $old_instance
     * @return array
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['sidebar'] = strip_tags(stripslashes($new_instance['sidebar']));
        $instance['class'] = strip_tags(stripslashes($new_instance['class']));

        return $instance;
    }

    public function widget_sidebar_params($params) {
        $params[0]['before_widget'] = '<div class="widget-tab">';
        $params[0]['after_widget'] = '</div>';
        $params[0]['before_title'] = '<a href="#" class="rit-tw-title"><span class="before"></span><span class="after"></span>';
        $params[0]['after_title'] = '</a>';

        return $params;
    }
}

add_action('widgets_init', 'RITTab_load_widgets');

function RITTab_load_widgets() {
    register_widget('RITTab');
}

?>
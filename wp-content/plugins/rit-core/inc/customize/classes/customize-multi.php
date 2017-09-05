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

class WP_Customize_Multiple_Control extends WP_Customize_Control {

/**
* The type of customize control being rendered.
*/
public $type = 'multiple';

/**
* Displays the multiple select on the customize screen.
*/
public function render_content() {

if ( empty( $this->choices ) )
return;
?>
<label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
        <?php
        foreach ( $this->choices as $value => $label ) {
            $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
            echo '<option value="' . esc_attr( $value ) . '"' . esc_attr($selected) . '>' . esc_html($label) . '</option>';
        }
        ?>
    </select>
</label>
<?php }
}
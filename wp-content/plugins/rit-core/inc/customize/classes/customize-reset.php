<?php

/**
 * @class RIT_Customize_Import_Export_Control
 */
class WP_Customize_Cei_Control extends WP_Customize_Control
{
    public $type = 'customize-export-import';
    /**
     * @method render_content
     * @protected
     */
    protected function render_content()
    {
        ?>
        <button class="rit-customize-reset btn"><?php esc_html_e('Reset', RIT_TEXT_DOMAIN)?></button>
        <?php

    }
}
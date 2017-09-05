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
        require_once(dirname(__FILE__) . '/../html/import-export.php');
    }
}
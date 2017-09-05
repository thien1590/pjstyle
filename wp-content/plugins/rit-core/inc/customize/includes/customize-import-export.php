<?php

/**
 * @class RIT_Customize_Import_Export
 */
if (!class_exists('RIT_Customize_Import_Export')) {
    class RIT_Customize_Import_Export
    {

        public function __construct()
        {
            add_action('init', array($this, 'init_customize_import_export'));
        }

        /**
         * @method init
         */
        public function init_customize_import_export()
        {
            if (current_user_can('edit_theme_options')) {

                if (isset($_REQUEST['rit-export'])) {
                    self::_export();
                }
                if (isset($_REQUEST['rit-import']) && isset($_FILES['rit-import-file'])) {
                    self::_import();
                }
            }
        }

        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new RIT_Customize_Import_Export();
            }
            return $instance;
        }

        /**
         * @method _export
         * @private
         */
        private function _export()
        {
            if (!wp_verify_nonce($_REQUEST['rit-export'], 'rit-exporting')) {
                return;
            }

            $theme = get_option('stylesheet');
            $template = get_option('template');
            $charset = get_option('blog_charset');
            $mods = get_theme_mods();
            $data = array(
                'template' => $template,
                'mods' => $mods ? $mods : array(),
                'options' => array()
            );

            // Plugin developers can specify option keys to export.
            $option_keys = apply_filters('cei_export_option_keys', array());

            // Add options to the data.
            foreach ($option_keys as $option_key) {

                $option_value = get_option($option_key);

                if ($option_value) {
                    $data['options'][$option_key] = $option_value;
                }
            }

            // Set the download headers.
            header('Content-disposition: attachment; filename=' . esc_attr($theme) . '-export.dat');
            header('Content-Type: application/octet-stream; charset=' . esc_attr($charset));

            // Serialize the export data.
            echo json_encode($data);

            // Start the download.
            die();
        }

        /**
         * Imports uploaded mods and calls WordPress core customize_save actions so
         * themes that hook into them can act before mods are saved to the database.
         *
         * @method _import
         * @protected
         */
        private function _import($file = null)
        {
            if (!wp_verify_nonce($_REQUEST['rit-import'], 'rit-importing')) {
                return;
            }
            $this->_do_import($file);
            
        }


        public function _do_import($file = null){

            global $wp_customize;
            global $cei_error;

            $cei_error = false;
            $template = get_option('template');
            if($file == null){
                $file = $_FILES['rit-import-file']['tmp_name'];
            }


            $data = json_decode(file_get_contents($file), true);

            // Data checks.
            if ('array' != gettype($data)) {
                $cei_error = esc_html__('Error importing settings! Please check that you uploaded a customizer export file.', RIT_TEXT_DOMAIN);
                return;
            }
            if (!isset($data['template']) || !isset($data['mods'])) {
                $cei_error = esc_html__('Error importing settings! Please check that you uploaded a customizer export file.', RIT_TEXT_DOMAIN);
                return;
            }
            if ($data['template'] != $template) {
                $cei_error = esc_html__('Error importing settings! The settings you uploaded are not for the current theme.', RIT_TEXT_DOMAIN);
                return;
            }

            // Import images.
            if (isset($_REQUEST['rit-import-images'])) {
                $data['mods'] = self::_import_images($data['mods']);
            }

            // Import custom options.
            if (isset($data['options'])) {
                foreach ($data['options'] as $option_key => $option_value) {
                    update_option($option_key, $option_value);
                }
            }

            // Call the customize_save action.
            do_action('customize_save', $wp_customize);

            // Loop through the mods.
            foreach ($data['mods'] as $key => $val) {

                // Call the customize_save_ dynamic action.
                do_action('customize_save_' . $key, $wp_customize);

                // Save the mod.
                set_theme_mod($key, $val);
            }

        }

        /**
         * @method _import_images
         * @private
         */
        private function _import_images($mods)
        {
            foreach ($mods as $key => $val) {

                if (self::_is_image_url($val)) {

                    $data = self::_sideload_image($val);

                    if (!is_wp_error($data)) {

                        $mods[$key] = $data->url;

                        // Handle header image controls.
                        if (isset($mods[$key . '_data'])) {
                            $mods[$key . '_data'] = $data;
                            update_post_meta($data->attachment_id, '_wp_attachment_is_custom_header', get_stylesheet());
                        }
                    }
                }
            }

            return $mods;
        }

        /**
         * Taken from the core media_sideload_image function and
         * modified to return the url instead of html.
         *
         * @method _sideload_image
         * @private
         */
        private function _sideload_image($file)
        {
            $data = new stdClass();

            if (!function_exists('media_handle_sideload')) {
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');
            }
            if (!empty($file)) {

                // Set variables for storage, fix file filename for query strings.
                preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches);
                $file_array = array();
                $file_array['name'] = basename($matches[0]);

                // Download file to temp location.
                $file_array['tmp_name'] = download_url($file);

                // If error storing temporarily, return the error.
                if (is_wp_error($file_array['tmp_name'])) {
                    return $file_array['tmp_name'];
                }

                // Do the validation and storage stuff.
                $id = media_handle_sideload($file_array, 0);

                // If error storing permanently, unlink.
                if (is_wp_error($id)) {
                    @unlink($file_array['tmp_name']);
                    return $id;
                }

                // Build the object to return.
                $meta = wp_get_attachment_metadata($id);
                $data->attachment_id = $id;
                $data->url = wp_get_attachment_url($id);
                $data->thumbnail_url = wp_get_attachment_thumb_url($id);
                $data->height = $meta['height'];
                $data->width = $meta['width'];
            }

            return $data;
        }

        /**
         * @method _is_image_url
         * @private
         */
        private function _is_image_url($string = '')
        {
            if (is_string($string)) {

                if (preg_match('/\.(jpg|jpeg|png|gif)/i', $string)) {
                    return true;
                }
            }

            return false;
        }
    }
}
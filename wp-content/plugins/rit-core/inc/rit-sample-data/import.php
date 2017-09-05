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

if( !function_exists('rit_import_data') ){
	function rit_import_data( $file ){
		if(!class_exists('WP_Import')){
			include RIT_CORE_SAMPLE_DATA_PATH . 'vendor/wordpress-importer/wordpress-importer.php';
		}

		$importer = new WP_Import();
		
		$importer->fetch_attachments = true;

		return $importer->import($file);
	}
}


if( !function_exists('rit_import_widget') ){
	function rit_import_widget( $file ){
		if(!class_exists('Widget_Importer_Exporter')){
			include RIT_CORE_SAMPLE_DATA_PATH . 'vendor/widget-importer-exporter/includes/widgets.php';
			include RIT_CORE_SAMPLE_DATA_PATH . 'vendor/widget-importer-exporter/includes/import.php';
		}

		$data = json_decode(file_get_contents( $file ));

		return wie_import_data( $data );
		
	}
}


if( !function_exists('rit_import_customizer') ){
	function rit_import_customizer( $file ){
		if (!class_exists('RIT_Customize_Import_Export')) {
			include ABSPATH . WPINC . '/class-wp-customize-control.php';
			include RIT_PLUGIN_PATH . 'customize/includes/customize-import-export.php';
		}

		$customize_importer = new RIT_Customize_Import_Export();

		return $customize_importer->_do_import( $file );

	}
}


if( !function_exists('rit_import_slider') ){
	function rit_import_slider( $file ){
		if( class_exists('RevSlider') ) {
		
			$revapi = new RevSlider();
			
			$_FILES["import_file"]["tmp_name"] = $file;
		
		
			return $revapi->importSliderFromPost();
		}

		return false; 
	}
}


if( !function_exists('rit_import_megamenu') ){
	function rit_import_megamenu( $file ){
		if (class_exists('Mega_Menu_Settings')) {

			include RIT_CORE_SAMPLE_DATA_PATH . 'vendor/megamenu/setting.class.php';

			$megamenu = new RIT_Mega_Menu_Settings();

			$_POST['data'] = file_get_contents($file);

			return $megamenu->import_theme();
		}
		return false; 
	}
}
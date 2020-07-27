<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('themestrap_ext_acf_field_js_loader') ) :


class themestrap_ext_acf_field_js_loader extends acf_field
{
	function __construct( $settings ) {
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		$this->name = 'JS_LOADER_EXT';
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		$this->label = __('JS Loader', 'TEXTDOMAIN');
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		$this->category = 'choice';
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		$this->defaults = array(
			'font_size'	=> 14,
		);
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'TEXTDOMAIN'),
		);
		
		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/
		$this->settings = $settings;
		
		// do not delete!
  	parent::__construct();
	}
	
	function render_field( $field ) {
		$path = get_template_directory().'/assets/build/js/selectable';
		$files = array_diff( scandir( $path ), array( '.', '..' ) );

		if ( $files ) {
			echo '<select name="' . esc_attr($field['name']) . '">';
			echo '<option>-- Select --</option>';
			foreach ( $files as $key => $file ) {
				$selected = ( $file === esc_attr( $field['value'] ) ) ? ' selected':'';
				echo '<option value="'.$file.'"'.$selected.'>'.$file.'</option>';
			}
			echo '</select>';
		} else {
			echo $field['value'] . ' not found.';
		}
	}
}

// initialize
new themestrap_ext_acf_field_js_loader( $this->settings );

// class_exists check
endif;
<?php

/*
Plugin Name: Advanced Custom Fields: JS Loader
Plugin URI: https://apexdevs.io/
Description: Select optional javascript files to include per page.
Version: 1.0.0
Author: Tex0gen
Author URI: https://apexdevs.io
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('themestrap_ext_acf_field_js_loaders') ) :

class themestrap_ext_acf_field_js_loaders {
	
	// vars
	var $settings;
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	void
	*  @return	void
	*/
	function __construct() {
		// settings
		// - these will be passed into the field class.
		$this->settings = array(
			'version'	=> '1.0.0',
			'url'		=> plugin_dir_url( __FILE__ ),
			'path'		=> plugin_dir_path( __FILE__ )
		);
		
		
		// include field
		add_action('acf/include_field_types', array($this, 'include_field')); // v5
		// add_action('acf/register_fields', 		array($this, 'include_field')); // v4

		add_filter('acf/settings/load_json', array($this, 'my_acf_json_load_point'));

		add_action( 'wp_enqueue_scripts', array($this, 'themestrap_enqueue_styles'), 5 );
	}

	function themestrap_enqueue_styles() {
    global $post;
    $js_to_enqueue = get_field('javascript', $post->ID);

    if ( $js_to_enqueue ) {
      foreach ( $js_to_enqueue as $key => $file ) {
        wp_enqueue_script( str_replace('.', '', $file['js_loader']), get_template_directory_uri() . '/assets/build/js/selectable/'.$file['js_loader'], array('jquery'), null, true );
      }
    }
	}


	function my_acf_json_load_point( $paths ) {
    // append path
    $paths[] = __DIR__ . '/json';
    
    // return
    return $paths;
	}
	
	
	/*
	*  include_field
	*
	*  This function will include the field type class
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	$version (int) major ACF version. Defaults to 4
	*  @return	void
	*/
	
	function include_field() {
		// load textdomain
		load_plugin_textdomain( 'TEXTDOMAIN', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' ); 
		
		// include
		include_once( plugin_dir_path( __FILE__ ) . 'fields/class-js-loader-ext-v5.php');
	}
}

// initialize
new themestrap_ext_acf_field_js_loaders();

// class_exists check
endif;

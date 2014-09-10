<?php

/**
* The Framework
*/
class Maera_Framework_Core {

	private static $instance;

	private function __construct() {
		do_action( 'maera/framework/include_modules' );

		if ( ! defined( 'MAERA_FRAMEWORK_PATH' ) ) {
			define( 'MAERA_FRAMEWORK_PATH', dirname( __FILE__ ) );
		}

		$compiler = null;

		// Enqueue the scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 110 );

		// Add the framework Timber modifications
		add_filter( 'timber_context', array( $this, 'timber_extras' ) );

		add_theme_support( 'custom-header' );
		add_filter( 'maera/styles', array( $this, 'custom_header' ) );
	}

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register all scripts and additional stylesheets (if necessary)
	 */
	function scripts() {

		wp_register_style( 'bootstrap_min', get_template_directory_uri() . '/framework/core/assets/css/bootstrap.min.css' );
		wp_register_style( 'theme_main', get_template_directory_uri() . '/framework/core/assets/css/main.css' );

		wp_enqueue_style( 'bootstrap_min' );
		wp_enqueue_style( 'theme_main' );

		wp_register_script( 'modernizr-respond', get_template_directory_uri() . '/framework/core/assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', false, null, false );
		wp_register_script( 'panel-menu', get_template_directory_uri() . '/framework/core/assets/js/vendor/jquery.jpanelmenu.min.js', false, null, true );
		wp_register_script( 'bootstrapjs', get_template_directory_uri() . '/framework/core/assets/js/vendor/bootstrap.min.js', false, null, true );
		wp_register_script( 'mainjs', get_template_directory_uri() . '/framework/core/assets/js/main.js', false, null, true );

		wp_enqueue_script( 'modernizr-respond' );
		wp_enqueue_script( 'panel-menu' );
		wp_enqueue_script( 'bootstrapjs' );
		wp_enqueue_script( 'mainjs' );

	}

	/**
	 * Timber extras.
	 */
	function timber_extras( $data ) {

		$data['singular']['image']['switch'] = true;
		$data['singular']['image']['width']  = 550;
		$data['singular']['image']['height'] = 300;

		$data['archives']['image']['switch'] = true;
		$data['archives']['image']['width']  = 550;
		$data['archives']['image']['height'] = 300;

		return $data;
	}

	function custom_header() {

		$url = get_header_image();
		if ( is_singular() && has_post_thumbnail() ) {
			$url_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			$url = $url_array[0];
		}

		if ( empty( $url ) ) {
			return;
		} else {
			return '.sidebar.perma { background: url("' . $url . '") no-repeat center center;';
		}

	}


}

/**
 * Include the framework
 */
function maera_framework_core_include( $frameworks ) {

	// Add our framework to the array of available frameworks
	$frameworks[] = array(
		'value' => 'core',
		'label' => 'Core',
		'class' => 'Maera_Framework_Core',
	);

	return $frameworks;

}
add_filter( 'maera/frameworks/available', 'maera_framework_core_include' );

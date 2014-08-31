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

		add_filter( 'maera/section_class/wrapper', array( $this, 'content_wrapper_class' ) );
		add_filter( 'maera/section_class/content', array( $this, 'content_main_class' ) );
		add_filter( 'maera/section_class/primary', array( $this, 'content_primary_class' ) );
		add_filter( 'maera/section_class/secondary', array( $this, 'content_secondary_class' ) );

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

		wp_register_style( 'theme_core', get_template_directory_uri() . '/framework/core/assets/css/style.css' );
		wp_register_style( 'normalize', get_template_directory_uri() . '/framework/core/assets/css/normalize.css' );

		wp_enqueue_style( 'theme_core' );
		wp_enqueue_style( 'normalize' );

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

	/**
	 * Content wrapper class
	 */
	function content_wrapper_class( $class ) { return $class . ' column medium size-10'; }

	/**
	 * Content class
	 */
	function content_main_class( $class ) { return $class . ' column medium size-8'; }

	/**
	 * Primary Sidebar class
	 */
	function content_primary_class( $class ) { return $class . ' column medium size-4'; }

	/**
	 * Secondary Sidebar class
	 */
	function content_secondary_class( $class ) { return $class . ' column medium size-2'; }

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

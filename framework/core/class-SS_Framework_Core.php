<?php

/**
* The Framework
*/
class SS_Framework_Core {

	private static $instance;

	private function __construct() {
		do_action( 'shoestrap/framework/include_modules' );

		if ( ! defined( 'SS_FRAMEWORK_PATH' ) ) {
			define( 'SS_FRAMEWORK_PATH', dirname( __FILE__ ) );
		}

		$compiler = null;

		// Enqueue the scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 110 );

		// Add the framework Timber modifications
		add_filter( 'timber_context', array( $this, 'timber_extras' ) );

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
	function scripts() {}

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

}

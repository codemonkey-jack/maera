<?php

if ( ! class_exists( 'SS_Framework_Bootstrap' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class SS_Framework_Bootstrap extends SS_Framework_Core {

		private static $instance;

		/**
		 * Class constructor
		 */
		public function __construct() {

			if ( ! defined( 'SS_FRAMEWORK_PATH' ) ) {
				define( 'SS_FRAMEWORK_PATH', dirname( __FILE__ ) );
			}

			// Instantianate the compiler and pass the framework's properties to it
			$compiler = new Shoestrap_Compiler( array(
				'compiler'     => 'less_php',
				'minimize_css' => true,
				'less_path'    => dirname( __FILE__ ) . '/assets/less/',
			) );

			// Trigger the compiler when the customizer options are saved.
			add_action( 'customize_save_after', array( $compiler, 'makecss' ), 77 );

			// Trigger the compiler the first time the theme is enabled
			add_action( 'after_switch_theme', array( $compiler, 'makecss' ) );

			// Enqueue the scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 110 );
		}

		/**
		 * Singleton
		 */
		public static function get_instance() {
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Enqueue all scripts and additional stylesheets (if necessary)
		 */
		function scripts() {
			wp_register_script( 'bootstrap-min', get_template_directory_uri() . '/framework/bootstrap/assets/js/bootstrap.min.js', false, null, true  );
			wp_enqueue_script( 'bootstrap-min' );
		}

		/**
		 * Trigger the compiler when the customizer options are saved
		 */
	}
}

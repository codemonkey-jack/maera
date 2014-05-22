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
				'minimize_css' => false,
				'less_path'    => dirname( __FILE__ ) . '/assets/less/',
			) );

			// Trigger the compiler when the customizer options are saved.
			add_action( 'customize_save_after', array( $compiler, 'makecss' ), 77 );

			// Trigger the compiler the first time the theme is enabled
			add_action( 'after_switch_theme', array( $compiler, 'makecss' ) );

			// Enqueue the scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 110 );

			include_once( SS_FRAMEWORK_PATH . '/classes/class-Shoestrap_Breadcrumbs.php' );

			include_once( SS_FRAMEWORK_PATH . '/functions/layout.php' );
			include_once( SS_FRAMEWORK_PATH . '/functions/logo.php' );
			include_once( SS_FRAMEWORK_PATH . '/functions/widgets.php' );
			include_once( SS_FRAMEWORK_PATH . '/functions/footer.php' );
			include_once( SS_FRAMEWORK_PATH . '/functions/variables.php' );
			include_once( SS_FRAMEWORK_PATH . '/functions/background.php' );
			include_once( SS_FRAMEWORK_PATH . '/functions/typography.php' );
			include_once( SS_FRAMEWORK_PATH . '/functions/colors.php' );
			include_once( SS_FRAMEWORK_PATH . '/functions/blog.php' );

			if ( isset( $wp_customize ) ) {

				include_once( SS_FRAMEWORK_PATH . '/customizer/general.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/colors.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/background.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/layout.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/blog.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/jumbotron.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/menus.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/header.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/footer.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/typography.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/social.php' );
				include_once( SS_FRAMEWORK_PATH . '/customizer/advanced.php' );

			}
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

			wp_register_script( 'bootstrap-accessibility', get_template_directory_uri() . '/framework/bootstrap/assets/js/bootstrap-accessibility.min.js', false, null, true  );
			wp_enqueue_script( 'bootstrap-accessibility' );
		}

		/**
		 * Trigger the compiler when the customizer options are saved
		 */
	}
}

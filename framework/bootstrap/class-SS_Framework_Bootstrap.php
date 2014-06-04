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

			// Add the framework Timber modifications
			add_filter( 'timber_context', array( $this, 'timber_extras' ) );

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
		 * Register all scripts and additional stylesheets (if necessary)
		 */
		function scripts() {
			wp_register_script( 'bootstrap-min', get_template_directory_uri() . '/framework/bootstrap/assets/js/bootstrap.min.js', false, null, true  );
			wp_enqueue_script( 'bootstrap-min' );

			wp_register_script( 'bootstrap-accessibility', get_template_directory_uri() . '/framework/bootstrap/assets/js/bootstrap-accessibility.min.js', false, null, true  );
			wp_enqueue_script( 'bootstrap-accessibility' );

			wp_register_style( 'bootstrap-accessibility', get_template_directory_uri() . '/framework/bootstrap/assets/css/bootstrap-accessibility.css', false, null, true );
			wp_enqueue_style( 'bootstrap-accessibility' );
		}

		/**
		 * Timber extras.
		 */
		function timber_extras( $data ) {

			$data['singular']['image']['switch'] = apply_filters( 'shoestrap/image/switch', get_theme_mod( 'feat_img_post', 0 ) );
			$data['singular']['image']['width']  = get_theme_mod( 'feat_img_post_width', -1 );
			$data['singular']['image']['height'] = get_theme_mod( 'feat_img_post_height', 300 );

			if ( -1 == $data['singular']['image']['width'] ) {
				$data['singular']['image']['width']  = get_theme_mod( 'screen_large_desktop', 1200 );
			}

			$data['archives']['image']['switch'] = get_theme_mod( 'feat_img_archive', 0 );
			$data['archives']['image']['width']  = get_theme_mod( 'feat_img_archive_width', -1 );
			$data['archives']['image']['height'] = get_theme_mod( 'feat_img_archive_height', 300 );

			if ( -1 == $data['archives']['image']['width'] ) {

				$data['archives']['image']['width']  = apply_filters( 'shoestrap/content_width', 960 );

			}

			return $data;
		}

	}

}

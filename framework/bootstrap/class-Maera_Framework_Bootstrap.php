<?php

if ( ! class_exists( 'Maera_Framework_Bootstrap' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class Maera_Framework_Bootstrap {

		private static $instance;


		/**
		 * Class constructor
		 */
		public function __construct() {

			add_theme_support( 'kirki' );
			add_theme_support( 'maera_image' );
			add_theme_support( 'maera_color' );

			if ( ! defined( 'MAERA_FRAMEWORK_PATH' ) ) {
				define( 'MAERA_FRAMEWORK_PATH', dirname( __FILE__ ) );
			}

			// Include the customizer
			include_once( MAERA_FRAMEWORK_PATH . '/customizer.php' );

			// Include other classes
			include_once( MAERA_FRAMEWORK_PATH . '/classes/class-Maera_Framework_Bootstrap_Widgets.php' );
			include_once( MAERA_FRAMEWORK_PATH . '/classes/class-Maera_Framework_Bootstrap_Styles.php' );
			include_once( MAERA_FRAMEWORK_PATH . '/classes/class-Maera_Framework_Bootstrap_Structure.php' );

			// Instantianate addon classes
			global $bs_structure;
			$bs_structure = new Maera_Framework_Bootstrap_Structure();
			global $bs_widgets;
			$bs_widgets   = new Maera_Framework_Bootstrap_Widgets();
			global $bs_styles;
			$bs_styles    = new Maera_Framework_Bootstrap_Styles();

			global $extra_widget_areas;
			$extra_widget_areas = $bs_widgets->extra_widget_areas_array();

			// Instantianate the compiler and pass the framework's properties to it
			$compiler = new Maera_Compiler( array(
				'compiler'     => 'less_php',
				'minimize_css' => false,
				'less_path'    => dirname( __FILE__ ) . '/assets/less/',
			) );

			// Trigger the compiler when the customizer options are saved.
			add_action( 'customize_save_after', array( $compiler, 'makecss' ), 77 );

			// If the CSS file does not exist, attempt creating it.
			if ( ! file_exists( $compiler->file( 'path' ) ) ) {
				add_action( 'wp', array( $compiler, 'makecss' ) );
			}

			// Trigger the compiler the first time the theme is enabled
			add_action( 'after_switch_theme', array( $compiler, 'makecss' ) );

			// Enqueue the scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 110 );

			// Add the framework Timber modifications
			add_filter( 'timber_context', array( $this, 'timber_extras' ), 20 );

			// Excerpt
			add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
			add_filter( 'excerpt_more', array( $this, 'excerpt_more' ), 10, 2 );

			add_filter( 'maera/image/display', array( $this, 'disable_feat_images_ppt' ), 99 );

			// Add stylesheets caching if dev_mode is set to off.
			if ( 0 != get_theme_mod( 'dev_mode' ) ) {
				add_filter( 'maera/styles/caching', '__return_false' );
				TimberLoader::CACHE_NONE;
			} else {
				add_filter( 'maera/styles/caching', '__return_true' );
				// Turn on Timber caching.
				// See https://github.com/jarednova/timber/wiki/Performance#cache-the-twig-file-but-not-the-data
				Timber::$cache = true;
				add_filter( 'maera/timber/cache', array( $this, 'timber_caching' ) );

			}

			add_action( 'maera/topbar/brand', array( $this, 'logo' ) );

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

			if ( get_theme_mod( 'wai_aria', 0 ) == 1 ) {

				wp_register_script( 'bootstrap-accessibility', get_template_directory_uri() . '/framework/bootstrap/assets/js/bootstrap-accessibility.min.js', false, null, true  );
				wp_enqueue_script( 'bootstrap-accessibility' );

				wp_register_style( 'bootstrap-accessibility', get_template_directory_uri() . '/framework/bootstrap/assets/css/bootstrap-accessibility.css', false, null, true );
				wp_enqueue_style( 'bootstrap-accessibility' );

			}

		}


		/**
		 * Timber caching
		 */
		function timber_caching() {

			$caching_int = get_theme_mod( 'caching_int', 0 );

			if ( 0 != $caching_int ) {

				// Convert minutes to seconds
				return ( $caching_int * 60 );

			} else {

				return false;

			}

		}


		/**
		 * Timber extras.
		 */
		function timber_extras( $data ) {

			// Get the layout we're using (sidebar arrangement).
			$layout = apply_filters( 'maera/layout/modifier', get_theme_mod( 'layout', 1 ) );

			If ( 0 == $layout ) {

				$data['sidebar']['primary']   = null;
				$data['sidebar']['secondary'] = null;

				// Add a filter for the layout.
				add_filter( 'maera/layout/modifier', 'maera_return_0' );

			}

			$comment_form_args = array(
				'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'maera' ) . '</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
				'id_submit'     => 'comment-submit',
			);

			$data['comment_form'] = TimberHelper::get_comment_form( null, $comment_form_args );

			return $data;
		}


		/*
		 * The site logo.
		 * If no custom logo is uploaded, use the sitename
		 */
		function logo( $fallback = null ) {

			$logo = get_theme_mod( 'logo', '' );

			if ( $logo ) {
				return '<img id="site-logo" src="' . $logo . '" alt="' . get_bloginfo( 'name' ) .'">';
			} else {
				return $fallback;
			}

		}


		/**
		 * Excerpt length
		 */
		function excerpt_length() {

			return get_theme_mod( 'post_excerpt_length', 55 );

		}


		/**
		 * The "more" text
		 */
		function excerpt_more( $more, $post_id = 0 ) {

			$continue_text = get_theme_mod( 'post_excerpt_link_text', 'Continued' );
			return ' &hellip; <a href="' . get_permalink( $post_id ) . '">' . $continue_text . '</a>';

		}


		/**
		 * Disable featured images per post type.
		 * This is a simple fanction that parses the array of disabled options from the customizer
		 * and then sets their display to 0 if we've selected them in our array.
		 */
		function disable_feat_images_ppt() {
			global $post;

			$current_post_type = get_post_type( $post );
			$images_ppt        = get_theme_mod( 'feat_img_per_post_type', '' );

			// Get the array of disabled featured images per post type
			$disabled = ( '' != $images_ppt ) ? explode( ',', $images_ppt ) : '';

			// Get the default switch values for singulars and archives
			$default = ( is_singular() ) ? get_theme_mod( 'feat_img_post', 0 ) : get_theme_mod( 'feat_img_archive', 0 );

			// If the current post type exists in our array of disabled post types, then set its displaying to false
			if ( $disabled ) {
				$display = ( in_array( $current_post_type, $disabled ) ) ? 0 : $default;
			} else {
				$display = $default;
			}

			return $display;

		}

	}

}

/**
 * Include the framework
 */
function maera_framework_bootstrap_include( $frameworks ) {

	// Add our framework to the array of available frameworks
	$frameworks[] = array(
		'value' => 'bootstrap',
		'label' => 'Bootstrap',
		'class' => 'Maera_Framework_Bootstrap',
	);

	return $frameworks;

}
add_filter( 'maera/frameworks/available', 'maera_framework_bootstrap_include' );

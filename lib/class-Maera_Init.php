<?php

class Maera_Init {

	function __construct() {

		// Early exit if Timber does not exist
		if ( ! class_exists( 'Timber' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'require_libs_init' ) );
		add_action( 'after_setup_theme', array( $this, 'require_libs_after_setup_theme' ) );
		add_action( 'after_setup_theme', array( $this, 'setup' ) );
		add_action( 'wp_head', array( $this, 'render_title' ) );

	}

	function require_libs_after_setup_theme() {

		/**
		 * Include the Custom Widget Areas builder
		 */
		// require_once locate_template( '/lib/class-Maera_CWA.php' );
		// $extra_widget_areas = new Maera_CWA();

		/**
		 * Load the Extended posts widget
		 */
		require_once locate_template( '/lib/widgets/extended-posts/extended-posts.php' );


		/**
		 * Load the Logo widget
		 */
		require_once locate_template( '/lib/widgets/logo/logo.php' );

	}

	function require_libs_init() {

		/**
		 * Load the color library from jetpack
		 */
		if ( function_exists( 'jetpack_require_lib' ) ) {
			jetpack_require_lib( 'class.color' );
		}

		/**
		 * Load the Tonesque library from jetpack
		 */
		if ( function_exists( 'jetpack_require_lib' ) ) {
			jetpack_require_lib( 'tonesque' );
		}

	}

	/**
	 * Maera initial setup and constants
	 */
	function setup() {
		// Make theme available for translation
		load_theme_textdomain( 'maera', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Register wp_nav_menu() menu ( http://codex.wordpress.org/Function_Reference/register_nav_menus )
		register_nav_menus( array(
			'primary_navigation'   => __( 'Primary Navigation', 'maera' )
		 ) );

		// Add post thumbnails ( http://codex.wordpress.org/Post_Thumbnails )
		add_theme_support( 'post-thumbnails' );

		// Add post formats ( http://codex.wordpress.org/Post_Formats )
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

		// Enable support for HTML5 markup.
		add_theme_support( 'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
			'caption',
		) );

		// Tell the TinyMCE editor to use a custom stylesheet
		add_editor_style( '/assets/css/editor-style.css' );

		// Add title-tag support (introduced in WP 4.1)
		add_theme_support( 'title-tag' );

		// site-logo is included in Jetpack 3.2 and above
		add_theme_support( 'site-logo' );

		$lang_dir    = get_template_directory() . '/languages';
		$custom_path = WP_LANG_DIR . '/maera-' . get_locale() . '.mo';

		if ( file_exists( $custom_path ) ) {
			load_textdomain( 'maera', $custom_path );
		} else {
			load_theme_textdomain( 'maera', false, $lang_dir );
		}
	}

	function render_title() {
		if ( ! function_exists( '_wp_render_title_tag' ) ) : ?>
			<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php endif;
	}

}

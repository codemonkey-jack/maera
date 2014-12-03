<?php

class Maera_Init {

	function __construct() {

		// Early exit if Timber does not exist
		if ( ! class_exists( 'Timber' ) ) {
			return;
		}

		add_action( 'init',              array( $this, 'require_libs_init' ) );
		add_action( 'init',              array( $this, 'timber_customizations' ) );
		add_filter( 'timber_context',    array( $this, 'timber_global_context' ) );
		add_action( 'after_setup_theme', array( $this, 'require_libs_after_setup_theme' ) );
		add_action( 'after_setup_theme', array( $this, 'setup' ) );
		add_filter( 'get_twig',          array( $this, 'add_to_twig' ) );

	}

	/**
	 * Returns an array of paths where our twig files are located.
	 */
	public static function twig_locations() {

		$locations = array(
			MAERA_SHELL_PATH . '/macros',
			MAERA_SHELL_PATH . '/views/macros',
			MAERA_SHELL_PATH . '/views',
			MAERA_SHELL_PATH,
			get_stylesheet_directory() . '/macros',
			get_stylesheet_directory() . '/views/macros',
			get_stylesheet_directory() . '/views',
			get_stylesheet_directory(),
			get_template_directory() . '/macros',
			get_template_directory() . '/views/macros',
			get_template_directory() . '/views',
			get_template_directory(),
		);

		return apply_filters( 'maera/timber/locations', $locations );

	}

	/**
	 * Apply global Timber customizations
	 */
	function timber_customizations() {

		$locations = self::twig_locations();
		Timber::$locations = $locations;

		// Add caching if dev_mode is set to off.
		$theme_options = get_option( 'maera_admin_options', array() );
		if ( isset( $theme_options['dev_mode'] ) && 0 == $theme_options['dev_mode'] ) {

			add_filter( 'maera/styles/caching', '__return_true' );
			// Turn on Timber caching.
			// See https://github.com/jarednova/timber/wiki/Performance#cache-the-twig-file-but-not-the-data
			Timber::$cache = true;
			add_filter( 'maera/timber/cache', array( $this, 'timber_caching' ) );

		} else {

			add_filter( 'maera/styles/caching', '__return_false' );
			TimberLoader::CACHE_NONE;

			$_SERVER['QUICK_CACHE_ALLOWED'] = FALSE;
			Maera::define( 'DONOTCACHEPAGE', TRUE );

		}

	}

	/**
	 * Timber caching
	 */
	function timber_caching() {

		$theme_options = get_option( 'maera_admin_options', array() );

		$cache_int = isset( $theme_options['cache'] ) ? intval( $theme_options['cache'] ) : 0;

		if ( 0 == $cache_int ) {

			// No need to proceed if cache=0
			return false;

		}

		// Convert minutes to seconds
		return ( $cache_int * 60 );

	}

	function require_libs_after_setup_theme() {

		/**
		 * Include the Custom Widget Areas builder
		 */
		require_once locate_template( '/lib/class-Maera_CWA.php' );
		$extra_widget_areas = new Maera_CWA();

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

	function timber_global_context( $data ) {

		global $content_width, $maera_i18n;

		$sidebar_primary   = Timber::get_widgets( 'sidebar_primary' );
		$sidebar_footer    = Timber::get_widgets( 'sidebar_footer' );

		$data['theme_mods']           = get_theme_mods();
		$data['site_options']         = wp_load_alloptions();
		$data['teaser_mode']          = apply_filters( 'maera/teaser/mode', 'excerpt' );
		$data['thumbnail']['width']   = apply_filters( 'maera/image/width', 600 );
		$data['thumbnail']['height']  = apply_filters( 'maera/image/height', 371 );
		$data['menu']['primary']      = has_nav_menu( 'primary_navigation' ) ? new TimberMenu( 'primary_navigation' ) : null;
		$data['sidebar']['primary']   = apply_filters( 'maera/sidebar/primary', $sidebar_primary );
		$data['sidebar']['footer']    = apply_filters( 'maera/sidebar/footer', $sidebar_footer );
		$data['pagination']           = Timber::get_pagination();
		$data['comment_form']         = TimberHelper::get_comment_form();
		$data['site_logo']            = get_option( 'site_logo', false );
		$data['content_width']        = $content_width;
		$data['i18n']                 = $maera_i18n;

		return $data;

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

	/**
	* Enable Twig_Extension_StringLoader.
	* This allows us to use template_from_string() in our templates.
	*
	* See http://twig.sensiolabs.org/doc/functions/template_from_string.html for details
	*/
	function add_to_twig( $twig ){
		$twig->addExtension( new Twig_Extension_StringLoader() );
		return $twig;
	}

}

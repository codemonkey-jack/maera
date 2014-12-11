<?php

class Maera {

	function __construct() {

		self::define( 'MAERA_ASSETS_URL', get_stylesheet_directory_uri() . '/assets' );

		// If the Timber plugin is not already installed, load it from the theme.
		if ( ! class_exists( 'Timber' ) ) {
			// TODO: ERROR MESSAGE
		}

		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_action( 'init', array( $this, 'content_width' ) );
        add_filter( 'get_search_form', array( $this, 'maera_get_search_form' ) );
		add_filter( 'kirki/config', array( $this, 'customizer_config' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 100 );
		add_action( 'customize_save_after', array( $this, 'reset_style_cache_on_customizer_save' ) );

		$this->requires();

		global $maera_shell;
		$maera_shell = new Maera_Shell();

		$maera_timber = new Maera_Timber();
		$maera_init   = new Maera_Init();

		$this->required_plugins();

	}

	function requires() {

		$files = array(
			'/lib/class-Maera_Required_Plugins.php',
			'/lib/utils.php',
			'/lib/class-Maera_Shell.php',
			'/lib/class-Maera_Timber.php',
			'/lib/class-Maera_Init.php',
			'/lib/widgets.php',
			'/lib/admin/class-Maera_Admin.php',
			'/lib/updater/updater.php',
		);

		foreach ( $files as $file ) {
			require_once locate_template( $file );
		}

	}

	/*
	 * Set the content width
	 * Uses the 'maera/content_width' filter.
	 */
	function content_width() {

		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = apply_filters( 'maera/content_width', 960 );
		}

	}

	/**
	 * Add and remove body_class() classes
	 */
	function body_class( $classes ) {

		// Add post/page slug
		if ( is_single() || is_page() && ! is_front_page() ) {

			$permalink = basename( get_permalink() );
			$classes[] = sanitize_html_class( $permalink );

		}

		$classes[] = get_theme_mod( 'shell', 'core' );

		// Remove unnecessary classes
		$home_id_class  = 'page-id-' . get_option( 'page_on_front' );
		$remove_classes = array(
			'page-template-default',
			$home_id_class
		);

		$classes = array_diff( $classes, $remove_classes );

		return $classes;
	}

	/**
	 * Tell WordPress to use searchform.php from the templates/ directory
	 */
	function maera_get_search_form( $form ) {
		$form = '';
		locate_template( '/searchform.php', true, false );
		return $form;
	}

	/**
	* The configuration options for the Kirki Customizer
	*/
	function customizer_config() {

		$args = array( 'stylesheet_id' => 'maera' );
		return $args;

	}

	/**
	* Enqueue scripts and stylesheets
	*/
	function scripts() {

		global $wp_customize, $active_shell;

		// Get the stylesheet path and version
		$stylesheet_url = apply_filters( 'maera/stylesheet/url', MAERA_ASSETS_URL . '/css/style.css' );
		$stylesheet_ver = apply_filters( 'maera/stylesheet/ver', null );

		// Enqueue the theme's stylesheet
		wp_enqueue_style( 'maera', $stylesheet_url, false, $stylesheet_ver );

		wp_enqueue_script( 'maera-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );

		// Enqueue Modernizr
		wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.min.js', false, null, false );
		wp_enqueue_script( 'modernizr' );

		// Enqueue fitvids
		wp_register_script( 'fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js',false, null, true  );
		wp_enqueue_script( 'fitvids' );

		// Enqueue jQuery
		wp_enqueue_script( 'jquery' );

		// If needed, add the comment-reply script.
		if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		$caching = apply_filters( 'maera/styles/caching', false );

		if ( ! $caching ) {
			// Get our styles using the maera/styles filter
			$data = apply_filters( 'maera/styles', null );
		} else {
			// Get the cached CSS from the database
			$cache = get_theme_mod( 'css_cache', '' );
			// If the transient does not exist, then create it.
			if ( $cache === false || empty( $cache ) || '' == $cache ) {
				// Get our styles using the maera/styles filter
				$data = apply_filters( 'maera/styles', null );
				// Set the transient for 24 hours.
				set_theme_mod( 'css_cache', $data );
			} else {
				$data = $cache;
			}
		}

		// Add the CSS inline.
		// See http://codex.wordpress.org/Function_Reference/wp_add_inline_style#Examples
		wp_add_inline_style( 'maera', $data );

	}

	/**
	* Reset the cache when saving the customizer
	*/
	function reset_style_cache_on_customizer_save() {
		remove_theme_mod( 'css_cache' );
	}

	/**
	* Check if a constand is already defined, and if not then give it a value
	*/
	public static function define( $define, $value ) {
		if ( ! defined( $define ) ) {
			define( $define, $value );
		}
	}

	/**
	 * Build the array of required plugins.
	 * You can use the 'maera/required_plugins' filter to add or remove plugins.
	 */
	function required_plugins() {

		$plugins = array(
			array(
				'name' => 'Timber',
				'file' => 'timber.php',
				'slug' => 'timber-library',
			),
			array(
				'name' => 'Jetpack',
				'file' => 'jetpack.php',
				'slug' => 'jetpack',
			),
			array(
				'name' => 'Kirki',
				'file' => 'kirki.php',
				'slug' => 'kirki',
			),
		);

		if ( current_theme_supports( 'breadcrumbs' ) ) {
			$plugins[] = array( 'name' => 'Breadcrumb Trail', 'file' => 'breadcrumb-trail.php', 'slug' => 'breadcrumb-trail' );
		}

		if ( current_theme_supports( 'less_compiler' ) || current_theme_supports( 'sass_compiler' ) ) {
			$plugins[] = array( 'name' => 'Less & scss compilers', 'file' => 'less-plugin.php', 'slug' => 'lessphp' );
		}

		$jetpack_active_modules = get_option( 'jetpack_active_modules' );
		if ( isset( $jetpack_active_modules['photon'] ) && $jetpack_active_modules['photon'] ) {
			$plugins[] = array( 'name' => 'Timber with Jetpack Photon', 'file' => 'TimberPhoton.php', 'slug' => 'timber-with-jetpack-photon' );
		}

		$plugins = new Maera_Required_Plugins( $plugins );

	}

}

$maera = new Maera();

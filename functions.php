<?php

class Maera {

	function __construct() {

		if ( ! defined( 'MAERA_ASSETS_URL' ) ) {
			define( 'MAERA_ASSETS_URL', get_stylesheet_directory_uri() . '/assets' );
		}

		// If the Timber plugin is not already installed, load it from the theme.
		if ( ! class_exists( 'Timber' ) ) {
			// TODO: ERROR MESSAGE
		}

		add_filter( 'body_class',           array( $this, 'body_class' ) );
		add_action( 'init',                 array( $this, 'content_width' ) );
        add_filter( 'get_search_form',      array( $this, 'maera_get_search_form' ) );
		add_filter( 'kirki/config',         array( $this, 'customizer_config' ) );
		add_action( 'wp_enqueue_scripts',   array( $this, 'scripts' ), 100 );
		add_action( 'customize_save_after', array( $this, 'reset_style_cache_on_customizer_save' ) );

		$this->requires();

		global $maera_shell;
		$maera_shell = new Maera_Shell();
		$maera_init  = new Maera_Init();

	}

	function requires() {

		// Require TGM to install required plugins.
		require_once locate_template( '/lib/tgm-requires.php' );

		require_once locate_template( '/lib/breadcrumb-trail.php' );

		require_once locate_template( '/lib/class-Maera_Shell.php' );
		require_once locate_template( '/lib/class-Maera_Init.php' );

		require_once locate_template( '/lib/widgets.php' );
		require_once locate_template( '/lib/i18n.php' );
		require_once locate_template( '/lib/utils.php' );
		require_once locate_template( '/lib/admin-page.php' );
		require_once locate_template( '/lib/updater/updater.php' );

	}

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
			$classes[] = maera_transliterate( $permalink );

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

		global $wp_customize;
		global $active_shell;

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

}

$maera = new Maera();

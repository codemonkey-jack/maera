<?php

class Maera_Styles {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 100 );
		add_action( 'wp_enqueue_scripts', array( $this, 'custom_css_cached' ), 101 );
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

	}

	function custom_css_cached() {

		$caching = apply_filters( 'maera/styles/caching', false );

		if ( ! $caching ) {
			// Get our styles using the maera/styles filter
			$data = apply_filters( 'maera/styles', null );
		} else {
			// Get the cached CSS from the database
			$cache = get_theme_mod( 'css_cache', '' );
			// If the transient does not exist, then create it.
			if ( ! $cache || empty( $cache ) || '' == $cache ) {
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

}

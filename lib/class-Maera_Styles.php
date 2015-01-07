<?php

class Maera_Styles {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 100 );
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

}

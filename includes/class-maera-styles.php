<?php

class Maera_Styles {

	function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 100 );
		add_action( 'init', array( $this, 'content_width' ) );

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
	 * Enqueue scripts and stylesheets
	 */
	function scripts() {

		global $wp_customize, $active_shell;

		// Get the stylesheet path and version
		$stylesheet_url = apply_filters( 'maera/stylesheet/url', null );
		$stylesheet_ver = apply_filters( 'maera/stylesheet/ver', null );

		// Enqueue the theme's stylesheet
		if ( ! is_null( $stylesheet_url ) ) {
			wp_enqueue_style( 'shell', $stylesheet_url, false, $stylesheet_ver );
		}
		wp_enqueue_style( 'maera', get_stylesheet_uri(), false, MAERA_VERSION );

		wp_enqueue_script( 'maera-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );

		// Enqueue Modernizr
		wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.min.js', false, null, false );
		wp_enqueue_script( 'modernizr' );

		// Enqueue fitvids
		wp_register_script( 'fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js',false, null, true  );
		wp_enqueue_script( 'fitvids' );

		// If needed, add the comment-reply script.
		if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Enqueue Socicon styles
		wp_enqueue_style( 'socicon', get_template_directory_uri() . '/assets/css/socicon.css', false, MAERA_VERSION );

	}

}

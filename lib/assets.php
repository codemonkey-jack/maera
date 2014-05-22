<?php
/**
 * Enqueue scripts and stylesheets
 */
function shoestrap_scripts() {
	global $wp_customize;

	// Get the stylesheet path and version
	$stylesheet_url = apply_filters( 'shoestrap/stylesheet/url', SHOESTRAP_ASSETS_URL . '/css/style.css' );
	$stylesheet_ver = apply_filters( 'shoestrap/stylesheet/ver', null );

	// Enqueue the theme's stylesheet
	wp_enqueue_style( 'shoestrap_css', $stylesheet_url, false, $stylesheet_ver );

	// Enqueue Modernizr
	wp_register_script( 'modernizr', SHOESTRAP_ASSETS_URL . '/js/modernizr-2.7.0.min.js', false, null, false );
	wp_enqueue_script( 'modernizr' );

	// Enqueue fitvids
	wp_register_script( 'fitvids', SHOESTRAP_ASSETS_URL . '/js/jquery.fitvids.js',false, null, true  );
	wp_enqueue_script( 'fitvids' );


	// Enqueue jQuery
	wp_enqueue_script( 'jquery' );

	// If needed, add the comment-reply script.
	if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Check we're not on the Customizer.
	// If we're on the customizer then DO NOT cache the results.
	if ( ! isset( $wp_customize ) ) {

		// Get the transient from the database
		$data = get_transient( 'shoestrap_styles' );

		// If the transient does not exist, then create it.
		if ( $data === false || empty( $data ) ) {
			// We'll be adding our actual CSS using a filter
			$data = apply_filters( 'shoestrap/styles', null );
			// Set the transient for 24 hours.
			set_transient( 'shoestrap_styles', $data, 3600 * 24 );
		}

	// If we're on the customizer, get all the styles using our filter
	} else {

		$data = apply_filters( 'shoestrap/styles', null );

	}

	// Add the CSS inline.
	// See http://codex.wordpress.org/Function_Reference/wp_add_inline_style#Examples
	wp_add_inline_style( 'shoestrap_css', $data );

}
add_action( 'wp_enqueue_scripts', 'shoestrap_scripts', 100 );

/**
 * Reset the cache when saving the customizer
 */
function shoestrap_reset_style_cache_on_customizer_save() {

	delete_transient( 'shoestrap_styles' );

}
add_action( 'customize_save_after', 'shoestrap_reset_style_cache_on_customizer_save' );

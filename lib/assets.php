<?php
/**
 * Enqueue scripts and stylesheets
 */
function shoestrap_scripts() {

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

}
add_action( 'wp_enqueue_scripts', 'shoestrap_scripts', 100 );

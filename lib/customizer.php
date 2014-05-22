<?php


/**
 * The configuration options for the Shoestrap Customizer
 */
function shoestrap_customizer_config() {

	$args = array(

		'logo_image'   => get_template_directory_uri() . '/assets/images/customizer-logo.png',
		'color_active' => '#1abc9c',
		'color_light'  => '#8cddcd',
		'color_select' => '#34495e',
		'color_accent' => '#FF5740',
		'color_back'   => '#222',
		'url_path'     => get_template_directory_uri() . '/lib/kirki/'

	);

	return $args;

}
add_filter( 'kirki/config', 'shoestrap_customizer_config' );

/**
 * Cache the customizer styles
 */
function shoestrap_customizer_styles_cache() {
	global $wp_customize;

	// Check we're not on the Customizer.
	// If we're on the customizer then DO NOT cache the results.
	if ( ! isset( $wp_customize ) ) {

		// Get the transient from the database
		$data = get_transient( 'shoestrap_customizer_styles' );

		// If the transient does not exist, then create it.
		if ( $data === false || empty( $data ) ) {
			// We'll be adding our actual CSS using a filter
			$data = apply_filters( 'shoestrap/customizer/styles', null );
			// Set the transient for 24 hours.
			set_transient( 'shoestrap_customizer_styles', $data, 3600 * 24 );
		}

	// If we're on the customizer, get all the styles using our filter
	} else {

		$data = apply_filters( 'shoestrap/customizer/styles', null );

	}

	// Add the CSS inline.
	// See http://codex.wordpress.org/Function_Reference/wp_add_inline_style#Examples
	wp_add_inline_style( 'shoestrap_css', $data );

}
add_action( 'wp_enqueue_scripts', 'shoestrap_customizer_styles_cache', 130 );

/**
 * Reset the cache when saving the customizer
 */
function shoestrap_reset_style_cache_on_customizer_save() {

	delete_transient( 'shoestrap_customizer_styles' );

}
add_action( 'customize_save_after', 'shoestrap_reset_style_cache_on_customizer_save' );

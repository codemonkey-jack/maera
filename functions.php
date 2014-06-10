<?php

if ( ! defined( 'SHOESTRAP_ASSETS_URL' ) ) {
	define( 'SHOESTRAP_ASSETS_URL', get_stylesheet_directory_uri() . '/assets' );
}

// If the Timber plugin is not already installed, load it from the theme.
if ( ! class_exists( 'Timber' ) ) {
	require_once locate_template( '/lib/timber-library/timber.php' );
}

// Include the Kirki Advanced Customizer
if ( ! class_exists( 'Kirki' ) ) {
	require_once locate_template( '/lib/kirki/kirki.php' );
}

require_once locate_template( '/lib/breadcrumb-trail.php' );
require_once locate_template( '/framework/framework.php' );
require_once locate_template( '/lib/init.php' );
require_once locate_template( '/lib/class-Shoestrap_Color.php' );
require_once locate_template( '/lib/class-Shoestrap_Image.php' );
require_once locate_template( '/lib/widgets.php' );
require_once locate_template( '/lib/utils.php' );
require_once locate_template( '/lib/customizer.php' );
require_once locate_template( '/lib/admin-page.php' );

require_once locate_template( '/lib/assets.php' );

if ( ! isset( $content_width ) ) {
	$content_width = apply_filters( 'shoestrap/content_width', 960 );
}

/**
 * Add and remove body_class() classes
 */
function shoestrap_body_class( $classes ) {

	// Add post/page slug
	if ( is_single() || is_page() && ! is_front_page() ) {

		$permalink = basename( get_permalink() );
		$classes[] = shoestrap_transliterate( $permalink );

	}

	$classes[] = get_theme_mod( 'framework', 'bootstrap' );;

	// Remove unnecessary classes
	$home_id_class  = 'page-id-' . get_option( 'page_on_front' );
	$remove_classes = array(
		'page-template-default',
		$home_id_class
	);

	$classes = array_diff( $classes, $remove_classes );

	return $classes;
}
add_filter( 'body_class', 'shoestrap_body_class' );

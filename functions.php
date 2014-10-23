<?php

if ( ! defined( 'MAERA_ASSETS_URL' ) ) {
	define( 'MAERA_ASSETS_URL', get_stylesheet_directory_uri() . '/assets' );
}

// If the Timber plugin is not already installed, load it from the theme.
if ( ! class_exists( 'Timber' ) ) {
	require_once locate_template( '/lib/timber-library/timber.php' );
}

require_once locate_template( '/lib/breadcrumb-trail.php' );
require_once locate_template( '/lib/shell.php' );
require_once locate_template( '/lib/init.php' );
require_once locate_template( '/lib/widgets.php' );
require_once locate_template( '/lib/utils.php' );
require_once locate_template( '/lib/customizer.php' );
require_once locate_template( '/lib/admin-page.php' );
require_once locate_template( '/lib/updater/updater.php' );

require_once locate_template( '/lib/assets.php' );

if ( ! isset( $content_width ) ) {
	$content_width = apply_filters( 'maera/content_width', 960 );
}

/**
 * Add and remove body_class() classes
 */
function maera_body_class( $classes ) {

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
add_filter( 'body_class', 'maera_body_class' );


/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function maera_get_search_form( $form ) {
	$form = '';
	locate_template( '/searchform.php', true, false );
	return $form;
}
add_filter( 'get_search_form', 'maera_get_search_form' );

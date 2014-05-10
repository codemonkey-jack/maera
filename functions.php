<?php

if ( ! defined( 'SHOESTRAP_ASSETS_URL' ) ) {
	define( 'SHOESTRAP_ASSETS_URL', get_stylesheet_directory_uri() . '/assets' );
}

require_once locate_template( '/lib/dependencies/dependencies.php' );

if ( ! class_exists( 'Timber' ) ) {
	return;
}

require_once locate_template( '/lib/widgets.php' );      // Sidebars and widgets

// Include the Kirki Advanced Customizer
if ( ! function_exists( 'kirki_customizer_controls' ) ) {
	require_once locate_template( '/lib/kirki/kirki.php' );
}

// Initialize the customizer
require_once locate_template( '/lib/customizer.php' );

require_once locate_template( '/framework/framework.php' );

require_once locate_template( '/lib/assets.php' );

Timber::$locations = array(
	SS_FRAMEWORK_PATH . '/macros',
	SS_FRAMEWORK_PATH,
	get_stylesheet_directory() . '/views',
	get_template_directory() . '/views'
);

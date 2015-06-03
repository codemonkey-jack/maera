<?php

/**
 * The Maera class autoloader.
 * Finds the path to a class that we're requiring and includes the file.
 */
function maera_autoload_classes( $class_name ) {

	if ( class_exists( $class_name ) ) {
		return;
	}

	$class_path = get_template_directory() . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';
	if ( file_exists( $class_path ) ) {
		include $class_path;
	}

}
// Run the autoloader
spl_autoload_register( 'maera_autoload_classes' );

require_once( locate_template( '/includes/template-hierarchy.php' ) );
require_once( locate_template( '/includes/utils.php' ) );
require_once( locate_template( '/includes/widgets.php' ) );
require_once( locate_template( '/includes/remote-installer/client.php' ) );

/**
 * If Kirki is not installed as a plugin include the embedded Version
 */
if ( ! class_exists( 'Kirki' ) && ! is_admin() ) {
	define( 'KIRKI_PATH', get_template_directory() . '/includes/plugins/kirki' );
	define( 'KIRKI_URL', get_template_directory_uri() . '/includes/plugins/kirki' );
	require_once( get_template_directory() . '/includes/plugins/kirki/kirki.php' );
}

/**
 * If Timber is not installed as a plugin include the embedded version.
 */
if ( ! class_exists( 'Timber' ) && ! is_admin() ) {
	require_once( get_template_directory() . '/includes/plugins/timber-library/timber.php' );
}

/**
 * Dummy function to prevent fatal errors with the Tonesque library
 * Only used when Jetpack is not installed.
 */
if ( ! function_exists( 'jetpack_require_lib' ) && ! is_admin() ) {
	function jetpack_require_lib() {}
}

function Maera() {
	return Maera::get_instance();
}

// Global
$GLOBALS['maera'] = maera();
global $maera;


// Load our Maera_EDD class if EDD is installed
if ( class_exists( 'Easy_Digital_Downloads' ) ) {
	Maera_EDD::get_instance();
}

/**
 * Add theme support for infinite scroll.
 * http://jetpack.me/support/infinite-scroll/
 *
 * @uses add_theme_support
 * @return void
 */
function maera_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'type'            => 'scroll',
		'footer_widgets'  => false,
		'container'       => 'main',
		'footer'          => 'false',
		'wrapper'         => true,
		'render'          => false,
		'posts_per_page'  => false,
	) );
}
add_action( 'after_setup_theme', 'maera_infinite_scroll_init' );

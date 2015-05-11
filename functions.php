<?php

/**
 * The Maera class autoloader.
 * Finds the path to a class that we're requiring and includes the file.
 */
function maera_autoload_classes( $class_name ) {

	$class_path = get_template_directory() . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $foldername . 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';
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

function Maera() {
	return Maera::get_instance();
}

// Global for backwards compatibility.
$GLOBALS['maera'] = maera();
global $maera;

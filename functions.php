<?php
/**
 * Maera functions and definitions
 *
 * @package Maera
 */

if ( ! defined( 'MAERA_TEMPLATES_PATH' ) ) {
	define( 'MAERA_TEMPLATES_PATH', get_template_directory() . '/templates' );
}

/**
 * Add custom Maera classes
 */
require get_template_directory() . '/includes/class-maera.php';
require get_template_directory() . '/includes/class-maera-shell-handler.php';
require get_template_directory() . '/includes/class-maera-mdl.php';

function Maera() {
	$maera = new Maera();

	return $maera;
}
global $maera;
$maera = Maera();

/**
 * Setup the theme
 */
require get_template_directory() . '/includes/setup.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/includes/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/jetpack.php';

/**
 * Add scripts & styles
 */
require get_template_directory() . '/includes/scripts.php';

/**
 * Add custom template functions
 */
require get_template_directory() . '/includes/template-functions.php';

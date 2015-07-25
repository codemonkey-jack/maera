<?php
/**
 * Maera functions and definitions
 *
 * @package Maera
 */

if ( ! defined( 'MAERA_SHELL_PATH' ) ) {
	define( 'MAERA_SHELL_PATH', get_template_directory() . '/mdl-shell/templates' );
}

if ( ! defined( 'MAERA_SHELL_URL' ) ) {
	define( 'MAERA_SHELL_URL', get_template_directory_uri() . '/mdl-shell/' );
}

/**
 * Add custom Maera classes
 */
require get_template_directory() . '/includes/class-maera.php';
require get_template_directory() . '/includes/class-maera-shell-handler.php';
require get_template_directory() . '/mdl-shell/class-maera-mdl.php';
require get_template_directory() . '/mdl-shell/class-maera-mdl-menu-navwalker.php';

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

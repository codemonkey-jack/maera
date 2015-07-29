<?php
/**
 * Maera functions and definitions
 *
 * @package Maera
 */

/**
 * Add custom Maera classes
 */
require get_template_directory() . '/includes/class-maera.php';
require get_template_directory() . '/includes/class-maera-shell.php';
require get_template_directory() . '/includes/class-maera-template.php';
require get_template_directory() . '/includes/class-maera-shell-handler.php';
require get_template_directory() . '/includes/class-maera-wrapper-override.php';
require get_template_directory() . '/mdl-shell/class-maera-mdl.php';
require get_template_directory() . '/mdl-shell/class-maera-mdl-menu-navwalker.php';
require get_template_directory() . '/mdl-shell/class-maera-mdl-customizer.php';

function Maera() {
	$maera = new Maera();
	return $maera;
}
global $maera;
$maera = Maera();

/**
 * The theme wrapper
 */
require get_template_directory() . '/includes/wrapper.php';

/**
 * Setup the theme
 */
require get_template_directory() . '/includes/setup.php';

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
 * Load Jetpack's site-logo module if it does not already exist.
 */
if ( ! function_exists( 'site_logo_init' ) ) {
	require get_template_directory() . '/includes/site-logo.php';
}

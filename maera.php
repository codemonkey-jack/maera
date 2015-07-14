<?php
/**
 * Plugin Name:   Maera
 * Plugin URI:    http://maera.io
 * Description:   The ultimate WordPress Theme framework using twig & the customizer.
 * Author:        The PressCodes theam
 * Author URI:    https://presscodes.com
 * Version:       1.2
 * Text Domain:   maera
 *
 *
 * @package     Maera
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'MAERA_VERSION' ) ) {
	define( 'MAERA_VERSION', '1.2' );
}

if ( ! defined( 'MAERA_THEME_URL' ) ) {
	define( 'MAERA_THEME_URL', plugin_dir_url( __FILE__ ) . '/themes/maera' );
}

if ( ! defined( 'MAERA_ASSETS_URL' ) ) {
	define( 'MAERA_ASSETS_URL', plugin_dir_url( __FILE__ ) . '/themes/maera/assets' );
}

/**
 * Require 3rd-party plugins
 */
require_once dirname( __FILE__ ) . '/includes/dependencies.php';

/**
 * Register the additional themes folder
 */
register_theme_directory( dirname( __FILE__ ) . '/themes' );

/**
 * Check the active theme and switch if necessary
 */
function maera_check_active_theme() {
	$current_theme = wp_get_theme();
	$maera_theme   = wp_get_theme( 'maera' );

	/**
	 * Activate the theme
	 */
	if ( dirname( __FILE__ ) . '/themes' != $current_theme->theme_root ) {
		switch_theme( 'maera' );
	}
}
add_action( 'plugins_loaded', 'maera_check_active_theme' );

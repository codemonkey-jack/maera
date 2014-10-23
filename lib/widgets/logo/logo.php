<?php

/**
 * @package     Logo Widget
 * @version     1.0.0
 * @author      Aristeides Stathopoulos, Brian Welch
 * @copyright   2014
 * @link        https://press.codes
 * @license     http://opensource.org/licenses/MIT
 * @uses        Adds a logo widget to Maera.
 *
 */

// Widget folder url
if ( ! defined( 'MAERA_LOGO_WIDGET_URL' ) ) {
	define( 'MAERA_LOGO_WIDGET_URL', get_template_directory_uri() . '/lib/widgets/logo/' );
}

// Widget folder path
if ( ! defined( 'MAERA_LOGO_WIDGET_PATH' ) ) {
	define( 'MAERA_LOGO_WIDGET_PATH', dirname( __FILE__ ) );
}

//Widget root file
if ( ! defined( 'MAERA_LOGO_WIDGET_FILE' ) ) {
	define( 'MAERA_LOGO_WIDGET_FILE', __FILE__ );
}

/**
 * Include the logo widget class.
 */
include_once( MAERA_LOGO_WIDGET_PATH . '/includes/class-Maera_Logo_Widget.php' );


/**
 * Register the widget.
 */
function maera_logo_widget() {
	register_widget( 'Maera_Logo_Widget' );
}
add_action( 'widgets_init', 'maera_logo_widget' );

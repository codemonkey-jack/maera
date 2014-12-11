<?php

/**
 * @package     Maera/Extended Posts Widget/Loader
 * @version     1.0.0
 * @author      Aristeides Stathopoulos, Brian Welch
 * @copyright   2014
 * @link        https://wpmu.io
 * @license     http://opensource.org/licenses/MIT
 * @uses        Adds some extra widgets, primarily useful for News Sites.
 *
 */

// Widget folder url
if ( ! defined( 'MAERA_EXT_POSTS_URL' ) ) {
	define( 'MAERA_EXT_POSTS_URL', get_template_directory_uri() . '/lib/widgets/extended-posts/' );
}

// Widget folder path
if ( ! defined( 'MAERA_EXT_POSTS_PATH' ) ) {
	define( 'MAERA_EXT_POSTS_PATH', dirname( __FILE__ ) );
}

// Widget root file
if ( ! defined( 'MAERA_EXT_POSTS_FILE' ) ) {
	define( 'MAERA_EXT_POSTS_FILE', __FILE__ );
}

/**
 * Include the extended widget class.
 */
include_once( MAERA_EXT_POSTS_PATH . '/class-Maera_Ext_Posts_Widget_Latest_Articles.php' );


/**
 * Register the widget.
 */
function maera_ext_posts_widgets() {
	register_widget( 'Maera_Ext_Posts_Widget_Latest_Articles' );
}
add_action( 'widgets_init', 'maera_ext_posts_widgets' );


/**
 * Enqueue styles
 */
function maera_ext_posts_widgets_styles() {
	wp_enqueue_style( 'style', MAERA_EXT_POSTS_URL . 'assets/style.css' );
}

add_action( 'wp_enqueue_scripts', 'maera_ext_posts_widgets_styles' );

/**
 * Enqueue admin script
 */
function maera_ext_posts_widgets_admin_script() {
	wp_enqueue_script( 'script', MAERA_EXT_POSTS_URL . 'assets/script.js', array(), '1.0.0', true );
}

add_action( 'admin_enqueue_scripts', 'maera_ext_posts_widgets_admin_script' );

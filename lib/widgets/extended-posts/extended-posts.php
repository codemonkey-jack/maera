<?php
/*
Plugin Name: Maera extended posts
Plugin URI: http://wpmu.io
Description: Adds some extra widgets, primarily useful for News Sites.
Version: 0.1
Author: Aristeides Stathopoulos
Author URI:  http://aristeides.com
*/

// plugin folder url
if ( ! defined( 'MAERA_EXT_POSTS_URL' ) ) {
	define( 'MAERA_EXT_POSTS_URL', get_template_directory_uri() . '/lib/widgets/extended-posts/' );
}

// plugin folder path
if ( ! defined( 'MAERA_EXT_POSTS_PATH' ) ) {
	define( 'MAERA_EXT_POSTS_PATH', dirname( __FILE__ ) );
}

// plugin root file
if ( ! defined( 'MAERA_EXT_POSTS_FILE' ) ) {
	define( 'MAERA_EXT_POSTS_FILE', __FILE__ );
}

/**
 * Include plugin files
 */

include_once( MAERA_EXT_POSTS_PATH . '/includes/widget.posts-query.php' );
include_once( MAERA_EXT_POSTS_PATH . '/includes/functions.loop.php' );
include_once( MAERA_EXT_POSTS_PATH . '/includes/functions.excerpts.php' );

function maera_ext_posts_widgets() {
	register_widget( 'maera_ext_posts_widget_latest_articles' );
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
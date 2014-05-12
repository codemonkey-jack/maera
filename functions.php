<?php

if ( ! defined( 'SHOESTRAP_ASSETS_URL' ) ) {
	define( 'SHOESTRAP_ASSETS_URL', get_stylesheet_directory_uri() . '/assets' );
}

require_once locate_template( '/lib/dependencies/dependencies.php' );

if ( ! class_exists( 'Timber' ) ) {
	return;
}

require_once locate_template( '/lib/widgets.php' );      // Sidebars and widgets
require_once locate_template( '/lib/utils.php' );

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
	SS_FRAMEWORK_PATH . '/views',
	SS_FRAMEWORK_PATH,
	get_stylesheet_directory() . '/views',
	get_template_directory() . '/views'
);

function shoestrap_timber_global_context( $data ) {

	$data['theme_mods'] = get_theme_mods();
	$data['menu']['primary']   = new TimberMenu( 'primary_navigation' );
	$data['menu']['secondary'] = new TimberMenu( 'secondary_navigation' );

	$sidebar_primary   = Timber::get_widgets( 'sidebar_primary' );
	$sidebar_secondary = Timber::get_widgets( 'sidebar_secondary' );

	$sidebar_footer_1 = Timber::get_widgets( 'sidebar_footer_1' );
	$sidebar_footer_2 = Timber::get_widgets( 'sidebar_footer_2' );
	$sidebar_footer_3 = Timber::get_widgets( 'sidebar_footer_3' );
	$sidebar_footer_4 = Timber::get_widgets( 'sidebar_footer_4' );

	$data['sidebar']['primary']   = apply_filters( 'shoestrap/sidebar/primary', $sidebar_primary );
	$data['sidebar']['secondary'] = apply_filters( 'shoestrap/sidebar/secondary', $sidebar_secondary );

	$data['sidebar']['footer']['one']   = apply_filters( 'shoestrap/sidebar/footer/one', $sidebar_footer_1 );
	$data['sidebar']['footer']['two']   = apply_filters( 'shoestrap/sidebar/footer/two', $sidebar_footer_2 );
	$data['sidebar']['footer']['three'] = apply_filters( 'shoestrap/sidebar/footer/three', $sidebar_footer_3 );
	$data['sidebar']['footer']['four']  = apply_filters( 'shoestrap/sidebar/footer/four', $sidebar_footer_4 );

	return $data;

}
add_filter( 'timber_context', 'shoestrap_timber_global_context' );

/**
 * Shoestrap initial setup and constants
 */
function shoestrap_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'shoestrap', get_template_directory() . '/lang' );

	// Register wp_nav_menu() menus ( http://codex.wordpress.org/Function_Reference/register_nav_menus )
	register_nav_menus( array(
		'primary_navigation'   => __( 'Primary Navigation', 'shoestrap' ),
		'secondary_navigation' => __( 'Secondary Navigation', 'shoestrap' ),
	 ) );

	// Add post thumbnails ( http://codex.wordpress.org/Post_Thumbnails )
	add_theme_support( 'post-thumbnails' );

	// Add post formats ( http://codex.wordpress.org/Post_Formats )
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'html5', array( 'gallery', 'caption' ) );

	// Tell the TinyMCE editor to use a custom stylesheet
	add_editor_style( '/assets/css/editor-style.css' );
}
add_action( 'after_setup_theme', 'shoestrap_setup' );


/**
 * Add and remove body_class() classes
 */
function shoestrap_body_class( $classes ) {

	// Add post/page slug
	if ( is_single() || is_page() && ! is_front_page() ) {
		$permalink = basename( get_permalink() );
		$classes[] = shoestrap_transliterate( $permalink );
	}

	$classes[] = SS_FRAMEWORK;

	// Remove unnecessary classes
	$home_id_class = 'page-id-' . get_option( 'page_on_front' );
	$remove_classes = array(
		'page-template-default',
		$home_id_class
	);

	$classes = array_diff( $classes, $remove_classes );

	return $classes;
}
add_filter( 'body_class', 'shoestrap_body_class' );

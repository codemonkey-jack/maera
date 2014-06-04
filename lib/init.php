<?php

// If the Timber plugin is not already installed, load it from the theme.
if ( ! class_exists( 'Timber' ) ) {
	require_once locate_template( '/lib/timber/timber.php' );
}

// Include the Kirki Advanced Customizer
if ( ! class_exists( 'Kirki' ) ) {
	require_once locate_template( '/lib/kirki/kirki.php' );
}

Timber::$locations = array(
	SS_FRAMEWORK_PATH . '/macros',
	SS_FRAMEWORK_PATH . '/views',
	SS_FRAMEWORK_PATH,
	get_stylesheet_directory() . '/views',
	get_template_directory() . '/views'
);

function shoestrap_timber_global_context( $data ) {

	$data['theme_mods'] = get_theme_mods();
	$data['menu']['primary']   = has_nav_menu( 'primary_navigation' ) ? new TimberMenu( 'primary_navigation' ) : null;
	$data['menu']['secondary'] = has_nav_menu( 'secondary_navigation' ) ? new TimberMenu( 'secondary_navigation' ) : null;

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
	load_theme_textdomain( 'shoestrap', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Register wp_nav_menu() menus ( http://codex.wordpress.org/Function_Reference/register_nav_menus )
	register_nav_menus( array(
		'primary_navigation'   => __( 'Primary Navigation', 'shoestrap' ),
		'secondary_navigation' => __( 'Secondary Navigation', 'shoestrap' ),
	 ) );

	// Add post thumbnails ( http://codex.wordpress.org/Post_Thumbnails )
	add_theme_support( 'post-thumbnails' );

	// Add post formats ( http://codex.wordpress.org/Post_Formats )
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );

	// Tell the TinyMCE editor to use a custom stylesheet
	add_editor_style( '/assets/css/editor-style.css' );
}
add_action( 'after_setup_theme', 'shoestrap_setup' );

/**
 * Enable Twig_Extension_StringLoader.
 * This allows us to use template_from_string() in our templates.
 *
 * See http://twig.sensiolabs.org/doc/functions/template_from_string.html for details
 */
function add_to_twig( $twig ){
	$twig->addExtension( new Twig_Extension_StringLoader() );
	return $twig;
}
add_filter('get_twig', 'add_to_twig');

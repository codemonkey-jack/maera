<?php

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

	$sidebar_primary   = Timber::get_widgets( 'sidebar_primary' );
	$sidebar_secondary = Timber::get_widgets( 'sidebar_secondary' );

	$sidebar_footer = Timber::get_widgets( 'sidebar_footer' );

	$data['sidebar']['primary']   = apply_filters( 'shoestrap/sidebar/primary', $sidebar_primary );
	$data['sidebar']['secondary'] = apply_filters( 'shoestrap/sidebar/secondary', $sidebar_secondary );

	$data['sidebar']['footer'] = apply_filters( 'shoestrap/sidebar/footer', $sidebar_footer );

	$data['pagination'] = Timber::get_pagination();
	$data['comment_form'] = TimberHelper::get_comment_form();

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
		'' => __( 'Secondary Navigation', 'shoestrap' ),
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
function shoestrap_add_to_twig( $twig ){
	$twig->addExtension( new Twig_Extension_StringLoader() );
	return $twig;
}
add_filter( 'get_twig', 'shoestrap_add_to_twig' );

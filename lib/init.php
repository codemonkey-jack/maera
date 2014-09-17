<?php

Timber::$locations = array(
	MAERA_FRAMEWORK_PATH . '/macros',
	MAERA_FRAMEWORK_PATH . '/views',
	MAERA_FRAMEWORK_PATH,
	get_stylesheet_directory() . '/views',
	get_template_directory() . '/views'
);

/**
 * If we're using the color library, load it
 */
if ( current_theme_supports( 'maera_color' ) || current_theme_supports( 'jetpack_color' ) ) {
	// Include the Jetpack_Color class
	// if ( function_exists( 'jetpack_require_lib' ) ) {
	// 	jetpack_require_lib( 'class.color' );
	// }

	if ( ! class_exists( 'Jetpack_Color' ) ) {
		require_once locate_template( '/lib/jetpack/class.color.php' );
	}
}

/**
 * If we're using the Tonesque library, load it
 */
if ( current_theme_supports( 'tonesque' ) ) {
	if ( ! class_exists( 'Jetpack_Color' ) ) {
		require_once locate_template( '/lib/jetpack/class.color.php' );
	}
	if ( ! class_exists( 'Tonesque' ) ) {
		require_once locate_template( '/lib/jetpack/tonesque.php' );
	}
}


/**
 * load the image library
 */
require_once locate_template( '/lib/class-Maera_Image.php' );

/**
 * If we're using Kirki, load it
 */
if ( current_theme_supports( 'kirki' ) ) {
	// Include the Kirki Advanced Customizer
	if ( ! class_exists( 'Kirki' ) ) {
		require_once locate_template( '/lib/kirki/kirki.php' );
	}
}

/**
 * If our theme supports pjax, add the filter here
 */
if ( current_theme_supports( 'ajax' ) ) {
	add_filter( 'timber_output', 'maera_add_ajax_internal_links' );
}

function maera_timber_global_context( $data ) {

	$data['theme_mods'] = get_theme_mods();
	$data['menu']['primary']   = has_nav_menu( 'primary_navigation' ) ? new TimberMenu( 'primary_navigation' ) : null;

	$sidebar_primary   = Timber::get_widgets( 'sidebar_primary' );
	$sidebar_secondary = Timber::get_widgets( 'sidebar_secondary' );

	$sidebar_footer = Timber::get_widgets( 'sidebar_footer' );

	$data['sidebar']['primary']   = apply_filters( 'maera/sidebar/primary', $sidebar_primary );
	$data['sidebar']['secondary'] = apply_filters( 'maera/sidebar/secondary', $sidebar_secondary );

	$data['sidebar']['footer'] = apply_filters( 'maera/sidebar/footer', $sidebar_footer );

	$data['pagination'] = Timber::get_pagination();
	$data['comment_form'] = TimberHelper::get_comment_form();

	return $data;

}
add_filter( 'timber_context', 'maera_timber_global_context' );


/**
 * Maera initial setup and constants
 */
function maera_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'maera', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Register wp_nav_menu() menu ( http://codex.wordpress.org/Function_Reference/register_nav_menus )
	register_nav_menus( array(
		'primary_navigation'   => __( 'Primary Navigation', 'maera' )
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
add_action( 'after_setup_theme', 'maera_setup' );


/**
 * Enable Twig_Extension_StringLoader.
 * This allows us to use template_from_string() in our templates.
 *
 * See http://twig.sensiolabs.org/doc/functions/template_from_string.html for details
 */
function maera_add_to_twig( $twig ){
	$twig->addExtension( new Twig_Extension_StringLoader() );
	return $twig;
}
add_filter( 'get_twig', 'maera_add_to_twig' );


/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Fourteen 1.0
 *
 * @global int $paged WordPress archive pagination page count.
 * @global int $page  WordPress paginated post page count.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function maera_wp_title( $title, $sep = '|' ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'maera' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'maera_wp_title', 10, 2 );

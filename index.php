<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file
 */

if ( ! class_exists( 'Timber' ) ) {
	_e( 'Timber not activated. Make sure you activate the plugin.', 'shoestrap' );
}

$context = Timber::get_context();

$context['posts'] = Timber::get_posts();

$sidebar_primary = Timber::get_widgets( 'sidebar_primary' );
$context['sidebar_primary'] = apply_filters( 'shoestrap/sidebar/primary', $sidebar_primary );


$sidebar_secondary = Timber::get_widgets( 'sidebar_secondary' );
$context['sidebar_secondary'] = apply_filters( 'shoestrap/sidebar/secondary', $sidebar_secondary );

$templates = array( 'index.twig' );

if ( is_home() ) {
	array_unshift( $templates, 'home.twig' );
}

Timber::render( $templates, $context, false );

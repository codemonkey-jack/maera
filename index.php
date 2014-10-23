<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file
 */

if ( ! class_exists( 'Timber' ) ) {
	// _e( 'Timber not activated. Make sure you activate the plugin from https://wordpress.org/plugins/timber-library/.', 'maera' );
}

$context = Timber::get_context();

$context['posts'] = Timber::query_posts( false, 'TimberPost' );

$templates = array( 'index.twig' );

if ( is_home() ) {
	array_unshift( $templates, 'home.twig' );
}

Timber::render( $templates, $context, apply_filters( 'maera/timber/cache', false ) );

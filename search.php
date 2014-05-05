<?php
/**
 * Search results page
 */

$templates = array(
	'search.twig',
	'archive.twig',
	'index.twig'
);

$context = Timber::get_context();

$context['title'] = __( 'Search results for ', 'shoestrap' ) . get_search_query();
$context['posts'] = Timber::get_posts();

$context['sidebar_primary']   = Timber::get_widgets( 'sidebar_primary' );
$context['sidebar_secondary'] = Timber::get_widgets( 'sidebar_secondary' );

Timber::render( $templates, $context );

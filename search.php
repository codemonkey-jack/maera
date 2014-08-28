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

$context['title'] = __( 'Search results for ', 'maera' ) . get_search_query();
$context['posts'] = Timber::get_posts();

Timber::render( $templates, $context );

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
$context['framework'] = shoestrap_framework_array();

Timber::render( $templates, $context );

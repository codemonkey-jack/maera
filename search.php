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

global $ss_framework;
$context['framework'] = $ss_framework;

Timber::render( $templates, $context );

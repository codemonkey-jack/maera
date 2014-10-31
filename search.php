<?php
/**
 * Search results page
 */
global $maera_i18n;

$templates = array(
	'search.twig',
	'archive.twig',
	'index.twig'
);

$context = Timber::get_context();

$context['title'] = $maera_i18n['searchresultsfor'] . get_search_query();
$context['posts'] = Timber::get_posts();

Timber::render( $templates, $context, apply_filters( 'maera/timber/cache', false ) );

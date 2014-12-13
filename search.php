
<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package maera
 */

$context = Maera_Timber::get_context();

$context['title'] = __( 'Search results for ', 'maera' ) . get_search_query();
$context['posts'] = Timber::get_posts();

Maera_Timber::render(
	array(
		'search.twig',
		'archive.twig',
		'index.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

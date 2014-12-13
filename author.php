<?php
/**
 * The template for displaying Author Archive pages
 */
global $wp_query;

$data = Maera_Timber::get_context();
$data['posts'] = Timber::get_posts();

$author = new TimberUser( $wp_query->query_vars['author'] );

$data['author'] = $author;
$data['title']  = 'Author Archives: ' . $author->name();

Maera_Timber::render(
	Maera_Timber::twig_archive_templates(),
	$data,
	apply_filters( 'maera/timber/cache', false )
);

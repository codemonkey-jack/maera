<?php
/**
 * The template for displaying Author Archive pages
 */
global $wp_query;

$data = Timber::get_context();
$data['posts'] = Timber::get_posts();

$author = new TimberUser( $wp_query->query_vars['author'] );

$data['author'] = $author;
$data['title']  = 'Author Archives: ' . $author->name();
$context['framework'] = shoestrap_framework_array();

Timber::render(
	array(
		'author.twig',
		'archive.twig'
	),
	$data
);

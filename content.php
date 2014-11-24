<?php
/**
* The Template for displaying all single posts
*/

$context = Timber::get_context();
$post    = new TimberPost();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->title();

Timber::render(
	array(
		'tease-' . $post->ID . '.twig',
		'tease-' . $post->post_type . '.twig',
		'tease.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

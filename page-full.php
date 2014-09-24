<?php
/*
Template Name: Full-Width
*/

// Add a filter for the layout.
add_filter( 'maera/layout/modifier', 'maera_return_0' );

$context = Timber::get_context();
$post = new Maera_Post();
$context['post'] = $post;

$context['sidebar_primary']   = null;
$context['sidebar_secondary'] = null;

Timber::render(
	array(
		'page-' . $post->post_name . '.twig',
		'page.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

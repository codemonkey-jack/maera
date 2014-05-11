<?php
/*
Template Name: Full-Width
*/

// Add a filter for the layout.
add_filter( 'shoestrap/layout/modifier', 'shoestrap_return_0' );

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$context['sidebar_primary']   = null;
$context['sidebar_secondary'] = null;

Timber::render(
	array(
		'page-' . $post->post_name . '.twig',
		'page.twig'
	),
	$context
);

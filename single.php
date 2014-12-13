<?php
/**
 * The Template for displaying all single posts
 */

$context = Maera_Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->title();

Timber::render(
	array(
		'single-' . $post->ID . '.twig',
		'single-' . $post->post_type . '.twig',
		'single.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

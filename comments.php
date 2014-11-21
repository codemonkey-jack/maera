<?php
/**
 * The Template for displaying comments
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

Timber::render(
	array(
		'comments-' . $post->ID . '.twig',
		$post->post_type . '-comments.twig',
		'comments.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

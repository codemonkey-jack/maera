<?php
/**
 * The Template for displaying all single posts
 * @package maera
 */

$context = Maera_Timber::get_context();
$post    = new TimberPost();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->title();

Maera_Timber::render(
	array(
		'content-' . $post->ID . '.twig',
		'content-' . $post->post_type . '.twig',
		'content-single.twig',
		'content.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

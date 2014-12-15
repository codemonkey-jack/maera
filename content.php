<?php
/**
 * The Template for displaying all single posts
 * @package maera
 */

$context = Maera_Timber::get_context();
$post = ( is_home() ) ? new TimberPost( TimberPostGetter::loop_to_id() ) : new TimberPost();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->title();

Timber::render(
	array(
		'content-' . $post->ID . '.twig',
		'content-' . $post->post_type . '.twig',
		// 'content-single.twig',
		'content.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

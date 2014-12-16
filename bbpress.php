<?php

$context = Maera_Timber::get_context();
$post    = Timber::query_post();

$context['post']       = $post;
$context['bbp_content'] = maera_get_echo( 'the_content' );

// Header
get_header();

// Content
Timber::render(
	'bbp.twig',
	$context,
	apply_filters( 'maera/timber/cache', false )
);

<?php

$context = Maera_Timber::get_context();
$post    = Timber::query_post();

$context['post']       = $post;
$context['bp_content'] = maera_get_echo( 'the_content' );

// Header
get_header();

// Content
Timber::render(
	'bp.twig',
	$context,
	apply_filters( 'maera/timber/cache', false )
);

// Footer
get_footer();

<?php
/**
 * The Header for our theme.
 *
 * @package maera
 */

$context = Maera_Timber::get_context();
if ( is_singular() || is_home() ) {
	$context['post']  = new TimberPost();
}

Timber::render(
	'header.twig',
	$context,
	apply_filters( 'maera/timber/cache', false )
);

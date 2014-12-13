<?php
/**
 * The Header for our theme.
 *
 * @package maera
 */

$context = Maera_Timber::get_context();
Maera_Timber::render(
	'header.twig',
	$context,
	apply_filters( 'maera/timber/cache', false )
);

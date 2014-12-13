<?php
/**
 * The template for displaying the footer.
 *
 * @package maera
 */

$context = Maera_Timber::get_context();
Maera_Timber::render(
	'footer.twig',
	$context,
	apply_filters( 'maera/timber/cache', false )
);

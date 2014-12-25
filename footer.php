<?php
/**
 * The template for displaying the footer.
 *
 * @package maera
 */

Timber::render(
	'footer.twig',
	Maera_Template::context(),
	apply_filters( 'maera/timber/cache', false )
);

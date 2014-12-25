<?php
/**
 * The Header for our theme.
 *
 * @package maera
 */

Timber::render(
	'header.twig',
	Maera_Template::context(),
	apply_filters( 'maera/timber/cache', false )
);

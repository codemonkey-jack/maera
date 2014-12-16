<?php
/**
* The Sidebar for our theme.
*
* @package maera
*/

Timber::render(
	'sidebar.twig',
	Maera_Timber::get_context(),
	apply_filters( 'maera/timber/cache', false )
);

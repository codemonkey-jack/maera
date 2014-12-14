<?php
/**
 * Search Form
 */

Maera_Timber::render(
	'searchform.twig',
	Maera_Timber::get_context(),
	apply_filters( 'maera/timber/cache', false )
);

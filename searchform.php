<?php
/**
 * Search Form
 */

$templates = array(
	'searchform.twig',
);

$context = Maera_Timber::get_context();

Timber::render( $templates, $context, apply_filters( 'maera/timber/cache', false ) );

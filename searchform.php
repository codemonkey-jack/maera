<?php
/**
 * Search Form
 */

$templates = array(
	'parts/searchform.twig',
);

$context = Timber::get_context();

Timber::render( $templates, $context, apply_filters( 'maera/timber/cache', false ) );

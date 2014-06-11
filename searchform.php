<?php
/**
 * Search Form
 */

$templates = array(
	'parts/searchform.twig',
);

$context = Timber::get_context();

Timber::render( $templates, $context );

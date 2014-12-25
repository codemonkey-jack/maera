<?php
/**
 * The Template for displaying the sidebar
 * @package maera
 */

global $wp_query;
$context = Maera_Timber::get_context();
$post = ( is_home() ) ? new TimberPost( TimberPostGetter::loop_to_id() ) : new TimberPost();
$context['post'] = $post;

$templates = array();



Timber::render(
	$templates,
	$context,
	apply_filters( 'maera/timber/cache', false )
);

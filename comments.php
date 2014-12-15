<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package maera
 */

$context = Maera_Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

// If the current post is protected by a password and
// the visitor has not yet entered the password we will
// return early without loading the comments.
if ( post_password_required( $post ) ) {
	return;
}

Timber::render(
	array(
		'comments-' . $post->ID . '.twig',
		$post->post_type . '-comments.twig',
		'comments.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

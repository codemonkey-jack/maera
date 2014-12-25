<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package maera
 */

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required( $post ) ) {
	return;
}

Maera_Template::content( array(
	'comments-' . $post->ID . '.twig',
	$post->post_type . '-comments.twig',
	'comments.twig'
));

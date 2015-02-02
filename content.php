<?php
/**
 * The Template for displaying all single posts
 * @package maera
 */

Maera()->views->render( array(
	'content-' . $post->ID . '.twig',
	'content-' . $post->post_type . '.twig',
	'content.twig'
));

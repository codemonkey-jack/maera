<?php
/**
 * The Template for displaying all single posts
 * @package maera
 */

Maera_Template::content( array(
	'content-' . $post->ID . '.twig',
	'content-' . $post->post_type . '.twig',
	'content-single.twig',
	'content.twig'
));

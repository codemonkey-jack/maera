<?php
/**
 * The Template for displaying all single posts
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->title();
$context['comment_form'] = TimberHelper::get_comment_form();

$context['sidebar_primary']   = Timber::get_widgets( 'sidebar_primary' );
$context['sidebar_secondary'] = Timber::get_widgets( 'sidebar_secondary' );

global $ss_framework;
$context['framework'] = $ss_framework;

Timber::render(
	array(
		'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig',
		'single.twig'
	),
	$context
);

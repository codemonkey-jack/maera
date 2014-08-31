<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

Timber::render(
	array(
		'page-' . $post->post_name . '.twig',
		'page.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

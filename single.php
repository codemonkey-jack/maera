<?php
/**
 * The Template for displaying all single posts.
 *
 * @package maera
 */

/**
* Test if all required plugins are installed.
* If they are not then then do not proceed with the template loading.
* Instead display a custom template file that urges users to visit their dashboard to install them.
*/
if ( 'bad' == Maera::test_missing() ) {
	get_template_part( 'lib/required-error' );
	return;
}


$context = Maera_Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->title();

// Header
get_header();

// Content
Timber::render(
	array(
		'single-' . $post->ID . '.twig',
		'single-' . $post->post_type . '.twig',
		'single.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

// Footer
get_footer();

<?php
/**
 * The template for displaying Author Archive pages
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

global $wp_query;

$data = Maera_Timber::get_context();
$data['posts'] = Timber::get_posts();

$author = new TimberUser( $wp_query->query_vars['author'] );

$data['author'] = $author;
$data['title']  = __( 'Author Archives: ', 'maera' ) . $author->name();

// Header
get_header();

// Content
Timber::render(
	Maera_Timber::twig_archive_templates(),
	$data,
	apply_filters( 'maera/timber/cache', false )
);

// Footer
get_footer();


<?php
/**
 * The template for displaying Search Results pages.
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

$context['title'] = __( 'Search results for ', 'maera' ) . get_search_query();
$context['posts'] = Timber::get_posts();

Maera_Timber::render(
	array(
		'search.twig',
		'archive.twig',
		'index.twig'
	),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

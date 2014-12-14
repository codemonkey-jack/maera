<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
$context['posts'] = Timber::get_posts();

if ( is_home() ) {
	array_unshift( $templates, 'home.twig' );
}

Maera_Timber::render(
	Maera_Timber::twig_archive_templates(),
	$context,
	apply_filters( 'maera/timber/cache', false )
);

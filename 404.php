<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package  WordPress
 * @subpackage  Maera
 * @since    Maera 0.1
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
Maera_Timber::render( '404.twig', $context, apply_filters( 'maera/timber/cache', false ) );

<?php
/**
* The template for displaying Archive pages.
*
* Used to display archive-type pages if nothing more specific matches a query.
* For example, puts together date-based pages if no date.php file exists.
*
* Learn more: http://codex.wordpress.org/Template_Hierarchy
*/

global $wp_query;

$data = Maera()->template->context();

$data['title'] = __( 'Downloads', 'maera_edd' );
$data['posts'] = Timber::query_posts( false, 'TimberPost' );
$data['query'] = $wp_query->query_vars;

// The in-cart class
$data['in_cart'] = ( function_exists( 'edd_item_in_cart' ) && edd_item_in_cart( $post->ID ) && !edd_has_variable_prices( $post->ID ) ) ? 'in-cart' : '';

// The variable-priced class
$data['variable_priced'] = ( function_exists( 'edd_has_variable_prices' ) && edd_has_variable_prices( $post->ID ) ) ? 'variable-priced' : '';

// Get a list with categories of each download (Isotope filtering)
$terms = get_the_terms( $post->ID, 'download_category' );
if ( $terms && ! is_wp_error( $terms ) ) {
	foreach ( $terms as $term ) {
		$download_categories[] = $term->slug;
	}
	$data['categories'] = join( ' ', $download_categories );
} else {
	$data['categories'] = '';
}

// Get a list with tags of each download (Isotope filtering)
$terms = get_the_terms( $post->ID, 'download_tag' );
if ( $terms && ! is_wp_error( $terms ) ) {
	foreach ( $terms as $term ) {
		$download_tags[] = $term->slug;
	}
	$data['tags'] = join( ' ', $download_tags );
} else {
	$data['tags'] = '';
}

Maera()->template->header();
Maera()->template->main( 'archive-download.twig', $data );
Maera()->template->footer();

<?php
/**
 * The Template for displaying the sidebar
 * @package maera
 */

global $wp_query;
$context = Maera_Timber::get_context();
$post = ( is_home() ) ? new TimberPost( TimberPostGetter::loop_to_id() ) : new TimberPost();
$context['post'] = $post;

$templates = array();

if ( is_singular() ) {

	/**
	 * Use post-specific sidebars per-post or post-type:
	 *     sindebar-{post-ID}.twig
	 *     sidebar-{post-type}.twig
	 *     sidebar-single.twig
	 */
	$templates[] = 'sidebar-' . the_ID() . '.twig';
	$templates[] = 'sidebar-' . get_post_type() . '.twig';
	$templates[] = 'sidebar-single.twig';

} else if ( is_category() || is_tag() || is_tax() ) {

	$tax = $wp_query->tax_query->queries[0];


	/**
	 * If this is a taxonomy:
	 *     Category:
	 *         sidebar-category-{term_id}.twig
	 *         sidebar-category.twig
	 *     Tag:
	 *         sidebar-tag-{term_id}.twig
	 *         sidebar-tag.twig
	 *     Other taxonomies:
	 *         sidebar-term-{term_id}.twig
	 *         sidebar-taxonomy-{taxonomy}.twig
	 *         sidebar-taxonomy.twig
	 */
	$taxonomy  = $wp_query->tax_query->queries[0]['taxonomy'];
	$term_slug = $wp_query->tax_query->queries[0]['terms'][0];
	$term      = get_term_by( 'slug', $slug, $taxonomy );
	$term_id   = intval( $term->term_id );

	if ( is_category() ) {

		$templates[] = 'sidebar-category' . $term_id . '.twig';
		$templates[] = 'sidebar-category.twig';

	} else if ( is_tax() ) {

		$templates[] = 'sidebar-tag' . $term_id . '.twig';
		$templates[] = 'sidebar-tag.twig';

	} else {

		$templates[] = 'sidebar-term-' . $term_id . '.twig';
		$templates[] = 'sidebar-taxonomy-' . $taxonomy . '.twig';
		$templates[] = 'sidebar-taxonomy.twig';

	}


} else if ( is_post_type_archive() ) {

	/**
	 * If this is a post-type archive:
	 *     sidebar-archive-{post_type}.twig
	 */
	$templates[] = 'sidebar-' . $wp_query->query['post_type'] . '.twig';

}

// Fallback to the default sidebar.twig file
$templates[] = 'sidebar.twig';

Timber::render(
	$templates,
	$context,
	apply_filters( 'maera/timber/cache', false )
);

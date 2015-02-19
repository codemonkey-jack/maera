<?php

function maera_templates_hierarchy( $templates = array() ) {

	if ( ! isset( $templates ) ) {
		$templates = array();
	}
	
	if ( ! empty( $templates ) && ! is_array( $templates ) ) {
		$templates = explode( ',', $templates );
		$templates = array_map( 'trim', $templates );
	}

	// Home templates
	if ( is_front_page() ) {
		$templates[] = 'front-page.twig';

		// Check if we're displaying a static page on the front.
		if ( 'page' == get_option( 'show_on_front' ) ) {
			if ( is_page() ) {

				$post = new TimberPost();

				$templates[] = 'page-' . $post->slug . '.twig';
				$templates[] = 'page-' . $post->ID . '.twig';
				$templates[] = 'page.twig';

			}
		}

	}

	if ( is_home() ) {
		$templates[] = 'home.twig';
	}

	// The 404 template
	if ( is_404() ) {
		$templates[] = '404.twig';
	}

	// Page templates
	if ( is_page() ) {

		$post = new TimberPost();

		$templates[] = 'page-' . $post->post_name . '.twig';
		$templates[] = 'page-' . $post->slug . '.twig';
		$templates[] = 'page-' . $post->ID . '.twig';
		$templates[] = 'page.twig';

	}

 	// Singular templates
	if ( is_single() || is_singular( get_post_type() ) ) {

		$post = new TimberPost();

		$templates[] = 'single-' . $post->ID . '.twig';
		$templates[] = 'single-' . $post->post_type . '.twig';
		$templates[] = 'single.twig';

	}

 	// Search templates
	if ( is_search() ) {
		$templates[] = 'search.twig';
	}

	// Category templates
	if ( is_category() ) {

		$cat = get_category( get_query_var( 'cat' ) );
		$cat_id = $cat->cat_ID;
		$cat_slug = $cat->slug;

		$templates[] = 'category-' . $cat_slug . '.twig';
		$templates[] = 'category-' . $cat_id . '.twig';
		$templates[] = 'category.twig';

	}
	// Taxonomy templates
	if ( is_tax() ) {

		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

		$templates[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.twig';
		$templates[] = 'taxonomy-' . $term->taxonomy . '.twig';
		$templates[] = 'taxonomy.twig';

	}

 	// Tag templates
 	if ( is_tag() ) {

		$tag = get_tag( get_query_var( 'tag' ) );
		$tag_id = get_query_var( 'tag_id' );
		$tag_slug = $tag->slug;

		$templates[] = 'tag-' . $tag_slug . '.twig';
		$templates[] = 'tag-' . $tag_id . '.twig';
		$templates[] = 'tag.twig';

	}

	// Date templates
	if ( is_date() ) {
		$templates[] = 'date.twig';
	}

	// Custom post type archive templates
	if ( is_post_type_archive() ) {
		$templates[] = 'archive-' . get_post_type() . '.twig';
	}

 	// Get the templates for authors
	if ( is_author() ) {
		$templates[] = 'author-' . get_the_author_meta( 'user_nicename' ) . '.twig';
		$templates[] = 'author-' . get_the_author_meta( 'ID' ) . '.twig';
		$templates[] = 'author.twig';
	}

	// archives
	if ( is_archive() ) {
		$templates[] = 'archive.twig';
	}

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_templates_hierarchy' );

/**
 * Get the templates for sidebars
 */
function maera_templates_sidebar() {

	global $wp_query;
	$templates = array();

	if ( is_singular() ) {

		/**
		 * Use post-specific sidebars per-post or post-type:
		 *     sidebar-{post-ID}.twig
		 *     sidebar-{post-type}.twig
		 *     sidebar-single.twig
		 */
		$templates[] = 'sidebar-' . get_the_ID() . '.twig';
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
		$term      = get_term_by( 'slug', $term_slug, $taxonomy );
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

	} else if ( is_date() ) {

		/**
		 * If this is a date archive:
		 *     sidebar-date.twig
		 */
		$templates[] = 'sidebar-date.twig';

	}

	// Fallback to the default sidebar.twig file
	$templates[] = 'sidebar.twig';

	return $templates;

}
add_filter( 'maera/sidebar_template', 'maera_templates_sidebar' );

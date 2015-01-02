<?php

/**
 * Archives.
 * Fallback to archive.twig (use a priority of 100)
 */
function maera_templates_archives( $templates = array() ) {

	if ( is_archive() ) {
		$templates[] = 'archive.twig';
	}

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_templates_archives', 100 );

/**
 * The 404 template
 */
function maera_templates_404( $templates = array() ) {

	if ( is_404() ) {
		$templates = '404.twig';
	}

	$templates[] = 'index.twig';

}
add_filter( 'maera/templates', 'maera_templates_404' );

/**
 * Page templates
 */
function maera_templates_page( $templates = array() ) {

	if ( is_page() ) {

		$post = new TimberPost();

		$templates[] = 'page-' . $post->post_name . '.twig';
		$templates[] = 'page-' . $post->slug . '.twig';
		$templates[] = 'page-' . $post->ID . '.twig';
		$templates[] = 'page.twig';

	}

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_templates_page' );

/**
 * Singular templates
 */
function maera_templates_singular( $templates = array() ) {

	if ( is_single() || is_singular( get_post_type() ) ) {

		$post = new TimberPost();

		$templates[] = 'single-' . $post->ID . '.twig';
		$templates[] = 'single-' . $post->post_type . '.twig';
		$templates[] = 'single.twig';

	}

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_templates_singular' );

/**
 * Home templates
 */
function maera_templates_home( $templates = array() ) {

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

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_templates_home' );

/**
 * Search templates
 */
function maera_templates_search( $templates = array() ) {

	if ( is_search() ) {
		$templates[] = 'search.twig';
	}

	$templates[] = 'index.twig';

	return $templates;
}
add_filter( 'maera/templates', 'maera_templates_search' );

/**
 * Category templates
 */
function maera_templates_category( $templates = array() ) {

	if ( is_category() ) {

		$cat = get_category( get_query_var( 'cat' ) );
		$cat_id = $cat->cat_ID;
		$cat_slug = $cat->slug;

		$templates[] = 'category-' . $cat_slug . '.twig';
		$templates[] = 'category-' . $cat_id . '.twig';
		$templates[] = 'category.twig';

	}

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_templates_category' );

/**
 * Taxonomy templates
 */
function maera_template_taxonomy( $templates = array() ) {

	if ( is_tax() ) {

		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

		$templates[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.twig';
		$templates[] = 'taxonomy-' . $term->taxonomy . '.twig';
		$templates[] = 'taxonomy.twig';

	}

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_template_taxonomy' );

/**
 * Tag templates
 */
function maera_template_tax( $templates = array() ) {

 	if ( is_tag() ) {

		$tag = get_tag( get_query_var( 'tag' ) );
		$tag_id = get_query_var( 'tag_id' );
		$tag_slug = $tag->slug;

		$templates[] = 'tag-' . $tag_slug . '.twig';
		$templates[] = 'tag-' . $tag_id . '.twig';
		$templates[] = 'tag.twig';

	}

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_template_tax' );

/**
 * Date templates
 */
function maera_template_date( $templates = array() ) {

	if ( is_date() ) {
		$templates[] = 'date.twig';
	}

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_template_date' );

/**
 * Custom post type archive templates
 */
function maera_templates_cpt_archive( $templates = array() ) {

	if ( is_post_type_archive() ) {
		$templates[] = 'archive-' . get_post_type() . '.twig';
	}

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_templates_cpt_archive' );

/**
 * Get the templates for authors
 */
function maera_templates_author( $templates = array() ) {

	if ( is_author() ) {
		$templates[] = 'author-' . get_the_author_meta( 'user_nicename' ) . '.twig';
		$templates[] = 'author-' . get_the_author_meta( 'ID' ) . '.twig';
		$templates[] = 'author.twig';
		// archive.twig is added on the maera_templates_archives function.
	}

	$templates[] = 'index.twig';

	return $templates;

}
add_filter( 'maera/templates', 'maera_templates_author' );

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

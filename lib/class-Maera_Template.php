<?php

class Maera_Template {

	/**
	 * Test if all required plugins are installed.
	 * If they are not then then do not proceed with the template loading.
	 * Instead display a custom template file that urges users to visit their dashboard to install them.
	 */
	public static function dependencies() {

		if ( 'bad' == Maera::test_missing() ) {
			get_template_part( 'lib/required-error' );
			return;
		}

	}

	/**
	 * Get the header.
	 */
	public static function get_header() {
		get_header();
	}

	/**
	 * Get the content.
	 * This will render the necessary twig template
	 */
	public static function content( $templates = null ) {

		if ( is_null( $templates ) ) {
			$templates = self::twig_templates();
		}

		Timber::render(
			$templates,
			self::context(),
			apply_filters( 'maera/timber/cache', false )
		);

	}

	/**
	 * Get the footer
	 */
	public static function get_footer() {
		get_footer();
	}

	/**
	 * Determine the context that will be used by the content() method
	 */
	public static function context() {

		$context = Maera_Timber::get_context();
		$post = new TimberPost();
		$context['post'] = $post;
		$context['posts'] = Timber::get_posts();

		if ( is_singular() ) {
			$context['wp_title'] .= ' - ' . $post->title();
		}

		if ( is_search() ) {
			$context['title'] = __( 'Search results for ', 'maera' ) . get_search_query();
		}

		return $context;
	}

	/**
	 * Build the array of templates that will be used.
	 */
	public static function twig_templates() {

		$post = new TimberPost();
		$templates = array();

		if ( is_archive() || is_home() || is_search() ) {

			if ( is_search() ) {
				$templates[] = 'search.twig';
			}

			if ( is_home() ) {
				$templates[] = 'home.twig';
			}

			if ( is_author() ) { // Author

				$templates[] = 'author-' . get_the_author_meta( 'user_nicename' ) . '.twig';
				$templates[] = 'author-' . get_the_author_meta( 'ID' ) . '.twig';
				$templates[] = 'author.twig';

			} elseif ( is_category() ) { // Category

				$cat = get_category( get_query_var( 'cat' ) );
				$cat_id = $cat->cat_ID;
				$cat_slug = $cat->slug;

				$templates[] = 'category-' . $cat_slug . '.twig';
				$templates[] = 'category-' . $cat_id . '.twig';
				$templates[] = 'category.twig';

			} elseif ( is_post_type_archive() ) {

				$templates[] = 'archive-' . get_post_type() . '.twig';

			} elseif ( is_tax() ) {

				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

				$templates[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.twig';
				$templates[] = 'taxonomy-' . $term->taxonomy . '.twig';
				$templates[] = 'taxonomy.twig';

			} elseif ( is_date() ) {

				$templates[] = 'date.twig';

			} elseif ( is_tag() ) {

				$tag = get_tag( get_query_var( 'tag' ) );
				$tag_id = get_query_var( 'tag_id' );
				$tag_slug = $tag->slug;

				$templates[] = 'tag-' . $tag_slug . '.twig';
				$templates[] = 'tag-' . $tag_id . '.twig';
				$templates[] = 'tag.twig';

			}

			$templates[] = 'archive.twig';
			$templates[] = 'index.twig';

		}

		if ( is_page() ) {

			$templates[] = 'page-' . $post->post_name . '.twig';
			$templates[] = 'page-' . $post->slug . '.twig';
			$templates[] = 'page-' . $post->ID . '.twig';
			$templates[] = 'page.twig';

		} else if ( is_singular() ) {

			$templates[] = 'single-' . $post->ID . '.twig';
			$templates[] = 'single-' . $post->post_type . '.twig';
			$templates[] = 'single.twig';

		}


		return $templates;


	}

}

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

		global $wp_query;

		$context = Maera_Timber::get_context();
		$post = new TimberPost();
		$context['post'] = $post;
		$context['posts'] = Timber::get_posts();

		// Compatibility hack or plugins that change the content.
		if ( self::plugins_compatibility() ) {
			$post = Timber::query_post();
			$context['post'] = $post;
			$context['content'] = maera_get_echo( 'the_content' );
		}

		if ( is_singular() ) {
			$context['wp_title'] .= ' - ' . $post->title();
		}

		if ( is_search() ) {
			$context['title'] = __( 'Search results for ', 'maera' ) . get_search_query();
		}

		if ( is_archive() || is_home() ) {
			$context['posts'] = Timber::query_posts( false, 'TimberPost' );
			$context['title'] = __( 'Archive', 'maera' );

			if ( is_day() ) {
				$context['title'] = sprintf( __( 'Day: %s', 'maera' ), '<span>' . get_the_date() . '</span>' );
			} else if ( is_month() ) {
				$context['title'] = sprintf( __( 'Month: %s', 'maera' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'maera' ) ) . '</span>' );
			} else if ( is_year() ) {
				$context['title'] = sprintf( __( 'Year: %s', 'maera' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'maera' ) ) . '</span>' );
			} else if ( is_tag() ) {
				$context['title'] = single_tag_title( '', false );
			} else if ( is_category() ) {
				$context['title'] = single_cat_title( '', false );
			} else if ( is_post_type_archive() ) {
				$context['title'] = post_type_archive_title( '', false );
			} else if ( is_author() ) {
				$author = new TimberUser( $wp_query->query_vars['author'] );
				$context['author'] = $author;
				$context['title'] = sprintf( __( 'Author: %s', 'maera' ), '<span class="vcard">' . get_the_author() . '</span>' );
			} else if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$context['title'] = __( 'Asides', 'maera' );
			} else if ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$context['title'] = __( 'Galleries', 'maera' );
			} else if ( is_tax( 'post_format', 'post-format-image' ) ) {
				$context['title'] = __( 'Images', 'maera');
			} else if ( is_tax( 'post_format', 'post-format-video' ) ) {
				$context['title'] = __( 'Videos', 'maera' );
			} else if ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$context['title'] = __( 'Quotes', 'maera' );
			} else if ( is_tax( 'post_format', 'post-format-link' ) ) {
				$context['title'] = __( 'Links', 'maera' );
			} else if ( is_tax( 'post_format', 'post-format-status' ) ) {
				$context['title'] = __( 'Statuses', 'maera' );
			} else if ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$context['title'] = __( 'Audios', 'maera' );
			} else if ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$context['title'] = __( 'Chats', 'maera' );
			} else {
				$context['title'] = __( 'Archives', 'maera' );
			}

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

	public static function plugins_compatibility() {

		// bbPress
		if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
			return true;
		}

		// BuddyPress
		if ( function_exists( 'is_buddypress' ) && is_buddypress() ) {
			return true;
		}

		return apply_filters( 'maera/template/plugin_compatibility', false );

	}

}

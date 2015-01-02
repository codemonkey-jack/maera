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
	public static function header() {
		get_header();
	}

	/**
	 * Get the content.
	 * This will render the necessary twig template
	 */
	public static function main( $templates = null, $context = null ) {

		if ( is_null( $templates ) ) {
			$templates = apply_filters( 'maera/templates', array() );
		}

		if ( is_null( $context ) ) {
			$context = self::context();
		}

		Timber::render(
			$templates,
			$context,
			apply_filters( 'maera/timber/cache', false )
		);

	}

	/**
	 * Get the footer
	 */
	public static function footer() {
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
			$context['title'] = self::context_archives_title();

			if ( is_author() ) {
				$author = new TimberUser( $wp_query->query_vars['author'] );
				$context['author'] = $author;
			}

		}

		return $context;
	}

	/**
	 * Determine the context that will be used by the content() method
	 */
	public static function context_archives_title() {

		if ( is_day() ) {
			return sprintf( __( 'Day: %s', 'maera' ), '<span>' . get_the_date() . '</span>' );
		} elseif ( is_month() ) {
			return sprintf( __( 'Month: %s', 'maera' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'maera' ) ) . '</span>' );
		} elseif ( is_year() ) {
			return sprintf( __( 'Year: %s', 'maera' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'maera' ) ) . '</span>' );
		} elseif ( is_tag() ) {
			return single_tag_title( '', false );
		} elseif ( is_category() ) {
			return single_cat_title( '', false );
		} elseif ( is_post_type_archive() ) {
			return post_type_archive_title( '', false );
		} elseif ( is_author() ) {
			return sprintf( __( 'Author: %s', 'maera' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				return __( 'Asides', 'maera' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				return __( 'Galleries', 'maera' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				return __( 'Images', 'maera');
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				return __( 'Videos', 'maera' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				return __( 'Quotes', 'maera' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				return __( 'Links', 'maera' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				return __( 'Statuses', 'maera' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				return __( 'Audios', 'maera' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				return __( 'Chats', 'maera' );
			}
		} else {
			return __( 'Archive', 'maera' );
		}

	}

	/**
	 * Add compatibility for some plugins.
	 */
	public static function plugins_compatibility() {

		$compatibility = false;

		// bbPress
		$compatibility = function_exists( 'is_bbpress' ) && is_bbpress() ? true : $compatibility;
		// BuddyPress
		$compatibility = function_exists( 'is_buddypress' ) && is_buddypress() ? true : $compatibility;

		return apply_filters( 'maera/template/plugin_compatibility', $compatibility );

	}

}

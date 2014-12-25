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
	public static function main( $templates = null ) {

		if ( is_null( $templates ) ) {
			$templates = apply_filters( 'maera/templates', array( 'index.twig' ) );
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
	 * Add compatibility for some plugins.
	 */
	public static function plugins_compatibility() {

		$compatibility = false;

		// bbPress
		$compatibility = function_exists( 'is_bbpress' ) && is_bbpress() ? true : $compatibility;
		// BuddyPress
		$compatibility = function_exists( 'is_buddypress' ) && is_buddypress() ? true : $compatibility;

		return apply_filters( 'maera/template/plugin_compatibility', false );

	}

}

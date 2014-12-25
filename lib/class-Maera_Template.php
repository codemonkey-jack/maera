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
	public static function content() {

		Timber::render(
			self::twig_template(),
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
	public static function twig_template() {

		$post = new TimberPost();
		$templates = array();

		if ( is_singular() ) {
			$templates[] = 'single-' . $post->ID . '.twig';
			$templates[] = 'single-' . $post->post_type . '.twig';
			$templates[] = 'single.twig';
		}

		if ( is_search() ) {
			$templates[] = 'search.twig';
			$templates[] = 'archive.twig';
			$templates[] = 'index.twig';
		}

		return $templates;


	}

}

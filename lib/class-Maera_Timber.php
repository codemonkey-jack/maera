<?php

class Maera_Timber extends Maera {

	function __construct() {

		// early exit if timber is not installed.
		if ( ! class_exists( 'TImber' ) ) {
			return;
		}

		add_filter( 'get_twig',          array( $this, 'add_to_twig' ) );
		add_action( 'init',              array( $this, 'timber_customizations' ) );

	}

	/**
	 * Custom implementation for get_context method.
	 * Implements caching
	 */
	public static function get_context() {

		global $content_width;

		$cache = wp_cache_get( 'context', 'maera' );
		if ( $cache ) {
			return $cache;
		}

		$context = Timber::get_context();

		$sidebar_primary   = Timber::get_widgets( 'sidebar_primary' );
		$sidebar_footer    = Timber::get_widgets( 'sidebar_footer' );

		$context['theme_mods']           = get_theme_mods();
		$context['site_options']         = wp_load_alloptions();
		$context['teaser_mode']          = apply_filters( 'maera/teaser/mode', 'excerpt' );
		$context['thumbnail']['width']   = apply_filters( 'maera/image/width', 600 );
		$context['thumbnail']['height']  = apply_filters( 'maera/image/height', 371 );
		$context['menu']['primary']      = has_nav_menu( 'primary_navigation' ) ? new TimberMenu( 'primary_navigation' ) : null;

		$context['sidebar'] = Timber::get_sidebar();
		$context['widget_area']['primary']   = apply_filters( 'maera/sidebar/primary', $sidebar_primary );
		$context['widget_area']['footer']    = apply_filters( 'maera/sidebar/footer', $sidebar_footer );

		$context['pagination']           = Timber::get_pagination();
		$context['comment_form']         = TimberHelper::get_comment_form();
		$context['site_logo']            = get_option( 'site_logo', false );
		$context['content_width']        = $content_width;

		wp_cache_set( 'context', $context, 'maera' );
		return $context;

	}

	/**
	 * An array of paths containing our twig files.
	 * First we search in the childtheme if one is active.
	 * Then we continue looking for the twig file in the active shell
	 * and finally fallback to the core twig files.
	 */
	public static function twig_locations() {

		$locations = array();

		// Are we using a child theme?
		// If yes, then first look in there.
		if ( is_child_theme() ) {
			$locations[] = get_stylesheet_directory() . '/macros';
			$locations[] = get_stylesheet_directory() . '/views/macros';
			$locations[] = get_stylesheet_directory() . '/views';
			$locations[] = get_stylesheet_directory();
		}

		// Active shell
		$locations[] = MAERA_SHELL_PATH . '/macros';
		$locations[] = MAERA_SHELL_PATH . '/views/macros';
		$locations[] = MAERA_SHELL_PATH . '/views';
		$locations[] = MAERA_SHELL_PATH;

		// Core twig locations.
		$locations[] = get_template_directory() . '/macros';
		$locations[] = get_template_directory() . '/views/macros';
		$locations[] = get_template_directory() . '/views';
		$locations[] = get_template_directory();

		return apply_filters( 'maera/timber/locations', $locations );

	}

	public static function twig_archive_templates() {

		$templates = array();

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

		}

		$templates[] = 'archive.twig';
		$templates[] = 'index.twig';

		return $templates;
	}

	/**
	 * Apply global Timber customizations
	 */
	function timber_customizations() {

		global $wp_customize;

		$locations = self::twig_locations();
		Timber::$locations = $locations;

		// Add caching if dev_mode is set to off.
		$theme_options = get_option( 'maera_admin_options', array() );
		if ( isset( $theme_options['dev_mode'] ) && 0 == $theme_options['dev_mode'] && ! isset( $wp_customize ) ) {

			add_filter( 'maera/styles/caching', '__return_true' );
			// Turn on Timber caching.
			// See https://github.com/jarednova/timber/wiki/Performance#cache-the-twig-file-but-not-the-data
			Timber::$cache = true;
			add_filter( 'maera/timber/cache', array( $this, 'timber_caching' ) );

		} else {

			add_filter( 'maera/styles/caching', '__return_false' );
			TimberLoader::CACHE_NONE;
			Timber::$cache = false;

			$_SERVER['QUICK_CACHE_ALLOWED'] = FALSE;
			Maera::define( 'DONOTCACHEPAGE', TRUE );

		}

	}

	/**
	 * Timber caching
	 */
	function timber_caching() {

		$theme_options = get_option( 'maera_admin_options', array() );

		$cache_int = isset( $theme_options['cache'] ) ? intval( $theme_options['cache'] ) : 0;

		if ( 0 == $cache_int ) {

			// No need to proceed if cache=0
			return false;

		}

		// Convert minutes to seconds
		return ( $cache_int * 60 );

	}

	/**
	 * Enable Twig_Extension_StringLoader.
	 * This allows us to use template_from_string() in our templates.
	 *
	 * See http://twig.sensiolabs.org/doc/functions/template_from_string.html for details
	 */
	function add_to_twig( $twig ){
		$twig->addExtension( new Twig_Extension_StringLoader() );
		return $twig;
	}

}

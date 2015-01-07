<?php

class Maera_Timber extends Maera {

	function __construct() {

		// early exit if timber is not installed.
		if ( ! class_exists( 'TImber' ) ) {
			return;
		}

		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'timber_customizations' ) );

	}

	/**
	 * Custom implementation for get_context method.
	 */
	public static function get_context() {

		global $content_width;

		$context = Timber::get_context();

		$sidebar_primary   = Timber::get_widgets( 'sidebar_primary' );
		$sidebar_footer    = Timber::get_widgets( 'sidebar_footer' );

		$context['theme_mods']           = get_theme_mods();
		$context['site_options']         = wp_load_alloptions();
		$context['teaser_mode']          = apply_filters( 'maera/teaser/mode', 'excerpt' );
		$context['thumbnail']['width']   = apply_filters( 'maera/image/width', 600 );
		$context['thumbnail']['height']  = apply_filters( 'maera/image/height', 371 );
		$context['menu']['primary']      = has_nav_menu( 'primary_navigation' ) ? new TimberMenu( 'primary_navigation' ) : null;

		$context['sidebar']['primary']   = apply_filters( 'maera/sidebar/primary', $sidebar_primary );
		$context['sidebar']['footer']    = apply_filters( 'maera/sidebar/footer', $sidebar_footer );

		$context['pagination']           = Timber::get_pagination();
		$context['comment_form']         = TimberHelper::get_comment_form();
		$context['site_logo']            = get_option( 'site_logo', false );
		$context['content_width']        = $content_width;

		$context['sidebar_template']     = maera_templates_sidebar();

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
		$location_roots = array();

		// Are we using a child theme?
		// If yes, then first look in there.
		if ( is_child_theme() ) {
			$location_roots[] = get_stylesheet_directory();
		}
		// Active shell
		$location_roots[] = MAERA_SHELL_PATH;
		// Core twig locations.
		$location_roots[] = get_template_directory();
		// Allow modifying they location roots using a filter
		$location_roots = apply_filters( 'maera/timber/locations/roots', $location_roots );

		foreach ( $location_roots as $location_root ) {
			$locations[] = $location_root . '/macros';
			$locations[] = $location_root . '/views/macros';
			$locations[] = $location_root . '/views';
			$locations[] = $location_root;
		}

		return apply_filters( 'maera/timber/locations', $locations );

	}

	/**
	 * Apply global Timber customizations
	 */
	function timber_customizations() {

		global $wp_customize;

		$locations = self::twig_locations();
		Timber::$locations = $locations;

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

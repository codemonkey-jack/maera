<?php

class Maera_Caching {

	function __construct() {

		add_action( 'customize_save_after', array( $this, 'reset_style_cache_on_customizer_save' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'custom_css_cached' ), 101 );
		add_action( 'init', array( $this, 'timber_customizations' ) );

	}

	/**
	 * Reset the cache when saving the customizer
	 */
	function reset_style_cache_on_customizer_save() {
		remove_theme_mod( 'css_cache' );
	}

	function custom_css_cached() {

		if ( Maera_Development::dev_mode() ) {
			// Get our styles using the maera/styles filter
			$data = apply_filters( 'maera/styles', null );
		} else {
			// Get the cached CSS from the database
			$cache = get_theme_mod( 'css_cache', '' );
			// If the transient does not exist, then create it.
			if ( ! $cache || empty( $cache ) || '' == $cache ) {
				// Get our styles using the maera/styles filter
				$data = apply_filters( 'maera/styles', null );
				// Set the transient for 24 hours.
				set_theme_mod( 'css_cache', $data );
			} else {
				$data = $cache;
			}
		}

		// Add the CSS inline.
		// See http://codex.wordpress.org/Function_Reference/wp_add_inline_style#Examples
		wp_add_inline_style( 'maera', $data );

	}

	/**
	 * Apply global Timber customizations
	 */
	function timber_customizations() {

		// Early exit if Timber is not installed
		if ( ! class_exists( 'Timber' ) ) {
			return;
		}
		global $wp_customize;

		if ( ! Maera_Development::dev_mode() ) {

			// Turn on Timber caching.
			// See https://github.com/jarednova/timber/wiki/Performance#cache-the-twig-file-but-not-the-data
			Timber::$cache = true;

		} else {

			TimberLoader::CACHE_NONE;
			Timber::$cache = false;

			$_SERVER['QUICK_CACHE_ALLOWED'] = FALSE;
			Maera::define( 'DONOTCACHEPAGE', TRUE );

		}

	}

	/**
	 * Timber caching
	 */
	public static function cache_duration() {

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
	 * Custom implementation for get_context method.
	 * Implements caching
	 */
	public static function get_context() {

		if ( Maera_Development::dev_mode() ) {

			return Maera_Timber::get_context();

		} else {

			$cache = wp_cache_get( 'context', 'maera' );
			if ( $cache ) {
				return $cache;
			} else {
				$context = Maera_Timber::get_context();
				wp_cache_set( 'context', $context, 'maera' );
				return $context;
			}

		}

	}

	public static function cache_mode() {

		if ( Maera_Development::dev_mode() ) {
			return TimberLoader::CACHE_NONE;
		} else {
			return TimberLoader::CACHE_USE_DEFAULT;
		}
	}

}

<?php

class Maera_Development {

	function __construct() {

		if ( self::dev_mode() ) {
			$this->jetpack_dev_mode();
			$this->no_timber_caching();
		}

	}

	/**
	 * Detect if dev mode is active OR if we're on the customizer
	 * @return bool
	 */
	public static function dev_mode() {

		global $wp_customize;

		$theme_options = get_option( 'maera_admin_options', array() );
		if ( isset( $theme_options['dev_mode'] ) && 0 == $theme_options['dev_mode'] && ! isset( $wp_customize ) ) {
			return false;
		} else {
			return true;
		}

	}

	/**
	 * set JETPACK_DEV_DEBUG to true if not already defined
	 */
	function jetpack_dev_mode() {

		if ( ! defined( 'JETPACK_DEV_DEBUG' ) ) {
			define( 'JETPACK_DEV_DEBUG', true);
		}

	}

	function no_timber_caching() {

		// Early exit if TimberLoader does not exist
		if ( ! class_exists( 'TimberLoader' ) ) {
			return;
		}

		TimberLoader::CACHE_NONE;
	}

}

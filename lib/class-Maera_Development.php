<?php

class Maera_Development {

	function __construct() {

		if ( $this->dev_mode() ) {
			$this->jetpack_dev_mode();
		}

	}

	/**
	 * Detect if dev mode is active OR if we're on the customizer
	 * @return bool
	 */
	public function dev_mode() {

		global $wp_customize;
		$options = get_option( 'maera_admin_options', array() );

		// If we're on the customizer, return true.
		if ( isset( $wp_customize ) ) {
			return;
		}

		// If dev mode is enabled on the dashboard, return true;
		if ( isset( $options['dev_mode'] ) && 1 == $options['dev_mode'] ) {
			return true;
		}

		return false;

	}

	/**
	 * set JETPACK_DEV_DEBUG to true if not already defined
	 */
	function jetpack_dev_mode() {

		if ( ! defined( 'JETPACK_DEV_DEBUG' ) ) {
			define( 'JETPACK_DEV_DEBUG', true);
		}

	}

}

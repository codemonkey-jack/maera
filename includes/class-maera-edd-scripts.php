<?php

class Maera_EDD_Scripts {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 100 );
	}

	/**
	 * Add our custom stylesheets and scripts
	 */
	function scripts() {

		$options = get_option( 'maera_admin_options', array() );
		$active_shell = ( isset( $options['shell'] ) ) ? $options['shell'] : 'core';

		// Remove the default EDD styles
		wp_dequeue_style( 'edd-styles' );

		// If EDD-Software-Specs is installed, remove its styles
		if ( class_exists( 'EDD_Software_Specs' ) ) {
			wp_dequeue_style( 'edd-software-specs' );
			wp_deregister_style( 'edd-software-specs' );
		}

		// Add our custom styles
		wp_register_style( 'maera-edd', trailingslashit( MAERA_EDD_URL ) . 'assets/css/style.css' );
		wp_enqueue_style( 'maera-edd' );

		if ( 'isotope' == get_theme_mod( 'filter_mode', 'isotope' ) && ( is_archive( 'download' ) || is_tax('download_tag') || is_tax( 'download_category' ) ) ) {
			// Register && Enqueue Isotope
			wp_register_script( 'maera_isotope', MAERA_EDD_URL . 'assets/vendor/jquery.isotope.min.js', false, null, true );
			wp_enqueue_script( 'maera_isotope' );

			// Register && Enqueue Isotope-Sloppy-Masonry
			wp_register_script( 'maera_isotope_sloppy_masonry', MAERA_EDD_URL . 'assets/vendor/jquery.isotope.sloppy-masonry.min.js', false, null, true );
			wp_enqueue_script( 'maera_isotope_sloppy_masonry' );

			wp_enqueue_script( 'edd_script', MAERA_EDD_URL . 'assets/scripts.js', false, null, true );
			// wp_localize_script( 'maera_foundation_script', 'maera_foundation_script_vars', array(
			//
			//     )
			// );
		}

	}

}

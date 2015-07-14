<?php

class Maera_EDD_Compatibility {

	function __construct() {

		add_filter( 'post_class', array( $this, 'edd_coming_soon' ) );
		add_filter( 'body_class', array( $this, 'edd_coming_soon' ) );

	}

	/**
	 * Add extra post classes if needed
	 */
	function edd_coming_soon( $classes ) {

		global $post;

		// Add coming-soon classes
		if ( defined( 'EDD_COMING_SOON' ) ) {

			$coming_soon = get_post_meta( $post->ID, 'edd_coming_soon', true );
			if ( $coming_soon ) {
				$classes[] = 'edd_coming_soon';
			}

		}

		return $classes;

	}

}

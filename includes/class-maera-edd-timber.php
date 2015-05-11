<?php

/**
 * Timber customizations for Maera_EDD
 */
class Maera_EDD_Timber {

	function __construct() {

		add_filter( 'timber_context',         array( $this, 'timber_global_context' ) );

	}

	/**
	 * Modify Timber global context
	 */
	function timber_global_context( $data ) {

		global $edd_options;
		$data['edd_options'] = $edd_options;

		$data['download_categories'] = Timber::get_terms( 'download_category' );
		$data['download_tags']       = Timber::get_terms( 'download_tag' );

		$data['default_image'] = new TimberImage( get_template_directory_uri() . '/assets/images/default.png' );

		return $data;

	}

}

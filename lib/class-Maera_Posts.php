<?php

/**
 * Customizations for the TimberPost class.
 */
class Maera_Post extends TimberPost {

	/*
	 * Add the meta info
	 */
	function meta_info() {

		do_action( 'maera/entry/meta', $this->ID );

	}

	/*
	 * apply the 'maera/in_article/top' action
	 */
	function top() {

		do_action( 'maera/in_article/top', $this->ID );

	}

	/*
	 * Add the maera_get_post_teaser() function
	 */
	function teaser() {

		$content = maera_get_post_teaser( $this->ID );
		return $content;

	}

	/*
	 * apply the 'maera/entry/footer' action
	 */
	function footer() {

		do_action( 'maera/entry/footer', $this->ID );

	}

}

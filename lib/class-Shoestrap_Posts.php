<?php

/**
 * Customizations for the TimberPost class.
 */
class Shoestrap_Post extends TimberPost {

	/*
	 * Add the meta info
	 */
	function meta_info() {

		do_action( 'shoestrap/entry/meta', $this->ID );

	}

	/*
	 * apply the 'shoestrap/in_article/top' action
	 */
	function top() {

		do_action( 'shoestrap/in_article/top', $this->ID );

	}

	/*
	 * Add the shoestrap_get_post_teaser() function
	 */
	function teaser() {

		$content = shoestrap_get_post_teaser( $this->ID );
		return $content;

	}

	/*
	 * apply the 'shoestrap/entry/footer' action
	 */
	function footer() {

		do_action( 'shoestrap/entry/footer', $this->ID );

	}

}

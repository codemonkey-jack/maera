<?php

/**
 * Customizations for the TimberPost class.
 */
class Maera_Post extends TimberPost {

	/**
	 *  If you send the constructor nothing it will try to figure out the current post id based on being inside The_Loop
	 * @param mixed $pid
	 * @return \TimberPost TimberPost object -- woo!
	 */
	function __construct( $pid = null ) {

		if ( current_theme_supports( 'ajax' ) ) {
			if ( isset( $_POST['id'] ) && is_numeric( $_POST['id'] ) ) {
				$pid = $_POST['id'];
			}
		}

		if ( $pid === null && get_the_ID() ) {
			$pid = get_the_ID();
			$this->ID = $pid;
		} else if ( $pid === null && ( $pid_from_loop = TimberPostGetter::loop_to_id() ) ) {
			$this->ID = $pid_from_loop;
		}
		if ( is_numeric( $pid ) ) {
			$this->ID = $pid;
		}
		$this->init($pid);

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

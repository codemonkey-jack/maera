<?php
/*
 * Trick BuddyPress to think we are in the loop.
 *
 * Whenever BuddyPress detects a page that has BuddyPress content it wipes all posts from wp_query.
 * It then adds a new post with the BuddyPress content.
 * This however relies on being in the loop, which isn't used by Timber.
 */
class Timber_BuddyPress {

	function __construct() {
		add_action( 'timber_post_init',array( $this,'timber_post_init' ) );
	}

	function timber_post_init( $post ) {
		global $wp_query;

		if ( is_buddypress() ) {
			$wp_query->in_the_loop = true;
		}
	}

}
new Timber_BuddyPress();

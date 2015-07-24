<?php

/**
 * Enqueue scripts and styles.
 */
function maera_scripts() {
    /**
     * Add basic styles
     */
	wp_enqueue_style( 'maera-style', get_stylesheet_uri() );
    /**
     * Add skip-focus-fix.js
     */
	wp_enqueue_script( 'maera-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );
    /**
     * Add comments scripts when needed
     */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'maera_scripts' );

<?php

function shoestrap_breadcrumbs() {

	$breadcrumbs = get_theme_mod( 'breadcrumbs', 0 );

	if ( 0 != $breadcrumbs ) {

		$ss_breadcrumbs = new Shoestrap_Breadcrumbs();
		echo $ss_breadcrumbs->breadcrumb( false );

	}

}
add_action( 'shoestrap/content/before', 'shoestrap_breadcrumbs' );


/**
 * Excerpt length
 */
function shoestrap_excerpt_length() {

	return get_theme_mod( 'post_excerpt_length', 55 );

}
add_filter( 'excerpt_length', 'shoestrap_excerpt_length' );

/**
 * The "more" text
 */
function shoestrap_excerpt_more( $more ) {

	$continue_text = get_theme_mod( 'post_excerpt_link_text', 'Continued' );
	return ' &hellip; <a href="' . get_permalink() . '">' . $continue_text . '</a>';

}
add_filter( 'excerpt_more', 'shoestrap_excerpt_more' );

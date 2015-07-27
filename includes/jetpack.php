<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Maera
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function maera_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'maera_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function maera_jetpack_setup
add_action( 'after_setup_theme', 'maera_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function maera_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		Maera::get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function maera_infinite_scroll_render

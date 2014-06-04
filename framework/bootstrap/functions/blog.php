<?php

function shoestrap_breadcrumbs() {

	$breadcrumbs = get_theme_mod( 'breadcrumbs', 0 );

	if ( 0 != $breadcrumbs && ! is_home() && ! is_front_page() ) {

		$args = array(
			'container'       => 'ol',
			'separator'       => '</li><li>',
			'before'          => '<li>',
			'after'           => '</li>',
			'show_on_front'   => true,
			'network'         => false,
			'show_title'      => true,
			'show_browse'     => true,
			'echo'            => true,
			'labels'          => array(
				'browse'      => '',
				'home'        => '<i class="el-icon-home"></i>',
			),
		);

		shoestrap_breadcrumb_trail( $args );

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

/**
 * Disable featured images per post type.
 * This is a simple fanction that parses the array of disabled options from the customizer
 * and then sets their display to 0 if we've selected them in our array.
 */
function shoestrap_disable_feat_images_ppt() {
	global $post;

	$current_post_type = get_post_type( $post );

	// Get the array of disabled featured images per post type
	$disabled = explode( ',', get_theme_mod( 'feat_img_per_post_type', array() ) );
	// Get the default switch values for singulars and archives
	$default = ( is_singular() ) ? get_theme_mod( 'feat_img_post', 0 ) : get_theme_mod( 'feat_img_archive', 0 );
	// If the current post type exists in our array of disabled post types, then set its displaying to false
	$display = ( in_array( $current_post_type, $disabled ) ) ? 0 : $default;

	return $display;

}
add_filter( 'shoestrap/image/switch', 'shoestrap_disable_feat_images_ppt' );

<?php

/**
 *
 */
function shoestrap_layout_classes( $element ) {

	// What should we use for columns?
	$col = 'col-md-';

	// Get the layout we're using (sidebar arrangement).
	$layout = get_theme_mod( 'layout', 1 );

	// Apply a filter to the layout.
	// Allows us to bypass the selected layout using a simple filter like this:
	// add_filter( 'shoestrap/layout/modifier', function() { return 3 } ); // will only run on PHP > 5.3
	// OR
	// add_filter( 'shoestrap/layout/modifier', 'shoestrap_return_2' ); // will also run on PHP < 5.3
	$layout = apply_filters( 'shoestrap/layout/modifier', $layout );

	// Get the site style. Defaults to 'Wide'.
	$site_mode = get_theme_mod( 'site_style', 'wide' );

	// Get the sidebar widths
	$width_one = ( ! is_active_sidebar( 'sidebar_primary' ) )   ? null : get_theme_mod( 'layout_primary_width', 4 );
	$width_two = ( ! is_active_sidebar( 'sidebar_secondary' ) ) ? null : get_theme_mod( 'layout_secondary_width', 3 );

	// If the selected layout is no sidebars, then disregard the primary sidebar width.
	$width_one = ( 0 == $layout ) ? null : $width_one;

	// If the selected layout only has one sidebar, disregard the 2nd sidebar width.
	$width_two     = ( ! in_array( $layout, array( 3, 4, 5 ) ) ) ? null : $width_two;
	$width_wrapper = ( ! in_array( $layout, array( 3, 4, 5 ) ) ) ? null : 12 - $width_two;

	$width_main    = 12 - $width_one - $width_two;

	// When we select a layout like sidebar-content-sidebar, we need a wrapper around the primary sidebar and the content.
	// That changes the way we calculate the primary sidebar and the content columns.
	if ( in_array( $layout, array( 3, 4, 5 ) ) ) {

		$width_main = 12 - floor( ( 12 * $width_one ) / ( 12 - $width_two ) );
		$width_one  = floor( ( 12 * $width_one ) / ( 12 - $width_two ) );

	}

	if ( $element == 'primary' ) {

		// return the primary class
		$columns = $col . intval( $width_one );
		$classes = ( is_null( $width_one ) ) ? null : $columns;

	} elseif ( $element == 'secondary' ) {

		// return the secondary class
		$columns = $col . intval( $width_two );
		$classes = ( is_null( $width_two ) ) ? null : $columns;

	} elseif ( $element == 'wrapper' ) {

		$columns = $col . intval( $width_wrapper );

		if ( ! is_null( $width_wrapper ) ) {
			$classes = ( 3 == $layout ) ? $columns . ' pull-right' : $columns;
		} else {
			$classes = null;
		}

	} else {

		// return the main class
		$columns = $col . intval( $width_main );
		$classes = ( in_array( $layout, array( 2, 3, 5 ) ) ) ? $columns . ' pull-right' : $columns;

	}

	return $classes;

}

/**
 * This is just a helper function.
 *
 * Returns the class of the main content area.
 */
function shoestrap_layout_classes_content() {
	return shoestrap_layout_classes( 'content' );
}
add_filter( 'shoestrap/section_class/content', 'shoestrap_layout_classes_content' );

/**
 * This is just a helper function.
 *
 * Returns the class of the main primary sidebar
 */
function shoestrap_layout_classes_primary() {
	return shoestrap_layout_classes( 'primary' );
}
add_filter( 'shoestrap/section_class/primary', 'shoestrap_layout_classes_primary' );

/**
 * This is just a helper function.
 *
 * Returns the class of the main secondary sidebar
 */
function shoestrap_layout_classes_secondary() {
	return shoestrap_layout_classes( 'secondary' );
}
add_filter( 'shoestrap/section_class/secondary', 'shoestrap_layout_classes_secondary' );

/**
 * This is just a helper function.
 *
 * Returns the class of the wrppaer (main conent area + primary sidebar.)
 * Makes complex layouts possible.
 */
function shoestrap_layout_classes_wrapper() {
	return shoestrap_layout_classes( 'wrapper' );
}
add_filter( 'shoestrap/section_class/wrapper', 'shoestrap_layout_classes_wrapper' );


/**
 * Null sidebars when needed.
 * These are applied on the index.php file.
 */
function shoestrap_sidebars_bypass() {

	$layout = get_theme_mod( 'layout' );
	$layout = apply_filters( 'shoestrap/layout/modifier', $layout );

	// If the layout does not contain 2 sidebars, do not render the secondary sidebar
	if ( ! in_array( $layout, array( 3, 4, 5 ) ) ) {
		add_filter( 'shoestrap/sidebar/secondary', '__return_null' );
	}

	// If the layout selected contains no sidebars, do not render the primary sidebar
	if ( 0 == $layout ) {
		add_filter( 'shoestrap/sidebar/primary', '__return_null' );
	}

}
add_action( 'wp', 'shoestrap_sidebars_bypass' );

/**
 * Filter for the container class.
 *
 * When the user selects fluid site mode, remove the container class from containers.
 */
function shoestrap_container_class_modifier() {

	$site_style = get_theme_mod( 'site_style', 'wide' );

	if ( 'fluid' == $site_style ) {

		// Fluid mode
		add_filter( 'shoestrap/container_class', 'shoestrap_return_container_fluid' );
		add_filter( 'shoestrap/topbar/class/container', 'shoestrap_return_container_fluid' );

	}

}
add_action( 'wp', 'shoestrap_container_class_modifier' );

// return "container-fluid"
function shoestrap_return_container_fluid() { return 'container-fluid'; }

/**
 * Hide the sidebars on the frontpage if the user has selected to do so
 */
function shoestrap_timber_global_context_remove_sidebars( $data ) {

	$sidebars_on_front = get_theme_mod( 'layout_sidebar_on_front' );

	If ( 0 == $sidebars_on_front ) {

		$data['sidebar']['primary']   = null;
		$data['sidebar']['secondary'] = null;

		// Add a filter for the layout.
		add_filter( 'shoestrap/layout/modifier', 'shoestrap_return_0' );

	}

	return $data;

}
add_filter( 'timber_context', 'shoestrap_timber_global_context_remove_sidebars', 50 );

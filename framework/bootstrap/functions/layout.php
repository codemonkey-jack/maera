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
	$width_two = ( ! in_array( $layout, array( 3, 4, 5 ) ) ) ? null : $width_two;

	// The main wrapper width
	$width_wrapper = ( is_null( $width_two ) ) ? null : 12 - $width_two;

	// The main content area width
	$width_main = 12 - $width_one - $width_two;

	// When we select a layout like sidebar-content-sidebar, we need a wrapper around the primary sidebar and the content.
	// That changes the way we calculate the primary sidebar and the content columns.
	if ( ! is_null( $width_wrapper ) ) {

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
		$classes = ( in_array( $layout, array( 2, 3, 5 ) ) && ! is_null( $width_one ) ) ? $columns . ' pull-right' : $columns;

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

	// Have we selected custom layouts per post type?
	// if yes, then make sure the layout used for post types is the custom selected one.
	if ( 1 == get_theme_mod( 'cpt_layout_toggle' ) ) {

		$post_types = get_post_types( array( 'public' => true ), 'names' );

		foreach ( $post_types as $post_type ) {

			if ( is_singular( $post_type ) ) {
				$layout = get_theme_mod( $post_type . '_layout', get_theme_mod( 'layout' ) );
				add_filter( 'shoestrap/layout/modifier', 'shoestrap_return_' . $layout );
			}

		}

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

	} else {

		add_filter( 'shoestrap/container_class', 'shoestrap_return_container' );
		add_filter( 'shoestrap/topbar/class/container', 'shoestrap_return_container' );

	}

}
add_action( 'wp', 'shoestrap_container_class_modifier' );

// return "container-fluid"
function shoestrap_return_container_fluid() { return 'container-fluid'; }

// return "container"
function shoestrap_return_container() { return 'container'; }

/**
 * Hide the sidebars on the frontpage if the user has selected to do so
 */
function shoestrap_timber_global_context_remove_sidebars( $data ) {

	// Get the layout we're using (sidebar arrangement).
	$layout = apply_filters( 'shoestrap/layout/modifier', get_theme_mod( 'layout', 1 ) );

	$sidebars_on_front = get_theme_mod( 'layout_sidebar_on_front' );

	If ( 0 == $layout || ( 0 == $sidebars_on_front && ( is_home() || is_front_page() ) ) ) {

		$data['sidebar']['primary']   = null;
		$data['sidebar']['secondary'] = null;

		// Add a filter for the layout.
		add_filter( 'shoestrap/layout/modifier', 'shoestrap_return_0' );

	}

	return $data;

}
add_filter( 'timber_context', 'shoestrap_timber_global_context_remove_sidebars', 50 );


/**
 * Add and remove body_class() classes
 */
function shoestrap_boxed_body_class( $classes ) {

	$site_style = get_theme_mod( 'site_style', 'wide' );

	if ( 'boxed' == $site_style ) {
		$classes[] = 'container';
		$classes[] = 'boxed';
	}

	return $classes;
}
add_filter( 'body_class', 'shoestrap_boxed_body_class' );

/**
 * Additional CSS rules for layout options
 */
function shoestrap_layout_css( $style ) {
	global $wp_customize;

	$body_margin_top    = get_theme_mod( 'body_margin_top', 0 );
	$body_margin_bottom = get_theme_mod( 'body_margin_bottom', 0 );

	if ( 0 != $body_margin_top ) {
		$style .= 'html body.bootstrap { margin-top: ' . $body_margin_top . 'px !important; }';
	}

	if ( 0 != $body_margin_bottom ) {
		$style .= 'html body.bootstrap { margin-bottom: ' . $body_margin_bottom . 'px !important; }';
	}

	// Customizer-only styles
	if ( $wp_customize ) {

		$screen_sm = filter_var( get_theme_mod( 'screen_tablet', 768 ), FILTER_SANITIZE_NUMBER_INT );
		$screen_md = filter_var( get_theme_mod( 'screen_desktop', 992 ), FILTER_SANITIZE_NUMBER_INT );
		$screen_lg = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
		$gutter    = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );

		$style .= '
		.container {
			padding-left: ' . round( $gutter / 2 ) . 'px;
			padding-right: ' . round( $gutter / 2 ) . 'px;
		}
		@media (min-width: ' . $screen_sm . 'px) {
			.container {
				width: ' . ( $screen_sm - ( $gutter / 2 ) ). 'px;
			}
		}
		@media (min-width: ' . $screen_lg . 'px) {
			.container {
				width: ' . ( $screen_md - ( $gutter / 2 ) ). 'px;
			}
		}
		@media (min-width: ' . $screen_lg . 'px) {
			.container {
				width: ' . ( $screen_lg - ( $gutter / 2 ) ). 'px;
			}
		}
		.container-fluid {
			padding-left: ' . round( $gutter / 2 ) . 'px;
			padding-right: ' . round( $gutter / 2 ) . 'px;
		}
		.row {
			margin-left: -' . round( $gutter / 2 ) . 'px;
			margin-right: -' . round( $gutter / 2 ) . 'px;
		}
		.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
			padding-left: ' . round( $gutter / 2 ) . 'px;
			padding-right: ' . round( $gutter / 2 ) . 'px;
		}';

	}

	return $style;

}
add_filter( 'shoestrap/customizer/styles', 'shoestrap_layout_css' );

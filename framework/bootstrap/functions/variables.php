<?php

/**
 * Get the variables from the theme options and parse them all together.
 *
 * These will then be added to the compiler using the "shoestrap/compiler/variables" filter
 */
function shoestrap_compiler_variables( $variables ) {

	if ( 1 == get_theme_mod( 'custom_grid', 0 ) ) {

		$variables .= '@screen-sm: ' . get_theme_mod( 'screen_tablet', 768 ) . 'px;';
		$variables .= '@screen-md: ' . get_theme_mod( 'screen_desktop', 992 ) . 'px;';
		$variables .= '@screen-lg: ' . get_theme_mod( 'screen_large_desktop', 1200 ) . 'px;';

		$variables .= '@container-tablet: ((@screen-sm - (2 * @grid-gutter-width)));';
		$variables .= '@container-desktop: ((@screen-md - (2 * @grid-gutter-width)));';
		$variables .= '@container-large-desktop: ((@screen-lg - (2 * @grid-gutter-width)));';

	}

	return $variables;

}
add_filter( 'shoestrap/compiler/variables', 'shoestrap_compiler_variables' );

<?php

/**
 * Get the variables from the theme options and parse them all together.
 *
 * These will then be added to the compiler using the "shoestrap/compiler/variables" filter
 */
function shoestrap_compiler_variables( $variables ) {

	if ( 1 == get_theme_mod( 'custom_grid', 0 ) ) {

		// Layout settings
		$variables .= '@screen-sm: ' . get_theme_mod( 'screen_tablet', 768 ) . 'px;';
		$variables .= '@screen-md: ' . get_theme_mod( 'screen_desktop', 992 ) . 'px;';
		$variables .= '@screen-lg: ' . get_theme_mod( 'screen_large_desktop', 1200 ) . 'px;';

		$variables .= '@container-tablet: ((@screen-sm - (2 * @grid-gutter-width)));';
		$variables .= '@container-desktop: ((@screen-md - (2 * @grid-gutter-width)));';
		$variables .= '@container-large-desktop: ((@screen-lg - (2 * @grid-gutter-width)));';

		// Color Settings
		$variables .= '@brand-primary: ' . Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_primary', '#428bca' ) ) . ';';
		$variables .= '@brand-success: ' . Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_success', '#5cb85c' ) ) . ';';
		$variables .= '@brand-info:    ' . Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_info', '#5bc0de' ) ) . ';';
		$variables .= '@brand-warning: ' . Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_warning', '#f0ad4e' ) ) . ';';
		$variables .= '@brand-danger:  ' . Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_danger', '#d9534f' ) ) . ';';

		if ( get_theme_mod( 'gradients_toggle', 0 ) ) {
			$variables .= '@import "' . SS_FRAMEWORK_PATH . '/assets/less/gradients.less";';
		}


	}

	return $variables;

}
add_filter( 'shoestrap/compiler/variables', 'shoestrap_compiler_variables' );

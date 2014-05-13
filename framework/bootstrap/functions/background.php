<?php

/**
 * Additional CSS rules for background options
 */
function shoestrap_background_css( $styles ) {

	$html_bg_color    = Shoestrap_Color::sanitize_hex( get_theme_mod( 'html_bg_color', '#ffffff' ) );
	$html_bg_image    = get_theme_mod( 'html_bg_image', '' );
	$html_bg_repeat   = get_theme_mod( 'html_bg_repeat', 'repeat' );
	$html_bg_size     = get_theme_mod( 'html_bg_size', 'inherit' );
	$html_bg_attach   = get_theme_mod( 'html_bg_attach', 'scroll' );
	$html_bg_position = get_theme_mod( 'html_bg_position', 'left-top' );

	$body_bg_color    = Shoestrap_Color::sanitize_hex( get_theme_mod( 'body_bg_color', '#ffffff' ) );
	$body_bg_image    = get_theme_mod( 'body_bg_image', '' );
	$body_bg_repeat   = get_theme_mod( 'body_bg_repeat', 'repeat' );
	$body_bg_size     = get_theme_mod( 'body_bg_size', 'inherit' );
	$body_bg_attach   = get_theme_mod( 'body_bg_attach', 'scroll' );
	$body_bg_position = get_theme_mod( 'body_bg_position', 'left-top' );

	// HTML Background
	$styles .= 'html { ';

	if ( '#ffffff' != $html_bg_color || '#FFFFFF' != $html_bg_color ) {
		$styles .= 'background-color: ' . $html_bg_color . ';';
	}

	if ( '' != $html_bg_image ) {
		$styles .= 'background-image: url("' . $html_bg_image . '");';
		$styles .= 'background-repeat: ' . $html_bg_repeat . ';';
		$styles .= 'background-size: ' . $html_bg_size . ';';
		$styles .= 'background-attachment: ' . $html_bg_attach . ';';
		$styles .= 'background-position: ' . str_replace( '-', ' ', $html_bg_position ) . ';';
	}

	$styles .= ' }';

	// Body Background
	$styles .= 'body.bootstrap { ';

	if ( '#ffffff' != $body_bg_color || '#FFFFFF' != $body_bg_color ) {
		$styles .= 'background-color: ' . $body_bg_color . ';';
	}

	if ( '' != $body_bg_image ) {
		$styles .= 'background-image: url("' . $body_bg_image . '");';
		$styles .= 'background-repeat: ' . $body_bg_repeat . ';';
		$styles .= 'background-size: ' . $body_bg_size . ';';
		$styles .= 'background-attachment: ' . $body_bg_attach . ';';
		$styles .= 'background-position: ' . str_replace( '-', ' ', $body_bg_position ) . ';';
	}

	$styles .= ' }';

	return $styles;

}
add_filter( 'shoestrap/customizer/styles', 'shoestrap_background_css' );

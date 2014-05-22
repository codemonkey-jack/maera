<?php

/**
 * CSS rules for typography options
 */
function shoestrap_typography_css( $style ) {

	// Base font settings
	$font_base_family    = get_theme_mod( 'font_base_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
	$font_base_google    = get_theme_mod( 'font_base_google' );
	$font_base_color     = get_theme_mod( 'font_base_color', '#333333' );
	$font_base_weight    = get_theme_mod( 'font_base_weight', '#333333' );
	$font_base_size      = get_theme_mod( 'font_base_size', 20 );
	$font_base_height    = get_theme_mod( 'font_base_height', 22 );

	$style .= 'body { font-family: ' . $font_base_family . '; color: ' . $font_base_color . '; font-weight: ' . $font_base_weight . '; font-size: ' . $font_base_size . 'px; line-height: ' . $font_base_height . 'px; }';

	// Headers font
	$headers_font_family = get_theme_mod( 'headers_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
	$style .= 'h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6 { font-family: ' . $headers_font_family . '; }';

	$headers = array(
		'h1' => array( 'size' => 260, 'height' => 120 ),
		'h2' => array( 'size' => 215, 'height' => 120 ),
		'h3' => array( 'size' => 170, 'height' => 120 ),
		'h4' => array( 'size' => 110, 'height' => 125 ),
		'h5' => array( 'size' => 100, 'height' => 100 ),
		'h6' => array( 'size' => 85, 'height' => 85 ),
	);

	foreach ( $headers as $header => $values ) {
		$header_color  = get_theme_mod( 'font_' . $header . '_color', '#333333' );
		$header_weight = get_theme_mod( 'font_' . $header . '_weight', 400 );
		$header_size   = get_theme_mod( 'font_' . $header . '_size', $values['size'] );
		$header_height = get_theme_mod( 'font_' . $header . '_height', $values['height'] );

		$style .= $header . ', .' . $header . ' { color: ' . $header_color . '; font-weight: ' . $header_weight . '; font-size: ' . $header_size . '%; line-height: ' . $header_height . 'px; }';
	}

	return $style;

}
add_filter( 'shoestrap/styles', 'shoestrap_typography_css' );

/**
* Enqueue Google fonts if enabled
*/
function shoestrap_google_font() {
	$font_base_google = get_theme_mod( 'font_base_google' );
	if ( $font_base_google == 1 ) {
		$font_base_family = str_replace( ' ', '+', get_theme_mod( 'font_base_family' ) );
		$font_base_google_subsets = get_theme_mod( 'font_base_google_subsets' );

		wp_register_style( 'shoestrap_base_google_font', 'http://fonts.googleapis.com/css?family='.$font_base_family.'&subset='.$font_base_google_subsets );
 		wp_enqueue_style( 'shoestrap_base_google_font' );
	}

	$font_headers_google = get_theme_mod( 'headers_font_google' );
	if ( $font_headers_google == 1 ) {
		$font_headers_family = str_replace( ' ', '+', get_theme_mod( 'headers_font_family' ) );
		$font_headers_google_subsets = get_theme_mod( 'font_headers_google_subsets' );

		wp_register_style( 'shoestrap_headers_google_font', 'http://fonts.googleapis.com/css?family='.$font_headers_family.'&subset='.$font_headers_google_subsets );
 		wp_enqueue_style( 'shoestrap_headers_google_font' );
	}
}
add_action( 'wp_print_styles', 'shoestrap_google_font' );

<?php

/**
 * Additional CSS rules for layout options
 */
function shoestrap_color_css( $style ) {
	global $wp_customize;

	// Customizer-only styles
	if ( ! $wp_customize ) {
		return;
	}

	$brand_primary = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_primary', '#428bca' ) ) );
	$brand_success = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_success', '#5cb85c' ) ) );
	$brand_warning = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_warning', '#f0ad4e' ) ) );
	$brand_danger  = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_danger', '#d9534f' ) ) );
	$brand_info    = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_info', '#5bc0de' ) ) );

	$style .= 'a { color: ' . $brand_primary . '; }';
	$style .= '.text-primary { color: ' . $brand_primary . '; }';
	$style .= '.bg-primary { background-color: ' . $brand_primary . '; }';
	$style .= '.btn-primary { background-color: ' . $brand_primary . '; }';
	$style .= '.btn-primary.disabled, .btn-primary[disabled], fieldset[disabled] .btn-primary, .btn-primary.disabled:hover, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary:hover, .btn-primary.disabled:focus, .btn-primary[disabled]:focus, fieldset[disabled] .btn-primary:focus, .btn-primary.disabled:active, .btn-primary[disabled]:active, fieldset[disabled] .btn-primary:active, .btn-primary.disabled.active, .btn-primary[disabled].active, fieldset[disabled] .btn-primary.active { background-color: ' . $brand_primary . '; }';
	$style .= '.btn-primary .badge { color: ' . $brand_primary . '; }';
	$style .= '.btn-link { color: ' . $brand_primary . '; }';
	$style .= '.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus { background-color: ' . $brand_primary . '; }';
	$style .= '.pagination > li > a, .pagination > li > span { color: ' . $brand_primary . '; }';
	$style .= '.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus { background-color: ' . $brand_primary . '; border-color: ' . $brand_primary . '; }';

	$style .= '.text-info { color: ' . $brand_info . '; }';
	$style .= '.bg-info { background-color: ' . $brand_info . '; }';
	$style .= '.btn-info { background-color: ' . $brand_info . '; }';
	$style .= '.btn-info.disabled, .btn-info[disabled], fieldset[disabled] .btn-info, .btn-info.disabled:hover, .btn-info[disabled]:hover, fieldset[disabled] .btn-info:hover, .btn-info.disabled:focus, .btn-info[disabled]:focus, fieldset[disabled] .btn-info:focus, .btn-info.disabled:active, .btn-info[disabled]:active, fieldset[disabled] .btn-info:active, .btn-info.disabled.active, .btn-info[disabled].active, fieldset[disabled] .btn-info.active { background-color: ' . $brand_info . '; }';
	$style .= '.btn-info .badge { color: ' . $brand_info . '; }';

	$style .= '.text-warning { color: ' . $brand_warning . '; }';
	$style .= '.bg-warning { background-color: ' . $brand_warning . '; }';
	$style .= '.btn-warning { background-color: ' . $brand_warning . '; }';
	$style .= '.btn-warning.disabled, .btn-warning[disabled], fieldset[disabled] .btn-warning, .btn-warning.disabled:hover, .btn-warning[disabled]:hover, fieldset[disabled] .btn-warning:hover, .btn-warning.disabled:focus, .btn-warning[disabled]:focus, fieldset[disabled] .btn-warning:focus, .btn-warning.disabled:active, .btn-warning[disabled]:active, fieldset[disabled] .btn-warning:active, .btn-warning.disabled.active, .btn-warning[disabled].active, fieldset[disabled] .btn-warning.active { background-color: ' . $brand_warning . '; }';
	$style .= '.btn-warning .badge { color: ' . $brand_warning . '; }';

	$style .= '.text-danger { color: ' . $brand_danger . '; }';
	$style .= '.bg-danger { background-color: ' . $brand_danger . '; }';
	$style .= '.btn-danger { background-color: ' . $brand_danger . '; }';
	$style .= '.btn-danger.disabled, .btn-danger[disabled], fieldset[disabled] .btn-danger, .btn-danger.disabled:hover, .btn-danger[disabled]:hover, fieldset[disabled] .btn-danger:hover, .btn-danger.disabled:focus, .btn-danger[disabled]:focus, fieldset[disabled] .btn-danger:focus, .btn-danger.disabled:active, .btn-danger[disabled]:active, fieldset[disabled] .btn-danger:active, .btn-danger.disabled.active, .btn-danger[disabled].active, fieldset[disabled] .btn-danger.active { background-color: ' . $brand_danger . '; }';
	$style .= '.btn-danger .badge { color: ' . $brand_danger . '; }';

	return $style;

}
add_filter( 'shoestrap/styles', 'shoestrap_color_css' );

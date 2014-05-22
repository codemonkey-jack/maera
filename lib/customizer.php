<?php


/**
 * The configuration options for the Shoestrap Customizer
 */
function shoestrap_customizer_config() {

	$args = array(

		'logo_image'   => get_template_directory_uri() . '/assets/images/customizer-logo.png',
		'color_active' => '#1abc9c',
		'color_light'  => '#8cddcd',
		'color_select' => '#34495e',
		'color_accent' => '#FF5740',
		'color_back'   => '#222',
		'url_path'     => get_template_directory_uri() . '/lib/kirki/'

	);

	return $args;

}
add_filter( 'kirki/config', 'shoestrap_customizer_config' );

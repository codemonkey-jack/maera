<?php


/**
 * The configuration options for the Maera Customizer
 */
function maera_customizer_config() {

	$args = array(

		// 'logo_image'    => get_template_directory_uri() . '/assets/images/customizer-logo.png',
		// 'color_active'  => '#2ECC71',
		// 'color_light'   => '#F1C40F',
		// 'color_select'  => '#3498DB',
		// 'color_accent'  => '#E74C3C',
		// 'color_back'    => '#444',
		'url_path'      => get_template_directory_uri() . '/lib/kirki/',
		'stylesheet_id' => 'maera',

	);

	return $args;

}
add_filter( 'kirki/config', 'maera_customizer_config' );

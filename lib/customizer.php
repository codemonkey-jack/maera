<?php


/**
 * The configuration options for the Shoestrap Customizer
 */
function shoestrap_customizer_config() {

	$args = array(

		// 'logo_image'    => get_template_directory_uri() . '/assets/images/customizer-logo.png',
		'color_active'  => '#1abc9c',
		'color_light'   => '#8cddcd',
		'color_select'  => '#34495e',
		'color_accent'  => '#FF5740',
		'color_back'    => '#222',
		'url_path'      => get_template_directory_uri() . '/lib/kirki/',
		'stylesheet_id' => 'shoestrap',
		'live_css'      => false,

	);

	return $args;

}
add_filter( 'kirki/config', 'shoestrap_customizer_config' );

function shoestrap_customizer_additional_css() { ?>

	<style>
		li#customize-control-widgets_mode,
		li#customize-control-menu_mode,
		li#customize-control-dev_mode,
		li#customize-control-gradients_toggle,
		li#customize-control-navbar_toggle,
		li#customize-control-navbar_logo
		{
			margin-left: -20px;
			margin-right: -20px;
			background: #fafad2;
			padding-left: 20px;
			padding-right: 20px;
		}
	</style>

	<?php
}
add_action( 'customize_controls_print_styles', 'shoestrap_customizer_additional_css', 999 );

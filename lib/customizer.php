<?php


/**
 * The configuration options for the Maera Customizer
 */
function maera_customizer_config() {

	$args = array(

		// 'logo_image'    => get_template_directory_uri() . '/assets/images/customizer-logo.png',
		'color_active'  => '#2ECC71',
		'color_light'   => '#F1C40F',
		'color_select'  => '#3498DB',
		'color_accent'  => '#E74C3C',
		'color_back'    => '#FFFFFF',
		'url_path'      => get_template_directory_uri() . '/lib/kirki/',
		'stylesheet_id' => 'maera',
		// 'live_css'      => false,

	);

	return $args;

}
add_filter( 'kirki/config', 'maera_customizer_config' );

function maera_customizer_additional_css() { ?>

	<style>
		li#customize-control-widgets_mode,
		li#customize-control-menu_mode,
		li#customize-control-gradients_toggle,
		li#customize-control-navbar_position,
		li#customize-control-navbar_logo,
		li#customize-control-border_radius,
		li#customize-control-padding_base,
		li#customize-control-less,
		li#customize-control-minimize_css,
		li#customize-control-navbar_bg,
		li#customize-control-navbar_bg_opacity
		{
			margin-left: -20px;
			margin-right: -20px;
			background: #D1D5D8;
			padding: 10px 20px;
		}
	</style>

	<?php
}
add_action( 'customize_controls_print_styles', 'maera_customizer_additional_css', 999 );

<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_colors_customizer( $wp_customize ){

	$controls = array();

	// Create the "Colors" section
	$wp_customize->add_section( 'colors', array(
		'title' => __( 'Colors', 'shoestrap' ),
		'priority' => 3
	) );

}
add_action( 'customize_register', 'shoestrap_colors_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_colors_customizer_settings( $controls ){

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'gradients_toggle',
		'label'    => __( 'Enable Gradients', 'shoestrap' ),
		'description' => __( 'Enable or disable gradients. These are applied to navbars, buttons and other elements.', 'shoestrap' ),
		'section'  => 'colors',
		'priority' => 1,
		'default'  => 0,
		'choices'  => array(
			0 => __( 'Flat', 'shoestrap' ),
			1 => __( 'Gradients', 'shoestrap' ),
		),
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_primary',
		'label'    => __( 'Brand Colors: Primary', 'shoestrap' ),
		'description' => __( 'Select your primary branding color. Also referred to as an accent color. This will affect various areas of your site, including the color of your primary buttons, link color, the background of some elements and many more.', 'shoestrap' ),
		'section'  => 'colors',
		'default'  => '#428bca',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_success',
		'label'    => __( 'Brand Colors: Success', 'shoestrap' ),
		'description' =>  __( 'Select your branding color for success messages etc.', 'shoestrap' ),
		'section'  => 'colors',
		'default'  => '#5cb85c',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_warning',
		'label'    => __( 'Brand Colors: Warning', 'shoestrap' ),
		'description' =>  __( 'Select your branding color for warning messages etc.', 'shoestrap' ),
		'section'  => 'colors',
		'default'  => '#f0ad4e',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_danger',
		'label'    => __( 'Brand Colors: Danger', 'shoestrap' ),
		'description' =>  __( 'Select your branding color for danger messages etc.', 'shoestrap' ),
		'section'  => 'colors',
		'default'  => '#d9534f',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_info',
		'label'    => __( 'Brand Colors: Info', 'shoestrap' ),
		'description' =>  __( 'Select your branding color for info messages etc. It will also be used for the Search button color as well as other areas where it semantically makes sense to use an \'info\' class.', 'shoestrap' ),
		'section'  => 'colors',
		'default'  => '#5bc0de',
	);

	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_colors_customizer_settings' );

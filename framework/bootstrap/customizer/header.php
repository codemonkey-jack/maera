<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_header_customizer( $wp_customize ){

	$controls = array();

	// Create the "Header" section
	$wp_customize->add_section( 'header', array(
		'title' => __( 'Header', 'shoestrap' ),
		'priority' => 8
	) );

}
add_action( 'customize_register', 'shoestrap_header_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_header_customizer_settings( $controls ){

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'header_toggle',
		'label'    => __( 'Display the Header.', 'shoestrap' ),
		'description' => __( 'Check this to display the header. Default: OFF', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 0,
		'priority' => 1,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'header_branding',
		'label'    => __( 'Display branding on your Header.', 'shoestrap' ),
		'description' => __( 'Check to display branding ( Sitename or Logo )on your Header. Default: ON', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 1,
		'priority' => 2,
	);

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'header_bg',
		'label'        => __( 'Header Background', 'shoestrap' ),
		'section'      => 'background',
		'default'      => array(
			'color'    => '#ffffff',
			'image'    => null,
			'repeat'   => 'repeat',
			'size'     => 'inherit',
			'attach'   => 'inherit',
			'position' => 'left-top',
			'opacity'  => 100,
		),
		'priority' => 10,
		'output' => 'header.page-header',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'header_color',
		'label'    => __( 'Header Text Color', 'shoestrap' ),
		'description' => __( 'Select the text color for your header. Default: #333333.', 'shoestrap' ),
		'section'  => 'header',
		'default'  => '#333333',
		'priority' => 20,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'header_margin_top',
		'label'    => __( 'Margin-top', 'shoestrap' ),
		'subtitle' => __( 'Select the top margin of the header in pixels. Default: 0px.', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 0,
		'priority' => 21,
		'choices'  => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'header_margin_bottom',
		'label'    => __( 'Margin-bottom', 'shoestrap' ),
		'subtitle' => __( 'Select the bottom margin of the header in pixels. Default: 0px.', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 0,
		'priority' => 22,
		'choices'  => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
	);

	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_header_customizer_settings' );

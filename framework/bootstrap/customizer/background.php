<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_background_customizer( $wp_customize ){

	$controls = array();

	// Create the "Background" section
	$wp_customize->add_section( 'background', array(
		'title' => __( 'Background', 'shoestrap' ),
		'priority' => 4
	) );

}
add_action( 'customize_register', 'shoestrap_background_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_background_customizer_settings( $controls ){

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'html_bg',
		'label'        => __( 'General Background', 'shoestrap' ),
		'section'      => 'background',
		'default'      => array(
			'color'    => '#ffffff',
			'image'    => null,
			'repeat'   => 'repeat',
			'size'     => 'inherit',
			'attach'   => 'inherit',
			'position' => 'left-top',
			'opacity'  => false,
		),
		'priority' => 1,
		'output' => 'html',
	);

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'body_bg',
		'label'        => __( 'Body Background', 'shoestrap' ),
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
		'output' => 'body.bootstrap',
	);

	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_background_customizer_settings' );


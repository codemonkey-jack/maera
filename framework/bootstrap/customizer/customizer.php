<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_layout_customizer( $wp_customize ){

	$controls = array();

	// Create the "Layout" section
	$wp_customize->add_section( 'layout', array(
		'title' => __( 'Layout', 'shoestrap' ),
		'priority' => 2
	) );

}
add_action( 'customize_register', 'shoestrap_layout_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_layout_customizer_settings(){

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'site_style',
		'label'    => __( 'Site Style', 'shoestrap' ),
		'description' => '',
		'section'  => 'layout',
		'priority' => 1,
		'default'  => 'wide',
		'choices'  => array(
			'static'  => __( 'Static (Non-Responsive)', 'shoestrap' ),
			'wide'    => __( 'Wide', 'shoestrap' ),
			'boxed'   => __( 'Boxed', 'shoestrap' ),
			'fluid'   => __( 'Fluid', 'shoestrap' ),
		),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'image',
		'setting'  => 'layout',
		'label'    => __( 'Layout', 'shoestrap' ),
		'description' => '',
		'section'  => 'layout',
		'priority' => 2,
		'default'  => 1,
		'choices'  => array(
			0 => get_template_directory_uri() . '/lib/customizer/assets/images/1c.png',
			1 => get_template_directory_uri() . '/lib/customizer/assets/images/2cr.png',
			2 => get_template_directory_uri() . '/lib/customizer/assets/images/2cl.png',
			3 => get_template_directory_uri() . '/lib/customizer/assets/images/3cl.png',
			4 => get_template_directory_uri() . '/lib/customizer/assets/images/3cr.png',
			5 => get_template_directory_uri() . '/lib/customizer/assets/images/3cm.png',
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'layout_primary_width',
		'label'    => __( 'Primary Sidebar Width', 'shoestrap' ),
		'description' => '',
		'section'  => 'layout',
		'priority' => 10,
		'default'  => 4,
		'choices'  => array(
			'min'  => '1',
			'max'  => '5',
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'layout_secondary_width',
		'label'    => __( 'Secondary Sidebar Width', 'shoestrap' ),
		'description' => '',
		'section'  => 'layout',
		'priority' => 10,
		'default'  => 4,
		'choices'  => array(
			'min'  => '1',
			'max'  => '5',
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'layout_sidebar_on_front',
		'label'    => __( 'Show sidebars on the frontpage', 'shoestrap' ),
		'description' => 'This is a dummy description',
		'section'  => 'layout',
		'priority' => 7,
		'default'  => 1
	);

	return $controls;
}
add_filter( 'shoestrap/customizer/controls', 'shoestrap_layout_customizer_settings' );

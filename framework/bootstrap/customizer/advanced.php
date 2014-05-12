<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_advanced_customizer( $wp_customize ){

	$controls = array();

	// Create the "Advanced" section
	$wp_customize->add_section( 'advanced', array(
		'title' => __( 'Advanced', 'shoestrap' ),
		'priority' => 200
	) );

}
add_action( 'customize_register', 'shoestrap_advanced_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_advanced_customizer_settings( $controls ) {

	$advanceds = array(
		0 => get_template_directory_uri() . '/assets/images/1c.png',
		1 => get_template_directory_uri() . '/assets/images/2cr.png',
		2 => get_template_directory_uri() . '/assets/images/2cl.png',
		3 => get_template_directory_uri() . '/assets/images/3cl.png',
		4 => get_template_directory_uri() . '/assets/images/3cr.png',
		5 => get_template_directory_uri() . '/assets/images/3cm.png',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'retina_toggle',
		'label'    => __( 'Enable Retina mode', 'shoestrap' ),
		'description' => __( 'When checked, your site\'s featured images will be retina ready. Requires images to be uploaded at 2x the typical size desired. (uses retina.js) Default: On', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 1,
		'default'  => 1,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'border_radius',
		'label'    => __( 'Border-Radius', 'shoestrap' ),
		'description' => __( 'You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 2,
		'default'  => 4,
		'choices'  => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'padding_base',
		'label'    => __( 'Padding Base', 'shoestrap' ),
		'description' => __( 'You can adjust the padding base. This affects buttons size and lots of other cool stuff too! Default: 8', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 3,
		'default'  => 8,
		'choices'  => array(
			'min'  => 0,
			'max'  => 22,
			'step' => 1
		),
	);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'css',
		'label'    => __( 'Custom CSS', 'shoestrap' ),
		'subtitle' => __( 'You can write your custom CSS here. This code will appear in a script tag appended in the header section of the page.', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 4,
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'less',
		'label'    => __( 'Custom LESS', 'shoestrap' ),
		'subtitle' => __( 'You can write your custom LESS here. This code will be compiled with the other LESS files of the theme and be appended to the header.', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 5,
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'js',
		'label'    => __( 'Custom JS', 'shoestrap' ),
		'subtitle' => __( 'You can write your custom JavaScript/jQuery here. The code will be included in a script tag appended to the bottom of the page.', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 6,
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'minimize_css',
		'label'    => __( 'Minimize CSS', 'shoestrap' ),
		'description' => __( 'Minimize the generated CSS. This should be always be checked for production sites.', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 10,
		'default'  => 1,
	);


	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_advanced_customizer_settings' );

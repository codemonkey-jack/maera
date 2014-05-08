<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_header_customizer( $wp_customize ){

	$controls = array();

	// Create the "Layout" section
	$wp_customize->add_section( 'header', array(
		'title' => __( 'Header', 'shoestrap' ),
		'priority' => 12
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
		'type'     => 'color',
		'setting'  => 'header_bg_color',
		'label'    => __( 'Background', 'shoestrap' ),
		'description' =>   __( 'Background Color', 'shoestrap' ),
		'section'  => 'header',
		'default'  => '#ffffff',
		'priority' => 3,
	);

	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'header_bg_image',
		'label'    => null,
		'description' =>   __( 'Background Image', 'shoestrap' ),
		'section'  => 'header',
		'default'  => '',
		'priority' => 4,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'header_bg_repeat',
		'label'    => null,
		'subtitle' => __( 'Background Repeat', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 'repeat',
		'choices'  => array(
			'no-repeat' => __( 'No Repeat', 'shoestrap' ),
			'repeat'    => __( 'Repeat All', 'shoestrap' ),
			'repeat-x'  => __( 'Repeat Horizontally', 'shoestrap' ),
			'repeat-y'  => __( 'Repeat Vertically', 'shoestrap' ),
			'inherit'   => __( 'Inherit', 'shoestrap' ),
		),
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'header_bg_size',
		'label'    => null,
		'subtitle' =>  __( 'Background Size', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 'inherit',
		'choices'  => array(
			'inherit' => __( 'Inherit', 'shoestrap' ),
			'cover'   => __( 'Cover', 'shoestrap' ),
			'contain' => __( 'Contain', 'shoestrap' ),
		),
		'priority' => 6,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'header_bg_attach',
		'label'    => null,
		'subtitle' => __( 'Background Attachment', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 'scroll',
		'choices'  => array(
			'inherit' => __( 'Inherit', 'shoestrap' ),
			'fixed'   => __( 'Fixed', 'shoestrap' ),
			'scroll' => __( 'Scroll', 'shoestrap' ),
		),
		'priority' => 7,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'header_bg_position',
		'label'    => null,
		'subtitle' =>   __( 'Background Position', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 'center-center',
		'choices'  => array(
			'left-top'      => __( 'Left Top', 'shoestrap' ),
			'left-center'   => __( 'Left Center', 'shoestrap' ),
			'left-bottom'   => __( 'Left Bottom', 'shoestrap' ),
			'right-top'     => __( 'Right Top', 'shoestrap' ),
			'right-center'  => __( 'Right Center', 'shoestrap' ),
			'right-bottom'  => __( 'Right Bottom', 'shoestrap' ),
			'center-top'    => __( 'Center Top', 'shoestrap' ),
			'center-center' => __( 'Center Center', 'shoestrap' ),
			'center-bottom' => __( 'Center Bottom', 'shoestrap' ),
		),
		'priority' => 8,
		'separator' => true,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'header_bg_opacity',
		'label'    => __( 'Header Background Opacity', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 100,
		'priority' => 9,
		'choices'  => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'header_color',
		'label'    => __( 'Header Text Color', 'shoestrap' ),
		'description' => __( 'Select the text color for your header. Default: #333333.', 'shoestrap' ),
		'section'  => 'header',
		'default'  => '#333333',
		'priority' => 10,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'header_margin_top',
		'label'    => __( 'Margin-top', 'shoestrap' ),
		'subtitle' => __( 'Select the top margin of the header in pixels. Default: 0px.', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 0,
		'priority' => 11,
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
		'priority' => 12,
		'choices'  => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
	);

	return $controls;
}
add_filter( 'shoestrap/customizer/controls', 'shoestrap_header_customizer_settings' );

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
		'type'     => 'color',
		'setting'  => 'html_bg_color',
		'label'    => __( 'General Background', 'shoestrap' ),
		'description' =>   __( 'Background Color', 'shoestrap' ),
		'section'  => 'background',
		'default'  => '#ffffff',
		'priority' => 1,
	);

	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'html_bg_image',
		'label'    => null,
		'description' =>   __( 'Background Image', 'shoestrap' ),
		'section'  => 'background',
		'default'  => '',
		'priority' => 2,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'html_bg_repeat',
		'label'    => null,
		'subtitle' => __( 'Background Repeat', 'shoestrap' ),
		'section'  => 'background',
		'default'  => 'repeat',
		'choices'  => array(
			'no-repeat' => __( 'No Repeat', 'shoestrap' ),
			'repeat'    => __( 'Repeat All', 'shoestrap' ),
			'repeat-x'  => __( 'Repeat Horizontally', 'shoestrap' ),
			'repeat-y'  => __( 'Repeat Vertically', 'shoestrap' ),
			'inherit'   => __( 'Inherit', 'shoestrap' ),
		),
		'priority' => 3,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'html_bg_size',
		'label'    => null,
		'subtitle' =>  __( 'Background Size', 'shoestrap' ),
		'section'  => 'background',
		'default'  => 'inherit',
		'choices'  => array(
			'inherit' => __( 'Inherit', 'shoestrap' ),
			'cover'   => __( 'Cover', 'shoestrap' ),
			'contain' => __( 'Contain', 'shoestrap' ),
		),
		'priority' => 4,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'html_bg_attach',
		'label'    => null,
		'subtitle' => __( 'Background Attachment', 'shoestrap' ),
		'section'  => 'background',
		'default'  => 'scroll',
		'choices'  => array(
			'inherit' => __( 'Inherit', 'shoestrap' ),
			'fixed'   => __( 'Fixed', 'shoestrap' ),
			'scroll' => __( 'Scroll', 'shoestrap' ),
		),
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'html_bg_position',
		'label'    => null,
		'subtitle' =>   __( 'Background Position', 'shoestrap' ),
		'section'  => 'background',
		'default'  => 'left-top',
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
		'priority' => 6,
		'separator' => true,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'body_bg_color',
		'label'    => __( 'Body Background', 'shoestrap' ),
		'description' =>   __( 'Background Color', 'shoestrap' ),
		'section'  => 'background',
		'default'  => '#ffffff',
		'priority' => 7,
	);

	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'body_bg_image',
		'label'    => null,
		'description' =>   __( 'Background Image', 'shoestrap' ),
		'section'  => 'background',
		'default'  => '',
		'priority' => 8,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'body_bg_repeat',
		'label'    => null,
		'subtitle' => __( 'Background Repeat', 'shoestrap' ),
		'section'  => 'background',
		'default'  => 'repeat',
		'choices'  => array(
			'no-repeat' => __( 'No Repeat', 'shoestrap' ),
			'repeat'    => __( 'Repeat All', 'shoestrap' ),
			'repeat-x'  => __( 'Repeat Horizontally', 'shoestrap' ),
			'repeat-y'  => __( 'Repeat Vertically', 'shoestrap' ),
			'inherit'   => __( 'Inherit', 'shoestrap' ),
		),
		'priority' => 9,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'body_bg_size',
		'label'    => null,
		'subtitle' =>  __( 'Background Size', 'shoestrap' ),
		'section'  => 'background',
		'default'  => 'inherit',
		'choices'  => array(
			'inherit' => __( 'Inherit', 'shoestrap' ),
			'cover'   => __( 'Cover', 'shoestrap' ),
			'contain' => __( 'Contain', 'shoestrap' ),
		),
		'priority' => 10,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'body_bg_attach',
		'label'    => null,
		'subtitle' => __( 'Background Attachment', 'shoestrap' ),
		'section'  => 'background',
		'default'  => 'scroll',
		'choices'  => array(
			'inherit' => __( 'Inherit', 'shoestrap' ),
			'fixed'   => __( 'Fixed', 'shoestrap' ),
			'scroll' => __( 'Scroll', 'shoestrap' ),
		),
		'priority' => 11,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'body_bg_position',
		'label'    => null,
		'subtitle' =>   __( 'Background Position', 'shoestrap' ),
		'section'  => 'background',
		'default'  => 'left-top',
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
		'priority' => 12,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'body_bg_opacity',
		'label'    => __( 'Body Background Opacity', 'shoestrap' ),
		'description' => __( 'Default: 100', 'shoestrap' ),
		'section'  => 'background',
		'priority' => 13,
		'default'  => 100,
		'choices'  => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	);

	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_background_customizer_settings' );


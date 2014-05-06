<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_general_customizer( $wp_customize ){

	$controls = array();

	// Create the "Layout" section
	$wp_customize->add_section( 'general', array(
		'title' => __( 'General', 'shoestrap' ),
		'priority' => 1
	) );

}
add_action( 'customize_register', 'shoestrap_general_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_general_customizer_settings( $controls ){

	$controls[] = array(
		'type'        => 'image',
		'setting'     => 'logo',
		'label'       => __( 'Logo', 'shoestrap' ),
		'subtitle' => __( 'Upload your site\'s logo', 'shoestrap' ),
		'section'     => 'general',
		'priority'    => 1,
		'default'     => null
	);

	$controls[] = array(
		'type'        => 'image',
		'setting'     => 'favicon',
		'label'       => __( 'Custom Favicon', 'shoestrap' ),
		'subtitle' => __( 'Upload your site\'s favicon', 'shoestrap' ),
		'section'     => 'general',
		'priority'    => 2,
		'default'     => null
	);

	$controls[] = array(
		'type'        => 'image',
		'setting'     => 'apple_icon',
		'label'       => __( 'Apple Icon', 'shoestrap' ),
		'subtitle' =>  __( 'This will create icons for Apple iPhone ( 57px x 57px ), Apple iPhone Retina Version ( 114px x 114px ), Apple iPad ( 72px x 72px ) and Apple iPad Retina ( 144px x 144px ). Please note that for better results the image you upload should be at least 144px x 144px.', 'shoestrap' ),
		'section'     => 'general',
		'priority'    => 3,
		'default'     => null
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'widgets_mode',
		'label'    => __( 'Widgets mode', 'shoestrap' ),
		'subtitle' => __( 'How do you want your widgets to be displayed?', 'shoestrap' ),
		'section'  => 'general',
		'priority' => 4,
		'default'  => 0,
		'choices'  => array(
			0 => __( 'Panel', 'shoestrap' ),
			1 => __( 'Well', 'shoestrap' ),
			2=> __( 'None', 'shoestrap' ),
		),
	);

	return $controls;
}
add_filter( 'shoestrap/customizer/controls', 'shoestrap_general_customizer_settings' );

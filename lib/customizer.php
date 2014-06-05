<?php


/**
 * The configuration options for the Shoestrap Customizer
 */
function shoestrap_customizer_config() {

	$args = array(

		'logo_image'    => get_template_directory_uri() . '/assets/images/customizer-logo.png',
		'color_active'  => '#1abc9c',
		'color_light'   => '#8cddcd',
		'color_select'  => '#34495e',
		'color_accent'  => '#FF5740',
		'color_back'    => '#222',
		'url_path'      => get_template_directory_uri() . '/lib/kirki/',
		'stylesheet_id' => 'shoestrap',

	);

	return $args;

}
add_filter( 'kirki/config', 'shoestrap_customizer_config' );


/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_general_customizer( $wp_customize ){

	$controls = array();

	// Create the "General" section
	$wp_customize->add_section( 'general', array(
		'title' => __( 'General', 'shoestrap' ),
		'priority' => 1
	) );

}
add_action( 'customize_register', 'shoestrap_general_customizer' );


/*
 * Creates the basic controls on the customizer
 */
function shoestrap_core_customizer_settings( $controls ) {

	$frameworks = apply_filters( 'shoestrap/frameworks/list', array(
		'core'      => __( 'Core', 'shoestrap' ),
		'bootstrap' => __( 'Bootstrap', 'shoestrap' ),
	) );

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'framework',
		'label'    => __( 'Framework', 'shoestrap' ),
		'subtitle' => __( 'Select the framework you want to use. <strong>CAUTION</strong>: Once you save your settings you will have to refresh your page in order to see the new controls. All previous settings will be lost.', 'shoestrap' ),
		'section'  => 'general',
		'priority' => 1,
		'default'  => 'bootstrap',
		'choices'  => $frameworks,
	);

	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_core_customizer_settings' );

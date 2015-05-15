<?php

class Maera_Core_Customizer {

	function __construct() {

		if ( defined( 'MAERA_SHOW_CORE_CUSTOMIZER' ) && MAERA_SHOW_CORE_CUSTOMIZER ) {
			add_action( 'customize_register', array( $this, 'add_section' ) );
			add_action( 'customize_register', array( $this, 'add_settings' ) );
			add_action( 'customize_register', array( $this, 'add_controls' ) );
		}

	}

	/**
	 * Add the customizer section
	 */
	function add_section( $wp_customize ) {

		$wp_customize->add_section( 'maera_options', array(
			'title'    => __( 'Maera Options', 'themename' ),
			'priority' => 1,
		) );

	}

	/**
	 * Add the setting
	 */
	function add_settings( $wp_customize ) {

		$wp_customize->add_setting( 'maera_admin_options[shell]', array(
			'default'        => 'core',
			'type'           => 'option',
			'capability'     => 'edit_theme_options',
		) );

	}

	/**
	 * Add the controls
	 */
	function add_controls( $wp_customize ) {

		// Get the available shells and format the array properly
		$available_shells = apply_filters( 'maera/shells/available', array() );
		$shells = array();
		foreach ( $available_shells as $available_shell ) {
			$shells[$available_shell['value']] = $available_shell['label'];
		}

		$wp_customize->add_control( 'maera_shell', array(
			'label'      => __( 'Shell', 'themename' ),
			'section'    => 'maera_options',
			'settings'   => 'maera_admin_options[shell]',
			'type'       => 'radio',
			'choices'    => $shells,
		) );

	}
}

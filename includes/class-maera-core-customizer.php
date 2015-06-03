<?php

class Maera_Core_Customizer {

	function __construct() {

		// if ( defined( 'MAERA_SHOW_CORE_CUSTOMIZER' ) && MAERA_SHOW_CORE_CUSTOMIZER ) {
			add_action( 'customize_register', array( $this, 'add_section' ) );
			add_action( 'customize_register', array( $this, 'add_settings' ) );
			add_action( 'customize_register', array( $this, 'add_controls' ) );
		// }

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

		$wp_customize->add_setting( 'maera_admin_options[dev_mode]', array(
			'default'        => 'core',
			'type'           => 'option',
			'capability'     => 'edit_theme_options',
		) );

		$wp_customize->add_setting( 'maera_admin_options[cache]', array(
			'default'        => 'core',
			'type'           => 'option',
			'capability'     => 'edit_theme_options',
		) );

		$wp_customize->add_setting( 'maera_admin_options[cache_mode]', array(
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
			'label'       => __( 'Shell', 'themename' ),
			'section'     => 'maera_options',
			'settings'    => 'maera_admin_options[shell]',
			'description' => __( 'You can change the active shell here. Please note that the changes will not take effect immediately. You will have to save and your selection and then refresh this page. All current options will be lost, so we advise you to first export them from the "Theme Options" page on your dashboard.', 'maera' ),
			'type'        => 'radio',
			'choices'     => $shells,
		) );

		$wp_customize->add_control( 'maera_dev_mode', array(
			'label'       => __( 'Enable Development Mode', 'themename' ),
			'section'     => 'maera_options',
			'settings'    => 'maera_admin_options[dev_mode]',
			'type'        => 'checkbox',
		) );

		$wp_customize->add_control( 'maera_cache_mode', array(
			'label'       => __( 'Cache mode.', 'maera' ),
			'section'     => 'maera_options',
			'settings'    => 'maera_admin_options[cache_mode]',
			'type'        => 'select',
			'default'     => 'none',
			'choices'     => array(
				'none'      => __( 'No Caching', 'maera' ),
				'object'    => __( 'WP Object Caching', 'maera' ),
				'transient' => __( 'Transients', 'maera' ),
				'default'   => __( 'Default', 'maera' ),
			),
		) );

	}
}

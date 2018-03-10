<?php

/**
 *
 */
class Maera_EDD_Customizer {

	function __construct() {

		add_action( 'customize_register', array( $this, 'create_section' ) );
		add_filter( 'kirki/controls', array( $this, 'create_settings' ) );

		add_action( 'customize_save_after',array( $this, 'sync_edd_colors_options' ) );
		add_action( 'wp',array( $this, 'sync_edd_colors_theme_mod' ) );

	}

	/*
	 * Create the section
	 */
	function create_section( $wp_customize ) {

		$wp_customize->add_section( 'maera_edd', array(
			'title'    => esc_html__( 'Easy Digital Downloads', 'maera' ),
			'priority' => 999,
		) );

		}

	/**
	 * Create the customizer controls.
	 * Depends on the Kirki Customizer plugin.
	 */
	function create_settings( $controls ) {

		global $edd_options;

		$controls[] = array(
			'type'     => 'select',
			'setting'  => 'checkout_color',
			'label'    => esc_html__( 'Button color', 'maera' ),
			'subtitle' => esc_html__( 'Select the button color for the purchase/buynow button.', 'maera' ) . ' ' . esc_html__( 'Please note that this change will be applied after you save the options and refresh (no live-preview available).', 'maera' ),
			'section'  => 'maera_edd',
			'priority' => 12,
			'default'  => $edd_options['checkout_color'],
			'choices'  => array(
				'white'     => esc_html__( 'White', 'edd' ),
				'gray'      => esc_html__( 'Gray', 'edd' ),
				'blue'      => esc_html__( 'Blue', 'edd' ),
				'red'       => esc_html__( 'Red', 'edd' ),
				'green'     => esc_html__( 'Green', 'edd' ),
				'yellow'    => esc_html__( 'Yellow', 'edd' ),
				'orange'    => esc_html__( 'Orange', 'edd' ),
				'dark-gray' => esc_html__( 'Dark Gray', 'edd' ),
			),

		);

		$controls[] = array(
			'type'     => 'select',
			'setting'  => 'hover_type',
			'label'    => esc_html__( 'Hover Type', 'maera' ),
			'subtitle' => esc_html__( 'Select the hover type for the grid display.', 'maera' ),
			'section'  => 'maera_edd',
			'priority' => 13,
			'default'  => 'edd',
			'choices'  => array(
				'edd'  => esc_html__( 'EDD style', 'maera' ),
				'zoe'  => esc_html__( 'Zoe', 'maera' ),
			),

		);

		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'edd_variables_dropdown',
			'label'    => esc_html__( 'Replace variables radio select with a dropdown', 'maera' ),
			'section'  => 'maera_edd',
			'default'  => 0,
			'priority' => 20,
		);

		$controls[] = array(
			'type'     => 'radio',
			'mode'     => 'buttonset',
			'setting'  => 'filter_mode',
			'label'    => esc_html__( 'Downloads filter mode', 'maera' ),
			'subtitle' => esc_html__( 'Please note that this change will be applied after you save the options and refresh (no live-preview available).', 'maera' ),
			'section'  => 'maera_edd',
			'default'  => 'php',
			'priority' => 1,
			'choices'  => array(
				'isotope' => esc_html__( 'Isotope', 'maera' ),
				'php'     => esc_html__( 'PHP', 'maera' ),
			),
		);

		return $controls;

	}

	function sync_edd_colors_options() {
		global $edd_options;

		$checkout_color = get_theme_mod( 'checkout_color' );

		if ( $checkout_color != $edd_options['checkout_color'] ) {
			$edd_options['checkout_color'] = $checkout_color;
			update_option( 'edd_settings', $edd_options );
		}
	}

	function sync_edd_colors_theme_mod() {
		global $edd_options;

		$checkout_color = get_theme_mod( 'checkout_color' );

		if ( $checkout_color != $edd_options['checkout_color'] ) {
			set_theme_mod( 'checkout_color', $edd_options['checkout_color'] );
		}
	}

}

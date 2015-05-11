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
			'title'    => __( 'Easy Digital Downloads', 'maera_edd' ),
			'priority' => 999,
		) );

		}

	/**
	 * Create the customizer controls.
	 * Depends on the Kirki Customizer plugin.
	 */
	function create_settings( $controls ) {

		$controls[] = array(
			'type'     => 'select',
			'setting'  => 'checkout_color',
			'label'    => __( 'Button color', 'maera_edd' ),
			'subtitle' => __( 'Select the button color for the purchase/buynow button.', 'maera_edd' ) . ' ' . __( 'Please note that this change will be applied after you save the options and refresh (no live-preview available).', 'maera_edd' ),
			'section'  => 'maera_edd',
			'priority' => 12,
			'default'  => 'primary',
			'choices'  => array(
				'white'     => __( 'White', 'edd' ),
				'gray'      => __( 'Gray', 'edd' ),
				'blue'      => __( 'Blue', 'edd' ),
				'red'       => __( 'Red', 'edd' ),
				'green'     => __( 'Green', 'edd' ),
				'yellow'    => __( 'Yellow', 'edd' ),
				'orange'    => __( 'Orange', 'edd' ),
				'dark-gray' => __( 'Dark Gray', 'edd' ),
			),

		);

		$controls[] = array(
			'type'     => 'select',
			'setting'  => 'hover_type',
			'label'    => __( 'Hover Type', 'maera_edd' ),
			'subtitle' => __( 'Select the hover type for the grid display.', 'maera_edd' ),
			'section'  => 'maera_edd',
			'priority' => 13,
			'default'  => 'edd',
			'choices'  => array(
				'edd'  => __( 'EDD style', 'maera_edd' ),
				'zoe'  => __( 'Zoe', 'maera_edd' ),
			),

		);

		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'edd_variables_dropdown',
			'label'    => __( 'Replace variables radio select with a dropdown', 'maera_edd' ),
			'section'  => 'maera_edd',
			'default'  => 0,
			'priority' => 20,
		);

		$controls[] = array(
			'type'     => 'radio',
			'mode'     => 'buttonset',
			'setting'  => 'filter_mode',
			'label'    => __( 'Downloads filter mode', 'textdomain' ),
			'subtitle' => __( 'Please note that this change will be applied after you save the options and refresh (no live-preview available).', 'maera_edd' ),
			'section'  => 'maera_edd',
			'default'  => 'isotope',
			'priority' => 1,
			'choices'  => array(
				'isotope' => __( 'Isotope', 'maera_edd' ),
				'php'     => __( 'PHP', 'maera_edd' ),
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

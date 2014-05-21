<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_typography_customizer( $wp_customize ){

	$controls = array();

	// Create the "Typography" section
	$wp_customize->add_section( 'typography', array(
		'title' => __( 'Typography', 'shoestrap' ),
		'priority' => 5
	) );

}
add_action( 'customize_register', 'shoestrap_typography_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_typography_customizer_settings( $controls ){

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'font_base_family',
		'label'    => __( 'Base font', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'priority' => 20,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'font_base_google',
		'label'    => __( 'Google-Font', 'shoestrap' ),
		'description' => __( 'If you have entered the name of a google font above, then you must enable check this option to process it.', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 0,
		'priority' => 21,
	);

	$controls[] = array(
		'type'     => 'multicheck',
		'setting'  => 'font_base_google_subsets',
		'label'    => __( 'Google-Font subsets', 'shoestrap' ),
		'description' => __( 'The subsets used from Google\'s API.', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 'latin',
		'priority' => 22,
		'choices'  => array(
			'latin' 		=> __( 'Latin', 'shoestrap' ),
			'latin-ext' 	=> __( 'Latin Ext.', 'shoestrap' ),
			'greek' 		=> __( 'Greek', 'shoestrap' ),
			'greek-ext' 	=> __( 'Greek Ext.', 'shoestrap' ),
			'cyrillic' 		=> __( 'Cyrillic', 'shoestrap' ),
			'cyrillic-ext' 	=> __( 'Cyrillic Ext.', 'shoestrap' ),
			'vietnamese' 	=> __( 'Vietnamese', 'shoestrap' ),
		),
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'font_base_color',
		'description' =>   __( 'Font Color', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => '#333333',
		'priority' => 23,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_base_weight',
		'subtitle' => __( 'Font Weight', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 400,
		'priority' => 24,
		'choices'  => array(
			'min'  => 100,
			'max'  => 800,
			'step' => 100,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_base_size',
		'subtitle' => __( 'Font Size (px)', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 20,
		'priority' => 25,
		'choices'  => array(
			'min'  => 7,
			'max'  => 70,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_base_height',
		'subtitle' => __( 'Line Height (px)', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 22,
		'priority' => 26,
		'choices'  => array(
			'min'  => 7,
			'max'  => 70,
			'step' => 1,
		),
		'separator' => true
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'headers_font_family',
		'label'    => __( 'Headers font', 'shoestrap' ),
		'subtitle' => __( 'Headers font-family', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'priority' => 30,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'headers_font_google',
		'label'    => __( 'Google-Font', 'shoestrap' ),
		'description' => __( 'If you have entered the name of a google font above, then you must enable check this option to process it.', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 0,
		'priority' => 31,
	);

	$controls[] = array(
		'type'     => 'multicheck',
		'setting'  => 'font_headers_google_subsets',
		'label'    => __( 'Google-Font subsets', 'shoestrap' ),
		'description' => __( 'The subsets used from Google\'s API.', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 'latin',
		'priority' => 32,
		'choices'  => array(
			'latin' 		=> __( 'Latin', 'shoestrap' ),
			'latin-ext' 	=> __( 'Latin Ext.', 'shoestrap' ),
			'greek' 		=> __( 'Greek', 'shoestrap' ),
			'greek-ext' 	=> __( 'Greek Ext.', 'shoestrap' ),
			'cyrillic' 		=> __( 'Cyrillic', 'shoestrap' ),
			'cyrillic-ext' 	=> __( 'Cyrillic Ext.', 'shoestrap' ),
			'vietnamese' 	=> __( 'Vietnamese', 'shoestrap' ),
		),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'headers_color_toggle',
		'label'    => __( 'Headers colors', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 0,
		'priority' => 39,
		'choices'  => array(
			0 => __( 'Off', 'shoestrap' ),
			1 => __( 'On', 'shoestrap' )
		),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'headers_weight_toggle',
		'label'    => __( 'Headers weight', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 0,
		'priority' => 49,
		'choices'  => array(
			0 => __( 'Off', 'shoestrap' ),
			1 => __( 'On', 'shoestrap' )
		),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'headers_size_toggle',
		'label'    => __( 'Headers size', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 0,
		'priority' => 59,
		'choices'  => array(
			0 => __( 'Off', 'shoestrap' ),
			1 => __( 'On', 'shoestrap' )
		),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'headers_height_toggle',
		'label'    => __( 'Headers height', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 0,
		'priority' => 69,
		'choices'  => array(
			0 => __( 'Off', 'shoestrap' ),
			1 => __( 'On', 'shoestrap' )
		),
	);

	$headers = array(
		'h1' => array( 'size' => 260, 'height' => 120 ),
		'h2' => array( 'size' => 215, 'height' => 120 ),
		'h3' => array( 'size' => 170, 'height' => 120 ),
		'h4' => array( 'size' => 110, 'height' => 125 ),
		'h5' => array( 'size' => 100, 'height' => 100 ),
		'h6' => array( 'size' => 85, 'height' => 85 ),
	);

	$i = 0;
	foreach ( $headers as $header => $values ) {

		$controls[] = array(
			'type'     => 'color',
			'setting'  => 'font_' . $header . '_color',
			'subtitle' => $header . ' ' . __( 'Color', 'shoestrap' ),
			'section'  => 'typography',
			'default'  => '#333333',
			'priority' => 40 + $i,
			'required' => array( 'headers_color_toggle' => 1 )
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_' . $header . '_weight',
			'subtitle' => $header . ' ' . __( 'Font Weight.', 'shoestrap' ) . ' ' . __( 'Default: ', 'shoestrap' ) . 400,
			'section'  => 'typography',
			'default'  => 400,
			'priority' => 50 + $i,
			'choices'  => array(
				'min'  => 100,
				'max'  => 800,
				'step' => 100,
			),
			'required' => array( 'headers_weight_toggle' => 1 )
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_' . $header .'_size',
			'subtitle' => $header . ' ' . __( 'Font Size (%)', 'shoestrap' ) . ' ' . __( 'Default: ', 'shoestrap' ) . $values['size'],
			'section'  => 'typography',
			'default'  => $values['size'],
			'priority' => 60 + $i,
			'choices'  => array(
				'min'  => 30,
				'max'  => 300,
				'step' => 1,
			),
			'required' => array( 'headers_size_toggle' => 1 )
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_' . $header . '_height',
			'subtitle' => $header . ' ' . __( 'Line Height (px)', 'shoestrap' ) . ' ' . __( 'Default: ', 'shoestrap' ) . $values['height'],
			'section'  => 'typography',
			'default'  => $values['height'],
			'priority' => 70 + $i,
			'choices'  => array(
				'min'  => 30,
				'max'  => 300,
				'step' => 1,
			),
			'required' => array( 'headers_height_toggle' => 1 )
		);

		$i++;
	}

	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_typography_customizer_settings' );

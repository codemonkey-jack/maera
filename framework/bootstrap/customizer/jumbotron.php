<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_jumbotron_customizer( $wp_customize ){

	$controls = array();

	// Create the "Jumbotron" section
	$wp_customize->add_section( 'jumbotron', array(
		'title' => __( 'Jumbotron', 'shoestrap' ),
		'priority' => 7
	) );

}
add_action( 'customize_register', 'shoestrap_jumbotron_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_jumbotron_customizer_settings( $controls ){

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'jumbo_bg',
		'label'        => __( 'Jumbotron Background', 'shoestrap' ),
		'section'      => 'jumbotron',
		'default'      => array(
			'color'    => '#eeeeee',
			'image'    => null,
			'repeat'   => 'repeat',
			'size'     => 'inherit',
			'attach'   => 'inherit',
			'position' => 'left-top',
			'opacity'  => 100,
		),
		'priority' => 1,
		'output' => '.jumbotron',
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'jumbotron_visibility',
		'label'    => __( 'Jumbotron Visibility', 'shoestrap' ),
		'subtitle' => __( 'Select if the Jumbotron should only be displayed in the frontpage or on all pages.', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => 1,
		'choices'  => array(
			0 => __( 'All Pages', 'shoestrap' ),
			1 => __( 'Frontpage only', 'shoestrap' ),
		),
		'priority' => 10,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'jumbotron_nocontainer',
		'label'    => __( 'Full-Width', 'shoestrap' ),
		'description' => __( 'When selected, the Jumbotron is no longer restricted by the width of your page, taking over the full width of your screen. This option is useful when you have assigned a slider widget on the Jumbotron area and you want its width to be the maximum width of the screen. Default: OFF.', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => 0,
		'priority' => 11,
		'separator' => true
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'font_jumbotron_font_family',
		'label'    => __( 'Jumbotron font', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'priority' => 20,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'font_jumbotron_google',
		'label'    => __( 'Google-Font', 'shoestrap' ),
		'description' => __( 'If you have entered the name of a google font above, then you must enable check this option to process it.', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => 0,
		'priority' => 21,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'font_jumbotron_color',
		'description' =>   __( 'Font Color', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => '#333333',
		'priority' => 22,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_jumbotron_weight',
		'subtitle' => __( 'Font Weight', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => 400,
		'priority' => 23,
		'choices'  => array(
			'min'  => 100,
			'max'  => 800,
			'step' => 100,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_jumbotron_size',
		'subtitle' => __( 'Font Size (px)', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => 20,
		'priority' => 24,
		'choices'  => array(
			'min'  => 7,
			'max'  => 70,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_jumbotron_height',
		'subtitle' => __( 'Line Height (px)', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => 22,
		'priority' => 25,
		'choices'  => array(
			'min'  => 7,
			'max'  => 70,
			'step' => 1,
		),
		'separator' => true
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'jumbotron_title_fit',
		'label'    => __( 'Use fittext for titles.', 'shoestrap' ),
		'description' => __( 'Use the fittext script to enlarge or scale-down the font-size of the widget title to fit the Jumbotron area. Default: OFF', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => 0,
		'priority' => 30,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'jumbotron_center',
		'label'    => __( 'Center-align the content.', 'shoestrap' ),
		'description' =>  __( 'Turn this on to center-align the contents of the Jumbotron area. Default: OFF', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => 0,
		'priority' => 31,
	);

	$controls[] = array(
		'type'     => 'number',
		'setting'  => 'jumbotron_border_bottom_thickness',
		'label'    => __( 'Border Bottom', 'shoestrap' ),
		'subtitle' => __( 'Border Thickness (px)', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => 0,
		'priority' => 32,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'jumbotron_border_bottom_style',
		'subtitle' =>  __( 'Border Style', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => 'none',
		'choices'  => array(
			'solid'  => __( 'Solid', 'shoestrap' ),
			'dashed' => __( 'Dashed', 'shoestrap' ),
			'dotted' => __( 'Dotted', 'shoestrap' ),
			'none'   => __( 'None', 'shoestrap' ),
		),
		'priority' => 33,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'jumbotron_border_bottom_color',
		'subtitle' =>  __( 'Border Color', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => '#eeeeee',
		'priority' => 34,
	);

	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_jumbotron_customizer_settings' );

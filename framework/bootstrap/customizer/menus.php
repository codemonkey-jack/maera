<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_menus_customizer( $wp_customize ){

	$controls = array();

	// Create the "Layout" section
	$wp_customize->add_section( 'menus', array(
		'title' => __( 'Menus', 'shoestrap' ),
		'priority' => 12
	) );

}
add_action( 'customize_register', 'shoestrap_menus_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_menus_customizer_settings( $controls ){

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'navbar_toggle',
		'label'    => __( 'NavBar Type', 'shoestrap' ),
		'subtitle' => __( 'Choose the type of Navbar you want. Off completely hides the navbar. <strong>WARNING:</strong> The "Static-Left" option is ONLY compatible with fluid layouts. The width of the static-left navbar is controlled by the secondary sidebar width.', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 'normal',
		'choices'  => array(
			'none'   => __( 'None', 'shoestrap' ),
			'normal' => __( 'Normal', 'shoestrap' ),
			'full'   => __( 'Full-Width', 'shoestrap' ),
			'left'   => __( 'Static-Left', 'shoestrap' ),
		),
		'priority' => 1,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'navbar_logo',
		'label'    => __( 'Use Logo ( if available ) for branding.', 'shoestrap' ),
		'description' => __( 'If this option is not checked, or there is no logo available, then the sitename will be displayed instead.', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 1,
		'priority' => 2,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'navbar_position',
		'label'    => __( 'NavBar Positioning', 'shoestrap' ),
		'description' => __( 'Using this option you can set the navbar to be fixed to top, fixed to bottom or normal. When you\'re using one of the \'fixed\' options, the navbar will stay fixed on the top or bottom of the page. Default: Normal', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 'normal',
		'choices'  => array(
			'normal'       => __( 'Normal', 'shoestrap' ),
			'fixed-top'    => __( 'Fixed (top)', 'shoestrap' ),
			'fixed-bottom' => __( 'Fixed (bottom)', 'shoestrap' ),
		),
		'priority' => 3,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'grid_float_breakpoint',
		'label'    => __( 'Responsive NavBar Threshold', 'shoestrap' ),
		'subtitle' => __( 'Point at which the navbar becomes uncollapsed', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 'screen_sm_min',
		'choices'  => array(
			'min'           => __( 'Never', 'shoestrap' ),
			'screen_xs_min' => __( 'Extra Small', 'shoestrap' ),
			'screen_sm_min' => __( 'Small', 'shoestrap' ),
			'screen_md_min' => __( 'Desktop', 'shoestrap' ),
			'screen_lg_min' => __( 'Large Desktop', 'shoestrap' ),
			'max'           => __( 'Always', 'shoestrap' ),
		),
		'priority' => 4,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'navbar_social',
		'label'    => __( 'Display social links in the NavBar.', 'shoestrap' ),
		'subtitle' => __( 'Social network links can be set-up in the "Social" section.', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 'off',
		'choices'  => array(
			'off'      => __( 'Off', 'shoestrap' ),
			'inline'   => __( 'Inline', 'shoestrap' ),
			'dropdown' => __( 'Dropdown', 'shoestrap' ),
		),
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'navbar_search',
		'label'    => __( 'Display search form on the NavBar', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 1,
		'priority' => 6,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'navbar_nav_right',
		'label'    => __( 'Menus alignment', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 'left',
		'choices'  => array(
			'left'   => __( 'Left', 'shoestrap' ),
			'center' => __( 'Center', 'shoestrap' ),
			'right'  => __( 'Right', 'shoestrap' ),
		),
		'priority' => 7,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'navbar_bg',
		'label'    => __( 'NavBar Background Color', 'shoestrap' ),
		'description' => __( 'Pick a background color for the NavBar. Default: #f8f8f8.', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => '#f8f8f8',
		'priority' => 10,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'navbar_bg_opacity',
		'label'    => __( 'NavBar Background Opacity', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 100,
		'priority' => 11,
		'choices'  => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'navbar_style',
		'label'    => __( 'Navbar Style', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 'default',
		'choices'  => array(
			'default' => __( 'Default', 'shoestrap' ),
			'style1'  => __( 'Style', 'shoestrap' ) . ' 1',
			'style2'  => __( 'Style', 'shoestrap' ) . ' 2',
			'style3'  => __( 'Style', 'shoestrap' ) . ' 3',
			'style4'  => __( 'Style', 'shoestrap' ) . ' 4',
			'style5'  => __( 'Style', 'shoestrap' ) . ' 5',
			'style6'  => __( 'Style', 'shoestrap' ) . ' 6',
			'metro'   => __( 'Metro', 'shoestrap' ),
		),
		'priority' => 12,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'navbar_height',
		'label'    => __( 'NavBar Height', 'shoestrap' ),
		'subtitle' => __( 'Select the height of your navbars in pixels.', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 50,
		'priority' => 13,
		'choices'  => array(
			'min'  => 38,
			'max'  => 200,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'font_menus_font_family',
		'label'    => __( 'Menus font', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'priority' => 20,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'font_menus_google',
		'label'    => __( 'Google-Font', 'shoestrap' ),
		'description' => __( 'If you have entered the name of a google font above, then you must enable check this option to process it.', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 0,
		'priority' => 21,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'font_menus_color',
		'description' => __( 'Font Color', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => '#333333',
		'priority' => 22,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_menus_weight',
		'subtitle' => __( 'Font Weight', 'shoestrap' ),
		'section'  => 'menus',
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
		'setting'  => 'font_menus_size',
		'subtitle' => __( 'Font Size (px)', 'shoestrap' ),
		'section'  => 'menus',
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
		'setting'  => 'font_menus_height',
		'subtitle' => __( 'Line Height (px)', 'shoestrap' ),
		'section'  => 'menus',
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
		'type'     => 'slider',
		'setting'  => 'navbar_margin',
		'subtitle' => __( 'Select the top and bottom margin of the NavBar in pixels. Applies only in static top navbars. Default: 0px.', 'shoestrap' ),
		'section'  => 'menus',
		'default'  => 0,
		'priority' => 30,
		'choices'  => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
	);


	return $controls;
}
add_filter( 'shoestrap/customizer/controls', 'shoestrap_menus_customizer_settings' );

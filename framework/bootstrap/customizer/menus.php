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
		'setting'  => 'jumbotron_center',
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

	return $controls;
}
add_filter( 'shoestrap/customizer/controls', 'shoestrap_menus_customizer_settings' );

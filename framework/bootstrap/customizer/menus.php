<?php

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
		'section'  => 'nav',
		'default'  => 'normal',
		'choices'  => array(
			'none'   => __( 'None', 'shoestrap' ),
			'normal' => __( 'Normal', 'shoestrap' ),
			'full'   => __( 'Full-Width', 'shoestrap' ),
			'left'   => __( 'Static-Left', 'shoestrap' ),
		),
		'priority' => 21,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'navbar_logo',
		'label'    => __( 'Use Logo ( if available ) for branding.', 'shoestrap' ),
		'description' => __( 'If this option is not checked, or there is no logo available, then the sitename will be displayed instead.', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 1,
		'priority' => 22,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'navbar_position',
		'label'    => __( 'NavBar Positioning', 'shoestrap' ),
		'description' => __( 'Using this option you can set the navbar to be fixed to top, fixed to bottom or normal. When you\'re using one of the \'fixed\' options, the navbar will stay fixed on the top or bottom of the page. Default: Normal', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 'normal',
		'choices'  => array(
			'normal'       => __( 'Normal', 'shoestrap' ),
			'fixed-top'    => __( 'Fixed (top)', 'shoestrap' ),
			'fixed-bottom' => __( 'Fixed (bottom)', 'shoestrap' ),
		),
		'priority' => 23,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'grid_float_breakpoint',
		'label'    => __( 'Responsive NavBar Threshold', 'shoestrap' ),
		'subtitle' => __( 'Point at which the navbar becomes uncollapsed', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 'screen_sm_min',
		'choices'  => array(
			'min'           => __( 'Never', 'shoestrap' ),
			'screen_xs_min' => __( 'Extra Small', 'shoestrap' ),
			'screen_sm_min' => __( 'Small', 'shoestrap' ),
			'screen_md_min' => __( 'Desktop', 'shoestrap' ),
			'screen_lg_min' => __( 'Large Desktop', 'shoestrap' ),
			'max'           => __( 'Always', 'shoestrap' ),
		),
		'priority' => 24,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'navbar_social',
		'label'    => __( 'Display social links in the NavBar.', 'shoestrap' ),
		'subtitle' => __( 'Social network links can be set-up in the "Social" section.', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 'off',
		'choices'  => array(
			'off'      => __( 'Off', 'shoestrap' ),
			'inline'   => __( 'Inline', 'shoestrap' ),
			'dropdown' => __( 'Dropdown', 'shoestrap' ),
		),
		'priority' => 25,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'navbar_search',
		'label'    => __( 'Display search form on the NavBar', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 1,
		'priority' => 26,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'navbar_nav_right',
		'label'    => __( 'Menus alignment', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 'left',
		'choices'  => array(
			'left'   => __( 'Left', 'shoestrap' ),
			'center' => __( 'Center', 'shoestrap' ),
			'right'  => __( 'Right', 'shoestrap' ),
		),
		'priority' => 27,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'navbar_bg',
		'label'    => __( 'NavBar Background Color', 'shoestrap' ),
		'description' => __( 'Pick a background color for the NavBar. Default: #f8f8f8.', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => '#f8f8f8',
		'priority' => 30,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'navbar_bg_opacity',
		'label'    => __( 'NavBar Background Opacity', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 100,
		'priority' => 31,
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
		'section'  => 'nav',
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
		'priority' => 32,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'navbar_height',
		'label'    => __( 'NavBar Height', 'shoestrap' ),
		'subtitle' => __( 'Select the height of your navbars in pixels.', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 50,
		'priority' => 33,
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
		'section'  => 'nav',
		'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'priority' => 40,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'font_menus_google',
		'label'    => __( 'Google-Font', 'shoestrap' ),
		'description' => __( 'If you have entered the name of a google font above, then you must enable check this option to process it.', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 0,
		'priority' => 41,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'font_menus_color',
		'description' => __( 'Font Color', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => '#333333',
		'priority' => 42,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_menus_weight',
		'subtitle' => __( 'Font Weight', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 400,
		'priority' => 43,
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
		'section'  => 'nav',
		'default'  => 20,
		'priority' => 44,
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
		'section'  => 'nav',
		'default'  => 42,
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
		'label'    => __( 'Navbar Margins', 'shoestrap' ),
		'subtitle' => __( 'Select the top and bottom margin of the NavBar in pixels. Applies only in static top navbars. Default: 0px.', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 0,
		'priority' => 50,
		'choices'  => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'navbar_secondary_social',
		'label'    => __( 'Secondary Sidebar Social Networks', 'shoestrap' ),
		'description' => __( 'Should the social networks be displayed on the secondary navbar?', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 1,
		'priority' => 52,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'secondary_navbar_margin',
		'label'    => __( 'Secondary NavBar Margin', 'shoestrap' ),
		'subtitle' => __( 'Select the top and bottom margin of header in pixels. Default: 0px.', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 0,
		'priority' => 53,
		'choices'  => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
		'separator' => true
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'sidebar_menus_class',
		'label'    => __( 'Color for sidebar menus', 'shoestrap' ),
		'subtitle' => __( 'Select a style for menus added to your sidebars using the custom menu widget', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 'screen_sm_min',
		'choices'  => array(
			'default' => __( 'Default', 'shoestrap' ),
			'primary' => __( 'Branding-Primary', 'shoestrap' ),
			'success' => __( 'Branding-Success', 'shoestrap' ),
			'warning' => __( 'Branding-Warning', 'shoestrap' ),
			'info'    => __( 'Branding-Info', 'shoestrap' ),
			'danger'  => __( 'Branding-Danger', 'shoestrap' ),
		),
		'priority' => 60,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'inverse_navlist',
		'label'    => __( 'Inverse Sidebar Menus.', 'shoestrap' ),
		'description' => __( 'Default: OFF. See https://github.com/twittem/wp-bootstrap-navlist-walker for more details', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => 1,
		'priority' => 61,
	);

	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_menus_customizer_settings' );

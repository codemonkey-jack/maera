<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_layout_customizer( $wp_customize ){

	$controls = array();

	// Create the "Layout" section
	$wp_customize->add_section( 'layout', array(
		'title' => __( 'Layout', 'shoestrap' ),
		'priority' => 2
	) );

}
add_action( 'customize_register', 'shoestrap_layout_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_layout_customizer_settings( $controls ) {

	$layouts = array(
		0 => get_template_directory_uri() . '/lib/customizer/assets/images/1c.png',
		1 => get_template_directory_uri() . '/lib/customizer/assets/images/2cr.png',
		2 => get_template_directory_uri() . '/lib/customizer/assets/images/2cl.png',
		3 => get_template_directory_uri() . '/lib/customizer/assets/images/3cl.png',
		4 => get_template_directory_uri() . '/lib/customizer/assets/images/3cr.png',
		5 => get_template_directory_uri() . '/lib/customizer/assets/images/3cm.png',
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'site_style',
		'label'    => __( 'Site Style', 'shoestrap' ),
		'subtitle' => __( 'A static layout is non-responsive. Wide and boxed Layouts are responsive while fluid layouts are full-width.', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 1,
		'default'  => 'wide',
		'choices'  => array(
			'static'  => __( 'Static', 'shoestrap' ),
			'wide'    => __( 'Wide', 'shoestrap' ),
			'boxed'   => __( 'Boxed', 'shoestrap' ),
			'fluid'   => __( 'Fluid', 'shoestrap' ),
		),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'image',
		'setting'  => 'layout',
		'label'    => __( 'Layout', 'shoestrap' ),
		'subtitle' => __( 'Select your main layout. Please note that if no widgets are present in a sidebar then that sidebar will not be displayed. ', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 2,
		'default'  => 1,
		'choices'  => $layouts,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'layout_primary_width',
		'label'    => __( 'Primary Sidebar Width', 'shoestrap' ),
		'description' => '',
		'section'  => 'layout',
		'priority' => 3,
		'default'  => 4,
		'choices'  => array(
			'min'  => '1',
			'max'  => '5',
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'layout_secondary_width',
		'label'    => __( 'Secondary Sidebar Width', 'shoestrap' ),
		'description' => '',
		'section'  => 'layout',
		'priority' => 4,
		'default'  => 3,
		'choices'  => array(
			'min'  => '1',
			'max'  => '5',
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'layout_sidebar_on_front',
		'label'    => __( 'Show sidebars on the frontpage', 'shoestrap' ),
		'description' => __( 'Select if you want to display sidebars on the frontpage. Please note that this only applies to the primary and secondary navbars and not all other widget areas.', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 5,
		'default'  => 0,
		'choices'  => array(
			0 => __( 'Hide', 'shoestrap' ),
			1 => __( 'Show', 'shoestrap' ),
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'navbar_margin_top',
		'label'    => __( 'Navbar Margin from top', 'shoestrap' ),
		'description' => __( 'This will add a margin above the navbar. CAUTION: This setting only has an effect when using the "Boxed" site style.', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 7,
		'default'  => 0,
		'choices'  => array(
			'min'  => '0',
			'max'  => '120',
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'body_margin_top',
		'label'    => __( 'Body Top Margin', 'shoestrap' ),
		'subtitle' => __( 'Select the top margin of the body element in pixels.', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 8,
		'default'  => 0,
		'choices'  => array(
			'min'  => '0',
			'max'  => '200',
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'body_margin_bottom',
		'label'    => __( 'Body Bottom Margin', 'shoestrap' ),
		'subtitle' => __( 'Select the bottom margin of the body element in pixels.', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 9,
		'default'  => 0,
		'choices'  => array(
			'min'  => '0',
			'max'  => '200',
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'custom_grid',
		'label'    => __( 'Enable Custom Grid', 'shoestrap' ),
		'subtitle' => __( 'Take control of the grid breakpoints.', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 80,
		'default'  => 0,
		'subtitle' => __( 'Please save and refresh to see new options', 'shoestrap' )
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'screen_tablet',
		'label'    => __( 'Small Screen / Tablet view', 'shoestrap' ),
		'subtitle' => __( 'The width of Tablet screens. Default: 768px', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 81,
		'default'  => 768,
		'choices'  => array(
			'min'  => '620',
			'max'  => '2100',
			'step' => '1'
		),
		'required'    => array( 'custom_grid' => 1 )
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'screen_desktop',
		'label'    => __( 'Desktop Container Width', 'shoestrap' ),
		'subtitle' => __( 'The width of normal screens. Default: 992px', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 82,
		'default'  => 992,
		'choices'  => array(
			'min'  => '620',
			'max'  => '2100',
			'step' => '1'
		),
		'required'    => array( 'custom_grid' => 1 )
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'screen_large_desktop',
		'label'    => __( 'Large Desktop Container Width', 'shoestrap' ),
		'subtitle' => __( 'The width of Large Desktop screens. Default: 1200px', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 83,
		'default'  => 1200,
		'choices'  => array(
			'min'  => '620',
			'max'  => '2100',
			'step' => '1'
		),
		'required'    => array( 'custom_grid' => 1 )
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'cpt_layout_toggle',
		'label'    => __( 'Per Post-Type layouts', 'shoestrap' ),
		'subtitle' => __( 'After you enable this setting you will have to save your settings and refresh your page in order to see the new options.', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 90,
		'default'  => 0,
	);

	if ( 1 == get_theme_mod( 'cpt_layout_toggle', 0 ) ) {

		$post_types = get_post_types( array( 'public' => true ), 'names' );

		$layout = get_theme_mod( 'layout' );

		foreach ( $post_types as $post_type ) {
			$controls[] = array(
				'type'     => 'radio',
				'mode'     => 'image',
				'setting'  => $post_type . 'layout',
				'label'    => $post_type . ' ' . __( 'layout', 'shoestrap' ),
				'description' => null,
				'section'  => 'layout',
				'priority' => 92,
				'default'  => $layout,
				'choices'  => $layouts,
			);
		}
	}
	return $controls;
}
add_filter( 'shoestrap/customizer/controls', 'shoestrap_layout_customizer_settings' );

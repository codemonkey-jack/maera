<?php

/*
 * Create the sections
 */
function shoestrap_customizer_sections( $wp_customize ) {

	// Remove the "Navigation" menu so that we may add it manually using a different priority
	$wp_customize->remove_section( 'nav' );

	// Please note the "General" section is added on the theme core and not a framework.

	$sections = array(
		'general'    => array( 'title' => __( 'General', 'shoestrap' ),         'priority' => 5 ),
		'background' => array( 'title' => __( 'Background', 'shoestrap' ),      'priority' => 10 ),
		'typography' => array( 'title' => __( 'Typography', 'shoestrap' ),      'priority' => 11 ),
		'colors'     => array( 'title' => __( 'Colors', 'shoestrap' ),          'priority' => 12 ),
		'layout'     => array( 'title' => __( 'Layout', 'shoestrap' ),          'priority' => 13 ),
		'blog'       => array( 'title' => __( 'Blog', 'shoestrap' ),            'priority' => 14 ),
		'feat'       => array( 'title' => __( 'Featured Images', 'shoestrap' ), 'priority' => 15 ),
		'nav'        => array( 'title' => __( 'Navigation', 'shoestrap' ),      'priority' => 16 ),
		'header'     => array( 'title' => __( 'Header', 'shoestrap' ),          'priority' => 17 ),
		'jumbotron'  => array( 'title' => __( 'Jumbotron', 'shoestrap' ),       'priority' => 18 ),
		'footer'     => array( 'title' => __( 'Footer', 'shoestrap' ),          'priority' => 18 ),
		'social'     => array( 'title' => __( 'Social', 'shoestrap' ),          'priority' => 20 ),
		'advanced'   => array( 'title' => __( 'Advanced', 'shoestrap' ),        'priority' => 21 ),
	);

	foreach ( $sections as $section => $args ) {

		$wp_customize->add_section( $section, array(
			'title'    => $args['title'],
			'priority' => $args['priority'],
		) );

	}

}
add_action( 'customize_register', 'shoestrap_customizer_sections' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_customizer_settings( $controls ) {

	//-------------------------------------------------
	// GENERAL
	//-------------------------------------------------

	$controls[] = array(
		'type'        => 'image',
		'setting'     => 'logo',
		'label'       => __( 'Logo', 'shoestrap' ),
		'subtitle' => __( 'Upload your site\'s logo', 'shoestrap' ),
		'section'     => 'general',
		'priority'    => 10,
		'default'     => null
	);

	$controls[] = array(
		'type'        => 'image',
		'setting'     => 'favicon',
		'label'       => __( 'Custom Favicon', 'shoestrap' ),
		'subtitle' => __( 'Upload your site\'s favicon', 'shoestrap' ),
		'section'     => 'general',
		'priority'    => 11,
		'default'     => null
	);

	$controls[] = array(
		'type'        => 'image',
		'setting'     => 'apple_icon',
		'label'       => __( 'Apple Icon', 'shoestrap' ),
		'subtitle' =>  __( 'This will create icons for Apple iPhone ( 57px x 57px ), Apple iPhone Retina Version ( 114px x 114px ), Apple iPad ( 72px x 72px ) and Apple iPad Retina ( 144px x 144px ). Please note that for better results the image you upload should be at least 144px x 144px.', 'shoestrap' ),
		'section'     => 'general',
		'priority'    => 12,
		'default'     => null
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'widgets_mode',
		'label'    => __( 'Widgets mode', 'shoestrap' ),
		'subtitle' => __( 'How do you want your widgets to be displayed?', 'shoestrap' ),
		'section'  => 'general',
		'priority' => 13,
		'default'  => 0,
		'choices'  => array(
			0 => __( 'Panel', 'shoestrap' ),
			1 => __( 'Well', 'shoestrap' ),
			2=> __( 'None', 'shoestrap' ),
		),
	);


	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'font_size_units',
		'label'    => __( 'Font-size units', 'shoestrap' ),
		'section'  => 'general',
		'subtitle' => __( 'Choose if you want to set font sizes as pixels or ems. This will apply to all settings. Please note that if you change this setting you will have to save and refresh this page. Once you do, please review ALL your font-size settings and set them accordingly.', 'shoestrap' ),
		'default'  => 'px',
		'choices'  => array(
			'px'   => 'Pixels',
			'rem'  => '(r)Ems',
		),
		'priority' => 18,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'dev_mode',
		'label'    => __( 'Enable development mode', 'shoestrap' ),
		'section'  => 'general',
		'subtitle' => __( 'When development mode is enabled, all theme caches are disabled (does not affect any caching plugins you may have installed).', 'shoestrap' ),
		'default'  => 0,
		'priority' => 20,
	);

	//-------------------------------------------------
	// LAYOUTS
	//-------------------------------------------------

	$layouts = array(
		0 => get_template_directory_uri() . '/assets/images/1c.png',
		1 => get_template_directory_uri() . '/assets/images/2cr.png',
		2 => get_template_directory_uri() . '/assets/images/2cl.png',
		3 => get_template_directory_uri() . '/assets/images/3cl.png',
		4 => get_template_directory_uri() . '/assets/images/3cr.png',
		5 => get_template_directory_uri() . '/assets/images/3cm.png',
	);

	$controls[] = array(
		'type'     => 'group_title',
		'label'    => __( 'Basic Layout Options', 'shoestrap' ),
		'priority' => 1,
		'section'  => 'layout',
		'setting'  => 'separator' . rand( 999, 9999 ),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'site_style',
		'label'    => __( 'Site Style', 'shoestrap' ),
		'subtitle' => __( 'A static layout is non-responsive. Wide and boxed Layouts are responsive while fluid layouts are full-width.', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 2,
		'default'  => 'wide',
		'choices'  => array(
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
		'priority' => 3,
		'default'  => 1,
		'choices'  => $layouts,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'layout_primary_width',
		'label'    => __( 'Primary Sidebar Width', 'shoestrap' ),
		'description' => '',
		'section'  => 'layout',
		'priority' => 4,
		'default'  => 4,
		'choices'  => array(
			'min'  => 1,
			'max'  => 5,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'layout_secondary_width',
		'label'    => __( 'Secondary Sidebar Width', 'shoestrap' ),
		'description' => '',
		'section'  => 'layout',
		'priority' => 5,
		'default'  => 3,
		'choices'  => array(
			'min'  => 1,
			'max'  => 5,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'layout_sidebar_on_front',
		'label'    => __( 'Show sidebars on the frontpage', 'shoestrap' ),
		'description' => __( 'Select if you want to display sidebars on the frontpage. Please note that this only applies to the primary and secondary navbars and not all other widget areas.', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 6,
		'default'  => 0,
		'choices'  => array(
			0 => __( 'Hide', 'shoestrap' ),
			1 => __( 'Show', 'shoestrap' ),
		),
	);

	$controls[] = array(
		'type'     => 'group_title',
		'label'    => __( 'Extended Layout Options', 'shoestrap' ),
		'priority' => 7,
		'section'  => 'layout',
		'setting'  => 'separator' . rand( 999, 9999 ),
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
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
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
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'group_title',
		'label'    => __( 'Advanced Layout Options', 'shoestrap' ),
		'priority' => 80,
		'section'  => 'layout',
		'setting'  => 'separator' . rand( 999, 9999 ),
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
			'min'  => 620,
			'max'  => 2100,
			'step' => 1
		),
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
			'min'  => 620,
			'max'  => 2100,
			'step' => 1,
		),
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
			'min'  => 620,
			'max'  => 2100,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'gutter',
		'label'    => __( 'Gutter', 'shoestrap' ),
		'subtitle' => __( 'The spacing between grid columns. Default: 30px', 'shoestrap' ),
		'section'  => 'layout',
		'priority' => 84,
		'default'  => 30,
		'choices'  => array(
			'min'  => 0,
			'max'  => 80,
			'step' => 1,
		),
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

		$layout = get_theme_mod( 'layout', 1 );

		foreach ( $post_types as $post_type ) {
			$controls[] = array(
				'type'     => 'radio',
				'mode'     => 'image',
				'setting'  => $post_type . '_layout',
				'label'    => $post_type . ' ' . __( 'layout', 'shoestrap' ),
				'description' => null,
				'section'  => 'layout',
				'priority' => 92,
				'default'  => $layout,
				'choices'  => $layouts,
			);
		}
	}

	//-------------------------------------------------
	// MENUS
	//-------------------------------------------------

	$controls[] = array(
		'type'     => 'group_title',
		'label'    => __( 'NavBar Styling', 'shoestrap' ),
		'priority' => 20,
		'section'  => 'nav',
		'setting'  => 'separator' . rand( 999, 9999 ),
	);

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
        'framework_var' => '@navbar-default-bg'
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
		'type'     => 'group_title',
		'label'    => __( 'Menus Font', 'shoestrap' ),
		'priority' => 35,
		'section'  => 'nav',
		'setting'  => 'separator' . rand( 999, 9999 ),
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
        'framework_var' => '@navbar-default-color'
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
		'subtitle' => __( 'Font Size', 'shoestrap' ),
		'section'  => 'nav',
		'default'  => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 14 : 1.5,
		'priority' => 44,
		'choices'  => array(
			'min'  => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 7 : 0.1,
			'max'  => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 70 : 7,
			'step' => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 1 : 0.01,
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
	);

	$controls[] = array(
		'type'     => 'group_title',
		'label'    => __( 'Secondary NavBar', 'shoestrap' ),
		'priority' => 51,
		'section'  => 'nav',
		'setting'  => 'separator' . rand( 999, 9999 ),
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'navbar_secondary_social',
		'label'    => __( 'Secondary Navbar Social Networks', 'shoestrap' ),
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

	//-------------------------------------------------
	// COLORS
	//-------------------------------------------------

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_primary',
		'label'    => __( 'Brand Colors: Primary', 'shoestrap' ),
		'description' => __( 'Select your primary branding color. Also referred to as an accent color. This will affect various areas of your site, including the color of your primary buttons, link color, the background of some elements and many more.', 'shoestrap' ),
		'section'  => 'colors',
		'default'  => '#428bca',
		'priority' => 1,
        'framework_var' => '@brand-primary'
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_info',
		'label'    => __( 'Brand Colors: Info', 'shoestrap' ),
		'description' =>  __( 'Select your branding color for info messages etc. It will also be used for the Search button color as well as other areas where it semantically makes sense to use an \'info\' class.', 'shoestrap' ),
		'section'  => 'colors',
		'default'  => '#5bc0de',
		'priority' => 2,
        'framework_var' => '@brand-info'
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_success',
		'label'    => __( 'Brand Colors: Success', 'shoestrap' ),
		'description' =>  __( 'Select your branding color for success messages etc.', 'shoestrap' ),
		'section'  => 'colors',
		'default'  => '#5cb85c',
		'priority' => 3,
        'framework_var' => '@brand-success'
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_warning',
		'label'    => __( 'Brand Colors: Warning', 'shoestrap' ),
		'description' =>  __( 'Select your branding color for warning messages etc.', 'shoestrap' ),
		'section'  => 'colors',
		'default'  => '#f0ad4e',
		'priority' => 4,
        'framework_var' => '@brand-warning'
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_danger',
		'label'    => __( 'Brand Colors: Danger', 'shoestrap' ),
		'description' =>  __( 'Select your branding color for danger messages etc.', 'shoestrap' ),
		'section'  => 'colors',
		'default'  => '#d9534f',
		'priority' => 5,
        'framework_var' => '@brand-danger'
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'gradients_toggle',
		'label'    => __( 'Enable Gradients', 'shoestrap' ),
		'description' => __( 'Enable or disable gradients. These are applied to navbars, buttons and other elements. Please note that gradients will not be applied in the preview mode and can only be seen on the live site.', 'shoestrap' ),
		'section'  => 'colors',
		'priority' => 10,
		'default'  => 0,
		'choices'  => array(
			0 => __( 'Flat', 'shoestrap' ),
			1 => __( 'Gradients', 'shoestrap' ),
		),
	);
	//-------------------------------------------------
	// BACKGROUND
	//-------------------------------------------------


	$controls[] = array(
		'type'     => 'group_title',
		'label'    => __( 'General Background', 'shoestrap' ),
		'priority' => 1,
		'section'  => 'background',
		'setting'  => 'separator' . rand( 999, 9999 ),
        'framework_var' => '@body-bg',
	);

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'html_bg',
		'label'        => __( 'General Background', 'shoestrap' ),
		'section'      => 'background',
		'default'      => array(
			'color'    => '#ffffff',
			'image'    => null,
			'repeat'   => 'repeat',
			'size'     => 'inherit',
			'attach'   => 'inherit',
			'position' => 'left-top',
			'opacity'  => false,
		),
		'priority' => 2,
		'output' => 'body.bootstrap',
        'framework_var' => '@body-bg',
	);

	$controls[] = array(
		'type'     => 'group_title',
		'label'    => __( 'Body Background', 'shoestrap' ),
		'priority' => 30,
		'section'  => 'background',
		'setting'  => 'separator' . rand( 999, 9999 ),
	);

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'body_bg',
		'label'        => __( 'Body Background', 'shoestrap' ),
		'section'      => 'background',
		'default'      => array(
			'color'    => '#ffffff',
			'image'    => null,
			'repeat'   => 'repeat',
			'size'     => 'inherit',
			'attach'   => 'inherit',
			'position' => 'left-top',
			'opacity'  => 100,
		),
		'priority' => 31,
		'output' => 'body.bootstrap #wrap-main-section',
        'framework_var' => '@boxed-container-bg-color',
	);

	//-------------------------------------------------
	// TYPOGRAPHY
	//-------------------------------------------------

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
        'framework_var' => '@text-color'
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
			'max'  => 900,
			'step' => 100,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_base_size',
		'subtitle' => __( 'Font Size', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 14 : 1.5,
		'priority' => 25,
		'choices'  => array(
			'min'  => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 7 : 0.1,
			'max'  => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 70 : 7,
			'step' => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 1 : 0.01,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_base_height',
		'subtitle' => __( 'Line Height', 'shoestrap' ),
		'section'  => 'typography',
		'default'  => 1.4,
		'priority' => 26,
		'choices'  => array(
			'min'  => 0,
			'max'  => 3,
			'step' => 0.1,
		),
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
		'h1' => array( 'size' => 260, 'height' => 1.1 ),
		'h2' => array( 'size' => 215, 'height' => 1.1 ),
		'h3' => array( 'size' => 170, 'height' => 1.1 ),
		'h4' => array( 'size' => 110, 'height' => 1.1 ),
		'h5' => array( 'size' => 100, 'height' => 1.1 ),
		'h6' => array( 'size' => 85,  'height' => 1.1 ),
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
			'required' => array( 'headers_color_toggle' => 1 ),
            'framework_var' => '@text-color'
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
				'max'  => 900,
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
			'subtitle' => $header . ' ' . __( 'Line Height', 'shoestrap' ) . ' ' . __( 'Default: ', 'shoestrap' ) . $values['height'],
			'section'  => 'typography',
			'default'  => $values['height'],
			'priority' => 70 + $i,
			'choices'  => array(
				'min'  => 0,
				'max'  => 3,
				'step' => 0.1,
			),
			'required' => array( 'headers_height_toggle' => 1 )
		);

		$i++;
	}

	//-------------------------------------------------
	// BLOG
	//-------------------------------------------------

	$controls[] = array(
		'type'        => 'radio',
		'mode'        => 'buttonset',
		'setting'     => 'blog_post_mode',
		'label'       => __( 'Archives Display Mode', 'shoestrap' ),
		'description' => __( 'Display the excerpt or the full post on post archives.', 'shoestrap' ),
		'section'     => 'blog',
		'priority'    => 1,
		'default'     => 'excerpt',
		'choices'     => array(
			'excerpt' => __( 'Excerpt', 'shoestrap' ),
			'full'    => __( 'Full Post', 'shoestrap' ),
		),
	);

	$controls[] = array(
		'type'        => 'sortable',
		'mode'        => 'checkbox',
		'setting'     => 'shoestrap_entry_meta_config',
		'label'       => __( 'Post Meta elements', 'shoestrap' ),
		'description' => __( 'Activate and order Post Meta elements', 'shoestrap' ),
		'section'     => 'blog',
		'priority'    => 2,
		'default'     => '',
		'choices'     => array(
			'post-format'   => 'Post Format',
			'tags'          => 'Tags',
			'date'          => 'Date',
			'category'      => 'Category',
			'author'        => 'Author',
			'comment-count' => 'Comments',
			'sticky'        => 'Sticky'
		),
	);

	$controls[] = array(
		'type'        => 'checkbox',
		'setting'     => 'breadcrumbs',
		'label'       => __( 'Show Breadcrumbs', 'shoestrap' ),
		'section'     => 'blog',
		'priority'    => 3,
		'default'     => 0,
	);

	$controls[] = array(
		'type'        => 'radio',
		'mode'        => 'buttonset',
		'setting'     => 'date_meta_format',
		'label'       => __( 'Date format in meta', 'shoestrap' ),
		'subtitle'    => __( 'Show the date as a normal date, or as time difference (example: 2 weeks ago)', 'shoestrap' ),
		'section'     => 'blog',
		'priority'    => 9,
		'default'     => 1,
		'choices'     => array(
			0 => __( 'Date', 'shoestrap' ),
			1 => __( 'Time Difference', 'shoestrap' ),
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'post_excerpt_length',
		'label'    => __( 'Post excerpt length', 'shoestrap' ),
		'description' => __( 'Choose how many words should be used for post excerpt. Default: 55', 'shoestrap' ),
		'section'  => 'blog',
		'priority' => 10,
		'default'  => 55,
		'choices'  => array(
			'min'  => 10,
			'max'  => 150,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'        => 'text',
		'setting'     => 'post_excerpt_link_text',
		'label'       => __( '"more" text', 'shoestrap' ),
		'subtitle'    => __( 'Text to display in case of excerpt too long. Default: Continued', 'shoestrap' ),
		'section'     => 'blog',
		'priority'    => 12,
		'default'     => __( 'Continued', 'shoestrap' ),
	);

	$controls[] = array(
		'type'        => 'checkbox',
		'setting'     => 'single_meta',
		'label'       => __( 'Post Meta in single posts', 'shoestrap' ),
		'description' => __( 'When checked, the post tags and categories will be added on the footer of posts.', 'shoestrap' ),
		'section'     => 'blog',
		'priority'    => 40,
		'default'     => 1,
	);


	//-------------------------------------------------
	// FEATURED IMAGES
	//-------------------------------------------------

	$controls[] = array(
		'type'        => 'checkbox',
		'setting'     => 'feat_img_archive',
		'label'       => __( 'Featured Images on Archives', 'shoestrap' ),
		'description' => __( 'Display featured Images on post archives ( such as categories, tags, month view etc ).', 'shoestrap' ),
		'section'     => 'feat',
		'priority'    => 50,
		'default'     => 0,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'feat_img_archive_width',
		'label'    => __( 'Archives Featured Image Width', 'shoestrap' ),
		'description' => __( 'Select the width of your featured images on post archives. Set to -1 for max width and 0 for original width. Default: -1', 'shoestrap' ) . '<strong>' . __( 'Set to -1 for full-width', 'shoestrap' ) . '</strong>',
		'section'  => 'feat',
		'priority' => 52,
		'default'  => 550,
		'choices'  => array(
			'min'  => -1,
			'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'feat_img_archive_height',
		'label'    => __( 'Archives Featured Image Height', 'shoestrap' ),
		'description' => __( 'Select the height of your featured images on post archives. Set to 0 to resize the image using the original image proportions. Default: -1', 'shoestrap' ),
		'section'  => 'feat',
		'priority' => 53,
		'default'  => 300,
		'choices'  => array(
			'min'  => 0,
			'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'        => 'checkbox',
		'setting'     => 'feat_img_post',
		'label'       => __( 'Featured Images on Posts', 'shoestrap' ),
		'subtitle'    => __( 'Display featured Images on simgle posts.', 'shoestrap' ),
		'section'     => 'feat',
		'priority'    => 60,
		'default'     => 0,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'feat_img_post_width',
		'label'    => __( 'Posts Featured Image Width', 'shoestrap' ),
		'description' => __( 'Select the width of your featured images on single posts. Set to -1 for max width and 0 for original image width. Default: -1', 'shoestrap' ) . '<strong>' . __( 'Set to -1 for full-width', 'shoestrap' ) . '</strong>',
		'section'  => 'feat',
		'priority' => 62,
		'default'  => 550,
		'choices'  => array(
			'min'  => -1,
			'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'feat_img_post_height',
		'label'    => __( 'Posts Featured Image Height', 'shoestrap' ),
		'description' => __( 'Select the height of your featured images on single posts. Set to 0 to use the original image proportions. Default: 0', 'shoestrap' ),
		'section'  => 'feat',
		'priority' => 63,
		'default'  => 300,
		'choices'  => array(
			'min'  => 0,
			'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
			'step' => '1'
		),
	);

	$post_types = get_post_types( array( 'public' => true ), 'names' );
	$controls[] = array(
		'type'        => 'multicheck',
		'mode'        => 'checkbox',
		'setting'     => 'feat_img_per_post_type',
		'label'       => __( 'Disable featured images per post type', 'shoestrap' ),
		'section'     => 'feat',
		'priority'    => 65,
		'default'     => '',
		'choices'     => $post_types,
	);

	//-------------------------------------------------
	// JUMBOTRON
	//-------------------------------------------------

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
        'framework_var' => 'jumbotron-bg'
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
        'framework_var' => '@jumbotron-color'
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
		'subtitle' => __( 'Font Size', 'shoestrap' ),
		'section'  => 'jumbotron',
		'default'  => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 20 : 1.8,
		'priority' => 24,
		'choices'  => array(
			'min'  => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 7 : 0.1,
			'max'  => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 70 : 7,
			'step' => ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 1 : 0.01,
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
        'framework_var' => '@jumbotron-bottom-border'
	);

	//-------------------------------------------------
	// HEADER
	//-------------------------------------------------

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'header_toggle',
		'label'    => __( 'Display the Header.', 'shoestrap' ),
		'description' => __( 'Check this to display the header. Default: OFF', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 0,
		'priority' => 1,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'header_branding',
		'label'    => __( 'Display branding on your Header.', 'shoestrap' ),
		'description' => __( 'Check to display branding ( Sitename or Logo )on your Header. Default: ON', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 1,
		'priority' => 2,
	);

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'header_bg',
		'label'        => __( 'Header Background', 'shoestrap' ),
		'section'      => 'header',
		'default'      => array(
			'color'    => '#ffffff',
			'image'    => null,
			'repeat'   => 'repeat',
			'size'     => 'inherit',
			'attach'   => 'inherit',
			'position' => 'left-top',
			'opacity'  => 100,
		),
		'priority' => 10,
		'output' => 'header.page-header',
        'framework_var' => '@header-bg'
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'header_color',
		'label'    => __( 'Header Text Color', 'shoestrap' ),
		'description' => __( 'Select the text color for your header. Default: #333333.', 'shoestrap' ),
		'section'  => 'header',
		'default'  => '#333333',
		'priority' => 20,
        'framework_var' => '@header-color'
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'header_margin_top',
		'label'    => __( 'Margin-top', 'shoestrap' ),
		'subtitle' => __( 'Select the top margin of the header in pixels. Default: 0px.', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 0,
		'priority' => 21,
		'choices'  => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'header_margin_bottom',
		'label'    => __( 'Margin-bottom', 'shoestrap' ),
		'subtitle' => __( 'Select the bottom margin of the header in pixels. Default: 0px.', 'shoestrap' ),
		'section'  => 'header',
		'default'  => 0,
		'priority' => 22,
		'choices'  => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
	);

	//-------------------------------------------------
	// SOCIAL
	//-------------------------------------------------

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'social_sharing_text',
		'label'    => __( 'Sharing Button Text', 'shoestrap' ),
		'description' => __( 'Select the text for the social sharing button.', 'shoestrap' ),
		'section'  => 'social',
		'default'  => __( 'Share', 'shoestrap' ),
		'priority' => 1,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'social_sharing_location',
		'label'    => __( 'Button Location', 'shoestrap' ),
		'section'  => 'social',
		'default'  => 'none',
		'choices'  => array(
			'none'   => __( 'None', 'shoestrap' ),
			'top'    => __( 'Top', 'shoestrap' ),
			'bottom' => __( 'Bottom', 'shoestrap' ),
			'both'   => __( 'Both', 'shoestrap' ),
		),
		'priority' => 2,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'radio',
		'setting'  => 'social_sharing_button_class',
		'label'    => __( 'Button Styling', 'shoestrap' ),
		'subtitle' => __( 'Select between your branding colors', 'shoestrap' ),
		'section'  => 'social',
		'default'  => 'default',
		'choices'  => array(
			'default' => __( 'Default', 'shoestrap' ),
			'primary' => __( 'Primary', 'shoestrap' ),
			'success' => __( 'Success', 'shoestrap' ),
			'warning' => __( 'Warning', 'shoestrap' ),
			'danger'  => __( 'Danger', 'shoestrap' ),
		),
		'priority' => 3,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'social_sharing_archives',
		'label'    => __( 'Show in post archives', 'shoestrap' ),
		'section'  => 'social',
		'default'  => 0,
		'priority' => 4,
	);

	$post_types = get_post_types( array( 'public' => true ), 'names' );
	$controls[] = array(
		'type'        => 'multicheck',
		'mode'        => 'checkbox',
		'setting'     => 'social_sharing_singular',
		'label'       => __( 'Enable on single post types', 'shoestrap' ),
		'subtitle'    => __( 'If you want to display the sharing buttons on posts, pages or any other post type you will have to select it here.', 'shoestrap' ),
		'section'     => 'social',
		'priority'    => 5,
		'default'     => '',
		'choices'     => $post_types,
	);

	$controls[] = array(
		'type'        => 'multicheck',
		'mode'        => 'checkbox',
		'setting'     => 'share_networks',
		'label'       => __( 'Social Share Networks', 'shoestrap' ),
		'subtitle'    => __( 'Select the Social Networks you want to enable for social shares', 'shoestrap' ),
		'section'     => 'social',
		'priority'    => 6,
		'default'     => '',
		'choices'     => array(
			'fb'    => __( 'Facebook', 'shoestrap' ),
			'gp'    => __( 'Google+', 'shoestrap' ),
			'li'    => __( 'LinkedIn', 'shoestrap' ),
			'pi'    => __( 'Pinterest', 'shoestrap' ),
			'rd'    => __( 'Reddit', 'shoestrap' ),
			'tu'    => __( 'Tumblr', 'shoestrap' ),
			'tw'    => __( 'Twitter', 'shoestrap' ),
			'em'    => __( 'Email', 'shoestrap' ),
		)
	);

	$social_links = array(
		'blogger'     => __( 'Blogger', 'shoestrap' ),
		'deviantart'  => __( 'DeviantART', 'shoestrap' ),
		'digg'        => __( 'Digg', 'shoestrap' ),
		'dribbble'    => __( 'Dribbble', 'shoestrap' ),
		'facebook'    => __( 'Facebook', 'shoestrap' ),
		'flickr'      => __( 'Flickr', 'shoestrap' ),
		'github'      => __( 'Github', 'shoestrap' ),
		'google_plus' => __( 'Google+', 'shoestrap' ),
		'instagram'   => __( 'Instagram', 'shoestrap' ),
		'linkedin'    => __( 'LinkedIn', 'shoestrap' ),
		'myspace'     => __( 'MySpace', 'shoestrap' ),
		'pinterest'   => __( 'Pinterest', 'shoestrap' ),
		'reddit'      => __( 'Reddit', 'shoestrap' ),
		'rss'         => __( 'RSS', 'shoestrap' ),
		'skype'       => __( 'Skype', 'shoestrap' ),
		'soundcloud'  => __( 'SoundCloud', 'shoestrap' ),
		'tumblr'      => __( 'Tumblr', 'shoestrap' ),
		'twitter'     => __( 'Twitter', 'shoestrap' ),
		'vimeo'       => __( 'Vimeo', 'shoestrap' ),
		'vkontakte'   => __( 'Vkontakte', 'shoestrap' ),
		'youtube'     => __( 'YouTube', 'shoestrap' ),
	);

	$i = 0;
	foreach ( $social_links as $social_link => $label ) {

		$controls[] = array(
			'type'     => 'text',
			'setting'  => $social_link . '_link',
			'label'    => $label . ' ' . __( 'link', 'shoestrap' ),
			'section'  => 'social',
			'default'  => '',
			'priority' => 10 + $i,
		);

		$i++;

	}


	//-------------------------------------------------
	// FOOTER
	//-------------------------------------------------

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'footer_bg',
		'label'        => __( 'Footer Background', 'shoestrap' ),
		'section'      => 'footer',
		'default'      => array(
			'color'    => '#ffffff',
			'image'    => null,
			'repeat'   => 'repeat',
			'size'     => 'inherit',
			'attach'   => 'inherit',
			'position' => 'left-top',
			'opacity'  => 100,
		),
		'priority' => 10,
		'output' => 'footer.page-footer',
        'framework_var' => '@footer-bg'
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'footer_color',
		'label'    => __( 'Footer Text Color', 'shoestrap' ),
		'description' => __( 'Select the text color for your footer. Default: #333333.', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => '#333333',
		'priority' => 10,
        'framework_var' => '@footer-bg'
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'footer_margin_top',
		'label'    => __( 'Margin-top', 'shoestrap' ),
		'subtitle' => __( 'Select the top margin of the footer in pixels. Default: 0px.', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => 0,
		'priority' => 11,
		'choices'  => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'textarea',
		'label'    => __( 'Footer Text', 'shoestrap' ),
		'setting'  => 'footer_text',
		'default'  => '&copy; [year] [sitename]',
		'section'  => 'footer',
		'priority' => 12,
		'subtitle' => __( 'The text that will be displayed in your footer. You can use [year] and [sitename] and they will be replaced appropriately. Default: &copy; [year] [sitename]', 'shoestrap' ),
	);

	$controls[] = array(
		'type'     => 'number',
		'setting'  => 'footer_border_bottom_thickness',
		'label'    => __( 'Border Top', 'shoestrap' ),
		'subtitle' => __( 'Border Thickness (px)', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => 0,
		'priority' => 32,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'footer_border_bottom_style',
		'subtitle' =>  __( 'Border Style', 'shoestrap' ),
		'section'  => 'footer',
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
		'setting'  => 'footer_border_bottom_color',
		'subtitle' =>  __( 'Border Color', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => '#eeeeee',
		'priority' => 34,
        'framework_var' => '@footer-color'
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'footer_social_width',
		'label'    => __( 'Footer social links column width', 'shoestrap' ),
		'description' => __( 'You can customize the width of the footer social links area. The footer text width will be adjusted accordingly. Set to 0 to completely hide social links.', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => 0,
		'priority' => 40,
		'choices'  => array(
			'min'  => 0,
			'max'  => 12,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'footer_social_new_window_toggle',
		'label'    => __( 'Footer social icons open new window', 'shoestrap' ),
		'description' => __( 'Social icons in footer will open a new window. Default: On.', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => 0,
		'priority' => 1,
	);

	//-------------------------------------------------
	// ADVANCED
	//-------------------------------------------------

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'retina_toggle',
		'label'    => __( 'Enable Retina mode', 'shoestrap' ),
		'description' => __( 'When checked, your site\'s featured images will be retina ready. Requires images to be uploaded at 2x the typical size desired. (uses retina.js) Default: On', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 1,
		'default'  => 1,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'border_radius',
		'label'    => __( 'Border-Radius', 'shoestrap' ),
		'description' => __( 'You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 2,
		'default'  => 4,
		'choices'  => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'padding_base',
		'label'    => __( 'Padding Base', 'shoestrap' ),
		'description' => __( 'You can adjust the padding base. This affects buttons size and lots of other cool stuff too! Default: 8', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 3,
		'default'  => 8,
		'choices'  => array(
			'min'  => 0,
			'max'  => 22,
			'step' => 1
		),
	);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'css',
		'label'    => __( 'Custom CSS', 'shoestrap' ),
		'subtitle' => __( 'You can write your custom CSS here. This code will appear in a script tag appended in the header section of the page.', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 4,
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'less',
		'label'    => __( 'Custom LESS', 'shoestrap' ),
		'subtitle' => __( 'You can write your custom LESS here. This code will be compiled with the other LESS files of the theme and be appended to the header.', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 5,
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'js',
		'label'    => __( 'Custom JS', 'shoestrap' ),
		'subtitle' => __( 'You can write your custom JavaScript/jQuery here. The code will be included in a script tag appended to the bottom of the page.', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 6,
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'minimize_css',
		'label'    => __( 'Minimize CSS', 'shoestrap' ),
		'description' => __( 'Minimize the generated CSS. This should be always be checked for production sites.', 'shoestrap' ),
		'section'  => 'advanced',
		'priority' => 10,
		'default'  => 1,
	);


	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_customizer_settings' );

<?php

/*
 * Create the sections
 */
function maera_customizer_sections( $wp_customize ) {

	// Remove the "Navigation" menu so that we may add it manually using a different priority
	$wp_customize->remove_section( 'nav' );

	$panels = array(
		'structure'   => array( 'title' => __( 'Structure', 'maera' ),   'description' => __( 'Set the structure options', 'maera' ),       'priority' => 10 ),
		'backgrounds' => array( 'title' => __( 'Backgrounds', 'maera' ), 'description' => __( 'Set the site backgrounds', 'maera' ),        'priority' => 20 ),
		'typography'  => array( 'title' => __( 'Typography', 'maera' ),  'description' => __( 'Set the site typography options', 'maera' ), 'priority' => 30 ),
		'blog'        => array( 'title' => __( 'Blog', 'maera' ),        'description' => __( 'Set the blog options', 'maera' ),            'priority' => 40 ),
	);

	$sections = array(
		'branding' => array( 'title' => __( 'Branding', 'maera' ), 'priority' => 5, 'panel' => '' ),

		'general'         => array( 'title' => __( 'General', 'maera' ),         'priority' => 10, 'panel' => 'structure' ),
		'layout'          => array( 'title' => __( 'Layout', 'maera' ),          'priority' => 15, 'panel' => 'structure' ),
		'layout_advanced' => array( 'title' => __( 'Advanced Layout', 'maera' ), 'priority' => 20, 'panel' => 'structure' ),
		'structure_jumbo' => array( 'title' => __( 'Jumbotron', 'maera' ),       'priority' => 30, 'panel' => 'structure' ),
		'nav'             => array( 'title' => __( 'Navigation', 'maera' ),      'priority' => 35, 'panel' => 'structure' ),
		'widget_areas'    => array( 'title' => __( 'Widget Areas', 'maera' ),    'priority' => 35, 'panel' => 'structure' ),

		'html_bg'    => array( 'title' => __( 'HTML', 'maera' ),         'priority' => 10, 'panel' => 'backgrounds' ),
		'body_bg'    => array( 'title' => __( 'Body', 'maera' ),         'priority' => 15, 'panel' => 'backgrounds' ),
		'nav_bg'     => array( 'title' => __( 'Navbar', 'maera' ),       'priority' => 20, 'panel' => 'backgrounds' ),
		'header_bg'  => array( 'title' => __( 'Extra Header', 'maera' ), 'priority' => 25, 'panel' => 'backgrounds' ),
		'jumbo_bg'   => array( 'title' => __( 'Jumbotron', 'maera' ),    'priority' => 30, 'panel' => 'backgrounds' ),
		'footer_bg'  => array( 'title' => __( 'Footer', 'maera' ),       'priority' => 35, 'panel' => 'backgrounds' ),

		'colors' => array( 'title' => __( 'Colors', 'maera' ), 'priority' => 25, 'panel' => '' ),

		'typo_base'    => array( 'title' => __( 'Base', 'maera' ),         'priority' => 10, 'panel' => 'typography' ),
		'typo_headers' => array( 'title' => __( 'Headers', 'maera' ),      'priority' => 15, 'panel' => 'typography' ),
		'typo_nav'     => array( 'title' => __( 'Navbar', 'maera' ),       'priority' => 20, 'panel' => 'typography' ),
		'typo_header'  => array( 'title' => __( 'Extra Header', 'maera' ), 'priority' => 25, 'panel' => 'typography' ),
		'typo_jumbo'   => array( 'title' => __( 'Jumbotron', 'maera' ),    'priority' => 30, 'panel' => 'typography' ),
		'typo_footer'  => array( 'title' => __( 'Footer', 'maera' ),       'priority' => 35, 'panel' => 'typography' ),

		'blog_options' => array( 'title' => __( 'Blog Options', 'maera' ),    'priority' => 10, 'panel' => 'blog' ),
		'feat'         => array( 'title' => __( 'Featured Images', 'maera' ), 'priority' => 15, 'panel' => 'blog' ),

		'social' => array( 'title' => __( 'Social Links', 'maera' ), 'priority' => 45, 'panel' => '' ),
		'advanced' => array( 'title' => __( 'Advanced', 'maera' ), 'priority' => 50, 'panel' => '' ),
	);

	foreach ( $sections as $section => $args ) {

		$wp_customize->add_section( $section, array(
			'title'    => $args['title'],
			'priority' => $args['priority'],
			'panel'    => $args['panel']
		) );

	}

	foreach ( $panels as $panel => $args ) {
		$wp_customize->add_panel( $panel, array(
			'priority'       => $args['priority'],
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => $args['title'],
			'description'    => $args['description']
		) );
	}



}
add_action( 'customize_register', 'maera_customizer_sections' );

/*
 * Creates the array of options and controls for the customizer
 */
function maera_customizer_settings( $controls ) {

	//-------------------------------------------------
	// GENERAL
	//-------------------------------------------------

	$controls[] = array(
		'type'        => 'image',
		'setting'     => 'logo',
		'label'       => __( 'Logo', 'maera' ),
		'subtitle' => __( 'Upload your site\'s logo', 'maera' ),
		'section'     => 'branding',
		'priority'    => 10,
		'default'     => null
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'widgets_mode',
		'label'    => __( 'Widgets mode', 'maera' ),
		'subtitle' => __( 'How do you want your widgets to be displayed?', 'maera' ),
		'section'  => 'layout_advanced',
		'priority' => 13,
		'default'  => 2,
		'choices'  => array(
			'none'  => __( 'None', 'maera' ),
			'well'  => __( 'Well', 'maera' ),
			'panel' => __( 'Panel', 'maera' ),
		),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'font_size_units',
		'label'    => __( 'Font-size units', 'maera' ),
		'section'  => 'typo_base',
		'subtitle' => __( 'Choose if you want to set font sizes as pixels or ems. This will apply to all settings. Please note that if you change this setting you will have to save and refresh this page. Once you do, please review ALL your font-size settings and set them accordingly.', 'maera' ),
		'default'  => 'px',
		'choices'  => array(
			'px'   => 'Pixels',
			'rem'  => '(r)Ems',
		),
		'priority' => 18,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'wai_aria',
		'label'    => __( 'Enable accessibility scripts', 'maera' ),
		'section'  => 'advanced',
		'subtitle' => __( 'When enabled, paypal\'s bootstrap-accessibility plugin is loaded', 'maera' ),
		'default'  => 1,
		'priority' => 19,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'dev_mode',
		'label'    => __( 'Enable development mode', 'maera' ),
		'section'  => 'advanced',
		'subtitle' => __( 'When development mode is enabled, all theme caches are disabled (does not affect any caching plugins you may have installed).', 'maera' ),
		'default'  => 0,
		'priority' => 20,
	);


	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'caching_int',
		'label'    => __( 'Caching time', 'maera' ),
		'subtitle' => __( 'Set the time (in minutes) you want your pages cached. CAUTION: If you have any context dependent sub-views (eg. current user), this mode won\'t do. In that case, set this to 0.', 'maera' ),
		'section'  => 'advanced',
		'priority' => 30,
		'default'  => 0,
		'choices'  => array(
			'min'  => 0,
			'max'  => 1440,
			'step' => 1,
		),
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
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'site_style',
		'label'    => __( 'Site Style', 'maera' ),
		'subtitle' => __( 'Wide and boxed Layouts are responsive while fluid layouts are full-width.', 'maera' ),
		'section'  => 'layout',
		'priority' => 2,
		'default'  => 'wide',
		'choices'  => array(
			'wide'    => __( 'Wide', 'maera' ),
			'boxed'   => __( 'Boxed', 'maera' ),
			'fluid'   => __( 'Fluid', 'maera' ),
		),
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'image',
		'setting'  => 'layout',
		'label'    => __( 'Layout', 'maera' ),
		'subtitle' => __( 'Select your main layout. Please note that if no widgets are present in a sidebar then that sidebar will not be displayed. ', 'maera' ),
		'section'  => 'layout',
		'priority' => 3,
		'default'  => 1,
		'choices'  => $layouts,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'layout_primary_width',
		'label'    => __( 'Primary Sidebar Width', 'maera' ),
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
		'label'    => __( 'Secondary Sidebar Width', 'maera' ),
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
		'type'     => 'slider',
		'setting'  => 'screen_tablet',
		'label'    => __( 'Small Screen / Tablet view', 'maera' ),
		'subtitle' => __( 'The width of Tablet screens. Default: 768px', 'maera' ),
		'section'  => 'layout_advanced',
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
		'label'    => __( 'Desktop Container Width', 'maera' ),
		'subtitle' => __( 'The width of normal screens. Default: 992px', 'maera' ),
		'section'  => 'layout_advanced',
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
		'label'    => __( 'Large Desktop Container Width', 'maera' ),
		'subtitle' => __( 'The width of Large Desktop screens. Default: 1200px', 'maera' ),
		'section'  => 'layout_advanced',
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
		'label'    => __( 'Gutter', 'maera' ),
		'subtitle' => __( 'The spacing between grid columns. Default: 30px', 'maera' ),
		'section'  => 'layout_advanced',
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
		'label'    => __( 'Per Post-Type layouts', 'maera' ),
		'subtitle' => __( 'After you enable this setting you will have to save your settings and refresh your page in order to see the new options.', 'maera' ),
		'section'  => 'layout_advanced',
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
				'label'    => $post_type . ' ' . __( 'layout', 'maera' ),
				'description' => null,
				'section'  => 'layout_advanced',
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
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'navbar_toggle',
		'label'    => __( 'NavBar Type', 'maera' ),
		'subtitle' => __( 'Choose the type of Navbar you want. Off completely hides the navbar. <strong>WARNING:</strong> You will have to save the option and refresh this page to see the result.', 'maera' ),
		'section'  => 'nav',
		'default'  => 'normal',
		'choices'  => array(
			'none'   => __( 'None', 'maera' ),
			'normal' => __( 'Normal', 'maera' ),
			'full'   => __( 'Full-Width', 'maera' ),
		),
		'priority' => 21,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'navbar_position',
		'label'    => __( 'NavBar Positioning', 'maera' ),
		'description' => __( 'Using this option you can set the navbar to be fixed to top, fixed to bottom or normal. When you\'re using one of the \'fixed\' options, the navbar will stay fixed on the top or bottom of the page. Default: Normal', 'maera' ),
		'section'  => 'nav',
		'default'  => 'normal',
		'choices'  => array(
			'normal'        => __( 'Normal', 'maera' ),
			'fixed-top'     => __( 'Fixed (top)', 'maera' ),
			'fixed-bottom'  => __( 'Fixed (bottom)', 'maera' ),
			'after-headers' => __( 'After Extra Headers', 'maera' ),
			'left-slide'	=> __( 'Left Slide', 'maera' ),
			'right-slide'	=> __( 'Right Slide', 'maera' )
		),
		'priority' => 23,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'grid_float_breakpoint',
		'label'    => __( 'Responsive NavBar Threshold', 'maera' ),
		'subtitle' => __( 'Point at which the navbar becomes uncollapsed', 'maera' ),
		'section'  => 'nav',
		'default'  => 'screen_sm_min',
		'choices'  => array(
			'min'           => __( 'Never', 'maera' ),
			'screen_xs_min' => __( 'Extra Small', 'maera' ),
			'screen_sm_min' => __( 'Small', 'maera' ),
			'screen_md_min' => __( 'Desktop', 'maera' ),
			'screen_lg_min' => __( 'Large Desktop', 'maera' ),
			'max'           => __( 'Always', 'maera' ),
		),
		'priority' => 24,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'navbar_search',
		'label'    => __( 'Display search form on the NavBar', 'maera' ),
		'section'  => 'nav',
		'default'  => 1,
		'priority' => 26,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'navbar_nav_align',
		'label'    => __( 'Menus alignment', 'maera' ),
		'section'  => 'nav',
		'default'  => 'left',
		'choices'  => array(
			'left'   => __( 'Left', 'maera' ),
			'center' => __( 'Center', 'maera' ),
			'right'  => __( 'Right', 'maera' ),
		),
		'priority' => 27,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'navbar_bg',
		'label'    => __( 'NavBar Background Color', 'maera' ),
		'description' => __( 'Pick a background color for the NavBar. Default: #f8f8f8.', 'maera' ),
		'section'  => 'nav_bg',
		'default'  => '#f8f8f8',
		'priority' => 30,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'navbar_bg_opacity',
		'label'    => __( 'NavBar Background Opacity', 'maera' ),
		'section'  => 'nav_bg',
		'default'  => 100,
		'priority' => 31,
		'choices'  => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'navbar_height',
		'label'    => __( 'NavBar Height', 'maera' ),
		'subtitle' => __( 'Select the height of your navbars in pixels.', 'maera' ),
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
		'label'    => __( 'Menus font', 'maera' ),
		'section'  => 'typo_nav',
		'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'priority' => 40,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'font_menus_google',
		'label'    => __( 'Google-Font', 'maera' ),
		'description' => __( 'If you have entered the name of a google font above, then you must enable check this option to process it.', 'maera' ),
		'section'  => 'typo_nav',
		'default'  => 0,
		'priority' => 41,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_menus_weight',
		'subtitle' => __( 'Font Weight', 'maera' ),
		'section'  => 'typo_nav',
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
		'subtitle' => __( 'Font Size', 'maera' ),
		'section'  => 'typo_nav',
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
		'subtitle' => __( 'Line Height (px)', 'maera' ),
		'section'  => 'typo_nav',
		'default'  => 42,
		'priority' => 25,
		'choices'  => array(
			'min'  => 7,
			'max'  => 70,
			'step' => 1,
		),
	);

	//-------------------------------------------------
	// COLORS
	//-------------------------------------------------

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_primary',
		'label'    => __( 'Brand Colors: Primary', 'maera' ),
		'description' => __( 'Select your primary branding color. Also referred to as an accent color. This will affect various areas of your site, including the color of your primary buttons, link color, the background of some elements and many more.', 'maera' ),
		'section'  => 'colors',
		'default'  => '#428bca',
		'priority' => 1,
        'framework_var' => '@brand-primary'
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_info',
		'label'    => __( 'Brand Colors: Info', 'maera' ),
		'description' =>  __( 'Select your branding color for info messages etc. It will also be used for the Search button color as well as other areas where it semantically makes sense to use an \'info\' class.', 'maera' ),
		'section'  => 'colors',
		'default'  => '#5bc0de',
		'priority' => 2,
        'framework_var' => '@brand-info'
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_success',
		'label'    => __( 'Brand Colors: Success', 'maera' ),
		'description' =>  __( 'Select your branding color for success messages etc.', 'maera' ),
		'section'  => 'colors',
		'default'  => '#5cb85c',
		'priority' => 3,
        'framework_var' => '@brand-success'
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_warning',
		'label'    => __( 'Brand Colors: Warning', 'maera' ),
		'description' =>  __( 'Select your branding color for warning messages etc.', 'maera' ),
		'section'  => 'colors',
		'default'  => '#f0ad4e',
		'priority' => 4,
        'framework_var' => '@brand-warning'
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color_brand_danger',
		'label'    => __( 'Brand Colors: Danger', 'maera' ),
		'description' =>  __( 'Select your branding color for danger messages etc.', 'maera' ),
		'section'  => 'colors',
		'default'  => '#d9534f',
		'priority' => 5,
        'framework_var' => '@brand-danger'
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'gradients_toggle',
		'label'    => __( 'Enable Gradients', 'maera' ),
		'description' => __( 'Enable or disable gradients. These are applied to navbars, buttons and other elements. Please note that gradients will not be applied in the preview mode and can only be seen on the live site.', 'maera' ),
		'section'  => 'colors',
		'priority' => 10,
		'default'  => 0,
		'choices'  => array(
			0 => __( 'Flat', 'maera' ),
			1 => __( 'Gradients', 'maera' ),
		),
	);
	//-------------------------------------------------
	// BACKGROUND
	//-------------------------------------------------

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'html_bg',
		'label'        => __( 'General Background', 'maera' ),
		'section'      => 'html_bg',
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
	);

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'body_bg',
		'label'        => __( 'Body Background', 'maera' ),
		'section'      => 'body_bg',
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
	);

	//-------------------------------------------------
	// TYPOGRAPHY
	//-------------------------------------------------

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'font_base_family',
		'label'    => __( 'Base font', 'maera' ),
		'section'  => 'typo_base',
		'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'priority' => 20,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'font_base_google',
		'label'    => __( 'Google-Font', 'maera' ),
		'description' => __( 'If you have entered the name of a google font above, then you must enable check this option to process it.', 'maera' ),
		'section'  => 'typo_base',
		'default'  => 0,
		'priority' => 21,
	);

	$controls[] = array(
		'type'     => 'multicheck',
		'setting'  => 'font_base_google_subsets',
		'label'    => __( 'Google-Font subsets', 'maera' ),
		'description' => __( 'The subsets used from Google\'s API.', 'maera' ),
		'section'  => 'typo_base',
		'default'  => 'latin',
		'priority' => 22,
		'choices'  => array(
			'latin' 		=> __( 'Latin', 'maera' ),
			'latin-ext' 	=> __( 'Latin Ext.', 'maera' ),
			'greek' 		=> __( 'Greek', 'maera' ),
			'greek-ext' 	=> __( 'Greek Ext.', 'maera' ),
			'cyrillic' 		=> __( 'Cyrillic', 'maera' ),
			'cyrillic-ext' 	=> __( 'Cyrillic Ext.', 'maera' ),
			'vietnamese' 	=> __( 'Vietnamese', 'maera' ),
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_base_weight',
		'label'    => __( 'Base Font Weight', 'maera' ),
		'section'  => 'typo_base',
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
		'label'    => __( 'Base Font Size', 'maera' ),
		'section'  => 'typo_base',
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
		'label'    => __( 'Base Line Height', 'maera' ),
		'section'  => 'typo_base',
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
		'label'    => __( 'Font-Family', 'maera' ),
		'section'  => 'typo_headers',
		'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'priority' => 30,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'headers_font_google',
		'label'    => __( 'Google-Font', 'maera' ),
		'description' => __( 'If you have entered the name of a google font above, then you must enable check this option to process it.', 'maera' ),
		'section'  => 'typo_headers',
		'default'  => 0,
		'priority' => 31,
	);

	$controls[] = array(
		'type'     => 'multicheck',
		'setting'  => 'font_headers_google_subsets',
		'label'    => __( 'Google-Font subsets', 'maera' ),
		'description' => __( 'The subsets used from Google\'s API.', 'maera' ),
		'section'  => 'typo_headers',
		'default'  => 'latin',
		'priority' => 32,
		'choices'  => array(
			'latin' 		=> __( 'Latin', 'maera' ),
			'latin-ext' 	=> __( 'Latin Ext.', 'maera' ),
			'greek' 		=> __( 'Greek', 'maera' ),
			'greek-ext' 	=> __( 'Greek Ext.', 'maera' ),
			'cyrillic' 		=> __( 'Cyrillic', 'maera' ),
			'cyrillic-ext' 	=> __( 'Cyrillic Ext.', 'maera' ),
			'vietnamese' 	=> __( 'Vietnamese', 'maera' ),
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_headers_weight',
		'label'    => __( 'Font Weight.', 'maera' ) . ' ' . __( 'Default: ', 'maera' ) . 400,
		'section'  => 'typo_headers',
		'default'  => 400,
		'priority' => 34,
		'choices'  => array(
			'min'  => 100,
			'max'  => 900,
			'step' => 100,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_headers_size',
		'label'    => __( 'Font Size (%)', 'maera' ) . ' ' . __( 'Default: ', 'maera' ) . '215',
		'description' => __( 'The size defined here applies to H2. All other header elements are calculated porportionally.', 'maera' ),
		'section'  => 'typo_headers',
		'default'  => 215,
		'priority' => 35,
		'choices'  => array(
			'min'  => 30,
			'max'  => 350,
			'step' => 1,
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_headers_height',
		'label'    => __( 'Line Height', 'maera' ) . ' ' . __( 'Default: ', 'maera' ) . '1.1',
		'section'  => 'typo_headers',
		'default'  => 1.1,
		'priority' => 36,
		'choices'  => array(
			'min'  => 0,
			'max'  => 3,
			'step' => 0.1,
		),
	);

	//-------------------------------------------------
	// BLOG
	//-------------------------------------------------

	$controls[] = array(
		'type'        => 'radio',
		'mode'        => 'buttonset',
		'setting'     => 'blog_post_mode',
		'label'       => __( 'Archives Display Mode', 'maera' ),
		'description' => __( 'Display the excerpt or the full post on post archives.', 'maera' ),
		'section'     => 'blog_options',
		'priority'    => 1,
		'default'     => 'excerpt',
		'choices'     => array(
			'excerpt' => __( 'Excerpt', 'maera' ),
			'full'    => __( 'Full Post', 'maera' ),
		),
	);

	$controls[] = array(
		'type'        => 'text',
		'setting'     => 'maera_entry_meta_config',
		'label'       => __( 'Post Meta elements', 'maera' ),
		'subtitle'    => __( 'You can define a comma-separated list of meta elements you want on your posts, in the order that you want them. Accepted values: <code>author, sticky, post-format, date, category, tags, comments</code>', 'maera' ),
		'section'     => 'blog_options',
		'priority'    => 2,
		'default'     => 'post-format, date, author, comments',
	);

	$controls[] = array(
		'type'        => 'checkbox',
		'setting'     => 'breadcrumbs',
		'label'       => __( 'Show Breadcrumbs', 'maera' ),
		'section'     => 'blog_options',
		'priority'    => 3,
		'default'     => 0,
	);

	$controls[] = array(
		'type'        => 'radio',
		'mode'        => 'buttonset',
		'setting'     => 'date_meta_format',
		'label'       => __( 'Date format in meta', 'maera' ),
		'subtitle'    => __( 'Show the date as a normal date, or as time difference (example: 2 weeks ago)', 'maera' ),
		'section'     => 'blog_options',
		'priority'    => 9,
		'default'     => 1,
		'choices'     => array(
			0 => __( 'Date', 'maera' ),
			1 => __( 'Time Difference', 'maera' ),
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'post_excerpt_length',
		'label'    => __( 'Post excerpt length', 'maera' ),
		'description' => __( 'Choose how many words should be used for post excerpt. Default: 55', 'maera' ),
		'section'  => 'blog_options',
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
		'label'       => __( '"more" text', 'maera' ),
		'subtitle'    => __( 'Text to display in case of excerpt too long. Default: Continued', 'maera' ),
		'section'     => 'blog_options',
		'priority'    => 12,
		'default'     => __( 'Continued', 'maera' ),
	);

	//-------------------------------------------------
	// FEATURED IMAGES
	//-------------------------------------------------

	$controls[] = array(
		'type'        => 'checkbox',
		'setting'     => 'feat_img_archive',
		'label'       => __( 'Featured Images on Archives', 'maera' ),
		'description' => __( 'Display featured Images on post archives ( such as categories, tags, month view etc ).', 'maera' ),
		'section'     => 'feat',
		'priority'    => 50,
		'default'     => 0,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'feat_img_archive_width',
		'label'    => __( 'Archives Featured Image Width', 'maera' ),
		'subtitle' => __( 'Select the width of your featured images on post archives. Set to -1 for max width and 0 for original width. Default: -1', 'maera' ),
		'section'  => 'feat',
		'priority' => 52,
		'default'  => -1,
		'choices'  => array(
			'min'  => -1,
			'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'feat_img_archive_height',
		'label'    => __( 'Archives Featured Image Height', 'maera' ),
		'subtitle' => __( 'Select the height of your featured images on post archives. Set to 0 to resize the image using the original image proportions. Default: 0', 'maera' ),
		'section'  => 'feat',
		'priority' => 53,
		'default'  => 0,
		'choices'  => array(
			'min'  => 0,
			'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'        => 'checkbox',
		'setting'     => 'feat_img_post',
		'label'       => __( 'Featured Images on Posts', 'maera' ),
		'subtitle'    => __( 'Display featured Images on simgle posts.', 'maera' ),
		'section'     => 'feat',
		'priority'    => 60,
		'default'     => 0,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'feat_img_post_width',
		'label'    => __( 'Posts Featured Image Width', 'maera' ),
		'subtitle' => __( 'Select the width of your featured images on single posta. Set to -1 for max width and 0 for original width. Default: -1', 'maera' ),
		'section'  => 'feat',
		'priority' => 62,
		'default'  => -1,
		'choices'  => array(
			'min'  => -1,
			'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'feat_img_post_height',
		'label'    => __( 'Posts Featured Image Height', 'maera' ),
		'subtitle' => __( 'Select the height of your featured images on single posts. Set to 0 to use the original image proportions. Default: 0', 'maera' ),
		'section'  => 'feat',
		'priority' => 63,
		'default'  => 0,
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
		'label'       => __( 'Disable featured images per post type', 'maera' ),
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
		'label'        => __( 'Jumbotron Background', 'maera' ),
		'section'      => 'jumbo_bg',
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
		'type'     => 'checkbox',
		'setting'  => 'jumbotron_nocontainer',
		'label'    => __( 'Full-Width', 'maera' ),
		'description' => __( 'When selected, the Jumbotron is no longer restricted by the width of your page, taking over the full width of your screen. This option is useful when you have assigned a slider widget on the Jumbotron area and you want its width to be the maximum width of the screen. Default: OFF.', 'maera' ),
		'section'  => 'structure_jumbo',
		'default'  => 0,
		'priority' => 11,
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'font_jumbotron_font_family',
		'label'    => __( 'Jumbotron font', 'maera' ),
		'section'  => 'typo_jumbo',
		'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'priority' => 20,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'font_jumbotron_google',
		'label'    => __( 'Google-Font', 'maera' ),
		'description' => __( 'If you have entered the name of a google font above, then you must enable check this option to process it.', 'maera' ),
		'section'  => 'typo_jumbo',
		'default'  => 0,
		'priority' => 21,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'font_jumbotron_color',
		'description' =>   __( 'Font Color', 'maera' ),
		'section'  => 'typo_jumbo',
		'default'  => '#333333',
		'priority' => 22,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'font_jumbotron_weight',
		'subtitle' => __( 'Font Weight', 'maera' ),
		'section'  => 'typo_jumbo',
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
		'subtitle' => __( 'Font Size', 'maera' ),
		'section'  => 'typo_jumbo',
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
		'subtitle' => __( 'Line Height (px)', 'maera' ),
		'section'  => 'typo_jumbo',
		'default'  => 22,
		'priority' => 25,
		'choices'  => array(
			'min'  => 7,
			'max'  => 70,
			'step' => 1,
		),
	);
	//-------------------------------------------------
	// HEADER
	//-------------------------------------------------

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'header_bg',
		'label'        => __( 'Header Background', 'maera' ),
		'section'      => 'header_bg',
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
	);

	//-------------------------------------------------
	// SOCIAL
	//-------------------------------------------------

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'navbar_social',
		'label'    => __( 'Display social links in the NavBar.', 'maera' ),
		'subtitle' => __( 'Social network links can be set-up in the "Social" section.', 'maera' ),
		'section'  => 'social',
		'default'  => 'off',
		'choices'  => array(
			'off'      => __( 'Off', 'maera' ),
			'inline'   => __( 'Inline', 'maera' ),
			'dropdown' => __( 'Dropdown', 'maera' ),
		),
		'priority' => 1,
	);

	$social_links = array(
		'blogger'     => __( 'Blogger', 'maera' ),
		'deviantart'  => __( 'DeviantART', 'maera' ),
		'digg'        => __( 'Digg', 'maera' ),
		'dribbble'    => __( 'Dribbble', 'maera' ),
		'facebook'    => __( 'Facebook', 'maera' ),
		'flickr'      => __( 'Flickr', 'maera' ),
		'github'      => __( 'Github', 'maera' ),
		'googleplus'  => __( 'Google+', 'maera' ),
		'instagram'   => __( 'Instagram', 'maera' ),
		'linkedin'    => __( 'LinkedIn', 'maera' ),
		'myspace'     => __( 'MySpace', 'maera' ),
		'pinterest'   => __( 'Pinterest', 'maera' ),
		'reddit'      => __( 'Reddit', 'maera' ),
		'rss'         => __( 'RSS', 'maera' ),
		'skype'       => __( 'Skype', 'maera' ),
		'soundcloud'  => __( 'SoundCloud', 'maera' ),
		'tumblr'      => __( 'Tumblr', 'maera' ),
		'twitter'     => __( 'Twitter', 'maera' ),
		'vimeo'       => __( 'Vimeo', 'maera' ),
		'vkontakte'   => __( 'Vkontakte', 'maera' ),
		'youtube'     => __( 'YouTube', 'maera' ),
	);

	$i = 0;
	foreach ( $social_links as $social_link => $label ) {

		$controls[] = array(
			'type'     => 'text',
			'setting'  => $social_link . '_link',
			'label'    => $label . ' ' . __( 'link', 'maera' ),
			'section'  => 'social',
			'default'  => '',
			'priority' => 10 + $i,
		);

		$i++;

	}


	//-------------------------------------------------
	// FOOTER BACKGROUND
	//-------------------------------------------------

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'footer_bg',
		'label'        => __( 'Footer Background', 'maera' ),
		'section'      => 'footer_bg',
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
	);

	$controls[] = array(
		'type'     => 'textarea',
		'label'    => __( 'Footer Text', 'maera' ),
		'setting'  => 'footer_text',
		'default'  => '&copy; [year] [sitename]',
		'section'  => 'branding',
		'priority' => 12,
		'subtitle' => __( 'The text that will be displayed in your footer. You can use [year] and [sitename] and they will be replaced appropriately. Default: &copy; [year] [sitename]', 'maera' ),
	);

	//-------------------------------------------------
	// ADVANCED
	//-------------------------------------------------

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'retina_toggle',
		'label'    => __( 'Enable Retina mode', 'maera' ),
		'description' => __( 'When checked, your site\'s featured images will be retina ready. Requires images to be uploaded at 2x the typical size desired. (uses retina.js) Default: On', 'maera' ),
		'section'  => 'advanced',
		'priority' => 1,
		'default'  => 1,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'border_radius',
		'label'    => __( 'Border-Radius', 'maera' ),
		'description' => __( 'You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', 'maera' ),
		'section'  => 'general',
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
		'label'    => __( 'Padding Base', 'maera' ),
		'description' => __( 'You can adjust the padding base. This affects buttons size and lots of other cool stuff too! Default: 6', 'maera' ),
		'section'  => 'general',
		'priority' => 3,
		'default'  => 6,
		'choices'  => array(
			'min'  => 0,
			'max'  => 22,
			'step' => 1
		),
	);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'css',
		'label'    => __( 'Custom CSS', 'maera' ),
		'subtitle' => __( 'You can write your custom CSS here. This code will appear in a script tag appended in the header section of the page.', 'maera' ),
		'section'  => 'advanced',
		'priority' => 4,
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'less',
		'label'    => __( 'Custom LESS', 'maera' ),
		'subtitle' => __( 'You can write your custom LESS here. This code will be compiled with the other LESS files of the theme and be appended to the header.', 'maera' ),
		'section'  => 'advanced',
		'priority' => 5,
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'js',
		'label'    => __( 'Custom JS', 'maera' ),
		'subtitle' => __( 'You can write your custom JavaScript/jQuery here. The code will be included in a script tag appended to the bottom of the page.', 'maera' ),
		'section'  => 'advanced',
		'priority' => 6,
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'minimize_css',
		'label'    => __( 'Minimize CSS', 'maera' ),
		'description' => __( 'Minimize the generated CSS. This should be always be checked for production sites.', 'maera' ),
		'section'  => 'advanced',
		'priority' => 10,
		'default'  => 1,
	);

	global $extra_widget_areas;

	$i = 1;

	foreach ( $extra_widget_areas as $area => $settings ) {

		$controls[] = array(
			'type'     => 'select',
			'setting'  => $area . '_widgets_nr',
			'label'    => sprintf( __( 'Number of widge areas in %s', 'maera' ), $settings['name'] ),
			'section'  => 'widget_areas',
			'default'  => $settings['default'],
			'choices'  => array(
				0 => 0,
				1 => 1,
				2 => 2,
				3 => 3,
				4 => 4,
				6 => 6,
			),
			'priority' => $i,
		);

		$i++;
	}


	return $controls;
}
add_filter( 'kirki/controls', 'maera_customizer_settings' );

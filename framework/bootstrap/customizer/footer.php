<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_footer_customizer( $wp_customize ){

	$controls = array();

	// Create the "Footer" section
	$wp_customize->add_section( 'footer', array(
		'title' => __( 'Footer', 'shoestrap' ),
		'priority' => 9
	) );

}
add_action( 'customize_register', 'shoestrap_footer_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_footer_customizer_settings( $controls ){

	$controls[] = array(
		'type'         => 'background',
		'setting'      => 'footer_bg',
		'label'        => __( 'Footer Background', 'shoestrap' ),
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
		'priority' => 10,
		'output' => 'footer.page-footer',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'footer_color',
		'label'    => __( 'Footer Text Color', 'shoestrap' ),
		'description' => __( 'Select the text color for your footer. Default: #333333.', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => '#333333',
		'priority' => 10,
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

	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_footer_customizer_settings' );

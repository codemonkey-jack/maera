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
		'type'     => 'color',
		'setting'  => 'footer_bg_color',
		'label'    => __( 'Background', 'shoestrap' ),
		'description' =>   __( 'Background Color', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => '#ffffff',
		'priority' => 3,
	);

	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'footer_bg_image',
		'label'    => null,
		'description' =>   __( 'Background Image', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => '',
		'priority' => 4,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'footer_bg_repeat',
		'label'    => null,
		'subtitle' => __( 'Background Repeat', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => 'repeat',
		'choices'  => array(
			'no-repeat' => __( 'No Repeat', 'shoestrap' ),
			'repeat'    => __( 'Repeat All', 'shoestrap' ),
			'repeat-x'  => __( 'Repeat Horizontally', 'shoestrap' ),
			'repeat-y'  => __( 'Repeat Vertically', 'shoestrap' ),
			'inherit'   => __( 'Inherit', 'shoestrap' ),
		),
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'footer_bg_size',
		'label'    => null,
		'subtitle' =>  __( 'Background Size', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => 'inherit',
		'choices'  => array(
			'inherit' => __( 'Inherit', 'shoestrap' ),
			'cover'   => __( 'Cover', 'shoestrap' ),
			'contain' => __( 'Contain', 'shoestrap' ),
		),
		'priority' => 6,
	);

	$controls[] = array(
		'type'     => 'radio',
		'mode'     => 'buttonset',
		'setting'  => 'footer_bg_attach',
		'label'    => null,
		'subtitle' => __( 'Background Attachment', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => 'scroll',
		'choices'  => array(
			'inherit' => __( 'Inherit', 'shoestrap' ),
			'fixed'   => __( 'Fixed', 'shoestrap' ),
			'scroll' => __( 'Scroll', 'shoestrap' ),
		),
		'priority' => 7,
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'footer_bg_position',
		'label'    => null,
		'subtitle' =>   __( 'Background Position', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => 'center-center',
		'choices'  => array(
			'left-top'      => __( 'Left Top', 'shoestrap' ),
			'left-center'   => __( 'Left Center', 'shoestrap' ),
			'left-bottom'   => __( 'Left Bottom', 'shoestrap' ),
			'right-top'     => __( 'Right Top', 'shoestrap' ),
			'right-center'  => __( 'Right Center', 'shoestrap' ),
			'right-bottom'  => __( 'Right Bottom', 'shoestrap' ),
			'center-top'    => __( 'Center Top', 'shoestrap' ),
			'center-center' => __( 'Center Center', 'shoestrap' ),
			'center-bottom' => __( 'Center Bottom', 'shoestrap' ),
		),
		'priority' => 8,
		'separator' => true,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'footer_bg_opacity',
		'label'    => __( 'Footer Background Opacity', 'shoestrap' ),
		'section'  => 'footer',
		'default'  => 100,
		'priority' => 9,
		'choices'  => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
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

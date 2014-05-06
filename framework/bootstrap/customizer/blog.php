<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_blog_customizer( $wp_customize ){

	$controls = array();

	// Create the "Layout" section
	$wp_customize->add_section( 'blog', array(
		'title' => __( 'Blog', 'shoestrap' ),
		'priority' => 10
	) );

}
add_action( 'customize_register', 'shoestrap_blog_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_blog_customizer_settings( $controls ){

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

	return $controls;
}
add_filter( 'shoestrap/customizer/controls', 'shoestrap_blog_customizer_settings' );

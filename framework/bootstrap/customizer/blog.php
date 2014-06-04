<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_blog_customizer( $wp_customize ){

	$controls = array();

	// Create the "Blog" section
	$wp_customize->add_section( 'blog', array(
		'title' => __( 'Blog', 'shoestrap' ),
		'priority' => 6
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

	$controls[] = array(
		'type'        => 'checkbox',
		'setting'     => 'feat_img_archive',
		'label'       => __( 'Featured Images on Archives', 'shoestrap' ),
		'description' => __( 'Display featured Images on post archives ( such as categories, tags, month view etc ).', 'shoestrap' ),
		'section'     => 'blog',
		'priority'    => 50,
		'default'     => 0,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'feat_img_archive_width',
		'label'    => __( 'Archives Featured Image Custom Width', 'shoestrap' ),
		'description' => __( 'Select the width of your featured images on post archives. Default: -1', 'shoestrap' ) . '<strong>' . __( 'Set to -1 for full-width', 'shoestrap' ) . '</strong>',
		'section'  => 'blog',
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
		'label'    => __( 'Archives Featured Image Custom Height', 'shoestrap' ),
		'description' => __( 'Select the height of your featured images on post archives. Default: 300px', 'shoestrap' ),
		'section'  => 'blog',
		'priority' => 53,
		'default'  => 300,
		'choices'  => array(
			'min'  => 50,
			'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
			'step' => '1'
		),
	);

	$controls[] = array(
		'type'        => 'checkbox',
		'setting'     => 'feat_img_post',
		'label'       => __( 'Featured Images on Posts', 'shoestrap' ),
		'subtitle'    => __( 'Display featured Images on simgle posts.', 'shoestrap' ),
		'section'     => 'blog',
		'priority'    => 60,
		'default'     => 0,
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'feat_img_post_width',
		'label'    => __( 'Posts Featured Image Custom Width', 'shoestrap' ),
		'description' => __( 'Select the width of your featured images on single posts. Default: -1', 'shoestrap' ) . '<strong>' . __( 'Set to -1 for full-width', 'shoestrap' ) . '</strong>',
		'section'  => 'blog',
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
		'label'    => __( 'Posts Featured Image Custom Height', 'shoestrap' ),
		'description' => __( 'Select the height of your featured images on single posts. Default: 300px', 'shoestrap' ),
		'section'  => 'blog',
		'priority' => 63,
		'default'  => 300,
		'choices'  => array(
			'min'  => 50,
			'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
			'step' => '1'
		),
	);

	$post_types = get_post_types( array( 'public' => true ), 'names' );
	$controls[] = array(
		'type'        => 'multicheck',
		'mode'        => 'checkbox',
		'setting'     => 'feat_img_per_post_type',
		'label'       => __( 'Disable featured images on single post types', 'shoestrap' ),
		'section'     => 'blog',
		'priority'    => 65,
		'default'     => '',
		'choices'     => $post_types,
	);

	return $controls;

}
add_filter( 'kirki/controls', 'shoestrap_blog_customizer_settings' );

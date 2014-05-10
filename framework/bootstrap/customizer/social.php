<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_social_customizer( $wp_customize ){

	$controls = array();

	// Create the "Social" section
	$wp_customize->add_section( 'social', array(
		'title' => __( 'Social', 'shoestrap' ),
		'priority' => 12
	) );

}
add_action( 'customize_register', 'shoestrap_social_customizer' );

/*
 * Creates the array of options and controls for the customizer
 */
function shoestrap_social_customizer_settings( $controls ){

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


	return $controls;
}
add_filter( 'kirki/controls', 'shoestrap_social_customizer_settings' );

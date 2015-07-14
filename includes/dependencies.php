<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/tgmpa.php';


function maera__register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     => 'Timber Library',
			'slug'     => 'timber-library',
			'required' => true,
		),
		array(
			'name'     => 'Kirki Toolkit',
			'slug'     => 'kirki',
			'required' => true,
		),
		array(
			'name'     => 'Jetpack',
			'slug'     => 'jetpack',
			'required' => true,
		),
	);

	$config = array(
		'id'           => 'maera-tgmpa',
		'menu'         => 'maera-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => false,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'maera__register_required_plugins' );

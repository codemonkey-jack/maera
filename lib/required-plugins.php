<?php

/**
 * Build the array of required plugins.
 * You can use the 'maera/required_plugins' filter to add or remove plugins.
 */
function maera_required_plugins() {

	$plugins = array();

	$plugins[] = array(
		'name' => 'Timber',
		'file' => 'timber.php',
		'slug' => 'timber-library',
	);

	$plugins[] = array(
		'name' => 'Jetpack',
		'file' => 'jetpack.php',
		'slug' => 'jetpack',
	);

	$plugins[] = array(
		'name' => 'Kirki',
		'file' => 'kirki.php',
		'slug' => 'kirki',
	);

	if ( current_theme_supports( 'breadcrumbs' ) ) {
		$plugins[] = array(
			'name' => 'Breadcrumb Trail',
			'file' => 'breadcrumb-trail.php',
			'slug' => 'breadcrumb-trail',
		);
	}

	if ( current_theme_supports( 'less_compiler' ) || current_theme_supports( 'sass_compiler' ) ) {
		$plugins[] = array(
			'name' => 'Less & scss compilers',
			'file' => 'less-plugin.php',
			'slug' => 'lessphp',
		);
	}

	return apply_filters( 'maera/required_plugins', $plugins );

}


add_action( 'admin_notices', 'maera_required_plugins_notices' );
/**
 * Add the admin notices for the required plugins
 */
function maera_required_plugins_notices() {

	$plugin_messages = array();

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$plugins = maera_required_plugins();

	foreach ( $plugins as $plugin ) {
		$install_link = '<a href="' . esc_url( network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin['slug'] . '&TB_iframe=true&width=600&height=550' ) ) . '" class="thickbox" title="More info about ' . $plugin['name'] . '">Install and activate ' . $plugin['name'] . '</a>';
		if ( ! is_plugin_active( $plugin['slug'] . '/' . $plugin['file'] ) ) {
			$plugin_url  = 'https://wordpress.org/plugins/' . $plugin['slug'] . '/';
			$install_url = self_admin_url( 'update.php?action=install-plugin&plugin=' . $plugin['slug'] . '&_wpnonce=install-plugin_' . $plugin['slug'] );
			$plugin_messages[] = 'This theme requires you to install and activate the ' . $plugin['name'] . ' plugin, ' . $install_link . '.';
		}
	}

	if ( 0 < count( $plugin_messages ) ) {
		echo '<div id="message" class="error">';

		foreach( $plugin_messages as $message ) {
			echo '<p><strong>' . $message . '</strong></p>';
		}

		echo '</div>';
	}

}

<?php

class Maera_Required_Plugins {

	private $plugins;

	function __construct( $plugins = array() ) {

		$this->plugins = $plugins;

		add_action( 'admin_notices', array( $this, 'required_plugins_notices' ) );
		add_action( 'wp', array( $this, 'auto_activate_plugins' ) );
		add_action( 'switch_theme', array( $this, 'auto_deactivate_plugins' ) );

	}

	/**
	 * Add the admin notices for the required plugins
	 */
	function required_plugins_notices() {

		$plugin_messages = array();

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		foreach ( $this->plugins as $plugin ) {
			$install_link = '<a href="' . esc_url( network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin['slug'] . '&TB_iframe=true&width=600&height=550' ) ) . '" class="thickbox" title="More info about ' . $plugin['name'] . '">Install and activate ' . $plugin['name'] . '</a>';
			if ( ! is_plugin_active( $plugin['slug'] . '/' . $plugin['file'] ) ) {
				$plugin_url  = 'https://wordpress.org/plugins/' . $plugin['slug'] . '/';
				$install_url = self_admin_url( 'update.php?action=install-plugin&plugin=' . $plugin['slug'] . '&_wpnonce=install-plugin_' . $plugin['slug'] );
				$plugin_messages[] = 'This theme requires you to install and activate the ' . $plugin['name'] . ' plugin, ' . $install_link . '.';
			}
		}

		if ( 0 < count( $plugin_messages ) ) {
			echo '<div id="message" class="error maera-required-plugins">';

			foreach( $plugin_messages as $message ) {
				echo '<p>' . $message . '</p>';
			}

			echo '</div>';
		}

	}

	/**
	 * Automaticaly activate required plugins
	 */
	function auto_activate_plugins() {

		foreach ( $this->plugins as $plugin ) {
			if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin['slug'] . '/' . $plugin['file'] ) ) {
				activate_plugin( $plugin['slug'] . '/' . $plugin['file'] );
			}
		}

	}

	/**
	 * Automaticaly activate required plugins
	 */
	function auto_deactivate_plugins() {

		$required_plugins = array();
		$ignore_plugins   = array(
			'jetpack',
			'breadcrumb-trail'
		);
		foreach ( $this->plugins as $plugin ) {
			if ( ! in_array( $plugin['slug'], $ignore_plugins ) ) {
				$required_plugins[] = $plugin['slug'] . '/' . $plugin['file'];
			}
		}

		deactivate_plugins( $required_plugins );

	}

}

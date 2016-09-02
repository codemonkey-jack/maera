<?php

class Maera_Required_Plugins {

	private $plugins;

	function __construct( $plugins = array() ) {

		$this->plugins = $plugins;

		add_action( 'admin_notices', array( $this, 'required_plugins_notices' ) );

		add_filter( 'maera/plugins/required', array( $this, 'add_filter' ) );

	}

	function add_filter( $required_plugins ) {
		return array_merge( $required_plugins, $this->plugins );
	}

	/**
	 * Test if all required plugins are active or not.
	 * If they are not, returns true;
	 */
	public function test_missing() {

		$plugins = apply_filters( 'maera/plugins/required', array() );
		$status  = get_transient( 'maera_required_plugins_status' );

		// If the transient exists and is set to 'ok' then no need to proceed.
		if ( false === $status && 'ok' == $status ) {
			return 'ok';
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		foreach ( $plugins as $plugin ) {
			if ( ! is_plugin_active( $plugin['slug'] . '/' . $plugin['file'] ) ) {
				return 'bad';
			}
		}

		// If we're good to go, set the transient value to 'ok' for 2 minutes
		set_transient( 'maera_required_plugins_status', 'ok', 60 * 2 );

		return 'ok';

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

}

<?php

/*
Plugin Name: EDD - Remote Installer Client
Plugin URL: http://press.codes
Description: Allows remote installation of WordPress plugins and themes
Version: 1.0
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'EDD_RI_PLUGIN_URL' ) ) {
	define( 'EDD_RI_PLUGIN_URL', get_template_directory_uri() . '/lib/admin/remote-installer' );
}

include( dirname( __FILE__ ) . '/includes/class-Maera_EDD_RI_Client.php' );
$remote_installer = new Maera_EDD_RI_Client( 'http://press.codes' );

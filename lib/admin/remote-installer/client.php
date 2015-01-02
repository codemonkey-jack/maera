<?php

/*
Plugin Name: EDD - Remote Installer Client
Plugin URL: http://press.codes
Description: Allows remote installation of WordPress plugins and themes
Version: 1.0-alpha1
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'EDD_RI_PLUGIN_URL' ) ) {
	define( 'EDD_RI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! class_exists( 'EDD_RI_Client' ) ) {
	include( dirname( __FILE__ ) . '/includes/class-EDD_RI_Client.php' );
}

new EDD_RI_Client( 'http://press.codes' );

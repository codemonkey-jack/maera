<?php
/*
Plugin Name:         Maera Bootstrap Framework
Plugin URI:
Description:         Add the bootstrap framework to the Maera theme
Version:             1.0-beta1
Author:              Aristeides Stathopoulos, Dimitris Kalliris
Author URI:          http://wpmu.io
*/

define( 'MAERA_BOOTSTRAP_FRAMEWORK_URL', plugins_url( '', __FILE__ ) );
define( 'MAERA_BOOTSTRAP_FRAMEWORK_PATH', dirname( __FILE__ ) );

// Include the compiler class
require_once MAERA_BOOTSTRAP_FRAMEWORK_PATH . '/class-Maera_Bootstrap.php';

/**
 * Include the framework
 */
function maera_framework_bootstrap_include( $frameworks ) {

	// Add our framework to the array of available frameworks
	$frameworks[] = array(
		'value' => 'bootstrap',
		'label' => 'Bootstrap',
		'class' => 'Maera_Bootstrap',
	);

	return $frameworks;

}
add_filter( 'maera/frameworks/available', 'maera_framework_bootstrap_include' );

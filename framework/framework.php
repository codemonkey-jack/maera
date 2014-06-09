<?php

// Include the compiler class
require_once locate_template( '/lib/compilers/class-Shoestrap_Compiler.php' );

// Include the Core framework
require_once locate_template( '/framework/core/class-SS_Framework_Core.php' );

// Include Bootstrap
require_once locate_template( '/framework/bootstrap/class-SS_Framework_Bootstrap.php' );


/**
 * Activate the enabled framework
 */


// Get the option from the database
$options = get_option( 'shoestrap_admin_options', 'bootstrap' );

$active_framework = ( isset( $options['framework'] ) ) ? $options['framework'] : 'bootstrap';
$active_framework = ( empty( $active_framework ) || '' == $active_framework ) ? 'bootstrap' : $active_framework;

// Get the list of available frameworks
$available_frameworks = apply_filters( 'shoestrap/frameworks/available', array() );

// Figure out the enabled framework
foreach ( $available_frameworks as $available_framework ) {

	if ( $active_framework == $available_framework['value'] ) {
		// Instantianate the active framework
		global $ss_framework;
		$ss_framework = $available_framework['class']::get_instance();
	}

}

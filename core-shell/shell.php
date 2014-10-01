<?php

// Include the compiler class
require_once locate_template( '/lib/compilers/class-Maera_Compiler.php' );

// Include the Core shell
require_once locate_template( '/core-shell/core/class-Maera_Shell_Core.php' );

/**
 * Activate the enabled shell
 */


// Get the option from the database
$options = get_option( 'maera_admin_options', 'bootstrap' );

$active_shell = ( isset( $options['shell'] ) ) ? $options['shell'] : 'core';
$active_shell = ( empty( $active_shell ) || '' == $active_shell ) ? 'core' : $active_shell;

// Get the list of available shells
$available_shells = apply_filters( 'maera/shells/available', array() );

// Figure out the enabled shell
foreach ( $available_shells as $available_shell ) {

	if ( $active_shell == $available_shell['value'] ) {
		// Instantianate the active shell
		global $ss_shell;
		$ss_shell = $available_shell['class']::get_instance();
	}

}

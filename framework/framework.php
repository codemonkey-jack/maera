<?php

// Include the compiler class
require_once locate_template( '/lib/compilers/class-Shoestrap_Compiler.php' );

// Include the Core framework
require_once locate_template( '/framework/core/class-SS_Framework_Core.php' );

// Include Bootstrap
require_once locate_template( '/framework/bootstrap/class-SS_Framework_Bootstrap.php' );

// Load the appropriate framework
$framework = get_theme_mod( 'active_framework', 'bootstrap' );

global $ss_framework;

if ( 'bootstrap' == $framework ) {
	$ss_framework = SS_Framework_Bootstrap::get_instance();
} else if ( 'core' == $framework ) {
	$ss_framework = SS_Framework_Core::get_instance();
}

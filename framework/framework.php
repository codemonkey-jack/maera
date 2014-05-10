<?php

if ( ! defined( 'SS_FRAMEWORK' ) ) {
	define( 'SS_FRAMEWORK', 'bootstrap' );
}

// Include the compiler class
require_once locate_template( '/lib/compilers/class-Shoestrap_Compiler.php' );

// Require the Core Framework class
require_once locate_template( '/framework/class-SS_Framework_Core.php' );

// Get the active framework
global $ss_active_framework;
if ( ! isset( $ss_active_framework ) || null == $ss_active_framework ) {
	require_once locate_template( '/framework/bootstrap/framework.php' );
}

global $ss_framework;
$framework_class = $ss_active_framework['classname'];
$ss_framework = $framework_class::get_instance();

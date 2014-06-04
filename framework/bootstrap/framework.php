<?php

global $ss_active_framework;
$ss_active_framework = array(
	'shortname' => 'bootstrap',
	'name'      => 'Bootstrap',
	'classname' => 'SS_Framework_Bootstrap',
	'compiler'  => 'less_php',
);

// Include the framework class
include_once( dirname( __FILE__ ) . '/class-SS_Framework_Bootstrap.php' );

if ( 'bootstrap' == SS_FRAMEWORK ) {
	define( 'SS_FRAMEWORK_PATH', dirname( __FILE__ ) );
}

include_once( SS_FRAMEWORK_PATH . '/functions/layout.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/logo.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/widgets.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/footer.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/variables.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/typography.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/colors.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/blog.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/jumbotron.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/header.php' );

include_once( SS_FRAMEWORK_PATH . '/customizer.php' );

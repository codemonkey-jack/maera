<?php

global $ss_settings, $wp_customize;

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

include_once( SS_FRAMEWORK_PATH . '/classes/class-Shoestrap_Breadcrumbs.php' );

include_once( SS_FRAMEWORK_PATH . '/functions/layout.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/logo.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/widgets.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/footer.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/variables.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/background.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/colors.php' );
include_once( SS_FRAMEWORK_PATH . '/functions/blog.php' );

if ( isset( $wp_customize ) ) {
	include_once( SS_FRAMEWORK_PATH . '/customizer/general.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/colors.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/background.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/layout.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/blog.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/jumbotron.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/menus.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/header.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/footer.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/typography.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/social.php' );
	include_once( SS_FRAMEWORK_PATH . '/customizer/advanced.php' );
}

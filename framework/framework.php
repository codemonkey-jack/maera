<?php

if ( ! class_exists( 'TimberCore' ) ) {
	exit('Please install the <a href="http://wordpress.org/plugins/timber-library/">Timber</a> plugin.');
}

if ( ! defined( 'SS_FRAMEWORK' ) ) {
	define( 'SS_FRAMEWORK', 'bootstrap' );
}

// Require the Core Framework class
require_once locate_template( '/framework/class-SS_Framework_Core.php' );

// Get the active framework
global $ss_active_framework;
if ( ! isset( $ss_active_framework ) || null == $ss_active_framework ) {
	require_once locate_template( '/framework/bootstrap/framework.php' );
}

// Get instance of framework object
global $ss_framework;
$framework_class = $ss_active_framework['classname'];
$ss_framework = $framework_class::get_instance();

// Add the framework object to global timber context
add_filter('timber_context','add_to_context');
function add_to_context($data) {
  global $ss_framework;
  $data['framework'] = $ss_framework;
  return $data;
}

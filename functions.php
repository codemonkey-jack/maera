<?php

require_once locate_template( '/lib/widgets.php' );      // Sidebars and widgets

require_once locate_template( '/framework/framework.php' );

Timber::$locations = array(
	SS_FRAMEWORK_PATH . '/macros',
	SS_FRAMEWORK_PATH,
	get_stylesheet_directory() . '/views',
	get_template_directory() . '/views'
);

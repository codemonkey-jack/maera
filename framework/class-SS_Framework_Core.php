<?php

/**
* The Framework
*/
class SS_Framework_Core {

	private static $instance;

	private function __construct() {
		do_action( 'shoestrap/framework/include_modules' );
	}

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}

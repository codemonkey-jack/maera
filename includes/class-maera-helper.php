<?php

class Maera_Helper {

	/**
	 * Check if a constand is already defined, and if not then give it a value
	 */
	public static function define( $define, $value ) {
		if ( ! defined( $define ) ) {
			define( $define, $value );
		}
	}

}

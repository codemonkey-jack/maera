<?php

if ( ! class_exists( 'SS_Framework_Bootstrap' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class SS_Framework_Bootstrap extends SS_Framework_Core {

		private static $instance;

		/**
		 * Class constructor
		 */
		public function __construct() {

			if ( ! defined( 'SS_FRAMEWORK_PATH' ) ) {
				define( 'SS_FRAMEWORK_PATH', dirname( __FILE__ ) );
			}

		}

		/**
		 * Singleton
		 */
		public static function get_instance() {
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
		/*
		 * Calculates the classes of the main area, main sidebar and secondary sidebar
		 */
		function shoestrap_section_class( $target, $echo = false ) {
			global $redux, $ss_framework;
			// Disable the wrapper by default
			$wrapper = NULL;

			if ( shoestrap_display_primary_sidebar() ) {
				// Both sidebars are displayed
				if ( shoestrap_display_secondary_sidebar() ) {

					if ( is_page_template( 'template-5.php' ) ) {

						$main    = 'col-md-8';
						$primary = 'col-md-4';

					} else {

						$main    = 'col-md-7';
						$primary = 'col-md-3';

					}

					$secondary = 'col-md-2';

					if ( is_page_template( 'template-5.php' ) ) {

						$wrapper = 'col-md-10';

					} else {

						$wrapper = NULL;

					}

				// Only the primary sidebar is displayed
				} else {

					$main    = 'col-md-8';
					$primary = 'col-md-4';

				}
			} else {
				// Only the secondary sidebar is displayed
				if ( shoestrap_display_secondary_sidebar() ) {

					$main      = 'col-md-8';
					$secondary = 'col-md-4';

				} else {

					// No sidebars displayed
					$main = 'col-md-12';

				}
			}

			// Add floats where needed.
			if ( is_page_template( 'template-2.php' ) || is_page_template( 'template-3.php' ) ) {

				$main .= ' pull-right';

			}

			if ( $target == 'primary' ) {

				$class = $primary;

			} elseif ( $target == 'secondary' ) {

				$class = $secondary;

			} elseif ( $target == 'wrapper' ) {

				$class = $wrapper;

			} else {

				$class = $main;

			}

			if ( is_array( $class ) ) {

				$class = implode( ' ', $class );

			}

			// echo or return the result.
			if ( $echo ) {
				echo $class;
			} else {
				return $class;
			}
		}
	}
}

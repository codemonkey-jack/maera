<?php

if ( ! class_exists( 'SS_Framework_Bootstrap' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class SS_Framework_Bootstrap extends SS_Framework_Core {

		private static $instance;

		var $defines = array(
			// Generic framework definitions
			'shortname' => 'bootstrap',
			'name'      => 'Bootstrap',
			'classname' => 'SS_Framework_Bootstrap',
			'compiler'  => 'less_php',

			// Layout
			'container'  => 'container',
			'row'        => 'row',
			'col-mobile' => 'col-xs',
			'col-tablet' => 'col-sm',
			'col-medium' => 'col-md',
			'col-large'  => 'col-lg',

			// Buttons
			'button'         => 'btn',
			'button-default' => 'btn-default',
			'button-primary' => 'btn-primary',
			'button-success' => 'btn-success',
			'button-info'    => 'btn-info',
			'button-warning' => 'btn-warning',
			'button-danger'  => 'btn-danger',
			'button-link'    => 'btn-link',

			'button-extra-small' => 'btn-xs',
			'button-small'       => 'btn-sm',
			'button-medium'      => null,
			'button-large'       => 'btn-lg',
			'button-extra-large' => 'btn-lg',

			'button-block'    => 'btn-block',
			'button-radius'   => null,
			'button-round'    => null,

			// Button-Groups
			'button-group'             => 'btn-group',
			'button-group-extra-small' => 'btn-group-xs',
			'button-group-small'       => 'btn-group-sm',
			'button-group-default'     => null,
			'button-group-large'       => 'btn-group-lg',
			'button-group-extra-large' => 'btn-group-lg',

			// Alerts
			'alert'         => 'alert',
			'alert-success' => 'alert-success',
			'alert-info'    => 'alert-info',
			'alert-warning' => 'alert-warning',
			'alert-danger'  => 'alert-danger',

			// Miscelaneous
			'clearfix' => '<div class="clearfix"></div>',

			// Forms
			'form-input' => 'form-control',
		);

		/**
		 * Class constructor
		 */
		public function __construct() {
			global $ss_settings;

			if ( ! defined( 'SS_FRAMEWORK_PATH' ) ) {
				define( 'SS_FRAMEWORK_PATH', dirname( __FILE__ ) );
			}

			add_filter( 'shoestrap_compiler', array( $this, 'styles_filter' ) );

			if ( isset( $ss_settings['navbar_social'] ) && $ss_settings['navbar_social'] == 1 ) {
				if ( $ss_settings['navbar_social_style'] == 1 ) {
					add_action( 'shoestrap_inside_nav_end', array( $this, 'navbar_social_bar' ) );
				} else {
					add_action( 'shoestrap_inside_nav_end', array( $this, 'navbar_social_links' ) );
				}
			}

			if ( isset( $ss_settings['retina_toggle'] ) && $ss_settings['retina_toggle'] ) {
				add_theme_support( 'retina' );
			}

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 110 );
			add_filter( 'nav_menu_css_class', array( $this, 'nav_menu_css_class' ), 10, 2 );
			add_filter( 'nav_menu_item_id',   '__return_null' );

			add_action( 'shoestrap_pre_wrap', array( $this, 'breadcrumbs' ), 99 );
			add_filter( 'wp_nav_menu_args',   array( $this, 'nav_menu_args' ) );
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

		/**
		 * Enqueue scripts and stylesheets
		 */
		function enqueue_scripts() {
			wp_register_script( 'bootstrap-min', get_template_directory_uri() . '/framework/bootstrap/assets/js/bootstrap.min.js',              false, null, true  );
			wp_enqueue_script( 'bootstrap-min' );
		}

		/**
		 * Column classes
		 */
		public function column_classes( $sizes = array(), $return = 'array' ) {
			$classes = array();

			// Get the classes based on the $sizes array.
			foreach ( $sizes as $size => $columns ) {
				$classes[] = $this->defines['col-' . $size] . '-' . $columns;
			}

			if ( $return == 'array' ) {
				return $classes;
			} else {
				return implode( ' ', $classes );
			}

		}

		public function make_dropdown_button( $color = 'primary', $size = 'medium', $type = null, $extra = null, $label = '', $content = '' ) {
			global $ss_framework;

			$return = '<div class="btn-group">';
				$return .= '<button type="button" class="' . $ss_framework->button_classes( $color, $size, $type, 'dropdown-toggle' ) . '" data-toggle="dropdown">';
					$return .= $label . ' <span class="caret"></span>';
				$return .= '</button>';
				$return .= '<ul class="dropdown-menu" role="menu">' . $content . '</ul>';
			$return .= '</div>';

			return $return;
		}

		public function button_group_classes( $size = 'default', $type = null, $extra_classes = null ) {

			$classes = array();

			$classes[] = $this->defines['button-group'];

			// Get the proper class for button sizing from the framework definitions.
			if ( $size == 'extra-small' ) {
				$classes[] = $this->defines['button-group-extra-small'];
			} elseif ( $size == 'small' ) {
				$classes[] = $this->defines['button-group-small'];
			} elseif ( $size == 'medium' ) {
				$classes[] = $this->defines['button-group-medium'];
			} elseif ( $size == 'large' ) {
				$classes[] = $this->defines['button-group-large'];
			} elseif ( $size == 'extra-large' ) {
				$classes[] = $this->defines['button-group-extra-large'];
			}

			if ( ! is_null( $extra_classes ) ) {
				$extras = explode( ' ', $extra_classes );

				foreach ( $extras as $extra ) {
					$classes[] = $extra;
				}
			}

			if ( ! is_null( $type ) ) {
				$types = explode( ' ', $type );

				foreach ( $types as $type ) {
					$classes[] = $type;
				}
			}
			$classes = implode( ' ', $classes );

			return $classes;
		}

		/**
		 * The framework's alert boxes.
		 */
		public function alert( $type = 'info', $content = '', $id = null, $extra_classes = null, $dismiss = false ) {
			$classes = array();

			$classes[] = $this->defines['alert'];
			$classes[] = $this->defines['alert-' . $type];

			if ( true == $dismiss ) {
				$classes[] = 'alert-dismissable';

				$dismiss = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			} else {
				$dismiss = null;
			}

			if ( ! is_null( $extra_classes ) ) {
				$extras = explode( ' ', $extra_classes );

				foreach ( $extras as $extra ) {
					$classes[] = $extra;
				}
			}

			// If an ID has been defined, format it properly.
			if ( ! is_null( $id ) ) {
				$id = ' id="' . $id . '"';
			}

			$classes = implode( ' ', $classes );

			return '<div class="' . $classes . '"' . $id . '>' . $dismiss . $content . '</div>';
		}

		public function make_panel( $extra_classes = null, $id = null  ) {

			$classes = array();

			if ( ! is_null( $extra_classes ) ) {
				$extras = explode( ' ', $extra_classes );

				foreach ( $extras as $extra ) {
					$classes[] = $extra;
				}
				$classes = ' ' . implode( ' ', $classes );
			} else {
				$classes = null;
			}

			// If an ID has been defined, format it properly.
			if ( ! is_null( $id ) ) {
				$id = ' id="' . $id . '"';
			}

			return '<div class="panel panel-default' . $classes . '"' . $id . '>';
		}

		public function panel_classes() {
			return 'panel panel-default';
		}

		/**
		 * The inline icon links for social networks.
		 */
		public function navbar_social_bar() {
			global $ss_social;

			// Get all the social networks the user is using
			$networks = $ss_social->get_social_links();

			// The base class for icons that will be used
			$baseclass  = 'icon el-icon-';

			// Build the content
			$content = '';
			$content .= '<div id="navbar_social_bar">';

			// populate the networks
			foreach ( $networks as $network ) {
				if ( strlen( $network['url'] ) > 7 ) {
					// add the $show variable to check if the user has actually entered a url in any of the available networks
					$show     = true;
					$content .= '<a class="btn btn-link navbar-btn" href="' . $network['url'] . '" target="_blank" title="'. $network['icon'] .'">';
					$content .= '<i class="' . $baseclass . $network['icon'] . '"></i> ';
					$content .= '</a>';
				}
			}
			$content .= '</div>';

			echo ( $networks ) ? $content : '';
		}

		/**
		 * Build the social links for the navbar
		 */
		public function navbar_social_links() {
			global $ss_social;

			// Get all the social networks the user is using
			$networks = $ss_social->get_social_links();

			// The base class for icons that will be used
			$baseclass  = 'el-icon-';

			// Build the content
			$content = '';
			$content .= '<ul class="nav navbar-nav pull-left">';
			$content .= '<li class="dropdown">';
			$content .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
			$content .= '<i class="' . $baseclass . 'network"></i>';
			$content .= '<b class="caret"></b>';
			$content .= '</a>';
			$content .= '<ul class="dropdown-menu dropdown-social">';

			// populate the networks
			foreach ( $networks as $network ) {
				if ( strlen( $network['url'] ) > 7 ) {
					// add the $show variable to check if the user has actually entered a url in any of the available networks
					$show     = true;
					$content .= '<li>';
					$content .= '<a href="' . $network['url'] . '" target="_blank">';
					$content .= '<i class="' . $baseclass . $network['icon'] . '"></i> ';
					$content .= $network['fullname'];
					$content .= '</a></li>';
				}
			}
			$content .= '</ul></li></ul>';

			if ( $networks ) {
				echo $content;
			}
		}

		public function float_class( $alignment = 'left' ) {
			if ( $alignment == 'left' || $alignment == 'l' ) {
				return 'pull-left';
			} elseif ( $alignment == 'right' || $alignment == 'r' ) {
				return 'pull-right';
			}
		}

		function make_tabs( $tab_titles = array(), $tab_contents = array() ) {

			$content = '<ul class="nav nav-tabs">';

			$i = 0;
			foreach ( $tab_titles as $tab_title ) {

				// Make the first tab active
				$active = $i = 0 ? ' class="active"' : null;

				$content .= '<li' . $active . '><a href="#home" data-toggle="tab">Home</a></li>';

				$i++;
			}

			$content .= '</ul>';

			$content .= '<div class="tab-content">';

			$i = 0;
			foreach ( $tab_contents as $tab_content ) {

				// Make the first tab active
				$active = $i = 0 ? ' active' : null;

				$content .= '<div class="tab-pane' . $active . '" id="panel' . $i . '">' . $tab_content . '</div>';

				$i++;
			}

			$content .= '</div>';

			return $content;
		}
	}
}

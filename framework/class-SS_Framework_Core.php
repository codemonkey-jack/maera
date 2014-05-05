<?php

/**
* The Framework
*/
class SS_Framework_Core extends TimberCore {

	public static $representation = 'framework';

	private static $instance;

	var $defines = array(
		// Layout
		'container'  => 'container',
		'row'        => 'row',
		'col-mobile' => 'small',
		'col-tablet' => 'small',
		'col-medium' => 'medium',
		'col-large'  => 'large',

		// Buttons
		'button'         => 'button',
		'button-default' => null,
		'button-primary' => null,
		'button-success' => 'success',
		'button-info'    => 'secondary',
		'button-warning' => 'alert',
		'button-danger'  => 'alert',
		'button-link'    => null,
		'button-disabled'=> 'disabled',

		'button-extra-small' => 'tiny',
		'button-small'       => 'small',
		'button-medium'      => null,
		'button-large'       => 'large',
		'button-extra-large' => 'large',
		'button-block'			 => 'expand',

		// Button-Groups
		'button-group'             => 'button-group',
		'button-group-extra-small' => null,
		'button-group-small'       => null,
		'button-group-default'     => null,
		'button-group-large'       => null,
		'button-group-extra-large' => null,
		// Button Bar not supported

		// Alerts
		'alert'         => 'alert-box',
		'alert-success' => 'success',
		'alert-info'    => 'info',
		'alert-warning' => 'warning',
		'alert-danger'  => 'warning',

		// Miscelaneous
		'clearfix' => '<div class="clearfix"></div>',

		// Forms
		'form-input' => 'form-control',
	);

	private function __construct() {
		do_action( 'shoestrap_framework_include_modules' );
	}

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function include_wrapper() {}

	public function form_input_classes() {
		return $this->defines['form-input'];
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

	/*
	 * The site logo.
	 * If no custom logo is uploaded, use the sitename
	 */
	public function logo() {
		global $ss_settings;
		$logo  = $ss_settings['logo'];

		if ( ! empty( $logo['url'] ) ) {
			$branding = '<img id="site-logo" src="' . $logo['url'] . '" alt="' . get_bloginfo( 'name' ) . '">';
		} else {
			$branding = '<span class="sitename">' . get_bloginfo( 'name' ) . '</span>';
		}

		return $branding;
	}
}

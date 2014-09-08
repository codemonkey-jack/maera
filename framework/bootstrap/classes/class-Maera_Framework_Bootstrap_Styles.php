<?php

if ( ! class_exists( 'Maera_Framework_Bootstrap_Styles' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class Maera_Framework_Bootstrap_Styles {


		/**
		 * Class constructor
		 */
		public function __construct() {

			// Add the custom CSS
			add_action( 'wp_enqueue_scripts', array( $this, 'custom_css' ), 105 );

			// Styles
			add_filter( 'maera/styles', array( $this, 'header_css' ) );
			add_filter( 'maera/styles', array( $this, 'typography_css' ) );
			add_filter( 'maera/styles', array( $this, 'layout_css' ) );
			add_filter( 'maera/styles', array( $this, 'color_css' ) );

			add_action( 'wp_print_styles', array( $this, 'google_font' ) );

		}


		/**
		* Enqueue Google fonts if enabled
		*/
		function google_font() {

			$default_font = '"Helvetica Neue",Helvetica,Arial,sans-serif';

			$font_families = array(
				str_replace( ' ', '+', get_theme_mod( 'font_base_family', $default_font ) ),
				str_replace( ' ', '+', get_theme_mod( 'headers_font_family', $default_font ) ),
				str_replace( ' ', '+', get_theme_mod( 'font_jumbotron_font_family', $default_font ) ),
				str_replace( ' ', '+', get_theme_mod( 'font_menus_font_family', $default_font ) ),
			);

			$font_weights = array(
				get_theme_mod( 'font_base_weight', 400 ),
				get_theme_mod( 'font_headers_weight', 400 ),
			);

			$font_subsets = get_theme_mod( 'font_subsets', 'latin' );

			wp_register_style( 'maera_google_font', Kirki_Fonts::get_google_font_uri( $font_families, $font_weights, $font_subsets ) );
	 		wp_enqueue_style( 'maera_google_font' );

		}


		/*
		 * Any necessary extra CSS is generated here
		 */
		function header_css( $styles ) {

			$header_bg = get_theme_mod( 'header_bg_color', '#ffffff' );

			if ( 1 == get_theme_mod( 'header_toggle', 0 ) ) {

				$el = ( 'boxed' == get_theme_mod( 'site_style', 'wide' ) ) ? 'body .header-boxed' : 'body .header-wrapper';
				// $styles .= $el . ',' . $el . ' a,' . $el . ' h1,' . $el . ' h2,' . $el . ' h3,' . $el . ' h4,' . $el . ' h5,' . $el . ' h6{ color:' . Maera::text_color_calculated( $header_bg ) . ';}';
				// TODO: use getReadableContrastingColor() from Jetpack_Color class.
				// See https://github.com/Automattic/jetpack/issues/1068
				$styles .= $el . ',' . $el . ' a,' . $el . ' h1,' . $el . ' h2,' . $el . ' h3,' . $el . ' h4,' . $el . ' h5,' . $el . ' h6{ color:' . '#222222' . ';}';

			}

		}


		/**
		 * CSS rules for typography options
		 */
		function typography_css( $style ) {

			$body_obj = new Jetpack_Color( get_theme_mod( 'body_bg_color', '#ffffff' ) );
			$b_p_obj  = new Jetpack_Color( get_theme_mod( 'color_brand_primary', '#428bca' ) );

			$body_bg  = '#' . str_replace( '#', '', $body_obj->toHex() );
			$body_lum = $body_obj->toLuminosity();

			// Base font settings
			$font_base_family    = get_theme_mod( 'font_base_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
			// TODO: use getReadableContrastingColor() from Jetpack_Color class.
			// See https://github.com/Automattic/jetpack/issues/1068
			$font_base_color     = '#' . $body_obj->getGrayscaleContrastingColor(10)->toHex();

			$font_base_weight    = get_theme_mod( 'font_base_weight', '#333333' );
			$font_base_size      = get_theme_mod( 'font_base_size', ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 14 : 1.5 );
			$font_base_height    = get_theme_mod( 'font_base_height', 1.4 );

			$style .= 'body {font-family:' . $font_base_family . ';color:' . $font_base_color . ';font-weight:' . $font_base_weight . ';font-size:' . $font_base_size . get_theme_mod( 'font_size_units', 'px' ) . ';line-height:' . $font_base_height . ';}';

			// Headers font
			$headers_font_family = get_theme_mod( 'headers_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );

			$style .= 'h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6{';
			$style .= 'font-family: ' . $headers_font_family . ';';
			$style .= 'color: ' .$font_base_color . ';';
			$style .= 'font-weight: ' . get_theme_mod( 'font_headers_weight', 400 ) . ';';
			$style .= 'line-height: ' . get_theme_mod( 'font_headers_height', 1.1 ) . ';';
			$style .= '}';

			$style .= 'h1, .h1 { font-size: ' . intval( ( 260 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h2, .h2 { font-size: ' . intval( ( 215 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h3, .h3 { font-size: ' . intval( ( 170 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h4, .h4 { font-size: ' . intval( ( 110 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h5, .h5 { font-size: ' . intval( ( 100 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h6, .h6 { font-size: ' . intval( ( 85 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';

			// Navigation font
			$navbar_font_family = get_theme_mod( 'font_menus_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
			$navbar_obj = new Jetpack_Color( get_theme_mod( 'body_bg_color', '#ffffff' ) );

			$style .= '.navbar{';
			$style .= 'font-family: ' . $navbar_font_family . ';';
			$style .= 'font-weight: ' . get_theme_mod( 'font_menus_weight', 400 ) . ';';
			$style .= 'line-height: ' . get_theme_mod( 'font_menus_height', 1.1 ) . ';';
			$style .= '}';

			// Navigation font
			$jumbotron_font_family = get_theme_mod( 'font_jumbotron_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
			$jumbotron_obj = new Jetpack_Color( get_theme_mod( 'jumbo_bg', '#ffffff' ) );

			$style .= '.jumbotron{';
			$style .= 'color: ' . '#' . $body_obj->getGrayscaleContrastingColor(10)->toHex() . ';';
			$style .= 'font-family: ' . $navbar_font_family . ';';
			$style .= 'font-weight: ' . get_theme_mod( 'font_jumbotron_weight', 400 ) . ';';
			$style .= 'line-height: ' . get_theme_mod( 'font_jumbotron_height', 1.1 ) . ';';
			$style .= '}';

			// Make sure links are readable
			$links_color = $b_p_obj->getReadableContrastingColor( $body_obj, 2 );
			// Use "body a" instead of plain "a" to override the defaults
			$style .= 'body a, body a:visited, body a:hover { color: #' . $links_color->toHex() . ';}';

			return $style;

		}


		/**
		 * Additional CSS rules for layout options
		 */
		function layout_css( $style ) {

			global $wp_customize;

			// Customizer-only styles
			if ( $wp_customize ) {

				$screen_sm = filter_var( get_theme_mod( 'screen_tablet', 768 ), FILTER_SANITIZE_NUMBER_INT );
				$screen_md = filter_var( get_theme_mod( 'screen_desktop', 992 ), FILTER_SANITIZE_NUMBER_INT );
				$screen_lg = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
				$gutter    = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );

				$style .= '
				.container {
					padding-left: ' . round( $gutter / 2 ) . 'px;
					padding-right: ' . round( $gutter / 2 ) . 'px;
				}
				@media (min-width: ' . $screen_sm . 'px) {
					.container {
						width: ' . ( $screen_sm - ( $gutter / 2 ) ). 'px;
					}
				}
				@media (min-width: ' . $screen_lg . 'px) {
					.container {
						width: ' . ( $screen_md - ( $gutter / 2 ) ). 'px;
					}
				}
				@media (min-width: ' . $screen_lg . 'px) {
					.container {
						width: ' . ( $screen_lg - ( $gutter / 2 ) ). 'px;
					}
				}
				.container-fluid {
					padding-left: ' . round( $gutter / 2 ) . 'px;
					padding-right: ' . round( $gutter / 2 ) . 'px;
				}
				.row {
					margin-left: -' . round( $gutter / 2 ) . 'px;
					margin-right: -' . round( $gutter / 2 ) . 'px;
				}
				.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
					padding-left: ' . round( $gutter / 2 ) . 'px;
					padding-right: ' . round( $gutter / 2 ) . 'px;
				}';

			}

			return $style;

		}


		/**
		 * Additional CSS rules for layout options
		 */
		function color_css( $style ) {

			global $wp_customize;

			// Customizer-only styles
			if ( ! $wp_customize ) {
				return $style;
			}

			$body_obj  = new Jetpack_Color( get_theme_mod( 'body_bg_color', '#ffffff' ) );

			$color_primary = new Jetpack_Color( get_theme_mod( 'color_brand_primary', '#428bca' ) );
			$brand_primary = '#' . str_replace( '#', '', $color_primary->getReadableContrastingColor( $body_obj, 1.5 )->toHex() );

			$color_success = new Jetpack_Color( '#5cb85c' );
			$brand_success = '#' . str_replace( '#', '', $color_success->getReadableContrastingColor( $body_obj, 1.5 )->toHex() );

			$color_warning = new Jetpack_Color( '#f0ad4e' );
			$brand_warning = '#' . str_replace( '#', '', $color_warning->getReadableContrastingColor( $body_obj, 1.5 )->toHex() );

			$color_danger = new Jetpack_Color( '#d9534f' );
			$brand_danger = '#' . str_replace( '#', '', $color_danger->getReadableContrastingColor( $body_obj, 1.5 )->toHex() );

			$color_info = new Jetpack_Color( '#5bc0de' );
			$brand_info = '#' . str_replace( '#', '', $color_info->getReadableContrastingColor( $body_obj, 1.5 )->toHex() );

			$style .= 'a { color: ' . $brand_primary . '; }';

			$style .= '.text-primary { color: ' . $brand_primary . '; }';
			$style .= '.bg-primary { background-color: ' . $brand_primary . '; }';
			$style .= '.btn-primary { background-color: ' . $brand_primary . '; }';
			$style .= '.btn-primary.disabled, .btn-primary[disabled], fieldset[disabled] .btn-primary, .btn-primary.disabled:hover, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary:hover, .btn-primary.disabled:focus, .btn-primary[disabled]:focus, fieldset[disabled] .btn-primary:focus, .btn-primary.disabled:active, .btn-primary[disabled]:active, fieldset[disabled] .btn-primary:active, .btn-primary.disabled.active, .btn-primary[disabled].active, fieldset[disabled] .btn-primary.active { background-color: ' . $brand_primary . '; }';
			$style .= '.btn-primary .badge { color: ' . $brand_primary . '; }';

			$style .= '.btn-link { color: ' . $brand_primary . '; }';
			$style .= '.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus { background-color: ' . $brand_primary . '; }';
			$style .= '.pagination > li > a, .pagination > li > span { color: ' . $brand_primary . '; }';
			$style .= '.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus { background-color: ' . $brand_primary . '; border-color: ' . $brand_primary . '; }';

			$style .= '.text-success { color: ' . $brand_success . '; }';
			$style .= '.bg-success { background-color: ' . $brand_success . '; }';
			$style .= '.btn-success { background-color: ' . $brand_success . '; }';
			$style .= '.btn-success.disabled, .btn-success[disabled], fieldset[disabled] .btn-success, .btn-success.disabled:hover, .btn-success[disabled]:hover, fieldset[disabled] .btn-success:hover, .btn-success.disabled:focus, .btn-success[disabled]:focus, fieldset[disabled] .btn-success:focus, .btn-success.disabled:active, .btn-success[disabled]:active, fieldset[disabled] .btn-success:active, .btn-success.disabled.active, .btn-success[disabled].active, fieldset[disabled] .btn-success.active { background-color: ' . $brand_success . '; }';
			$style .= '.btn-success .badge { color: ' . $brand_success . '; }';

			$style .= '.text-info { color: ' . $brand_info . '; }';
			$style .= '.bg-info { background-color: ' . $brand_info . '; }';
			$style .= '.btn-info { background-color: ' . $brand_info . '; }';
			$style .= '.btn-info.disabled, .btn-info[disabled], fieldset[disabled] .btn-info, .btn-info.disabled:hover, .btn-info[disabled]:hover, fieldset[disabled] .btn-info:hover, .btn-info.disabled:focus, .btn-info[disabled]:focus, fieldset[disabled] .btn-info:focus, .btn-info.disabled:active, .btn-info[disabled]:active, fieldset[disabled] .btn-info:active, .btn-info.disabled.active, .btn-info[disabled].active, fieldset[disabled] .btn-info.active { background-color: ' . $brand_info . '; }';
			$style .= '.btn-info .badge { color: ' . $brand_info . '; }';

			$style .= '.text-warning { color: ' . $brand_warning . '; }';
			$style .= '.bg-warning { background-color: ' . $brand_warning . '; }';
			$style .= '.btn-warning { background-color: ' . $brand_warning . '; }';
			$style .= '.btn-warning.disabled, .btn-warning[disabled], fieldset[disabled] .btn-warning, .btn-warning.disabled:hover, .btn-warning[disabled]:hover, fieldset[disabled] .btn-warning:hover, .btn-warning.disabled:focus, .btn-warning[disabled]:focus, fieldset[disabled] .btn-warning:focus, .btn-warning.disabled:active, .btn-warning[disabled]:active, fieldset[disabled] .btn-warning:active, .btn-warning.disabled.active, .btn-warning[disabled].active, fieldset[disabled] .btn-warning.active { background-color: ' . $brand_warning . '; }';
			$style .= '.btn-warning .badge { color: ' . $brand_warning . '; }';

			$style .= '.text-danger { color: ' . $brand_danger . '; }';
			$style .= '.bg-danger { background-color: ' . $brand_danger . '; }';
			$style .= '.btn-danger { background-color: ' . $brand_danger . '; }';
			$style .= '.btn-danger.disabled, .btn-danger[disabled], fieldset[disabled] .btn-danger, .btn-danger.disabled:hover, .btn-danger[disabled]:hover, fieldset[disabled] .btn-danger:hover, .btn-danger.disabled:focus, .btn-danger[disabled]:focus, fieldset[disabled] .btn-danger:focus, .btn-danger.disabled:active, .btn-danger[disabled]:active, fieldset[disabled] .btn-danger:active, .btn-danger.disabled.active, .btn-danger[disabled].active, fieldset[disabled] .btn-danger.active { background-color: ' . $brand_danger . '; }';
			$style .= '.btn-danger .badge { color: ' . $brand_danger . '; }';

			return $style;

		}


		/**
		 * Include the custom CSS
		 */
		function custom_css() {
			$css = get_theme_mod( 'css', '' );

			if ( ! empty( $css ) ) {
				wp_add_inline_style( 'maera', $css );
			}
		}

	}

}

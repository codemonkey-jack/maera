<?php


/**
* The Meara Bootstrap variables
*/
class Maera_Bootstrap_Compiler {

	/**
	 * Class constructor
	 */
	function __construct() {

		global $wp_customize;

		$theme_options = get_option( 'maera_admin_options', array() );

		if ( $wp_customize || ( 1 == @$theme_options['dev_mode'] ) ) {

			add_action( 'wp_head', array( $this, 'echo_less' ) );

		}

		// Instantianate the compiler and pass the framework's properties to it
		$compiler = new Maera_Compiler( array(
			'compiler'     => 'less_php',
			'minimize_css' => false,
			'less_path'    => MAERA_FRAMEWORK_PATH . '/assets/less/',
		) );

		add_filter( 'maera/compiler/less/post', array( $this, 'less' ) );

		// Trigger the compiler the first time the theme is enabled
		add_action( 'after_switch_theme', array( $compiler, 'makecss' ) );
		// Trigger the compiler when the customizer options are saved.
		add_action( 'customize_save_after', array( $compiler, 'makecss' ), 77 );
		// Trigger the compiler when the options in the admin page are saved
		add_action( 'maera/admin/save', array( $compiler, 'makecss' ) );

		// If the CSS file does not exist, attempt creating it.
		if ( ! file_exists( $compiler->file( 'path' ) ) ) {
			add_action( 'wp', array( $compiler, 'makecss' ) );
		}

	}

	function echo_less() {

		echo '<style type="text/less">' . $this->less() . '</style>';
		echo '<script>less = {
		    env: "development",
		    async: false,
		    fileAsync: false,
		    poll: 1000,
		    functions: {},
		    dumpLineNumbers: "comments",
		    relativeUrls: false,
		    rootpath: ":/a.com/"
		  };</script>';
		echo '<script src="' . MAERA_ASSETS_URL . '/js/less.min.js" type="text/javascript"></script>';

	}


	/**
	 * Parse the array of variables to readable format by the less compiler
	 */
	function less() {

		global $wp_customize;

		$variables = $this->get_variables();

		// define the $content to avoid PHP notices
		$content = '';

		foreach ( $variables as $variable => $value ) {

			$content .= '@' . $variable . ': ' . $value . ';';

		}

		$content .= file_get_contents( MAERA_FRAMEWORK_PATH . '/assets/less/vendor/bootstrap/mixins.less' );

		// Reset
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/normalize.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/print.less' );

		// Core CSS
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/scaffolding.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/type.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/code.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/grid.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/tables.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/forms.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/buttons.less' );

		// Components
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/component-animations.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/glyphicons.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/dropdowns.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/button-groups.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/input-groups.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/navs.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/navbar.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/breadcrumbs.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/pagination.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/pager.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/labels.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/badges.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/jumbotron.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/thumbnails.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/alerts.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/progress-bars.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/media.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/list-group.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/panels.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/wells.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/close.less' );

		// Components w/ JavaScript
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/modals.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/tooltip.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/popovers.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/carousel.less' );

		// Utility classes
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/utilities.less' );
		$content .= file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/vendor/bootstrap/responsive-utilities.less' );

		$content .= ( $wp_customize || ( 0 != @$theme_options['dev_mode'] ) ) ? file_get_contents( MAERA_FRAMEWORK_PATH .  '/assets/less/app.less' ) : '';
		$content .= ( get_theme_mod( 'gradients_toggle', 0 ) ) ? file_get_contents( MAERA_FRAMEWORK_PATH . '/assets/less/gradients.less' ) : '';
		$content .= ( 'static' == get_theme_mod( 'site_style' ) ) ? '@screen-xs-max: 0 !important; .container { max-width: none !important; width: @container-large-desktop; } html { overflow-x: auto !important; }' : '';

		$content .= ( ! empty( get_theme_mod( 'less', '' ) ) ) get_theme_mod( 'less', '' ) : '';

		return $content;

	}

	/**
	 * Build an array of the available variables.
	 * These variables are basically the variables.less file from bootstrap,
	 * formatted as an array.
	 */
	function get_variables() {

		$body_obj  = new Jetpack_Color( get_theme_mod( 'body_bg_color', '#ffffff' ) );
		$body_bg   = '#' . $body_obj->toHex();
		$body_lum  = $body_obj->toLuminosity();

		$b_p_obj           = new Jetpack_Color( get_theme_mod( 'color_brand_primary', '#428bca' ) );
		$brand_primary     = '#' . $b_p_obj->toHex();
		$brand_primary_lum = $b_p_obj->toLuminosity();

		$color_success     = new Jetpack_Color( '#5cb85c' );
		$brand_success     = '#' . $color_success->getReadableContrastingColor( $body_obj, 1.5 )->toHex();
		$b_s_obj           = new Jetpack_Color( $brand_success );
		$brand_success_lum = $b_s_obj->toLuminosity();

		$color_warning     = new Jetpack_Color( '#f0ad4e' );
		$brand_warning     = '#' . $color_warning->getReadableContrastingColor( $body_obj, 1.5 )->toHex();
		$b_w_obj           = new Jetpack_Color( $brand_warning );
		$brand_warning_lum = $b_w_obj->toLuminosity();

		$color_danger      = new Jetpack_Color( '#d9534f' );
		$brand_danger      = '#' . $color_danger->getReadableContrastingColor( $body_obj, 1.5 )->toHex();
		$b_d_obj           = new Jetpack_Color( $brand_danger );
		$brand_danger_lum  = $b_d_obj->toLuminosity();

		$color_info        = new Jetpack_Color( '#5bc0de' );
		$brand_info        = '#' . $color_info->getReadableContrastingColor( $body_obj, 1.5 )->toHex();
		$b_i_obj           = new Jetpack_Color( $brand_info );
		$brand_info_lum    = $b_i_obj->toLuminosity();

		$nav_col_obj   = new Jetpack_Color( get_theme_mod( 'navbar_bg', '#f8f8f8' ) );
		$jumbotron_obj = new Jetpack_Color( get_theme_mod( 'jumbo_bg', '#ffffff' ) );

		$navbar_border      = ( 0.6 < $brand_primary_lum ) ? 'lighten(@navbar-default-bg, 6.5%)' : 'darken(@navbar-default-bg, 6.5%)';

		$screen_sm = filter_var( get_theme_mod( 'screen_tablet', 768 ), FILTER_SANITIZE_NUMBER_INT );
		$screen_md = filter_var( get_theme_mod( 'screen_desktop', 992 ), FILTER_SANITIZE_NUMBER_INT );
		$screen_lg = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
		$gutter    = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );
		$gutter    = ( $gutter < 2 ) ? 2 : $gutter;

		$site_style = get_theme_mod( 'site_style', 'wide' );

		$screen_xs = ( $site_style == 'static' ) ? '50px' : '480px';
		$screen_sm = ( $site_style == 'static' ) ? '50px' : $screen_sm;
		$screen_md = ( $site_style == 'static' ) ? '50px' : $screen_md;

		$gfb = get_theme_mod( 'grid_float_breakpoint', 'screen_sm_min' );
		$grid_float_breakpoint = ( isset( $gfb ) )           ? $gfb             : '@screen-sm-min';
		$grid_float_breakpoint = ( $gfb == 'min' )           ? '10px'           : $grid_float_breakpoint;
		$grid_float_breakpoint = ( $gfb == 'screen_xs_min' ) ? '@screen-xs-min' : $grid_float_breakpoint;
		$grid_float_breakpoint = ( $gfb == 'screen_sm_min' ) ? '@screen-sm-min' : $grid_float_breakpoint;
		$grid_float_breakpoint = ( $gfb == 'screen_md_min' ) ? '@screen-md-min' : $grid_float_breakpoint;
		$grid_float_breakpoint = ( $gfb == 'screen_lg_min' ) ? '@screen-lg-min' : $grid_float_breakpoint;
		$grid_float_breakpoint = ( $gfb == 'max' )           ? '9999px'         : $grid_float_breakpoint;

		$grid_float_breakpoint = ( $gfb == 'screen-lg-min' ) ? '0 !important' : $grid_float_breakpoint;

		$variables = array(
			'gray-darker'  => ( 0.4 < $body_lum ) ? 'lighten(#000, 13.5%)' : 'darken(#fff, 13.5%)',
			'gray-dark'    => ( 0.4 < $body_lum ) ? 'lighten(#000, 20%)' : 'darken(#fff, 20%)',
			'gray'         => ( 0.4 < $body_lum ) ? 'lighten(#000, 33.5%)' : 'darken(#fff, 33.5%)',
			'gray-light'   => ( 0.4 < $body_lum ) ? 'lighten(#000, 60%)' : 'darken(#fff, 60%)',
			'gray-lighter' => ( 0.4 < $body_lum ) ? 'lighten(#000, 93.5%)' : 'darken(#fff, 93.5%)',

			'brand-primary' => '#' . $b_p_obj->getReadableContrastingColor(3)->toHex(),
			'brand-success' => '#' . $color_success->getReadableContrastingColor(3)->toHex(),
			'brand-info'    => '#' . $color_info->getReadableContrastingColor(3)->toHex(),
			'brand-warning' => '#' . $color_warning->getReadableContrastingColor(3)->toHex(),
			'brand-danger'  => '#' . $color_danger->getReadableContrastingColor(3)->toHex(),

			'body-bg'          => $body_bg,
			'text-color'       => '#' . $body_obj->getGrayscaleContrastingColor(10)->toHex(),
			'link-color'       => '#' . $b_p_obj->getReadableContrastingColor( $body_obj, 2 )->toHex(),
			'link-hover-color' => ( 0.3 < $brand_primary_lum ) ? 'darken(@link-color, 15%)' : 'lighten(@link-color, 15%)',

			'font-family-sans-serif' => get_theme_mod( 'font_base_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' ),
			'font-family-serif'      => 'Georgia, "Times New Roman", Times, serif',
			'font-family-monospace'  => 'Menlo, Monaco, Consolas, "Courier New", monospace',
			'font-family-base'       => '@font-family-sans-serif',

			'font-size-base'  => get_theme_mod( 'font_base_size', ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 14 : 1.5 ) . get_theme_mod( 'font_size_units', 'px' ),
			'font-size-large' => 'ceil((@font-size-base * 1.25))',
			'font-size-small' => 'ceil((@font-size-base * 0.85))',

			'font-size-h1' => 'floor((@font-size-base * ' . get_theme_mod( 'font_headers_size', 1 ) * 2.6 . '))',
			'font-size-h2' => 'floor((@font-size-base * ' . get_theme_mod( 'font_headers_size', 1 ) * 2.15 . '))',
			'font-size-h3' => 'ceil((@font-size-base * ' . get_theme_mod( 'font_headers_size', 1 ) * 1.7 . '))',
			'font-size-h4' => 'ceil((@font-size-base * ' . get_theme_mod( 'font_headers_size', 1 ) * 1.25 . '))',
			'font-size-h5' => '@font-size-base',
			'font-size-h6' => 'ceil((@font-size-base * ' . get_theme_mod( 'font_headers_size', 1 ) * 0.85 . '))',

			'line-height-base'     => get_theme_mod( 'font_base_height', 1.43 ),
			'line-height-computed' => 'floor((@font-size-base * @line-height-base))',
			'headings-font-family' => get_theme_mod( 'headers_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' ),
			'headings-font-weight' => get_theme_mod( 'font_headers_weight', 500 ),
			'headings-line-height' => get_theme_mod( 'font_headers_height', 1.1 ),
			'headings-color'       => 'inherit',

			'icon-font-path'   => '"../fonts/"',
			'icon-font-name'   => '"glyphicons-halflings-regular"',
			'icon-font-svg-id' => '"glyphicons_halflingsregular"',

			'padding-base-vertical'   => round( get_theme_mod( 'padding_base', 6 ) * ( 6/6 ) ) . 'px',
			'padding-base-horizontal' => round( get_theme_mod( 'padding_base', 6 ) * ( 10/6 ) ) . 'px',

			'padding-large-vertical'   => round( get_theme_mod( 'padding_base', 6 ) * ( 10/6 ) ) . 'px',
			'padding-large-horizontal' => round( get_theme_mod( 'padding_base', 6 ) * ( 16/6 ) ) . 'px',

			'padding-small-vertical'   => round( get_theme_mod( 'padding_base', 6 ) * ( 5/6 ) ) . 'px',
			'padding-small-horizontal' => round( get_theme_mod( 'padding_base', 6 ) * ( 10/6 ) ) . 'px',

			'padding-xs-vertical'   => round( get_theme_mod( 'padding_base', 6 ) * ( 1/6 ) ) . 'px',
			'padding-xs-horizontal' => round( get_theme_mod( 'padding_base', 6 ) * ( 5/6 ) ) . 'px',

			'line-height-large' => '1.33',
			'line-height-small' => '1.5',

			'border-radius-base'  => round( get_theme_mod( 'border_radius', 4 ) * ( 4/4 ) ) . 'px',
			'border-radius-large' => round( get_theme_mod( 'border_radius', 4 ) * ( 6/4 ) ) . 'px',
			'border-radius-small' => round( get_theme_mod( 'border_radius', 4 ) * ( 3/4 ) ) . 'px',

			'component-active-color' => '@body-bg',
			'component-active-bg'    => '@brand-primary',

			'caret-width-base'  => '4px',
			'caret-width-large' => '5px',

			'table-cell-padding'           => round( get_theme_mod( 'padding_base', 6 ) * ( 8/6 ) ) . 'px',
			'table-condensed-cell-padding' => round( get_theme_mod( 'padding_base', 6 ) * ( 5/6 ) ) . 'px',

			'table-bg'        => 'transparent',
			'table-bg-accent' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 2.5%)' : 'lighten(@body-bg, 2.5%)',

			'table-bg-hover'  => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 4%)' : 'lighten(@body-bg, 4%)',
			'table-bg-active' => '@table-bg-hover',

			'table-border-color' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',

			'btn-font-weight' => 'normal',

			'btn-default-color'  => '@text-color',
			'btn-default-bg'     => '@body-bg',
			'btn-default-border' => ( 0.6 < $body_lum ) ? 'darken(@btn-primary-bg, 5%)' : 'lighten(@btn-primary-bg, 5%)',

			'btn-primary-color'  => '@body-bg',
			'btn-primary-bg'     => '@brand-primary',
			'btn-primary-border' => ( 0.6 < $brand_primary_lum ) ? 'darken(@btn-primary-bg, 5%)' : 'lighten(@btn-primary-bg, 5%)',

			'btn-success-color'  => '@body-bg',
			'btn-success-bg'     => '@brand-success',
			'btn-success-border' => ( 0.6 < $brand_success_lum ) ? 'darken(@btn-success-bg, 5%)' : 'lighten(@btn-success-bg, 5%)',

			'btn-info-color'  => '@body-bg',
			'btn-info-bg'     => '@brand-info',
			'btn-info-border' => ( 0.6 < $brand_info_lum    ) ? 'darken(@btn-info-bg, 5%)' : 'lighten(@btn-info-bg, 5%)',

			'btn-warning-color'  => '@body-bg',
			'btn-warning-bg'     => '@brand-warning',
			'btn-warning-border' => ( 0.6 < $brand_warning_lum ) ? 'darken(@btn-warning-bg, 5%)' : 'lighten(@btn-warning-bg, 5%)',

			'btn-danger-color'  => '@body-bg',
			'btn-danger-bg'     => '@brand-danger',
			'btn-danger-border' => ( 0.6 < $brand_danger_lum  ) ? 'darken(@btn-danger-bg, 5%)' : 'lighten(@btn-danger-bg, 5%)',

			'btn-link-disabled-color' => '@gray-light',

			'input-bg'            => '@body-bg',
			'input-bg-disabled'   => '@gray-lighter',
			'input-color'         => '@gray',
			'input-border'        => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 20%)' : 'lighten(@body-bg, 20%)',
			'input-border-radius' => '@border-radius-base',
			'input-border-focus'  => ( 0.6 < $brand_primary_lum ) ? 'lighten(@brand-primary, 10%)' : 'darken(@brand-primary, 10%)',

			'input-color-placeholder' => '@gray-light',

			'input-height-base'  => '(@line-height-computed + (@padding-base-vertical * 2) + 2)',
			'input-height-large' => '(ceil(@font-size-large * @line-height-large) + (@padding-large-vertical * 2) + 2)',
			'input-height-small' => '(floor(@font-size-small * @line-height-small) + (@padding-small-vertical * 2) + 2)',

			'legend-color'        => '@gray-dark',
			'legend-border-color' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 10.2%)' : 'lighten(@body-bg, 10.2%)',

			'input-group-addon-bg'           => '@gray-lighter',
			'input-group-addon-border-color' => '@input-border',

			'dropdown-bg'              => '@body-bg',
			'dropdown-border'          => 'rgba(0,0,0,.15)',
			'dropdown-fallback-border' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 20%)' : 'lighten(@body-bg, 20%)',
			'dropdown-divider-bg'      => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 10.2%)' : 'lighten(@body-bg, 10.2%)',

			'dropdown-link-color'       => '@gray-dark',
			'dropdown-link-hover-color' => 'darken(@gray-dark, 5%)',
			'dropdown-link-hover-bg'    => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 4%)' : 'lighten(@body-bg, 4%)',

			'dropdown-link-active-color' => '@component-active-color',
			'dropdown-link-active-bg'    => '@component-active-bg',

			'dropdown-link-disabled-color' => '@gray-light',
			'dropdown-header-color'        => '@gray-light',
			'dropdown-caret-color'         => '@gray-darker',

			'zindex-navbar'           => '1000',
			'zindex-dropdown'         => '1000',
			'zindex-popover'          => '1010',
			'zindex-tooltip'          => '1030',
			'zindex-navbar-fixed'     => '1030',
			'zindex-modal-background' => '1040',
			'zindex-modal'            => '1050',

			'screen-xs'     => '480px',
			'screen-xs-min' => '@screen-xs',
			'screen-phone'  => '@screen-xs-min',

			'screen-sm'     => $screen_sm . 'px',
			'screen-sm-min' => '@screen-sm',
			'screen-tablet' => '@screen-sm-min',

			'screen-md'      => $screen_md . 'px',
			'screen-md-min'  => '@screen-md',
			'screen-desktop' => '@screen-md-min',

			'screen-lg'         => $screen_lg . 'px',
			'screen-lg-min'     => '@screen-lg',
			'screen-lg-desktop' => '@screen-lg-min',

			'screen-xs-max' => '(@screen-sm-min - 1)',
			'screen-sm-max' => '(@screen-md-min - 1)',
			'screen-md-max' => '(@screen-lg-min - 1)',

			'grid-columns'              => '12',
			'grid-gutter-width'         => $gutter . 'px',
			'grid-float-breakpoint'     => $grid_float_breakpoint,
			'grid-float-breakpoint-max' => '(@grid-float-breakpoint - 1)',

			'container-tablet' => ( $screen_sm - ( $gutter / 2 ) ). 'px',
			'container-sm'     => '@container-tablet',

			'container-desktop' => ( $screen_md - ( $gutter / 2 ) ). 'px',
			'container-md'      => '@container-desktop',

			'container-large-desktop' => ( $screen_lg - $gutter ). 'px',
			'container-lg'            => '@container-large-desktop',

			'navbar-height'              => filter_var( get_theme_mod( 'navbar_height', 50 ), FILTER_SANITIZE_NUMBER_INT ) . 'px',
			'navbar-margin-bottom'       => '@line-height-computed',
			'navbar-border-radius'       => '@border-radius-base',
			'navbar-padding-horizontal'  => 'floor((@grid-gutter-width / 2))',
			'navbar-padding-vertical'    => '((@navbar-height - @line-height-computed) / 2)',
			'navbar-collapse-max-height' => '340px',

			'navbar-default-color'  => '#' . $nav_col_obj->getGrayscaleContrastingColor(7)->toHex(),
			'navbar-default-bg'     => '#' . $nav_col_obj->toHex(),
			'navbar-default-border' => ( 0.3 > $nav_col_obj->toLuminosity() ) ? 'lighten(@navbar-default-bg, 6.5%)' : 'darken(@navbar-default-bg, 6.5%)',

			'navbar-default-link-color'          => '@navbar-default-color',
			'navbar-default-link-hover-color'    => '#' . $nav_col_obj->getGrayscaleContrastingColor(11)->toHex(),
			'navbar-default-link-hover-bg'       => 'transparent',
			'navbar-default-link-active-color'   => 'mix(@navbar-default-color, @navbar-default-link-hover-color, 50%)',
			'navbar-default-link-active-bg'      => ( 0.6 > $nav_col_obj->toLuminosity() ) ? 'darken(@navbar-default-bg, 6.5%)' : 'lighten(@navbar-default-bg, 6.5%)',
			'navbar-default-link-disabled-color' => ( 0.6 > $nav_col_obj->toLuminosity() ) ? 'darken(@navbar-default-bg, 6.5%)' : 'lighten(@navbar-default-bg, 6.5%)',
			'navbar-default-link-disabled-bg'    => 'transparent',

			'navbar-default-brand-color'       => '@navbar-default-link-color',
			'navbar-default-brand-hover-color' => 'darken(@navbar-default-brand-color, 10%)',
			'navbar-default-brand-hover-bg'    => 'transparent',

			'navbar-default-toggle-hover-bg'     => ( 0.3 > $nav_col_obj->toLuminosity() ) ? 'lighten(@navbar-default-bg, 6.5%)' : 'darken(@navbar-default-bg, 6.5%)',
			'navbar-default-toggle-icon-bar-bg'  => '#' . $nav_col_obj->getGrayscaleContrastingColor(7)->toHex(),
			'navbar-default-toggle-border-color' => '@navbar-default-toggle-hover-bg',

			'navbar-inverse-color'  => '@gray-light',
			'navbar-inverse-bg'     => '#222',
			'navbar-inverse-border' => 'darken(@navbar-inverse-bg, 10%)',

			'navbar-inverse-link-color'          => '@gray-light',
			'navbar-inverse-link-hover-color'    => '@body-bg',
			'navbar-inverse-link-hover-bg'       => 'transparent',
			'navbar-inverse-link-active-color'   => '@navbar-inverse-link-hover-color',
			'navbar-inverse-link-active-bg'      => 'darken(@navbar-inverse-bg, 10%)',
			'navbar-inverse-link-disabled-color' => '#444',
			'navbar-inverse-link-disabled-bg'    => 'transparent',

			'navbar-inverse-brand-color'       => '@navbar-inverse-link-color',
			'navbar-inverse-brand-hover-color' => '@body-bg',
			'navbar-inverse-brand-hover-bg'    => 'transparent',

			'navbar-inverse-toggle-hover-bg'     => '#333',
			'navbar-inverse-toggle-icon-bar-bg'  => '@body-bg',
			'navbar-inverse-toggle-border-color' => '#333',

			'nav-link-padding'  => round( get_theme_mod( 'padding_base', 6 ) * ( 10/6 ) ) . 'px ' . round( get_theme_mod( 'padding_base', 6 ) * ( 15/6 ) ) . 'px',
			'nav-link-hover-bg' => '@gray-lighter',

			'nav-disabled-link-color'       => '@gray-light',
			'nav-disabled-link-hover-color' => '@gray-light',

			'nav-open-link-hover-color' => '@body-bg',

			'nav-tabs-border-color' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',

			'nav-tabs-link-hover-border-color' => '@gray-lighter',

			'nav-tabs-active-link-hover-bg'           => '@body-bg',
			'nav-tabs-active-link-hover-color'        => '@gray',
			'nav-tabs-active-link-hover-border-color' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',

			'nav-tabs-justified-link-border-color'        => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',
			'nav-tabs-justified-active-link-border-color' => '@body-bg',

			'nav-pills-border-radius'           => '@border-radius-base',
			'nav-pills-active-link-hover-bg'    => '@component-active-bg',
			'nav-pills-active-link-hover-color' => '@component-active-color',

			'pagination-color'  => '@link-color',
			'pagination-bg'     => '@body-bg',
			'pagination-border' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',

			'pagination-hover-color'  => '@link-hover-color',
			'pagination-hover-bg'     => '@gray-lighter',
			'pagination-hover-border' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',

			'pagination-active-color'  => '@body-bg',
			'pagination-active-bg'     => '@brand-primary',
			'pagination-active-border' => '@brand-primary',

			'pagination-disabled-color'  => '@gray-light',
			'pagination-disabled-bg'     => '@body-bg',
			'pagination-disabled-border' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',

			'pager-bg'            => '@pagination-bg',
			'pager-border'        => '@pagination-border',
			'pager-border-radius' => round( get_theme_mod( 'border_radius', 4 ) * ( 15/4 ) ) . 'px',

			'pager-hover-bg' => '@pagination-hover-bg',

			'pager-active-bg'    => '@pagination-active-bg',
			'pager-active-color' => '@pagination-active-color',

			'pager-disabled-color' => '@pagination-disabled-color',

			'jumbotron-padding'       => round( get_theme_mod( 'padding_base', 6 ) * ( 30/6 ) ) . 'px',
			'jumbotron-color'         => 'inherit',
			'jumbotron-bg'            => '#' . $jumbotron_obj->toHex(),
			'jumbotron-heading-color' => 'inherit',
			'jumbotron-font-size'     => 'ceil((@font-size-base * 1.5))',

			'state-success-text'   => '@brand-success',
			'state-success-bg'     => 'mix(@body-bg, @brand-success, 70%)',
			'state-success-border' => 'darken(spin(@state-success-bg, -10), 5%)',

			'state-info-text'   => '@brand-info',
			'state-info-bg'     => 'mix(@body-bg, @brand-info, 70%)',
			'state-info-border' => 'darken(spin(@state-info-bg, -10), 7%)',

			'state-warning-text'   => '@brand-warning',
			'state-warning-bg'     => 'mix(@body-bg, @brand-warning, 70%)',
			'state-warning-border' => 'darken(spin(@state-warning-bg, -10), 5%)',

			'state-danger-text'   => '@brand-danger',
			'state-danger-bg'     => 'mix(@body-bg, @brand-danger, 70%)',
			'state-danger-border' => 'darken(spin(@state-danger-bg, -10), 5%)',

			'tooltip-max-width' => '200px',
			'tooltip-color'     => '@body-bg',
			'tooltip-bg'        => 'darken(@gray-darker, 15%)',
			'tooltip-opacity'   => '.9',

			'tooltip-arrow-width' => '5px',
			'tooltip-arrow-color' => '@tooltip-bg',

			'popover-bg'                    => '@body-bg',
			'popover-max-width'             => '276px',
			'popover-border-color'          => 'rgba(0,0,0,.2)',
			'popover-fallback-border-color' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 20%)' : 'lighten(@body-bg, 20%)',

			'popover-title-bg' => 'darken(@popover-bg, 3%)',

			'popover-arrow-width' => '10px',
			'popover-arrow-color' => '@body-bg',

			'popover-arrow-outer-width'          => '(@popover-arrow-width + 1)',
			'popover-arrow-outer-color'          => 'fadein(@popover-border-color, 5%)',
			'popover-arrow-outer-fallback-color' => 'darken(@popover-fallback-border-color, 20%)',

			'label-default-bg' => '@gray-light',
			'label-primary-bg' => '@brand-primary',
			'label-success-bg' => '@brand-success',
			'label-info-bg'    => '@brand-info',
			'label-warning-bg' => '@brand-warning',
			'label-danger-bg'  => '@brand-danger',

			'label-color'            => '@body-bg',
			'label-link-hover-color' => '@body-bg',

			'modal-inner-padding' => round( get_theme_mod( 'padding_base', 6 ) * ( 20/6 ) ) . 'px',

			'modal-title-padding'     => round( get_theme_mod( 'padding_base', 6 ) * ( 15/6 ) ) . 'px',
			'modal-title-line-height' => '@line-height-base',

			'modal-content-bg'                    => '@body-bg',
			'modal-content-border-color'          => 'rgba(0,0,0,.2)',
			'modal-content-fallback-border-color' => '#999',

			'modal-backdrop-bg'         => '#000',
			'modal-backdrop-opacity'    => '.5',
			'modal-header-border-color' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 10.2%)' : 'lighten(@body-bg, 10.2%)',
			'modal-footer-border-color' => '@modal-header-border-color',

			'modal-lg' => round( $screen_md - ( 3 * $gutter ) ) . 'px',
			'modal-md' => round( $screen_sm - ( 3 * $gutter ) ) . 'px',
			'modal-sm' => round( $screen_xs - ( 3 * $gutter ) ) . 'px',

			'alert-padding'          => round( get_theme_mod( 'padding_base', 6 ) * ( 15/6 ) ) . 'px',
			'alert-border-radius'    => '@border-radius-base',
			'alert-link-font-weight' => 'bold',

			'alert-success-bg'     => '@state-success-bg',
			'alert-success-text'   => '@state-success-text',
			'alert-success-border' => '@state-success-border',

			'alert-info-bg'     => '@state-info-bg',
			'alert-info-text'   => '@state-info-text',
			'alert-info-border' => '@state-info-border',

			'alert-warning-bg'     => '@state-warning-bg',
			'alert-warning-text'   => '@state-warning-text',
			'alert-warning-border' => '@state-warning-border',

			'alert-danger-bg'     => '@state-danger-bg',
			'alert-danger-text'   => '@state-danger-text',
			'alert-danger-border' => '@state-danger-border',

			'progress-bg'        => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 4%)' : 'lighten(@body-bg, 4%)',
			'progress-bar-color' => '@body-bg',

			'progress-bar-bg'         => '@brand-primary',
			'progress-bar-success-bg' => '@brand-success',
			'progress-bar-warning-bg' => '@brand-warning',
			'progress-bar-danger-bg'  => '@brand-danger',
			'progress-bar-info-bg'    => '@brand-info',

			'list-group-bg'            => '@body-bg',
			'list-group-border'        => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',
			'list-group-border-radius' => '@border-radius-base',

			'list-group-hover-bg'          => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 4%)' : 'lighten(@body-bg, 4%)',
			'list-group-active-color'      => '@component-active-color',
			'list-group-active-bg'         => '@component-active-bg',
			'list-group-active-border'     => '@list-group-active-bg',
			'list-group-active-text-color' => 'lighten(@list-group-active-bg, 40%)',

			'list-group-link-color'         => '@gray',
			'list-group-link-heading-color' => '@gray-dark',

			'panel-bg'            => '@body-bg',
			'panel-body-padding'  => round( get_theme_mod( 'padding_base', 6 ) * ( 15/6 ) ) . 'px',
			'panel-border-radius' => '@border-radius-base',

			'panel-inner-border' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',
			'panel-footer-bg'    => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 4%)' : 'lighten(@body-bg, 4%)',

			'panel-default-text'       => '@gray-dark',
			'panel-default-border'     => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',
			'panel-default-heading-bg' => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 4%)' : 'lighten(@body-bg, 4%)',

			'panel-primary-text'       => '@body-bg',
			'panel-primary-border'     => '@brand-primary',
			'panel-primary-heading-bg' => '@brand-primary',

			'panel-success-text'       => '@state-success-text',
			'panel-success-border'     => '@state-success-border',
			'panel-success-heading-bg' => '@state-success-bg',

			'panel-info-text'       => '@state-info-text',
			'panel-info-border'     => '@state-info-border',
			'panel-info-heading-bg' => '@state-info-bg',

			'panel-warning-text'       => '@state-warning-text',
			'panel-warning-border'     => '@state-warning-border',
			'panel-warning-heading-bg' => '@state-warning-bg',

			'panel-danger-text'       => '@state-danger-text',
			'panel-danger-border'     => '@state-danger-border',
			'panel-danger-heading-bg' => '@state-danger-bg',

			'thumbnail-padding'       => round( get_theme_mod( 'padding_base', 6 ) * ( 4/6 ) ) . 'px',
			'thumbnail-bg'            => '@body-bg',
			'thumbnail-border'        => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 13.35%)' : 'lighten(@body-bg, 13.35%)',
			'thumbnail-border-radius' => '@border-radius-base',

			'thumbnail-caption-color'   => '@text-color',
			'thumbnail-caption-padding' => round( get_theme_mod( 'padding_base', 6 ) * ( 9/6 ) ) . 'px',

			'well-bg'     => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 4%)' : 'lighten(@body-bg, 4%)',
			'well-border' => 'darken(@well-bg, 7%)',

			'badge-color'            => '@body-bg',
			'badge-link-hover-color' => '@body-bg',
			'badge-bg'               => '@gray-light',

			'badge-active-color' => '@link-color',
			'badge-active-bg'    => '@body-bg',

			'badge-font-weight'   => 'bold',
			'badge-line-height'   => '1',
			'badge-border-radius' => round( get_theme_mod( 'border_radius', 4 ) * ( 10/4 ) ) . 'px',

			'breadcrumb-padding-vertical'   => round( get_theme_mod( 'padding_base', 6 ) * ( 8/6 ) ) . 'px',
			'breadcrumb-padding-horizontal' => round( get_theme_mod( 'padding_base', 6 ) * ( 15/6 ) ) . 'px',
			'breadcrumb-bg'                 => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 4%)' : 'lighten(@body-bg, 4%)',
			'breadcrumb-color'              => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 20%)' : 'lighten(@body-bg, 20%)',
			'breadcrumb-active-color'       => '@gray-light',
			'breadcrumb-separator'          => '"/"',

			'carousel-text-shadow' => '0 1px 2px rgba(0,0,0,.6)',

			'carousel-control-color'     => '@body-bg',
			'carousel-control-width'     => '15%',
			'carousel-control-opacity'   => '.5',
			'carousel-control-font-size' => '20px',

			'carousel-indicator-active-bg'    => '@body-bg',
			'carousel-indicator-border-color' => '@body-bg',

			'carousel-caption-color' => '@body-bg',

			'close-font-weight' => 'bold',
			'close-color'       => '#000',
			'close-text-shadow' => '0 1px 0 #fff',

			'code-color' => '#c7254e',
			'code-bg'    => '#f9f2f4',

			'kbd-color' => '@body-bg',
			'kbd-bg'    => '#333',

			'pre-bg'                    => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 4%)' : 'lighten(@body-bg, 4%)',
			'pre-color'                 => '@gray-dark',
			'pre-border-color'          => ( 0.3 < $body_lum ) ? 'darken(@body-bg, 20%)' : 'lighten(@body-bg, 20%)',
			'pre-scrollable-max-height' => '340px',

			'text-muted'               => '@gray-light',
			'abbr-border-color'        => '@gray-light',
			'headings-small-color'     => '@gray-light',
			'blockquote-small-color'   => '@gray-light',
			'blockquote-font-size'     => '(@font-size-base * 1.25)',
			'blockquote-border-color'  => '@gray-lighter',
			'page-header-border-color' => '@gray-lighter',

			'hr-border' => '@gray-lighter',

			'component-offset-horizontal' => '180px',
		);

		return $variables;

	}

}

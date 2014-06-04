<?php


/**
* The Header module
*/
class Shoestrap_Header {

	function __construct() {
		add_action( 'shoestrap/wrap/before', array( $this, 'html' ), 3 );
		add_filter( 'shoestrap/styles', array( $this, 'css' ) );

	}

	/*
	 * The Header template
	 */
	function html() { ?>

		<?php if ( 1 == get_theme_mod( 'header_toggle' ) ) : ?>

			<?php if ( 'boxed' == get_theme_mod( 'site_style' ) ) : ?>
				<div class="container header-boxed">
			<?php endif; ?>

				<div class="header-wrapper">

					<?php if ( 'wide' == get_theme_mod( 'site_style' ) ) : ?>
						<div class="container">
					<?php endif; ?>

						<?php if ( 1 == get_theme_mod( 'header_branding' ) ) : ?>
							<?php $extra_class = ( is_active_sidebar( 'header_area' ) ) ? ' col-md-6' : null; ?>
							<a class="brand-logo<?php echo $extra_class; ?>" href="<?php echo home_url(); ?>"><h1><?php shoestrap_logo( bloginfo( 'name' ) ); ?></h1></a>
						<?php endif; ?>

						<?php $extra_class = ( 1 == get_theme_mod( 'header_branding' ) ) ? ' col-md-6' : null; ?>

						<div class="header-widgets<?php echo $extra_class; ?>"><?php dynamic_sidebar( 'header_area' ); ?></div>

					<?php if ( 'wide' == get_theme_mod( 'site_style' ) ) : ?>
						</div>
					<?php endif; ?>

				</div>

			<?php if ( 'boxed' == get_theme_mod( 'site_style' ) ) : ?>
				</div>
			<?php endif;

		endif;
	}

	/*
	 * Any necessary extra CSS is generated here
	 */
	function css( $styles ) {

		if ( 1 == get_theme_mod( 'header_toggle' ) ) {

			$element = ( 'boxed' == get_theme_mod( 'site_style' ) ) ? 'body .header-boxed' : 'body .header-wrapper';

			$styles .= $element . ',';
			$styles .= $element . ' a,';
			$styles .= $element . ' h1,';
			$styles .= $element . ' h2,';
			$styles .= $element . ' h3,';
			$styles .= $element . ' h4,';
			$styles .= $element . ' h5,';
			$styles .= $element . ' h6{ color:' . get_theme_mod( 'header_color', '#333333') . ';}';

			$styles .= ( 0 < get_theme_mod( 'header_margin_top', 0 ) ) ? $element . '{margin-top:' . get_theme_mod( 'header_margin_top', 0 ) . 'px;}' : null;
			$styles .= ( 0 < get_theme_mod( 'header_margin_bottom', 0 ) ) ? $element . '{margin-bottom:' . get_theme_mod( 'header_margin_bottom', 0 ) . 'px;}' : null;

		}

	}

}

$header = new Shoestrap_Header();

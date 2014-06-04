<?php


/**
* The Jumbotron module
*/
class Shoestrap_Jumbotron {

	/**
	 * The class constructor
	 */
	function __construct() {

		add_action( 'shoestrap/wrap/before', array( $this, 'html' ), 5 );
		add_filter( 'shoestrap/styles', array( $this, 'css' ) );

		add_action( 'wp_footer', array( $this, 'fittext_init' ), 999 );
		add_action( 'wp_enqueue_scripts', array( $this, 'fittext_enqueue' ) );

	}

	/*
	 * The content of the Jumbotron region
	 * according to what we've entered in the customizer
	 */
	function html() {

		$site_style   = get_theme_mod( 'site_style', 'wide' );
		$visibility   = get_theme_mod( 'jumbotron_visibility', 1 );
		$nocontainer  = get_theme_mod( 'jumbotron_nocontainer', 0 );

		$hero = ( ( ( 1 == $visibility && is_front_page() ) || 1 != $visibility ) && is_active_sidebar( 'jumbotron' ) ) ? true : false;

		if ( $hero ) : ?>

			<div class="clearfix"></div>

			<?php if ( 'boxed' == $site_style && 1 != $nocontainer ) : ?>
				<div class="container">
			<?php endif; ?>

				<div class="jumbotron">

				<?php if ( ( 1 != $nocontainer && 'wide' == $site_style ) || 'boxed' == $site_style ) : ?>
					<div class="container">
				<?php endif; ?>

					<?php dynamic_sidebar( 'Jumbotron' ); ?>

				<?php if ( ( 1 != $nocontainer && 'wide' == $site_style ) || 'boxed' == $site_style ) : ?>
					</div>
				<?php endif; ?>

				</div>


			<?php if ( 'boxed' == $site_style && 1 != $nocontainer ) : ?>
				</div>
			<?php endif;

		endif;
	}

	/**
	 * Any Jumbotron-specific CSS that can't be added in the .less stylesheet is calculated here.
	 */
	function css( $styles ) {

		$center = get_theme_mod( 'jumbotron_center', 0 );
		$thickness = get_theme_mod( 'jumbotron_border_bottom_thickness', 0 );
		$style     = get_theme_mod( 'jumbotron_border_bottom_style', 'none');
		$color     = get_theme_mod( 'jumbotron_border_bottom_color', '#eeeeee' );

		if ( 0 != $center && 0 != $thickness ) {

			$styles .= '.jumbotron{';

			if ( $center ) {
				$styles .= 'text-align:center;';
			}

			if ( $thickness ) {
				$styles .= 'border-bottom:' . $thickness . 'px ' . $style . ' ' . $color . ';';
			}

			$styles .= '}';

		}

		return $styles;

	}

	/*
	 * Enables the fittext.js for h1 headings
	 */
	function fittext_init() {

		$fittext_toggle   = get_theme_mod( 'jumbotron_title_fit', 0 );
		$jumbo_visibility = get_theme_mod( 'jumbotron_visibility', 1 );

		// Should only show on the front page if it's enabled, or site-wide when appropriate
		if ( 1 == $fittext_toggle && ( 0 == $jumbo_visibility || ( 1 == $jumbo_visibility && is_front_page() ) ) ) {

			echo '<script>jQuery(".jumbotron h1").fitText(1.3);</script>';

		}
	}

	/*
	 * Enqueues fittext.js when needed
	 */
	function fittext_enqueue() {

		$fittext_toggle   = get_theme_mod( 'jumbotron_title_fit', 0 );
		$jumbo_visibility = get_theme_mod( 'jumbotron_visibility', 1 );

		if ( 1 == $fittext_toggle && ( 0 == $jumbo_visibility || ( 1 == $jumbo_visibility && is_front_page() ) ) ) {

			wp_register_script( 'fittext', get_template_directory_uri() . '/framework/bootstrap/assets/js/jquery.fittext.js', false, null, true  );
			wp_enqueue_script( 'fittext' );

		}
	}
}

$jumbotron = new Shoestrap_Jumbotron();

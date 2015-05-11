<?php

class Maera_EDD_Mods {

	function __construct() {

		add_filter( 'edd_purchase_link_defaults', array( $this, 'add_button_class' ) );
		add_action( 'wp', array( $this, 'checkout_no_sidebars' ) );
		add_filter( 'template_include', array( $this, 'templates' ), 99 );
		add_filter( 'edd_template_paths',     array( $this, 'templates_path' ) );

		if ( 1 == get_theme_mod( 'edd_variables_dropdown', 0 ) ) {
			remove_action( 'edd_purchase_link_top', 'edd_purchase_variable_pricing', 10, 1 );
			add_action( 'edd_purchase_link_top', array( $this, 'purchase_variable_pricing' ), 10, 1 );
		}

	}

	/**
	 * Add the /templates folder for our custom templates
	 */
	function templates_path( $file_paths ) {

		$file_paths[50] = MAERA_EDD_PATH . '/templates';
		ksort( $file_paths, SORT_NUMERIC );

		return $file_paths;

	}

	/**
	 * Add the shell button classes to EDD buttons
	 */
	function add_button_class( $defaults ) {

		if ( ! is_singular( 'download' ) ) {
			$class = '[maera_button_default_small]';
		} else {
			$class = '[maera_button_default_extra_large]';
		}

		$defaults['class'] = $class . ' radius';
		return $defaults;

	}

	function checkout_no_sidebars() {

		if ( edd_is_checkout() ) {
			// TODO: force fluid layout
			add_filter( 'maera/sidebar/primary', '__return_false' );
			add_filter( 'maera/sidebar/secondary', '__return_false' );
		}

	}

	function templates( $template ) {

		if ( is_post_type_archive( 'download' ) || is_tax( 'download_category' ) || is_tax( 'download_tag' ) ) {
			$new_template = MAERA_EDD_PATH . '/templates/archive-download.php';
			if ( '' != $new_template ) {
				return $new_template;
			}

		}

		return $template;
	}

	/*
	* Convert variable prices from radio buttons to a dropdown
	*/
	function purchase_variable_pricing( $download_id ) {

		$variable_pricing = edd_has_variable_prices( $download_id );

		if ( ! $variable_pricing ) {
			return;
		}

		$prices = apply_filters( 'edd_purchase_variable_prices', edd_get_variable_prices( $download_id ), $download_id );

		$type   = edd_single_price_option_mode( $download_id ) ? 'checkbox' : 'radio';

		do_action( 'edd_before_price_options', $download_id );

		echo '<div class="edd_price_options">';
		if ( $prices ) {
			echo '<select name="edd_options[price_id][]">';
			foreach ( $prices as $key => $price ) {
				printf(
					'<option for="%3$s" name="edd_options[price_id][]" id="%3$s" class="%4$s" value="%5$s" %7$s> %6$s</option>',
					checked( 0, $key, false ),
					$type,
					esc_attr( 'edd_price_option_' . $download_id . '_' . $key ),
					esc_attr( 'edd_price_option_' . $download_id ),
					esc_attr( $key ),
					esc_html( $price['name'] . ' - ' . edd_currency_filter( edd_format_amount( $price[ 'amount' ] ) ) ),
					selected( isset( $_GET['price_option'] ), $key, false )
				);
				do_action( 'edd_after_price_option', $key, $price, $download_id );
			}
			echo '</select>';
		}
		do_action( 'edd_after_price_options_list', $download_id, $prices, $type );

		echo '</div><!--end .edd_price_options-->';
		do_action( 'edd_after_price_options', $download_id );

	}

}

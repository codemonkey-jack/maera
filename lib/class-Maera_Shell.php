<?php

/**
 * Shell calculations
 */
class Maera_Shell {

	function __construct() {

		// Include the Core shell
		require_once locate_template( '/core-shell/class-Maera_Shell_Core.php' );

		$this->enable_shell();

		add_filter( 'timber_output', array( $this, 'do_twig_replacements' ) );
		add_action( 'init', array( $this, 'fallback_shell' ) );

	}


	/**
	 * Activate the enabled shell
	 */
	function enable_shell() {

		// Get the option from the database
		$options = get_option( 'maera_admin_options', array() );

		$active_shell = ( isset( $options['shell'] ) ) ? $options['shell'] : 'core';
		$active_shell = ( empty( $active_shell ) || '' == $active_shell ) ? 'core' : $active_shell;

		// Get the list of available shells
		$available_shells = apply_filters( 'maera/shells/available', array() );

		// Figure out the enabled shell
		foreach ( $available_shells as $available_shell ) {

			if ( $active_shell == $available_shell['value'] ) {
				// Instantianate the active shell
				global $ss_shell;
				$ss_shell = $available_shell['class']::get_instance();
			}

		}

	}

	/**
	 * Make sure the active shell exists.
	 * If the active shell is not in the array of available shells
	 * then fallback to the core shell.
	 */
	function fallback_shell() {

		$options = get_option( 'maera_admin_options', array() );
		$active  = ( isset( $options['shell'] ) ) ? $options['shell'] : 'core';
		$shells  = apply_filters( 'maera/shells/available', array() );
		$values  = array_column( $shells, 'value' );

		if ( ! in_array( $options['shell'], $values ) ) {
			$options['shell'] = 'core';
			update_option( 'maera_admin_options', $options );
		}

	}

	public function replacements() {

		$replacements = array(
			'maera_grid_container_open',
			'maera_grid_container_close',
			'maera_grid_container_class',

			'maera_grid_row_open',
			'maera_grid_row_close',
			'maera_grid_row_class',

			'maera_grid_col_1',
			'maera_grid_col_2',
			'maera_grid_col_3',
			'maera_grid_col_4',
			'maera_grid_col_5',
			'maera_grid_col_6',
			'maera_grid_col_7',
			'maera_grid_col_8',
			'maera_grid_col_9',
			'maera_grid_col_10',
			'maera_grid_col_11',
			'maera_grid_col_12',

			'maera_button_default_extra_small',
			'maera_button_default_small',
			'maera_button_default_medium',
			'maera_button_default_large',
			'maera_button_default_extra_large',

			'maera_button_primary_extra_small',
			'maera_button_primary_small',
			'maera_button_primary_medium',
			'maera_button_primary_large',
			'maera_button_primary_extra_large',

			'maera_button_success_extra_small',
			'maera_button_success_small',
			'maera_button_success_medium',
			'maera_button_success_large',
			'maera_button_success_extra_large',

			'maera_button_info_extra_small',
			'maera_button_info_small',
			'maera_button_info_medium',
			'maera_button_info_large',
			'maera_button_info_extra_large',

			'maera_button_warning_extra_small',
			'maera_button_warning_small',
			'maera_button_warning_medium',
			'maera_button_warning_large',
			'maera_button_warning_extra_large',

			'maera_button_danger_extra_small',
			'maera_button_danger_small',
			'maera_button_danger_medium',
			'maera_button_danger_large',
			'maera_button_danger_extra_large',

			'maera_button_link_extra_small',
			'maera_button_link_small',
			'maera_button_link_medium',
			'maera_button_link_large',
			'maera_button_link_extra_large',
		);

		return apply_filters( 'maera/twig/placeholders', $replacements );

	}

	/**
	 * Get the twig file and pass the replacement to it.
	 * This function is just a helper for the do_twig_replacements function.
	 */
	public static function twig_replacements( $replacement = false ) {

		// If no replacement has been defined, exit.
		if ( ! $replacement ) {
			return;
		}

		$context = Timber::get_context();
		$context['element'] = $replacement;
		Timber::render( array( 'twig-str_replace.twig', ), $context, Maera()->cache->cache_duration() );

	}

	/**
	 * Get the list of replacements and perform a str_replace for them to the rendered HTML of the page
	 * replacing all defined replacements with their respective rendered twig elements from the active shell.
	 */
	function do_twig_replacements( $content ) {

		$replacements = $this->replacements();

		foreach ( $replacements as $replacement => $value ) {

			if ( false !== strpos( $content, '[' . $value . ']' ) ) {

				$replaced = maera_get_echo( 'maera_helper_get_replacements', $value );
				$content  = str_replace( '[' . $value . ']', $replaced, $content );

			}

		}

		return $content;

	}

}

/**
 * Helper function to avoid a fatal error on WPEngine hosting
 */
function maera_helper_get_replacements( $replacement = false ) {
	Maera_Shell::twig_replacements( $replacement );
}

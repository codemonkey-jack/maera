<?php

// Include the compiler class
require_once locate_template( '/lib/compilers/class-Maera_Compiler.php' );

// Include the Core shell
require_once locate_template( '/core-shell/class-Maera_Shell_Core.php' );

/**
 * Activate the enabled shell
 */


// Get the option from the database
$options = get_option( 'maera_admin_options', 'bootstrap' );

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

function maera_twig_replacements( $content ) {

	$content = str_replace( '~maera_open_container~', '{{ shell.open_container() }}', $content );
	$content = str_replace( '~maera_close_container~', '{{ shell.close_container() }}', $content );

	$content = str_replace( '~maera_open_row~', '{{ shell.open_row() }}', $content );
	$content = str_replace( '~maera_close_row~', '{{ shell.close_row() }}', $content );

	$content = str_replace( '~maera_open_col_1~', '{{ shell.open_col( "div", ["medium":1] ) }}', $content );
	$content = str_replace( '~maera_open_col_2~', '{{ shell.open_col( "div", ["medium":2] ) }}', $content );
	$content = str_replace( '~maera_open_col_3~', '{{ shell.open_col( "div", ["medium":3] ) }}', $content );
	$content = str_replace( '~maera_open_col_4~', '{{ shell.open_col( "div", ["medium":4] ) }}', $content );
	$content = str_replace( '~maera_open_col_5~', '{{ shell.open_col( "div", ["medium":5] ) }}', $content );
	$content = str_replace( '~maera_open_col_6~', '{{ shell.open_col( "div", ["medium":6] ) }}', $content );
	$content = str_replace( '~maera_open_col_7~', '{{ shell.open_col( "div", ["medium":7] ) }}', $content );
	$content = str_replace( '~maera_open_col_8~', '{{ shell.open_col( "div", ["medium":8] ) }}', $content );
	$content = str_replace( '~maera_open_col_9~', '{{ shell.open_col( "div", ["medium":9] ) }}', $content );
	$content = str_replace( '~maera_open_col_10~', '{{ shell.open_col( "div", ["medium":10] ) }}', $content );
	$content = str_replace( '~maera_open_col_11~', '{{ shell.open_col( "div", ["medium":11] ) }}', $content );
	$content = str_replace( '~maera_open_col_12~', '{{ shell.open_col( "div", ["medium":12] ) }}', $content );
	$content = str_replace( '~maera_close_col~', '{{ shell.open_col( "div" ) }}', $content );

	$content = str_replace( '~maera_button_classes_default_extra_small~', '{{ shell.button_classes( "default", "extra-small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_default_small~', '{{ shell.button_classes( "default", "small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_default_medium~', '{{ shell.button_classes( "default", "medium" ) }}', $content );
	$content = str_replace( '~maera_button_classes_default_large~', '{{ shell.button_classes( "default", "large" ) }}', $content );
	$content = str_replace( '~maera_button_classes_default_extra_large~', '{{ shell.button_classes( "default", "extra-large" ) }}', $content );

	$content = str_replace( '~maera_button_classes_primary_extra_small~', '{{ shell.button_classes( "primary", "extra-small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_primary_small~', '{{ shell.button_classes( "primary", "small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_primary_medium~', '{{ shell.button_classes( "primary", "medium" ) }}', $content );
	$content = str_replace( '~maera_button_classes_primary_large~', '{{ shell.button_classes( "primary", "large" ) }}', $content );
	$content = str_replace( '~maera_button_classes_primary_extra_large~', '{{ shell.button_classes( "primary", "extra-large" ) }}', $content );

	$content = str_replace( '~maera_button_classes_success_extra_small~', '{{ shell.button_classes( "success", "extra-small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_success_small~', '{{ shell.button_classes( "success", "small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_success_medium~', '{{ shell.button_classes( "success", "medium" ) }}', $content );
	$content = str_replace( '~maera_button_classes_success_large~', '{{ shell.button_classes( "success", "large" ) }}', $content );
	$content = str_replace( '~maera_button_classes_success_extra_large~', '{{ shell.button_classes( "success", "extra-large" ) }}', $content );

	$content = str_replace( '~maera_button_classes_info_extra_small~', '{{ shell.button_classes( "info", "extra-small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_info_small~', '{{ shell.button_classes( "info", "small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_info_medium~', '{{ shell.button_classes( "info", "medium" ) }}', $content );
	$content = str_replace( '~maera_button_classes_info_large~', '{{ shell.button_classes( "info", "large" ) }}', $content );
	$content = str_replace( '~maera_button_classes_info_extra_large~', '{{ shell.button_classes( "info", "extra-large" ) }}', $content );

	$content = str_replace( '~maera_button_classes_warning_extra_small~', '{{ shell.button_classes( "warning", "extra-small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_warning_small~', '{{ shell.button_classes( "warning", "small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_warning_medium~', '{{ shell.button_classes( "warning", "medium" ) }}', $content );
	$content = str_replace( '~maera_button_classes_warning_large~', '{{ shell.button_classes( "warning", "large" ) }}', $content );
	$content = str_replace( '~maera_button_classes_warning_extra_large~', '{{ shell.button_classes( "warning", "extra-large" ) }}', $content );

	$content = str_replace( '~maera_button_classes_danger_extra_small~', '{{ shell.button_classes( "danger", "extra-small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_danger_small~', '{{ shell.button_classes( "danger", "small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_danger_medium~', '{{ shell.button_classes( "danger", "medium" ) }}', $content );
	$content = str_replace( '~maera_button_classes_danger_large~', '{{ shell.button_classes( "danger", "large" ) }}', $content );
	$content = str_replace( '~maera_button_classes_danger_extra_large~', '{{ shell.button_classes( "danger", "extra-large" ) }}', $content );

	$content = str_replace( '~maera_button_classes_link_extra_small~', '{{ shell.button_classes( "link", "extra-small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_link_small~', '{{ shell.button_classes( "link", "small" ) }}', $content );
	$content = str_replace( '~maera_button_classes_link_medium~', '{{ shell.button_classes( "link", "medium" ) }}', $content );
	$content = str_replace( '~maera_button_classes_link_large~', '{{ shell.button_classes( "link", "large" ) }}', $content );
	$content = str_replace( '~maera_button_classes_link_extra_large~', '{{ shell.button_classes( "link", "extra-large" ) }}', $content );

	$content = str_replace( '~maera_clearfix~', '{{ shell.clearfix() }}', $content );
	$content = str_replace( '~maera_float_left~', '{{ shell.float_class( "left" ) }}', $content );
	$content = str_replace( '~maera_float_right~', '{{ shell.float_class( "right" ) }}', $content );
	$content = str_replace( '~maera_pagination_class~', '{{ shell.pagination_ul_class() }}', $content );

}
// add_filter( 'timber_loader_render_data', 'maera_twig_replacements' );

<?php

// Require the Core Framework class
require_once locate_template( '/framework/class-SS_Framework_Core.php' );

/**
 * Builds the framework array.
 * This will be used by Timber
 */
function shoestrap_framework_array() {
	$ss_framework = SS_Framework_Core::get_instance();

	$framework = array();

	// Containers
	$framework['open_container']       = $ss_framework->open_container();
	$framework['close_container']      = $ss_framework->close_container();

	// Rows
	$framework['open_row']             = $ss_framework->open_row();
	$framework['close_row']            = $ss_framework->close_row();

	//Columns
	$framework['open_col']             = $ss_framework->open_col();
	$framework['close_col']            = $ss_framework->close_col();
	$framework['column_classes']       = $ss_framework->column_classes();

	// Buttons
	$framework['make_dropdown_button'] = $ss_framework->make_dropdown_button();
	$framework['button_classes']       = $ss_framework->button_classes();
	$framework['button_group_classes'] = $ss_framework->button_group_classes();

	// Clearfix
	$framework['clearfix']             = $ss_framework->clearfix();

	// Pagination
	$framework['pagination_ul_class']  = $ss_framework->pagination_ul_class();

	// Alerts
	$framework['alert']                = $ss_framework->alert();

	//Panels
	$framework['open_panel']           = $ss_framework->open_panel();
	$framework['close_panel']          = $ss_framework->close_panel();
	$framework['open_panel_heading']   = $ss_framework->open_panel_heading();
	$framework['close_panel_heading']  = $ss_framework->close_panel_heading();
	$framework['open_panel_body']      = $ss_framework->open_panel_body();
	$framework['close_panel_body']     = $ss_framework->close_panel_body();
	$framework['open_panel_footer']    = $ss_framework->open_panel_footer();
	$framework['close_panel_footer']   = $ss_framework->close_panel_footer();

	// Wrapper
	$framework['include_wrapper']      = $ss_framework->include_wrapper();

	// Form Inputs
	$framework['form_input_classes']   = $ss_framework->form_input_classes();

	// Panel Classes
	$framework['panel_classes']        = $ss_framework->panel_classes();

	//Helpers
	$framework['float_class']          = $ss_framework->float_class();

	//Tabs
	$framework['make_tabs']            = $ss_framework->make_tabs();

	//Logo
	$framework['logo']                 = $ss_framework->logo();

	return $framework;
}

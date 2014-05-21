<?php

function shoestrap_breadcrumbs() {

	$breadcrumbs = get_theme_mod( 'breadcrumbs', 0 );

	if ( 0 != $breadcrumbs ) {

		$ss_breadcrumbs = new Shoestrap_Breadcrumbs();
		echo $ss_breadcrumbs->breadcrumb( false );

	}

}
add_action( 'shoestrap/content/before', 'shoestrap_breadcrumbs' );

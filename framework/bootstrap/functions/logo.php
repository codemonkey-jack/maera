<?php

/*
 * The site logo.
 * If no custom logo is uploaded, use the sitename
 */
function shoestrap_logo( $branding ) {

	$logo = get_theme_mod( 'logo' );

	if ( $logo ) {
		return '<img class="navbar-brand" id="site-logo" src="' . $logo . '" alt="' . get_bloginfo( 'name' ) .'">';
	} else {
		echo $branding;
	}

}

// Add the logo to the main navbar.
function shoestrap_navbar_logo() {

	// If we've selected NOT to display the logo on navbars, then do not proceed.
	if ( 1 != get_theme_mod( 'navbar_logo', 1 ) ) {
		return;
	}

	add_action( 'shoestrap/topbar/brand', 'shoestrap_logo' );

}
add_action( 'init', 'shoestrap_navbar_logo' );

<?php

/**
 * Register sidebars and widgets
 */
function shoestrap_bs_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Header Area', 'shoestrap' ),
		'id'            => 'header_area',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h1>',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Jumbotron', 'shoestrap' ),
		'id'            => 'jumbotron',
		'before_widget' => '<section id="%1$s"><div class="section-inner">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h1>',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'In-Navbar Widget Area', 'shoestrap' ),
		'id'            => 'navbar',
		'description'   => __( 'This widget area will show up in your NavBars. This is most useful when using a static-left navbar.', 'shoestrap' ),
		'before_widget' => '<div id="in-navbar">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1>',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Navbar Slide-Down Top', 'shoestrap' ),
		'id'            => 'navbar_slide_down_top',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Navbar Slide-Down 1', 'shoestrap' ),
		'id'            => 'navbar_slide_down_1',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Navbar Slide-Down 2', 'shoestrap' ),
		'id'            => 'navbar_slide_down_2',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Navbar Slide-Down 3', 'shoestrap' ),
		'id'            => 'navbar_slide_down_3',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Navbar Slide-Down 4', 'shoestrap' ),
		'id'            => 'navbar_slide_down_4',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

}
add_action( 'widgets_init', 'shoestrap_bs_widgets_init' );

/**
 * Get the widget class
 */
function shoestrap_alter_widgets_class() {

	$widgets_mode = get_theme_mod( 'widgets_mode', 0 );

	if ( 0 == $widgets_mode ) {
		return 'panel panel-default';
	} elseif ( 1 == $widgets_mode ) {
		return 'well';
	}

}
add_action( 'shoestrap/widgets/class', 'shoestrap_alter_widgets_class' );

/**
 * Widgets 'before_title' modifying based on widgets mode.
 */
function shoestrap_alter_widgets_before_title() {

	$widgets_mode = get_theme_mod( 'widgets_mode', 0 );

	if ( 0 == $widgets_mode ) {
		return '<div class="panel-heading">';
	} elseif ( 1 == $widgets_mode ) {
		return '<h3 class="widget-title">';
	}

}
add_action( 'shoestrap/widgets/title/before', 'shoestrap_alter_widgets_before_title' );

/**
 * Widgets 'after_title' modifying based on widgets mode.
 */
function shoestrap_alter_widgets_after_title() {

	$widgets_mode = get_theme_mod( 'widgets_mode', 0 );

	if ( 0 == $widgets_mode ) {
		return '</div><div class="panel-body">';
	} elseif ( 1 == $widgets_mode ) {
		return '</h3>';
	}

}
add_action( 'shoestrap/widgets/title/after', 'shoestrap_alter_widgets_after_title' );

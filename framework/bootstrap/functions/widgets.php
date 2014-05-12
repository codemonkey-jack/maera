<?php

/**
 * Register sidebars and widgets
 */
function shoestrap_bs_widgets_init() {
	$class        = apply_filters( 'shoestrap/widgets/class', '' );
	$before_title = apply_filters( 'shoestrap/widgets/title/before', '<h3 class="widget-title">' );
	$after_title  = apply_filters( 'shoestrap/widgets/title/after', '</h3>' );

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

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 1', 'shoestrap' ),
		'id'            => 'sidebar_footer_1',
		'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 2', 'shoestrap' ),
		'id'            => 'sidebar_footer_2',
		'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 3', 'shoestrap' ),
		'id'            => 'sidebar_footer_3',
		'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 4', 'shoestrap' ),
		'id'            => 'sidebar_footer_4',
		'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );
}
add_action( 'widgets_init', 'shoestrap_bs_widgets_init' );

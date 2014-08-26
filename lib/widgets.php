<?php

/**
 * Register sidebars and widgets
 */
function shoestrap_widgets_init() {
	$class        = apply_filters( 'shoestrap/widgets/class', '' );
	$before_title = apply_filters( 'shoestrap/widgets/title/before', '<h3 class="widget-title">' );
	$after_title  = apply_filters( 'shoestrap/widgets/title/after', '</h3>' );

	// Sidebars
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'shoestrap' ),
		'id'            => 'sidebar_primary',
		'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Sidebar', 'shoestrap' ),
		'id'            => 'sidebar_secondary',
		'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

}
add_action( 'widgets_init', 'shoestrap_widgets_init' );


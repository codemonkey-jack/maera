<?php

/**
 * Register sidebars and widgets
 */
function maera_widgets_init() {
	$class        = apply_filters( 'maera/widgets/class', '' );
	$before_title = apply_filters( 'maera/widgets/title/before', '<h3 class="widget-title">' );
	$after_title  = apply_filters( 'maera/widgets/title/after', '</h3>' );

	// Sidebars
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'maera' ),
		'id'            => 'sidebar_primary',
		'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Sidebar', 'maera' ),
		'id'            => 'sidebar_secondary',
		'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

}
add_action( 'widgets_init', 'maera_widgets_init' );


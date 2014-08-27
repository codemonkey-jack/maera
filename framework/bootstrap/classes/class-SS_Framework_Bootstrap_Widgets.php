<?php

if ( ! class_exists( 'SS_Framework_Bootstrap_Widgets' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class SS_Framework_Bootstrap_Widgets {

		/**
		 * Class constructor
		 */
		public function __construct() {

			add_action( 'shoestrap/top-bar/before', array( $this, 'extra_widgets_body_top' ) );
			add_action( 'shoestrap/wrap/before', array( $this, 'extra_widgets_pre_header' ), 3 );
			add_action( 'shoestrap/extra_header/widgets', array( $this, 'extra_widgets_header' ) );
			add_action( 'shoestrap/extra_header/after', array( $this, 'extra_widgets_post_header' ) );
			add_action( 'shoestrap/jumbotron', array( $this, 'extra_widgets_jumbotron' ) );
			add_action( 'shoestrap/wrap/before', array( $this, 'extra_widgets_pre_content' ) );
			add_action( 'shoestrap/content/before', array( $this, 'extra_widgets_pre_main' ) );
			add_action( 'shoestrap/content/after', array( $this, 'extra_widgets_post_main' ) );
			add_action( 'shoestrap/footer/before', array( $this, 'extra_widgets_pre_footer' ) );
			add_action( 'shoestrap/footer/content', array( $this, 'extra_widgets_footer' ) );
			add_action( 'shoestrap/footer/after', array( $this, 'extra_widgets_post_footer' ) );

			// Widgets
			add_action( 'widgets_init', array( $this, 'widget_areas' ), 12 );
			add_action( 'shoestrap/widgets/class', array( $this, 'widgets_class' ) );
			add_action( 'shoestrap/widgets/title/before', array( $this, 'widgets_before_title' ) );
			add_action( 'shoestrap/widgets/title/after', array( $this, 'widgets_after_title' ) );
		}


		/**
		 * Return an array of the extra widget area regions
		 */
		function extra_widget_areas_array() {

			$areas = array(
				'body_top'     => array( 'name' => __( 'Body Top', 'shoestrap' ),     'default' => 0 ),
				'pre_header'   => array( 'name' => __( 'Pre-Header', 'shoestrap' ),   'default' => 0 ),
				'header'       => array( 'name' => __( 'Header', 'shoestrap' ),       'default' => 0 ),
				'post_header'  => array( 'name' => __( 'Post-Header', 'shoestrap' ),  'default' => 0 ),
				'jumbotron'    => array( 'name' => __( 'Jumbotron', 'shoestrap' ),    'default' => 0 ),
				'pre_content'  => array( 'name' => __( 'Pre-Content', 'shoestrap' ),  'default' => 0 ),
				'pre_main'     => array( 'name' => __( 'Pre-Main', 'shoestrap' ),     'default' => 0 ),
				'post_main'    => array( 'name' => __( 'Post-Main', 'shoestrap' ),    'default' => 0 ),
				'pre_footer'   => array( 'name' => __( 'Pre-Footer', 'shoestrap' ),   'default' => 0 ),
				'footer'       => array( 'name' => __( 'Footer', 'shoestrap' ),       'default' => 0 ),
				'post_footer'  => array( 'name' => __( 'Post-Footer', 'shoestrap' ),  'default' => 0 ),
			);

			return $areas;

		}


		/**
		 * Register sidebars and widgets
		 */
		function widget_areas() {

			register_sidebar( array(
				'name'          => __( 'Header Area', 'shoestrap' ),
				'id'            => 'header_area',
				'before_widget' => '<div>',
				'after_widget'  => '</div>',
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

			$areas = $this->extra_widget_areas_array();

			$class        = apply_filters( 'shoestrap/widgets/class', '' );
			$before_title = apply_filters( 'shoestrap/widgets/title/before', '<h3 class="widget-title">' );
			$after_title  = apply_filters( 'shoestrap/widgets/title/after', '</h3>' );

			foreach ( $areas as $area => $settings ) {

				$areas_nr = get_theme_mod( $area . '_widgets_nr', $settings['default'] );

				if ( 0 < $areas_nr ) {

					for ( $i = 0;  $i < $areas_nr;  $i++ ) {

						register_sidebar( array(
							'name'          => $settings['name'] . ' ' . $i,
							'id'            => $area . '_' . $i,
							'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
							'after_widget'  => '</section>',
							'before_title'  => $before_title,
							'after_title'   => $after_title,
						) );

					}

				}

			}

		}


		/**
		 * Get the widget class
		 */
		function widgets_class() {

			$widgets_mode = get_theme_mod( 'widgets_mode', 'none' );

			if ( 'panel' == $widgets_mode ) {
				return 'panel panel-default';
			} elseif ( 'well' == $widgets_mode ) {
				return 'well';
			}

		}


		/**
		 * Widgets 'before_title' modifying based on widgets mode.
		 */
		function widgets_before_title() {

			$widgets_mode = get_theme_mod( 'widgets_mode', 'none' );

			if ( 'panel' == $widgets_mode ) {
				return '<div class="panel-heading">';
			} elseif ( 'well' == $widgets_mode ) {
				return '<h3 class="widget-title">';
			}

		}


		/**
		 * Widgets 'after_title' modifying based on widgets mode.
		 */
		function widgets_after_title() {

			$widgets_mode = get_theme_mod( 'widgets_mode', 'none' );

			if ( 'panel' == $widgets_mode ) {
				return '</div><div class="panel-body">';
			} elseif ( 'well' == $widgets_mode ) {
				return '</h3>';
			}

		}


		/**
		 * Extra body_top widget areas
		 */
		function extra_widgets_body_top() {

			$area     = 'body_top';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}


		/**
		 * Extra pre_header widget areas
		 */
		function extra_widgets_pre_header() {

			$area     = 'pre_header';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}


		/**
		 * Extra header widget areas
		 */
		function extra_widgets_header() {

			$area     = 'header';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}


		/**
		 * Extra post_header widget areas
		 */
		function extra_widgets_post_header() {

			$area     = 'post_header';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}


		/**
		 * Extra jumbotron widget areas
		 */
		function extra_widgets_jumbotron() {

			$area     = 'jumbotron';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}


		/**
		 * Extra pre_content widget areas
		 */
		function extra_widgets_pre_content() {

			$area     = 'pre_content';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}


		/**
		 * Extra pre_main widget areas
		 */
		function extra_widgets_pre_main() {

			$area     = 'pre_main';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}


		/**
		 * Extra post_main widget areas
		 */
		function extra_widgets_post_main() {

			$area     = 'post_main';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}


		/**
		 * Extra pre_footer widget areas
		 */
		function extra_widgets_pre_footer() {

			$area     = 'pre_footer';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}


		/**
		 * Extra footer widget areas
		 */
		function extra_widgets_footer() {

			$area     = 'footer';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}


		/**
		 * Extra post_footer widget areas
		 */
		function extra_widgets_post_footer() {

			$area     = 'post_footer';
			$areas_nr = get_theme_mod( $area . '_widgets_nr', 0 );

			if ( 0 < $areas_nr ) : ?>

				<div class="row row-<?php echo $area; ?>">

					<?php for ( $i = 0;  $i < $areas_nr;  $i++ ) : ?>
						<?php $this->extra_widgets_render_content( $areas_nr, $area, $i ); ?>
					<?php endfor; ?>

				</div>

			<?php endif;

		}

		function extra_widgets_render_content( $areas_nr, $area, $i ) {

			$class = apply_filters( 'shoestrap/extra_widgets/' . $area . '/' . $i, 'col-md-' . ( 12 / $areas_nr ) ); ?>

			<div class="<?php echo $area . '_' . $i . ' ' . $class; ?>">
				<?php dynamic_sidebar( $area . '_' . $i ); ?>
			</div>

			<?php

		}

	}

}

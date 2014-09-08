<?php

if ( ! class_exists( 'Maera_Framework_Bootstrap_Widgets' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class Maera_Framework_Bootstrap_Widgets {

		/**
		 * Class constructor
		 */
		public function __construct() {

			add_action( 'maera/header/before', array( $this, 'extra_widgets_body_top' ) );
			add_action( 'maera/extra_header/before', array( $this, 'extra_widgets_pre_header' ), 3 );
			add_action( 'maera/extra_header/widgets', array( $this, 'extra_widgets_header' ) );
			add_action( 'maera/extra_header/after', array( $this, 'extra_widgets_post_header' ) );
			add_action( 'maera/jumbotron/content', array( $this, 'extra_widgets_jumbotron' ) );
			add_action( 'maera/wrap/before', array( $this, 'extra_widgets_pre_content' ) );
			add_action( 'maera/content/before', array( $this, 'extra_widgets_pre_main' ) );
			add_action( 'maera/content/after', array( $this, 'extra_widgets_post_main' ) );
			add_action( 'maera/footer/before', array( $this, 'extra_widgets_pre_footer' ) );
			add_action( 'maera/footer/content', array( $this, 'extra_widgets_footer' ) );
			add_action( 'maera/footer/after', array( $this, 'extra_widgets_post_footer' ) );

			// Widgets
			add_action( 'widgets_init', array( $this, 'widget_areas' ), 12 );
			add_action( 'maera/widgets/class', array( $this, 'widgets_class' ) );
			add_action( 'maera/widgets/title/before', array( $this, 'widgets_before_title' ) );
			add_action( 'maera/widgets/title/after', array( $this, 'widgets_after_title' ) );
		}


		/**
		 * Return an array of the extra widget area regions
		 */
		function extra_widget_areas_array() {

			$areas = array(
				'body_top'     => array( 'name' => __( 'Body Top', 'maera' ),     'default' => 0 ),
				'pre_header'   => array( 'name' => __( 'Pre-Header', 'maera' ),   'default' => 0 ),
				'header'       => array( 'name' => __( 'Header', 'maera' ),       'default' => 0 ),
				'post_header'  => array( 'name' => __( 'Post-Header', 'maera' ),  'default' => 0 ),
				'jumbotron'    => array( 'name' => __( 'Jumbotron', 'maera' ),    'default' => 0 ),
				'pre_content'  => array( 'name' => __( 'Pre-Content', 'maera' ),  'default' => 0 ),
				'pre_main'     => array( 'name' => __( 'Pre-Main', 'maera' ),     'default' => 0 ),
				'post_main'    => array( 'name' => __( 'Post-Main', 'maera' ),    'default' => 0 ),
				'pre_footer'   => array( 'name' => __( 'Pre-Footer', 'maera' ),   'default' => 0 ),
				'footer'       => array( 'name' => __( 'Footer', 'maera' ),       'default' => 0 ),
				'post_footer'  => array( 'name' => __( 'Post-Footer', 'maera' ),  'default' => 0 ),
			);

			return $areas;

		}


		/**
		 * Register sidebars and widgets
		 */
		function widget_areas() {

			$areas = $this->extra_widget_areas_array();

			$class        = apply_filters( 'maera/widgets/class', '' );
			$before_title = apply_filters( 'maera/widgets/title/before', '<h3 class="widget-title">' );
			$after_title  = apply_filters( 'maera/widgets/title/after', '</h3>' );

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

			$class = apply_filters( 'maera/extra_widgets/' . $area . '/' . $i, 'col-md-' . ( 12 / $areas_nr ) ); ?>

			<div class="<?php echo $area . '_' . $i . ' ' . $class; ?>">
				<?php dynamic_sidebar( $area . '_' . $i ); ?>
			</div>

			<?php

		}

	}

}

/**
 * Adds Maera Logo widget.
 */
class Maera_Logo_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'maera_logo',
			__( 'Logo (Maera Bootstrap)', 'maera' ),
			array( 'description' => __( 'The logo you have specified in the Customizer', 'maera' ), )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		$logo = get_theme_mod( 'logo', '' );

		if ( $logo ) {
			echo '<img id="brand-logo" src="' . $logo . '" alt="' . get_bloginfo( 'name' ) .'">';
		}

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		_e( 'This widget has no options. Its only function is to print the site logo, as defined in the theme customizer. You can use this wherever you need, particularly useful in the header widget areas, or to accomplish alternative site layouts', 'maera' );

	}

}

function register_maera_logo_widget() {
    register_widget( 'Maera_Logo_Widget' );
}
add_action( 'widgets_init', 'register_maera_logo_widget' );

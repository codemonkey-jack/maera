<?php

if ( ! class_exists( 'Maera_Bootstrap_Structure' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class Maera_Bootstrap_Structure {

		/**
		 * Class constructor
		 */
		public function __construct() {

			add_action( 'maera/header/inside/begin', array( $this, 'social_links_navbar_content' ), 10 );
			add_filter( 'maera/header/menu/class', array( $this, 'navbar_links_alignment' ) );
			add_action( 'maera/header/inside/begin', array( $this, 'navbar_search' ), 5 );

			// Breadcrumbs
			add_action( 'maera/content/before', array( $this, 'breadcrumbs' ) );

			add_action( 'maera/wrap/before', array( $this, 'header_html' ), 3 );
			add_action( 'maera/wrap/before', array( $this, 'jumbotron_html' ), 5 );

			add_filter( 'maera/header/class', array( $this, 'navbar_positioning_class' ) );

			add_filter( 'body_class', array( $this, 'body_class' ) );

			add_action( 'wp', array( $this, 'sidebars_bypass' ) );

			// Layout
			add_filter( 'maera/section_class/content', array( $this, 'layout_classes_content' ) );
			add_filter( 'maera/section_class/primary', array( $this, 'layout_classes_primary' ) );
			add_filter( 'maera/section_class/secondary', array( $this, 'layout_classes_secondary' ) );
			add_filter( 'maera/section_class/wrapper', array( $this, 'layout_classes_wrapper' ) );
			add_action( 'wp', array( $this, 'container_class_modifier' ) );

			add_filter( 'maera/image/height', array( $this, 'get_feat_image_height' ) );
			add_filter( 'maera/image/width', array( $this, 'get_feat_image_width' ) );
			add_filter( 'the_content', array( $this, 'inject_featured_images_content' ), 100 );
			add_filter( 'maera/image/display', array( $this, 'display_feat_image_posts' ) );

			// Post Meta
			add_action( 'maera/entry/meta', array( $this, 'meta_elements' ), 10, 1 );

			add_filter( 'maera/content_width', array( $this, 'content_width_px' ) );

		}


		/*
		 * Calculate the width of the content area in pixels.
		 */
		public static function content_width_px() {

			$layout = apply_filters( 'maera/layout/modifier', get_theme_mod( 'layout', 1 ) );

			$container  = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
			$gutter     = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );

			$main_span  = filter_var( self::layout_classes( 'content' ), FILTER_SANITIZE_NUMBER_INT );
			$main_span  = str_replace( '-' , '', $main_span );

			// If the layout is #5, override the default function and calculate the span width of the main area again.
			if ( is_active_sidebar( 'sidebar-secondary' ) && is_active_sidebar( 'sidebar-primary' ) && $layout == 5 ) {
				$main_span = 12 - intval( get_theme_mod( 'layout_primary_width', 4 ) ) - intval( get_theme_mod( 'layout_secondary_width', 3 ) );
			}

			$width = $container * ( $main_span / 12 ) - $gutter;

			// Width should be an integer since we're talking pixels, round up!.
			$width = round( $width );

			return $width;
		}


		/**
		 * Figure out the post meta that we want to use and inject them to our content.
		 */
		public function meta_elements( $post_id ) {

			$post = get_post( $post_id );

			// Get the options from the db
			$metas       = get_theme_mod( 'maera_entry_meta_config', 'post-format, date, author, comments' );
			$date_format = get_theme_mod( 'date_meta_format', 1 );

			$categories_list = has_category( '', $post_id ) ? get_the_category_list( __( ', ', 'maera' ), '', $post_id ) : false;
			$tag_list        = has_tag( '', $post_id ) ? get_the_tag_list( '', __( ', ', 'maera' ) ) : false;

			// No need to proceed if the option is empty
			if ( empty( $metas ) ) {
				return;
			}

			$content = '';

			// convert options from CSV to array
			$metas_array = explode( ',', $metas );

			// clean up the array a bit... make sure there are no spaces that may mess things up
			$metas_array = array_map( 'trim', $metas_array );

			foreach ( $metas_array as $meta ) {

				if ( 'author' == $meta ) { // Author

					$content .= sprintf( '<span class="post-meta-element ' . $meta . '"><span class="author vcard"><i class="el-icon-user icon"></i> <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></span>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) ),
						esc_attr( sprintf( __( 'View all posts by %s', 'maera' ), get_the_author_meta( 'display_name', $post->post_author ) ) ),
						get_the_author_meta( 'display_name', $post->post_author )
					);

				} elseif ( 'sticky' == $meta ) { // Sticky

					if ( is_sticky() ) {
						$content .= '<span class="post-meta-element ' . $meta . '">';
						$content .= '<i class="el-icon-flag icon"></i> ' . __( 'Sticky', 'maera' );
						$content .= '</span>';
					}

				} elseif ( 'post-format' == $meta ) { // Post-Formats

					if ( get_post_format() ) {

						$content .= '<span class="post-meta-element ' . $meta . '">';

						if ( get_post_format( $post_id ) === 'gallery' ) {
							// Gallery
							$content .= '<i class="el-icon-picture"></i> <a href="' . esc_url( get_post_format_link( 'gallery' ) ) . '">' . __('Gallery','maera') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'aside' ) {
							// Aside
							$content .= '<i class="el-icon-chevron-right"></i> <a href="' . esc_url( get_post_format_link( 'aside' ) ) . '">' . __('Aside','maera') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'link' ) {
							// Link
							$content .= '<i class="el-icon-link"></i> <a href="' . esc_url( get_post_format_link( 'link' ) ) . '">' . __('Link','maera') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'image' ) {
							// Image
							$content .= '<i class="el-icon-picture"></i> <a href="' . esc_url( get_post_format_link( 'image' ) ) . '">' . __('Image','maera') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'quote' ) {
							// Quote
							$content .= '<i class="el-icon-quotes-alt"></i> <a href="' . esc_url( get_post_format_link( 'quote' ) ) . '">' . __('Quote','maera') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'status' ) {
							// Status
							$content .= '<i class="el-icon-comment"></i> <a href="' . esc_url( get_post_format_link( 'status' ) ) . '">' . __('Status','maera') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'video' ) {
							// Video
							$content .= '<i class="el-icon-video"></i> <a href="' . esc_url( get_post_format_link( 'video' ) ) . '">' . __('Video','maera') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'audio' ) {
							// Audio
							$content .= '<i class="el-icon-volume-up"></i> <a href="' . esc_url( get_post_format_link( 'audio' ) ) . '">' . __('Audio','maera') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'chat' ) {
							// Chat
							$content .= '<i class="el-icon-comment-alt"></i> <a href="' . esc_url( get_post_format_link( 'chat' ) ) . '">' . __('Chat','maera') . '</a>';
						}

						$content .= '</span>';

					}

				} elseif ( 'date' == $meta ) { // Date

					if ( ! has_post_format( 'link' ) ) {

						$content .= '<span class="post-meta-element ' . $meta . '">';

						$format_prefix = ( has_post_format( 'chat' ) || has_post_format( 'status' ) ) ? _x( '%1$s on %2$s', '1: post format name. 2: date', 'maera' ): '%2$s';

						if ( $date_format == 0 ) {

							$text = esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date( '', $post_id ) ) );
							$icon = "el-icon-calendar icon";

						} elseif ( $date_format == 1 ) {

							$text = sprintf( human_time_diff( get_the_time('U', $post_id ), current_time('timestamp') ) . ' ago');
							$icon = "el-icon-time icon";

						}

						$content .= sprintf( '<span class="entry-date"><i class="' . $icon . '"></i> <a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span>',
							esc_url( get_permalink( $post_id ) ),
							esc_attr( get_the_date( 'c', $post_id ) ),
							$text
						);

						$content .= '</span>';

					}

				} elseif ( 'category' == $meta ) { // Category

					$content .= $categories_list ? '<span class="post-meta-element ' . $meta . '"><i class="el-icon-folder-open icon"></i> ' . $categories_list . '</span>': '';

				} elseif ( 'tags' == $meta ) { // Tags

					$content .= $tag_list ? '<span class="post-meta-element ' . $meta . '"><i class="el-icon-tags icon"></i> ' . $tag_list . '</span>': '';

				} elseif ( 'comments' == $meta ) { // Comments

					$content .= '<span class="post-meta-element ' . $meta . '"><i class="el-icon-comment icon"></i> <a href="' . get_comments_link( $post_id ) . '">' . get_comments_number( $post_id ) . ' ' . __( 'Comments', 'maera' ) . '</a></span>';

				}

			}

			echo $content;

		}


		/**
		 * Inject the featured images on the content.
		 */
		function inject_featured_images_content( $content ) {

			$r = '';

			if ( has_post_thumbnail() ) {

				$image = Maera_Image::featured_image( get_the_ID() );

				$r .= '<div class="featured-image" style="background: url(\'' . $image['url'] . '\'); width: ' . $image['width'] . 'px; height: ' . $image['height'] . 'px;"></div>';

			}

			$r .= $content;

			return $r;

		}


		/**
		 * Helper function: Return the feat_img_post theme mod
		 */
		function display_feat_image_posts() {

			if ( is_singular() ) {
				$display = ( 1 == get_theme_mod( 'feat_img_post', 0 ) ) ? true : false;
			} else {
				$display = ( 1 == get_theme_mod( 'feat_img_archive', 0 ) ) ? true : false;
			}

			return $display;

		}

		/**
		 * Helper function: return the featured image width
		 */
		function get_feat_image_width() {

			if ( is_singular() ) {
				return get_theme_mod( 'feat_img_post_width', -1 );
			} else {
				return get_theme_mod( 'feat_img_archive_width', -1 );
			}

		}

		/**
		 * Helper function: return the featured image height
		 */
		function get_feat_image_height() {

			if ( is_singular() ) {
				return get_theme_mod( 'feat_img_post_height', -1 );
			} else {
				return get_theme_mod( 'feat_img_archive_height', -1 );
			}

		}


		/**
		 * Figure out the layout classes.
		 * This will be used by other functions so that layouts are properly calculated.
		 */
		public static function layout_classes( $element ) {

			// What should we use for columns?
			$col = 'col-md-';

			// Get the layout we're using (sidebar arrangement).
			$layout = get_theme_mod( 'layout', 1 );

			// Apply a filter to the layout.
			// Allows us to bypass the selected layout using a simple filter like this:
			// add_filter( 'maera/layout/modifier', function() { return 3 } ); // will only run on PHP > 5.3
			// OR
			// add_filter( 'maera/layout/modifier', 'maera_return_2' ); // will also run on PHP < 5.3
			$layout = apply_filters( 'maera/layout/modifier', $layout );

			// Get the site style. Defaults to 'Wide'.
			$site_mode = get_theme_mod( 'site_style', 'wide' );

			// Get the sidebar widths
			$width_one = ( ! is_active_sidebar( 'sidebar_primary' ) )   ? null : get_theme_mod( 'layout_primary_width', 4 );
			$width_two = ( ! is_active_sidebar( 'sidebar_secondary' ) ) ? null : get_theme_mod( 'layout_secondary_width', 3 );

			// If the selected layout is no sidebars, then disregard the primary sidebar width.
			$width_one = ( 0 == $layout ) ? null : $width_one;

			// If the selected layout only has one sidebar, disregard the 2nd sidebar width.
			$width_two = ( ! in_array( $layout, array( 3, 4, 5 ) ) ) ? null : $width_two;

			// The main wrapper width
			$width_wrapper = ( is_null( $width_two ) ) ? null : 12 - $width_two;

			// The main content area width
			$width_main = 12 - $width_one - $width_two;

			// When we select a layout like sidebar-content-sidebar, we need a wrapper around the primary sidebar and the content.
			// That changes the way we calculate the primary sidebar and the content columns.
			if ( ! is_null( $width_wrapper ) ) {

				$width_main = 12 - floor( ( 12 * $width_one ) / ( 12 - $width_two ) );
				$width_one  = floor( ( 12 * $width_one ) / ( 12 - $width_two ) );

			}

			if ( $element == 'primary' ) {

				// return the primary class
				$columns = $col . intval( $width_one );
				$classes = ( is_null( $width_one ) ) ? null : $columns;

			} elseif ( $element == 'secondary' ) {

				// return the secondary class
				$columns = $col . intval( $width_two );
				$classes = ( is_null( $width_two ) ) ? null : $columns;

			} elseif ( $element == 'wrapper' ) {

				$columns = $col . intval( $width_wrapper );

				if ( ! is_null( $width_wrapper ) ) {
					$classes = ( 3 == $layout ) ? $columns . ' pull-right' : $columns;
				} else {
					$classes = null;
				}

			} else {

				// return the main class
				$columns = $col . intval( $width_main );
				$classes = ( in_array( $layout, array( 2, 3, 5 ) ) && ! is_null( $width_one ) ) ? $columns . ' pull-right' : $columns;

			}

			return $classes;

		}


		/**
		 * This is just a helper function.
		 *
		 * Returns the class of the main content area.
		 */
		function layout_classes_content() {
			return self::layout_classes( 'content' );
		}


		/**
		 * This is just a helper function.
		 *
		 * Returns the class of the main primary sidebar
		 */
		function layout_classes_primary() {
			return self::layout_classes( 'primary' );
		}


		/**
		 * This is just a helper function.
		 *
		 * Returns the class of the main secondary sidebar
		 */
		function layout_classes_secondary() {
			return self::layout_classes( 'secondary' );
		}


		/**
		 * This is just a helper function.
		 *
		 * Returns the class of the wrppaer (main conent area + primary sidebar.)
		 * Makes complex layouts possible.
		 */
		function layout_classes_wrapper() {
			return self::layout_classes( 'wrapper' );
		}


		/**
		 * Filter for the container class.
		 *
		 * When the user selects fluid site mode, remove the container class from containers.
		 */
		function container_class_modifier() {

			$nav_style  = get_theme_mod( 'navbar_position', 'normal' );
			$site_style = ( 'left' != $nav_style ) ? get_theme_mod( 'site_style', 'wide' ) : 'fluid';
			$breakpoint = get_theme_mod( 'grid_float_breakpoint', 'screen_sm_min' );

			if ( 'fluid' == $site_style ) {

				// Fluid mode
				add_filter( 'maera/container_class', array( $this, 'return_container_fluid' ) );
				add_filter( 'maera/header/class/container', array( $this, 'return_container_fluid' ) );

			} else {

				add_filter( 'maera/container_class', array( $this, 'return_container' ) );
				add_filter( 'maera/header/class/container', array( $this, 'return_container' ) );

			}

			if ( 'full' == $nav_style ) {

				add_filter( 'maera/header/class/container', array( $this, 'return_container_fluid' ) );

			}

		}


		/**
		 * Null sidebars when needed.
		 * These are applied on the index.php file.
		 */
		function sidebars_bypass() {

			$layout = get_theme_mod( 'layout', 1 );
			$layout = apply_filters( 'maera/layout/modifier', $layout );

			// If the layout does not contain 2 sidebars, do not render the secondary sidebar
			if ( ! in_array( $layout, array( 3, 4, 5 ) ) ) {
				add_filter( 'maera/sidebar/secondary', '__return_null' );
			}

			// If the layout selected contains no sidebars, do not render the sidebars
			if ( 0 == $layout ) {
				add_filter( 'maera/sidebar/primary', '__return_null' );
				add_filter( 'maera/sidebar/secondary', '__return_null' );
			}

			// Have we selected custom layouts per post type?
			// if yes, then make sure the layout used for post types is the custom selected one.
			if ( 1 == get_theme_mod( 'cpt_layout_toggle', 0 ) ) {

				$post_types = get_post_types( array( 'public' => true ), 'names' );

				foreach ( $post_types as $post_type ) {

					if ( is_singular( $post_type ) ) {
						$layout = get_theme_mod( $post_type . '_layout', get_theme_mod( 'layout', 1 ) );
						add_filter( 'maera/layout/modifier', 'maera_return_' . $layout );
					}

				}

			}

		}


		/**
		 * Close the wrapper div when using the left navbar
		 */
		function left_wrapper_close_right() { echo '</div></div>'; }


		/**
		 * return "container-fluid"
		 */
		function return_container_fluid() { return 'container-fluid'; }


		/**
		 * return "container"
		 */
		function return_container() { return 'container'; }


		/**
		 * Add and remove body_class() classes
		 */
		function body_class( $classes ) {

			$site_style = get_theme_mod( 'site_style', 'wide' );

			if ( 'boxed' == $site_style ) {
				$classes[] = 'container';
				$classes[] = 'boxed';
			}

			$navbar_position = get_theme_mod( 'navbar_position', 'normal' );
			$classes[] = 'body-nav-' . $navbar_position;

			return $classes;
		}


		/**
		 * Navbar Positioning classes
		 */
		function navbar_positioning_class( $classes ) {

			$position = get_theme_mod( 'navbar_position', 'normal' );

			$classes .= ( 'fixed-top' == $position || 'fixed-bottom' == $position ) ? ' navbar-' . $position : ' navbar-static-top';

			return $classes;

		}


		/*
		 * The content of the Jumbotron region
		 * according to what we've entered in the customizer
		 */
		function jumbotron_html() {

			$site_style   = get_theme_mod( 'site_style', 'wide' );
			// $visibility   = get_theme_mod( 'jumbotron_visibility', 1 );
			$nocontainer  = get_theme_mod( 'jumbotron_nocontainer', 0 );

			if ( 0 != get_theme_mod( 'jumbotron_widgets_nr', 0 ) ) : ?>

				<div class="clearfix"></div>

				<?php if ( 'boxed' == $site_style && 1 != $nocontainer ) : ?>
					<div class="container jumbotron">
				<?php else : ?>
					<div class="jumbotron">
				<?php endif; ?>

					<?php if ( ( 1 != $nocontainer && 'wide' == $site_style ) || 'boxed' == $site_style ) : ?>
						<div class="container">
					<?php endif; ?>

						<?php do_action( 'maera/jumbotron/content' ); ?>

					<?php if ( ( 1 != $nocontainer && 'wide' == $site_style ) || 'boxed' == $site_style ) : ?>
						</div>
					<?php endif; ?>

					</div>


				</div>
				<?php

			endif;
		}


		/*
		 * The Header template
		 */
		function header_html() { ?>

			<?php if ( 0 != get_theme_mod( 'header_widgets_nr', 0 ) ) : ?>
				<?php do_action( 'maera/extra_header/before' ); ?>

				<header class="page-header">

					<?php if ( 'boxed' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
						<div class="container header-boxed">
					<?php endif; ?>

						<div class="header-wrapper container-fluid">

							<?php if ( 'wide' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
								<div class="container">
							<?php endif; ?>

							<?php do_action( 'maera/extra_header/widgets' ); ?>

							<?php if ( 'wide' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
								</div>
							<?php endif; ?>

						</div>

					<?php if ( 'boxed' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
						</div>
					<?php endif; ?>

				</header>
				<?php do_action( 'maera/extra_header/after' ); ?>

			<?php endif;

		}


		/**
		 * Configure and initialize the Breadcrumbs
		 */
		function breadcrumbs() {

			$breadcrumbs = get_theme_mod( 'breadcrumbs', 0 );

			if ( 0 != $breadcrumbs && ! is_home() && ! is_front_page() ) {

				$args = array(
					'container'       => 'ol',
					'separator'       => '</li><li>',
					'before'          => '<li>',
					'after'           => '</li>',
					'show_on_front'   => true,
					'network'         => false,
					'show_title'      => true,
					'show_browse'     => true,
					'echo'            => true,
					'labels'          => array(
						'browse'      => '',
						'home'        => '<i class="el-icon-home"></i>',
					),
				);

				maera_breadcrumb_trail( $args );

			}

		}


		/**
		 * Include the NavBar Search
		 */
		function navbar_search() {
			$navbar_search = get_theme_mod( 'navbar_search' );

			if ( $navbar_search == 1 ) { ?>
				<form role="search" method="get" id="searchform" class="form-search navbar-right navbar-form" action="<?php echo home_url('/'); ?>">
					<label class="hide" for="s"><?php _e('Search for:', 'maera'); ?></label>
					<input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" id="s" class="form-control search-query" placeholder="<?php _e('Search', 'maera'); ?> <?php bloginfo('name'); ?>">
				</form>
			<?php }
		}

		/**
		* Build the social links
		*/
		function social_links_builder( $before = '', $after = '', $separator = '' ) {

			$social_links = array(
				'blogger'     => __( 'Blogger', 'maera' ),
				'deviantart'  => __( 'DeviantART', 'maera' ),
				'digg'        => __( 'Digg', 'maera' ),
				'dribbble'    => __( 'Dribbble', 'maera' ),
				'facebook'    => __( 'Facebook', 'maera' ),
				'flickr'      => __( 'Flickr', 'maera' ),
				'github'      => __( 'Github', 'maera' ),
				'googleplus' => __( 'Google+', 'maera' ),
				'instagram'   => __( 'Instagram', 'maera' ),
				'linkedin'    => __( 'LinkedIn', 'maera' ),
				'myspace'     => __( 'MySpace', 'maera' ),
				'pinterest'   => __( 'Pinterest', 'maera' ),
				'reddit'      => __( 'Reddit', 'maera' ),
				'rss'         => __( 'RSS', 'maera' ),
				'skype'       => __( 'Skype', 'maera' ),
				'soundcloud'  => __( 'SoundCloud', 'maera' ),
				'tumblr'      => __( 'Tumblr', 'maera' ),
				'twitter'     => __( 'Twitter', 'maera' ),
				'vimeo'       => __( 'Vimeo', 'maera' ),
				'vkontakte'   => __( 'Vkontakte', 'maera' ),
				'youtube'     => __( 'YouTube', 'maera' ),
			);

			$content = $before;

			foreach ( $social_links as $social_link => $label ) {
				$link = get_theme_mod( $social_link . '_link', '' );

				if ( '' != esc_url( $link ) ) {
					$content .= '<a role="link" aria-labelledby="' . $label . '" href="' . $link . '" target="_blank" title="' . $label . '"><i class="el-icon-' . $social_link . '"></i>';

					if ( 'dropdown' == get_theme_mod( 'navbar_social', 'off' ) ) {
						$content .= '&nbsp;'.$label;
					}
					$content .= '</a>';
					$content .= $separator;
				}
			}

			$content .= $after;

			return $content;

		}


		/**
		 * Social links in navbars
		 */
		function social_links_navbar_content() {

			$content = $before = $after = $separator = '';

			$social_mode = get_theme_mod( 'navbar_social', 'off' );

			if ( 'inline' == $social_mode ) {
				$before    = '<ul class="nav navbar-nav navbar-right navbar-inline-socials"><li>';
				$after     = '</li></ul>';
				$separator = '</li><li>';
			} elseif ( 'dropdown' == $social_mode ) {
				$before    = '<ul class="nav navbar-nav navbar-right navbar-dropdown-socials"><li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><i class="el-icon-network"></i>&nbsp;<b class="caret"></b></a><ul class="dropdown-menu" role="menu"><li>';
				$after     = '</li></ul></li></ul>';
				$separator = '</li><li>';
			} elseif ( 'off' == $social_mode ) {
				return;
			}

			$content = $this->social_links_builder( $before, $after, $separator );

			echo $content;
		}

		/**
		 * Take care of the alignment of navbar menu items
		 */
		function navbar_links_alignment( $classes ) {

			$align = get_theme_mod( 'navbar_nav_align', 'left' );

			if ( 'center' == $align ) {
				$classes .= ' navbar-center';
			} else if ( 'right' == $align ) {
				$classes .= ' navbar-right';
			}

			return $classes;
		}

	}

}

<?php

if ( ! class_exists( 'SS_Framework_Bootstrap' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class SS_Framework_Bootstrap {

		private static $instance;


		/**
		 * Class constructor
		 */
		public function __construct() {

			if ( ! defined( 'SS_FRAMEWORK_PATH' ) ) {
				define( 'SS_FRAMEWORK_PATH', dirname( __FILE__ ) );
			}

			// Include the customizer
			include_once( SS_FRAMEWORK_PATH . '/customizer.php' );

			// Instantianate the compiler and pass the framework's properties to it
			$compiler = new Shoestrap_Compiler( array(
				'compiler'     => 'less_php',
				'minimize_css' => false,
				'less_path'    => dirname( __FILE__ ) . '/assets/less/',
			) );

			// Trigger the compiler when the customizer options are saved.
			add_action( 'customize_save_after', array( $compiler, 'makecss' ), 77 );

			// If the CSS file does not exist, attempt creating it.
			if ( ! file_exists( $compiler->file( 'path' ) ) ) {
				add_action( 'wp', array( $compiler, 'makecss' ) );
			}

			// Trigger the compiler the first time the theme is enabled
			add_action( 'after_switch_theme', array( $compiler, 'makecss' ) );

			// Enqueue the scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 110 );

			// Add the custom CSS
			add_action( 'wp_enqueue_scripts', array( $this, 'custom_css' ), 105 );

			// Add the framework Timber modifications
			add_filter( 'timber_context', array( $this, 'timber_extras' ), 20 );

			// Breadcrumbs
			add_action( 'shoestrap/content/before', array( $this, 'breadcrumbs' ) );

			// Widgets
			add_action( 'widgets_init', array( $this, 'widget_areas' ), 12 );
			add_action( 'shoestrap/widgets/class', array( $this, 'widgets_class' ) );
			add_action( 'shoestrap/widgets/title/before', array( $this, 'widgets_before_title' ) );
			add_action( 'shoestrap/widgets/title/after', array( $this, 'widgets_after_title' ) );

			// Layout
			add_filter( 'shoestrap/section_class/content', array( $this, 'layout_classes_content' ) );
			add_filter( 'shoestrap/section_class/primary', array( $this, 'layout_classes_primary' ) );
			add_filter( 'shoestrap/section_class/secondary', array( $this, 'layout_classes_secondary' ) );
			add_filter( 'shoestrap/section_class/wrapper', array( $this, 'layout_classes_wrapper' ) );
			add_action( 'wp', array( $this, 'sidebars_bypass' ) );
			add_action( 'wp', array( $this, 'container_class_modifier' ) );
			add_filter( 'body_class', array( $this, 'body_class' ) );

			// Styles
			// add_filter( 'shoestrap/styles', array( $this, 'jumbotron_css' ) );
			add_filter( 'shoestrap/styles', array( $this, 'header_css' ) );
			add_filter( 'shoestrap/styles', array( $this, 'typography_css' ) );
			add_filter( 'shoestrap/styles', array( $this, 'layout_css' ) );
			add_filter( 'shoestrap/styles', array( $this, 'color_css' ) );

			// Fittext script
			// add_action( 'wp_footer', array( $this, 'fittext_init' ), 999 );
			// add_action( 'wp_enqueue_scripts', array( $this, 'fittext_enqueue' ) );

			add_action( 'wp_print_styles', array( $this, 'google_font' ) );
			add_action( 'init', array( $this, 'navbar_logo' ) );

			// Excerpt
			add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
			add_filter( 'excerpt_more', array( $this, 'excerpt_more' ), 10, 2 );

			add_filter( 'shoestrap/compiler/variables', array( $this, 'compiler_variables' ) );
			add_action( 'shoestrap/wrap/before', array( $this, 'jumbotron_html' ), 5 );
			add_action( 'shoestrap/wrap/before', array( $this, 'header_html' ), 3 );
			add_action( 'shoestrap/footer/content', array( $this, 'footer_content' ) );

			add_filter( 'shoestrap/image/display', array( $this, 'disable_feat_images_ppt' ), 99 );

			add_filter( 'shoestrap/content_width', array( $this, 'content_width_px' ) );

			// Add stylesheets caching if dev_mode is set to off.
			if ( 1 == get_theme_mod( 'dev_mode' ) ) {
				add_filter( 'shoestrap/styles/caching', '__return_false' );
				TimberLoader::CACHE_NONE;
			} else {
				add_filter( 'shoestrap/styles/caching', '__return_true' );
			}

			add_filter( 'the_content', array( $this, 'inject_featured_images_content' ), 100 );

			add_filter( 'shoestrap/image/display', array( $this, 'display_feat_image_posts' ) );
			add_filter( 'shoestrap/image/width', array( $this, 'get_feat_image_width' ) );
			add_filter( 'shoestrap/image/height', array( $this, 'get_feat_image_height' ) );

			add_filter( 'shoestrap/topbar/class', array( $this, 'navbar_positioning_class' ) );

			// Post Meta
			add_action( 'shoestrap/entry/meta', array( $this, 'meta_elements' ), 10, 1 );

			// if ( 'left' == get_theme_mod( 'menu_mode', 'normal' ) ) {

			// 	add_action( 'shoestrap/top-bar/before', array( $this, 'open_nav_left_row' ), 1 );
			// 	add_filter( 'shoestrap/topbar/class', array( $this, 'return_nav_left_class' ) );
			// 	add_action( 'shoestrap/top-bar/after', array( $this, 'left_wrapper_open_right' ), 1 );
			// 	add_action( 'shoestrap/footer/after', array( $this, 'left_wrapper_close_right' ) );

			// }

			add_filter( 'shoestrap/topbar/menu/class', array( $this, 'navbar_links_alignment' ) );

			add_action( 'shoestrap/topbar/inside/end', array( $this, 'social_links_navbar_content' ) );

			// // Conditions for showing share button
			// $social_share_post_types = explode(',', get_theme_mod('social_sharing_singular' ) );

			// foreach ($social_share_post_types as $key) {

			// 	if ( $key == 'page' ) {
			// 		if ( get_theme_mod('social_sharing_location') == 'top' ) {
			// 			add_action( 'shoestrap/page/pre_content',   array( $this, 'social_sharing' ) );
			// 		}
			// 		elseif ( get_theme_mod('social_sharing_location') == 'bottom' ) {
			// 			add_action( 'shoestrap/page/after_content', array( $this, 'social_sharing' ) );
			// 		}
			// 		elseif ( get_theme_mod('social_sharing_location') == 'both' ) {
			// 			add_action( 'shoestrap/page/pre_content',   array( $this, 'social_sharing' ) );
			// 			add_action( 'shoestrap/page/after_content', array( $this, 'social_sharing' ) );
			// 		}
			// 	}
			// 	if ( $key == 'post' ) {
			// 		if ( get_theme_mod('social_sharing_location') == 'top' ) {
			// 			add_action( 'shoestrap/single/pre_content',   array( $this, 'social_sharing' ) );
			// 		}
			// 		elseif ( get_theme_mod('social_sharing_location') == 'bottom' ) {
			// 			add_action( 'shoestrap/single/after_content', array( $this, 'social_sharing' ) );
			// 		}
			// 		elseif ( get_theme_mod('social_sharing_location') == 'both' ) {
			// 			add_action( 'shoestrap/single/pre_content',   array( $this, 'social_sharing' ) );
			// 			add_action( 'shoestrap/single/after_content', array( $this, 'social_sharing' ) );
			// 		}
			// 	}

			// }

		}


		/**
		 * Singleton
		 */
		public static function get_instance() {

			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}


		/**
		 * Register all scripts and additional stylesheets (if necessary)
		 */
		function scripts() {

			wp_register_script( 'bootstrap-min', get_template_directory_uri() . '/framework/bootstrap/assets/js/bootstrap.min.js', false, null, true  );
			wp_enqueue_script( 'bootstrap-min' );

			if ( get_theme_mod( 'wai_aria', 0 ) == 1 ) {

				wp_register_script( 'bootstrap-accessibility', get_template_directory_uri() . '/framework/bootstrap/assets/js/bootstrap-accessibility.min.js', false, null, true  );
				wp_enqueue_script( 'bootstrap-accessibility' );

				wp_register_style( 'bootstrap-accessibility', get_template_directory_uri() . '/framework/bootstrap/assets/css/bootstrap-accessibility.css', false, null, true );
				wp_enqueue_style( 'bootstrap-accessibility' );

			}

		}

		/**
		 * Inject the featured images on the content.
		 */
		function inject_featured_images_content( $content ) {

			$r = '';

			if ( has_post_thumbnail() ) {

				$image = Shoestrap_Image::featured_image( get_the_ID() );

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
		 * Timber extras.
		 */
		function timber_extras( $data ) {

			// Get the layout we're using (sidebar arrangement).
			$layout = apply_filters( 'shoestrap/layout/modifier', get_theme_mod( 'layout', 1 ) );

			$sidebars_on_front = get_theme_mod( 'layout_sidebar_on_front', 0 );

			If ( 0 == $layout || ( 0 == $sidebars_on_front && ( is_home() || is_front_page() ) ) ) {

				$data['sidebar']['primary']   = null;
				$data['sidebar']['secondary'] = null;

				// Add a filter for the layout.
				add_filter( 'shoestrap/layout/modifier', 'shoestrap_return_0' );

			}

			$comment_form_args = array(
				'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'shoestrap' ) . '</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
				'id_submit'     => 'comment-submit',
			);

			$data['comment_form'] = TimberHelper::get_comment_form( null, $comment_form_args );

			return $data;
		}


		/**
		 * Figure out the post meta that we want to use and inject them to our content.
		 */
		public function meta_elements( $post_id ) {

			$post = get_post( $post_id );

			// Get the options from the db
			$metas       = get_theme_mod( 'shoestrap_entry_meta_config', 'post-format, date, author, comments' );
			$date_format = get_theme_mod( 'date_meta_format', 1 );

			$categories_list = has_category( '', $post_id ) ? get_the_category_list( __( ', ', 'shoestrap' ), '', $post_id ) : false;
			$tag_list        = has_tag( '', $post_id ) ? get_the_tag_list( '', __( ', ', 'shoestrap' ) ) : false;

			// No need to proceed if the option is empty
			if ( empty( $metas ) ) {
				return;
			}

			// // No need to proceed if we're on a single post and we don't want to display the post meta
			// if ( is_singular() && 1 != get_theme_mod( 'single_meta', 1 ) ) {
			// 	return;
			// }

			$content = '';

			// convert options from CSV to array
			$metas_array = explode( ',', $metas );

			// clean up the array a bit... make sure there are no spaces that may mess things up
			$metas_array = array_map( 'trim', $metas_array );

			foreach ( $metas_array as $meta ) {

				if ( 'author' == $meta ) { // Author

					$content .= sprintf( '<span class="post-meta-element ' . $meta . '"><span class="author vcard"><i class="el-icon-user icon"></i> <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></span>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) ),
						esc_attr( sprintf( __( 'View all posts by %s', 'shoestrap' ), get_the_author_meta( 'display_name', $post->post_author ) ) ),
						get_the_author_meta( 'display_name', $post->post_author )
					);

				} elseif ( 'sticky' == $meta ) { // Sticky

					if ( is_sticky() ) {
						$content .= '<span class="post-meta-element ' . $meta . '">';
						$content .= '<i class="el-icon-flag icon"></i> ' . __( 'Sticky', 'shoestrap' );
						$content .= '</span>';
					}

				} elseif ( 'post-format' == $meta ) { // Post-Formats

					if ( get_post_format() ) {

						$content .= '<span class="post-meta-element ' . $meta . '">';

						if ( get_post_format( $post_id ) === 'gallery' ) {
							// Gallery
							$content .= '<i class="el-icon-picture"></i> <a href="' . esc_url( get_post_format_link( 'gallery' ) ) . '">' . __('Gallery','shoestrap') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'aside' ) {
							// Aside
							$content .= '<i class="el-icon-chevron-right"></i> <a href="' . esc_url( get_post_format_link( 'aside' ) ) . '">' . __('Aside','shoestrap') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'link' ) {
							// Link
							$content .= '<i class="el-icon-link"></i> <a href="' . esc_url( get_post_format_link( 'link' ) ) . '">' . __('Link','shoestrap') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'image' ) {
							// Image
							$content .= '<i class="el-icon-picture"></i> <a href="' . esc_url( get_post_format_link( 'image' ) ) . '">' . __('Image','shoestrap') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'quote' ) {
							// Quote
							$content .= '<i class="el-icon-quotes-alt"></i> <a href="' . esc_url( get_post_format_link( 'quote' ) ) . '">' . __('Quote','shoestrap') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'status' ) {
							// Status
							$content .= '<i class="el-icon-comment"></i> <a href="' . esc_url( get_post_format_link( 'status' ) ) . '">' . __('Status','shoestrap') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'video' ) {
							// Video
							$content .= '<i class="el-icon-video"></i> <a href="' . esc_url( get_post_format_link( 'video' ) ) . '">' . __('Video','shoestrap') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'audio' ) {
							// Audio
							$content .= '<i class="el-icon-volume-up"></i> <a href="' . esc_url( get_post_format_link( 'audio' ) ) . '">' . __('Audio','shoestrap') . '</a>';
						} elseif ( get_post_format( $post_id ) === 'chat' ) {
							// Chat
							$content .= '<i class="el-icon-comment-alt"></i> <a href="' . esc_url( get_post_format_link( 'chat' ) ) . '">' . __('Chat','shoestrap') . '</a>';
						}

						$content .= '</span>';

					}

				} elseif ( 'date' == $meta ) { // Date

					if ( ! has_post_format( 'link' ) ) {

						$content .= '<span class="post-meta-element ' . $meta . '">';

						$format_prefix = ( has_post_format( 'chat' ) || has_post_format( 'status' ) ) ? _x( '%1$s on %2$s', '1: post format name. 2: date', 'shoestrap' ): '%2$s';

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

					$content .= '<span class="post-meta-element ' . $meta . '"><i class="el-icon-comment icon"></i> <a href="' . get_comments_link( $post_id ) . '">' . get_comments_number( $post_id ) . ' ' . __( 'Comments', 'shoestrap' ) . '</a></span>';

				}

			}

			echo $content;

		}


		/*
		 * Calculate the width of the content area in pixels.
		 */
		public static function content_width_px() {

			$layout = apply_filters( 'shoestrap/layout/modifier', get_theme_mod( 'layout', 1 ) );

			$container  = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
			$gutter     = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );

			$main_span  = filter_var( self::layout_classes( 'content' ), FILTER_SANITIZE_NUMBER_INT );
			$main_span  = str_replace( '-' , '', $main_span );

			// If the layout is #5, override the default function and calculate the span width of the main area again.
			if ( is_active_sidebar( 'sidebar-secondary' ) && is_active_sidebar( 'sidebar-primary' ) && $layout == 5 ) {
				$main_span = 12 - intval( get_theme_mod( 'layout_primary_width', 4 ) ) - intval( get_theme_mod( 'layout_secondary_width', 3 ) );
			}

			if ( is_front_page() && get_theme_mod( 'layout_sidebar_on_front', 0 ) != 1 ) {
				$main_span = 12;
			}

			$width = $container * ( $main_span / 12 ) - $gutter;

			// Width should be an integer since we're talking pixels, round up!.
			$width = round( $width );

			return $width;
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
		 * Get the variables from the theme options and parse them all together.
		 *
		 * These will then be added to the compiler using the "shoestrap/compiler/variables" filter
		 */
		function compiler_variables( $variables ) {

			/**
			 * BACKGROUND
			 */
			$body_bg = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'body_bg_color', '#ffffff' ) ) );

			// Calculate the gray shadows based on the body background.
			// We basically create 2 "presets": light and dark.
			if ( Shoestrap_Color::get_brightness( $body_bg ) > 80 ) {
				$gray_darker  = 'lighten(#000, 13.5%)';
				$gray_dark    = 'lighten(#000, 20%)';
				$gray         = 'lighten(#000, 33.5%)';
				$gray_light   = 'lighten(#000, 60%)';
				$gray_lighter = 'lighten(#000, 93.5%)';
			} else {
				$gray_darker  = 'darken(#fff, 13.5%)';
				$gray_dark    = 'darken(#fff, 20%)';
				$gray         = 'darken(#fff, 33.5%)';
				$gray_light   = 'darken(#fff, 60%)';
				$gray_lighter = 'darken(#fff, 93.5%)';
			}

			$bg_brightness = Shoestrap_Color::get_brightness( $body_bg );

			$table_bg_accent      = $bg_brightness > 50 ? 'darken(@body-bg, 2.5%)'    : 'lighten(@body-bg, 2.5%)';
			$table_bg_hover       = $bg_brightness > 50 ? 'darken(@body-bg, 4%)'      : 'lighten(@body-bg, 4%)';
			$table_border_color   = $bg_brightness > 50 ? 'darken(@body-bg, 13.35%)'  : 'lighten(@body-bg, 13.35%)';
			$input_border         = $bg_brightness > 50 ? 'darken(@body-bg, 20%)'     : 'lighten(@body-bg, 20%)';
			$dropdown_divider_top = $bg_brightness > 50 ? 'darken(@body-bg, 10.2%)'   : 'lighten(@body-bg, 10.2%)';

			$variables = '';

			// Calculate grays
			if ( '#ffffff' != $body_bg || '#FFFFFF' != $body_bg ) {
				$variables .= '@gray-darker:            ' . $gray_darker . ';';
				$variables .= '@gray-dark:              ' . $gray_dark . ';';
				$variables .= '@gray:                   ' . $gray . ';';
				$variables .= '@gray-light:             ' . $gray_light . ';';
				$variables .= '@gray-lighter:           ' . $gray_lighter . ';';

				// The below are declared as #fff in the default variables.
				$variables .= '@body-bg:                     ' . $body_bg . ';';
				$variables .= '@component-active-color:          @body-bg;';
				$variables .= '@btn-default-bg:                  @body-bg;';
				$variables .= '@dropdown-bg:                     @body-bg;';
				$variables .= '@pagination-bg:                   @body-bg;';
				$variables .= '@progress-bar-color:              @body-bg;';
				$variables .= '@list-group-bg:                   @body-bg;';
				$variables .= '@panel-bg:                        @body-bg;';
				$variables .= '@panel-primary-text:              @body-bg;';
				$variables .= '@pagination-active-color:         @body-bg;';
				$variables .= '@pagination-disabled-bg:          @body-bg;';
				$variables .= '@tooltip-color:                   @body-bg;';
				$variables .= '@popover-bg:                      @body-bg;';
				$variables .= '@popover-arrow-color:             @body-bg;';
				$variables .= '@label-color:                     @body-bg;';
				$variables .= '@label-link-hover-color:          @body-bg;';
				$variables .= '@modal-content-bg:                @body-bg;';
				$variables .= '@badge-color:                     @body-bg;';
				$variables .= '@badge-link-hover-color:          @body-bg;';
				$variables .= '@badge-active-bg:                 @body-bg;';
				$variables .= '@carousel-control-color:          @body-bg;';
				$variables .= '@carousel-indicator-active-bg:    @body-bg;';
				$variables .= '@carousel-indicator-border-color: @body-bg;';
				$variables .= '@carousel-caption-color:          @body-bg;';
				$variables .= '@close-text-shadow:       0 1px 0 @body-bg;';
				$variables .= '@input-bg:                        @body-bg;';
				$variables .= '@nav-open-link-hover-color:       @body-bg;';

				// These are #ccc
				// We re-calculate the color based on the gray values above.
				$variables .= '@btn-default-border:            mix(@gray-light, @gray-lighter);';
				$variables .= '@input-border:                  mix(@gray-light, @gray-lighter);';
				$variables .= '@popover-fallback-border-color: mix(@gray-light, @gray-lighter);';
				$variables .= '@breadcrumb-color:              mix(@gray-light, @gray-lighter);';
				$variables .= '@dropdown-fallback-border:      mix(@gray-light, @gray-lighter);';

				$variables .= '@table-bg-accent:    ' . $table_bg_accent . ';';
				$variables .= '@table-bg-hover:     ' . $table_bg_hover . ';';
				$variables .= '@table-border-color: ' . $table_border_color . ';';

				$variables .= '@legend-border-color: @gray-lighter;';
				$variables .= '@dropdown-divider-bg: @gray-lighter;';

				$variables .= '@dropdown-link-hover-bg: @table-bg-hover;';
				$variables .= '@dropdown-caret-color:   @gray-darker;';

				$variables .= '@nav-tabs-border-color:                   @table-border-color;';
				$variables .= '@nav-tabs-active-link-hover-border-color: @table-border-color;';
				$variables .= '@nav-tabs-justified-link-border-color:    @table-border-color;';

				$variables .= '@pagination-border:          @table-border-color;';
				$variables .= '@pagination-hover-border:    @table-border-color;';
				$variables .= '@pagination-disabled-border: @table-border-color;';

				$variables .= '@tooltip-bg: darken(@gray-darker, 15%);';

				$variables .= '@popover-arrow-outer-fallback-color: @gray-light;';

				$variables .= '@modal-content-fallback-border-color: @gray-light;';
				$variables .= '@modal-backdrop-bg:                   darken(@gray-darker, 15%);';
				$variables .= '@modal-header-border-color:           lighten(@gray-lighter, 12%);';

				$variables .= '@progress-bg: ' . $table_bg_hover . ';';

				$variables .= '@list-group-border:   ' . $table_border_color . ';';
				$variables .= '@list-group-hover-bg: ' . $table_bg_hover . ';';

				$variables .= '@list-group-link-color:         @gray;';
				$variables .= '@list-group-link-heading-color: @gray-dark;';

				$variables .= '@panel-inner-border:       @list-group-border;';
				$variables .= '@panel-footer-bg:          @list-group-hover-bg;';
				$variables .= '@panel-default-border:     @table-border-color;';
				$variables .= '@panel-default-heading-bg: @panel-footer-bg;';

				$variables .= '@thumbnail-border: @list-group-border;';

				$variables .= '@well-bg: @table-bg-hover;';

				$variables .= '@breadcrumb-bg: @table-bg-hover;';

				$variables .= '@close-color: darken(@gray-darker, 15%);';
			}

			/**
			 * LAYOUT
			 */
			$screen_sm = filter_var( get_theme_mod( 'screen_tablet', 768 ), FILTER_SANITIZE_NUMBER_INT );
			$screen_md = filter_var( get_theme_mod( 'screen_desktop', 992 ), FILTER_SANITIZE_NUMBER_INT );
			$screen_lg = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
			$gutter    = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );
			$gutter    = ( $gutter < 2 ) ? 2 : $gutter;

			$site_style = get_theme_mod( 'site_style', 'wide' );

			$screen_xs = ( $site_style == 'static' ) ? '50px' : '480px';
			$screen_sm = ( $site_style == 'static' ) ? '50px' : $screen_sm;
			$screen_md = ( $site_style == 'static' ) ? '50px' : $screen_md;

			$variables .= '@screen-sm: ' . $screen_sm . 'px;';
			$variables .= '@screen-md: ' . $screen_md . 'px;';
			$variables .= '@screen-lg: ' . $screen_lg . 'px;';
			$variables .= '@grid-gutter-width: ' . $gutter . 'px;';

			$variables .= '@jumbotron-padding: @grid-gutter-width;';

			$variables .= '@modal-inner-padding: ' . round( $gutter * 20 / 30 ) . 'px;';
			$variables .= '@modal-title-padding: ' . round( $gutter * 15 / 30 ) . 'px;';

			$variables .= '@modal-lg: ' . round( $screen_md - ( 3 * $gutter ) ) . 'px;';
			$variables .= '@modal-md: ' . round( $screen_sm - ( 3 * $gutter ) ) . 'px;';
			$variables .= '@modal-sm: ' . round( $screen_xs - ( 3 * $gutter ) ) . 'px;';

			$variables .= '@panel-body-padding: @modal-title-padding;';

			$variables .= '@container-tablet:        ' . ( $screen_sm - ( $gutter / 2 ) ). 'px;';
			$variables .= '@container-desktop:       ' . ( $screen_md - ( $gutter / 2 ) ). 'px;';
			$variables .= '@container-large-desktop: ' . ( $screen_lg - $gutter ). 'px;';

			if ( $site_style == 'static' ) {
				// disable responsiveness
				$variables .= '@screen-xs-max: 0 !important;
				.container { max-width: none !important; width: @container-large-desktop; }
				html { overflow-x: auto !important; }';
			}

			/**
			 * BRANDING
			 */
			$brand_primary = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_primary', '#428bca' ) ) );
			$brand_success = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_success', '#5cb85c' ) ) );
			$brand_warning = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_warning', '#f0ad4e' ) ) );
			$brand_danger  = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_danger', '#d9534f' ) ) );
			$brand_info    = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_info', '#5bc0de' ) ) );

			$link_hover_color = ( Shoestrap_Color::get_brightness( $brand_primary ) > 50 ) ? 'darken(@link-color, 15%)' : 'lighten(@link-color, 15%)';

			$brand_primary_brightness = Shoestrap_Color::get_brightness( $brand_primary );
			$brand_success_brightness = Shoestrap_Color::get_brightness( $brand_success );
			$brand_warning_brightness = Shoestrap_Color::get_brightness( $brand_warning );
			$brand_danger_brightness  = Shoestrap_Color::get_brightness( $brand_danger );
			$brand_info_brightness    = Shoestrap_Color::get_brightness( $brand_info );

			// Button text colors
			$btn_primary_color  = $brand_primary_brightness < 195 ? '#fff' : '333';
			$btn_success_color  = $brand_success_brightness < 195 ? '#fff' : '333';
			$btn_warning_color  = $brand_warning_brightness < 195 ? '#fff' : '333';
			$btn_danger_color   = $brand_danger_brightness  < 195 ? '#fff' : '333';
			$btn_info_color     = $brand_info_brightness    < 195 ? '#fff' : '333';

			// Button borders
			$btn_primary_border = $brand_primary_brightness < 195 ? 'darken(@btn-primary-bg, 5%)' : 'lighten(@btn-primary-bg, 5%)';
			$btn_success_border = $brand_success_brightness < 195 ? 'darken(@btn-success-bg, 5%)' : 'lighten(@btn-success-bg, 5%)';
			$btn_warning_border = $brand_warning_brightness < 195 ? 'darken(@btn-warning-bg, 5%)' : 'lighten(@btn-warning-bg, 5%)';
			$btn_danger_border  = $brand_danger_brightness  < 195 ? 'darken(@btn-danger-bg, 5%)'  : 'lighten(@btn-danger-bg, 5%)';
			$btn_info_border    = $brand_info_brightness    < 195 ? 'darken(@btn-info-bg, 5%)'    : 'lighten(@btn-info-bg, 5%)';

			$input_border_focus = ( Shoestrap_Color::get_brightness( $brand_primary ) < 195 ) ? 'lighten(@brand-primary, 10%)' : 'darken(@brand-primary, 10%)';
			$navbar_border      = ( Shoestrap_Color::get_brightness( $brand_primary ) < 50 ) ? 'lighten(@navbar-default-bg, 6.5%)' : 'darken(@navbar-default-bg, 6.5%)';

			// Branding colors
			$variables .= '@brand-primary: ' . $brand_primary . ';';
			$variables .= '@brand-success: ' . $brand_success . ';';
			$variables .= '@brand-info:    ' . $brand_info . ';';
			$variables .= '@brand-warning: ' . $brand_warning . ';';
			$variables .= '@brand-danger:  ' . $brand_danger . ';';

			// Link-hover
			$variables .= '@link-hover-color: ' . $link_hover_color . ';';

			$variables .= '@btn-default-color:  @gray-dark;';

			$variables .= '@btn-primary-color:  ' . $btn_primary_color . ';';
			$variables .= '@btn-primary-border: ' . $btn_primary_border . ';';
			$variables .= '@btn-success-color:  ' . $btn_success_color . ';';
			$variables .= '@btn-success-border: ' . $btn_success_border . ';';
			$variables .= '@btn-info-color:     ' . $btn_info_color . ';';
			$variables .= '@btn-info-border:    ' . $btn_info_border . ';';
			$variables .= '@btn-warning-color:  ' . $btn_warning_color . ';';
			$variables .= '@btn-warning-border: ' . $btn_warning_border . ';';
			$variables .= '@btn-danger-color:   ' . $btn_danger_color . ';';
			$variables .= '@btn-danger-border:  ' . $btn_danger_border . ';';
			$variables .= '@input-border-focus: ' . $input_border_focus . ';';

			$variables .= '@state-success-text: mix(@gray-darker, @brand-success, 20%);';
			$variables .= '@state-success-bg:   mix(@body-bg, @brand-success, 50%);';

			$variables .= '@state-info-text:    mix(@gray-darker, @brand-info, 20%);';
			$variables .= '@state-info-bg:      mix(@body-bg, @brand-info, 50%);';

			$variables .= '@state-warning-text: mix(@gray-darker, @brand-warning, 20%);';
			$variables .= '@state-warning-bg:   mix(@body-bg, @brand-warning, 50%);';

			$variables .= '@state-danger-text:  mix(@gray-darker, @brand-danger, 20%);';
			$variables .= '@state-danger-bg:    mix(@body-bg, @brand-danger, 50%);';

			$padding_base  = intval( get_theme_mod( 'padding_base', 8 ) );

			$border_radius = filter_var( get_theme_mod( 'border_radius', 4 ), FILTER_SANITIZE_NUMBER_INT );
			$border_radius = ( strlen( $border_radius ) < 1 ) ? 0 : $border_radius;

			$variables .= '@padding-base-vertical:    ' . round( $padding_base * 6 / 6 ) . 'px;';
			$variables .= '@padding-base-horizontal:  ' . round( $padding_base * 12 / 6 ) . 'px;';

			$variables .= '@padding-large-vertical:   ' . round( $padding_base * 10 / 6 ) . 'px;';
			$variables .= '@padding-large-horizontal: ' . round( $padding_base * 16 / 6 ) . 'px;';

			$variables .= '@padding-small-vertical:   ' . round( $padding_base * 5 / 6 ) . 'px;';
			$variables .= '@padding-small-horizontal: @padding-large-vertical;';

			$variables .= '@padding-xs-vertical:      ' . round( $padding_base * 1 / 6 ) . 'px;';
			$variables .= '@padding-xs-horizontal:    @padding-small-vertical;';

			$variables .= '@border-radius-base:  ' . round( $border_radius * 4 / 4 ) . 'px;';
			$variables .= '@border-radius-large: ' . round( $border_radius * 6 / 4 ) . 'px;';
			$variables .= '@border-radius-small: ' . round( $border_radius * 3 / 4 ) . 'px;';

			$variables .= '@pager-border-radius: ' . round( $border_radius * 15 / 4 ) . 'px;';

			$variables .= '@tooltip-arrow-width: @padding-small-vertical;';
			$variables .= '@popover-arrow-width: (@tooltip-arrow-width * 2);';

			$variables .= '@thumbnail-padding:         ' . round( $padding_base * 4 / 6 ) . 'px;';
			$variables .= '@thumbnail-caption-padding: ' . round( $padding_base * 9 / 6 ) . 'px;';

			$variables .= '@badge-border-radius: ' . round( $border_radius * 10 / 4 ) . 'px;';

			$variables .= '@breadcrumb-padding-vertical:   ' . round( $padding_base * 8 / 6 ) . 'px;';
			$variables .= '@breadcrumb-padding-horizontal: ' . round( $padding_base * 15 / 6 ) . 'px;';

			/**
			 * MENUS
			 */
			$font_navbar       = get_theme_mod( 'font_menus_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
			$font_brand        = $font_navbar;
			$navbar_bg         = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'navbar_bg', '#f8f8f8' ) ) );
			$navbar_height     = filter_var( get_theme_mod( 'navbar_height', 50 ), FILTER_SANITIZE_NUMBER_INT );
			$navbar_text_color = '#' . str_replace( '#', '', get_theme_mod( 'font_menus_color', '#333333' ) );
			$brand_text_color  = $navbar_text_color;
			$navbar_border     = ( Shoestrap_Color::get_brightness( $navbar_bg ) < 50 ) ? 'lighten(@navbar-default-bg, 6.5%)' : 'darken(@navbar-default-bg, 6.5%)';
			$gfb = get_theme_mod( 'grid_float_breakpoint', 'screen_sm_min' );

			if ( Shoestrap_Color::get_brightness( $navbar_bg ) < 165 ) {
				$navbar_link_hover_color    = 'darken(@navbar-default-color, 26.5%)';
				$navbar_link_active_bg      = 'darken(@navbar-default-bg, 6.5%)';
				$navbar_link_disabled_color = 'darken(@navbar-default-bg, 6.5%)';
				$navbar_brand_hover_color   = 'darken(@navbar-default-brand-color, 10%)';
			} else {
				$navbar_link_hover_color    = 'lighten(@navbar-default-color, 26.5%)';
				$navbar_link_active_bg      = 'lighten(@navbar-default-bg, 6.5%)';
				$navbar_link_disabled_color = 'lighten(@navbar-default-bg, 6.5%)';
				$navbar_brand_hover_color   = 'lighten(@navbar-default-brand-color, 10%)';
			}

			$grid_float_breakpoint = ( isset( $gfb ) )           ? $gfb             : '@screen-sm-min';
			$grid_float_breakpoint = ( $gfb == 'min' )           ? '10px'           : $grid_float_breakpoint;
			$grid_float_breakpoint = ( $gfb == 'screen_xs_min' ) ? '@screen-xs-min' : $grid_float_breakpoint;
			$grid_float_breakpoint = ( $gfb == 'screen_sm_min' ) ? '@screen-sm-min' : $grid_float_breakpoint;
			$grid_float_breakpoint = ( $gfb == 'screen_md_min' ) ? '@screen-md-min' : $grid_float_breakpoint;
			$grid_float_breakpoint = ( $gfb == 'screen_lg_min' ) ? '@screen-lg-min' : $grid_float_breakpoint;
			$grid_float_breakpoint = ( $gfb == 'max' )           ? '9999px'         : $grid_float_breakpoint;

			$grid_float_breakpoint = ( $gfb == 'screen-lg-min' ) ? '0 !important' : $grid_float_breakpoint;

			$variables .= '@navbar-height:         ' . $navbar_height . 'px;';
			$variables .= '@navbar-default-color:  ' . $navbar_text_color . ';';
			$variables .= '@navbar-default-bg:     ' . $navbar_bg . ';';
			$variables .= '@navbar-default-border: ' . $navbar_border . ';';

			$variables .= '@navbar-default-link-color:          @navbar-default-color;';

			$variables .= '@navbar-default-link-hover-color:    ' . $navbar_link_hover_color . ';';

			$variables .= '@navbar-default-link-active-color:   mix(@navbar-default-color, @navbar-default-link-hover-color, 50%);';

			$variables .= '@navbar-default-link-active-bg:      ' . $navbar_link_active_bg . ';';
			$variables .= '@navbar-default-link-disabled-color: ' . $navbar_link_disabled_color . ';';

			$variables .= '@navbar-default-brand-color:         @navbar-default-link-color;';
			$variables .= '@navbar-default-brand-hover-color:   ' . $navbar_brand_hover_color . ';';
			$variables .= '@navbar-default-toggle-hover-bg:     ' . $navbar_border . ';';
			$variables .= '@navbar-default-toggle-icon-bar-bg:  ' . $navbar_text_color . ';';
			$variables .= '@navbar-default-toggle-border-color: ' . $navbar_border . ';';

			$variables .= '@grid-float-breakpoint: ' . $grid_float_breakpoint . ';';

			if ( get_theme_mod( 'gradients_toggle', 0 ) ) {
				$variables .= '@import "' . SS_FRAMEWORK_PATH . '/assets/less/gradients.less";';
			}

			return $variables;
		}

		/**
		 * CSS rules for typography options
		 */
		function typography_css( $style ) {

			// Base font settings
			$font_base_family    = get_theme_mod( 'font_base_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
			$font_base_google    = get_theme_mod( 'font_base_google', 0 );
			$font_base_color     = get_theme_mod( 'font_base_color', '#333333' );
			$font_base_weight    = get_theme_mod( 'font_base_weight', '#333333' );
			$font_base_size      = get_theme_mod( 'font_base_size', ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 14 : 1.5 );
			$font_base_height    = get_theme_mod( 'font_base_height', 1.4 );

			$style .= 'body {font-family:' . $font_base_family . ';color:' . $font_base_color . ';font-weight:' . $font_base_weight . ';font-size:' . $font_base_size . get_theme_mod( 'font_size_units', 'px' ) . ';line-height:' . $font_base_height . ';}';

			// Headers font
			$headers_font_family = get_theme_mod( 'headers_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );

			$style .= 'h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6{';
			$style .= 'font-family: ' . $headers_font_family . ';';
			$style .= 'color: ' . get_theme_mod( 'font_headers_color', '#333333' ) . ';';
			$style .= 'font-weight: ' . get_theme_mod( 'font_headers_weight', 400 ) . ';';
			$style .= 'line-height: ' . get_theme_mod( 'font_headers_height', 1.1 ) . ';';
			$style .= '}';

			$style .= 'h1, .h1 { font-size: ' . intval( ( 260 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h2, .h2 { font-size: ' . intval( ( 215 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h3, .h3 { font-size: ' . intval( ( 170 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h4, .h4 { font-size: ' . intval( ( 110 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h5, .h5 { font-size: ' . intval( ( 100 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h6, .h6 { font-size: ' . intval( ( 85 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';

			// $headers = array(
			// 	'h1' => array( 'size' => 260, 'height' => 1.1 ),
			// 	'h2' => array( 'size' => 215, 'height' => 1.1 ),
			// 	'h3' => array( 'size' => 170, 'height' => 1.1 ),
			// 	'h4' => array( 'size' => 110, 'height' => 1.1 ),
			// 	'h5' => array( 'size' => 100, 'height' => 1.1 ),
			// 	'h6' => array( 'size' => 85,  'height' => 1.1 ),
			// );

			// foreach ( $headers as $header => $values ) {
			// 	$header_color  = get_theme_mod( 'font_' . $header . '_color', '#333333' );
			// 	$header_weight = get_theme_mod( 'font_' . $header . '_weight', 400 );
			// 	$header_size   = get_theme_mod( 'font_' . $header . '_size', $values['size'] );
			// 	$header_height = get_theme_mod( 'font_' . $header . '_height', $values['height'] );

			// 	$style .= $header . ', .' . $header . ' {color:' . $header_color . ';font-weight: ' . $header_weight . ';font-size: ' . $header_size . '%;line-height: ' . $header_height . ';}';
			// }

			return $style;

		}


		/**
		* Enqueue Google fonts if enabled
		*/
		function google_font() {

			$font_base_google    = get_theme_mod( 'font_base_google', 0 );
			$font_headers_google = get_theme_mod( 'headers_font_google', 0 );

			if ( $font_base_google == 1 ) {

				$font_base_family = str_replace( ' ', '+', get_theme_mod( 'font_base_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' ) );
				$font_base_google_subsets = get_theme_mod( 'font_base_google_subsets', 'latin' );

				wp_register_style( 'shoestrap_base_google_font', 'http://fonts.googleapis.com/css?family=' . $font_base_family . '&subset=' . $font_base_google_subsets );
		 		wp_enqueue_style( 'shoestrap_base_google_font' );

			}


			if ( $font_headers_google == 1 ) {

				$font_headers_family = str_replace( ' ', '+', get_theme_mod( 'headers_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' ) );
				$font_headers_google_subsets = get_theme_mod( 'font_headers_google_subsets', 'latin' );

				wp_register_style( 'shoestrap_headers_google_font', 'http://fonts.googleapis.com/css?family='.$font_headers_family.'&subset='.$font_headers_google_subsets );
		 		wp_enqueue_style( 'shoestrap_headers_google_font' );

			}

		}


		/*
		 * The site logo.
		 * If no custom logo is uploaded, use the sitename
		 */
		function logo( $fallback ) {

			$logo = get_theme_mod( 'logo', '' );

			if ( $logo ) {
				return '<img id="site-logo" src="' . $logo . '" alt="' . get_bloginfo( 'name' ) .'">';
			} else {
				return $fallback;
			}

		}


		/**
		 * Adds the logo to the main navbar.
		 */
		function navbar_logo() {

			// If we've selected NOT to display the logo on navbars, then do not proceed.
			if ( 1 != get_theme_mod( 'navbar_logo', 1 ) ) {
				return;
			}

			add_action( 'shoestrap/topbar/brand', array( $this, 'logo' ) );

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
			// add_filter( 'shoestrap/layout/modifier', function() { return 3 } ); // will only run on PHP > 5.3
			// OR
			// add_filter( 'shoestrap/layout/modifier', 'shoestrap_return_2' ); // will also run on PHP < 5.3
			$layout = apply_filters( 'shoestrap/layout/modifier', $layout );

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
		 * Null sidebars when needed.
		 * These are applied on the index.php file.
		 */
		function sidebars_bypass() {

			$layout = get_theme_mod( 'layout', 1 );
			$layout = apply_filters( 'shoestrap/layout/modifier', $layout );

			$sidebars_on_front = get_theme_mod( 'layout_sidebar_on_front', 0 );

			// If the layout does not contain 2 sidebars, do not render the secondary sidebar
			if ( ! in_array( $layout, array( 3, 4, 5 ) ) ) {
				add_filter( 'shoestrap/sidebar/secondary', '__return_null' );
			}

			// If the layout selected contains no sidebars, do not render the sidebars
			if ( 0 == $layout || ( 0 == $sidebars_on_front && is_front_page() ) || ( 0 == $sidebars_on_front && is_home() ) ) {
				add_filter( 'shoestrap/sidebar/primary', '__return_null' );
				add_filter( 'shoestrap/sidebar/secondary', '__return_null' );
			}

			// Have we selected custom layouts per post type?
			// if yes, then make sure the layout used for post types is the custom selected one.
			if ( 1 == get_theme_mod( 'cpt_layout_toggle', 0 ) ) {

				$post_types = get_post_types( array( 'public' => true ), 'names' );

				foreach ( $post_types as $post_type ) {

					if ( is_singular( $post_type ) ) {
						$layout = get_theme_mod( $post_type . '_layout', get_theme_mod( 'layout', 1 ) );
						add_filter( 'shoestrap/layout/modifier', 'shoestrap_return_' . $layout );
					}

				}

			}

		}


		/**
		 * Filter for the container class.
		 *
		 * When the user selects fluid site mode, remove the container class from containers.
		 */
		function container_class_modifier() {

			$nav_style  = get_theme_mod( 'navbar_toggle', 'normal' );
			$site_style = ( 'left' != $nav_style ) ? get_theme_mod( 'site_style', 'wide' ) : 'fluid';
			$breakpoint = get_theme_mod( 'grid_float_breakpoint', 'screen_sm_min' );

			if ( 'fluid' == $site_style ) {

				// Fluid mode
				add_filter( 'shoestrap/container_class', array( $this, 'return_container_fluid' ) );
				add_filter( 'shoestrap/topbar/class/container', array( $this, 'return_container_fluid' ) );

			} else {

				add_filter( 'shoestrap/container_class', array( $this, 'return_container' ) );
				add_filter( 'shoestrap/topbar/class/container', array( $this, 'return_container' ) );

			}

			if ( 'full' == $nav_style ) {

				add_filter( 'shoestrap/topbar/class/container', array( $this, 'return_container_fluid' ) );

			}

		}

		/**
		 * Open a row to hold the left sidebar and main content divs
		 */
		function open_nav_left_row() { echo '<div class="row">'; }


		/**
		 * Return the width of the left navbar
		 */
		function return_nav_left_class() {

			$cols = get_theme_mod( 'layout_secondary_width', 3 );
			return 'col-sm-' . $cols;

		}

		/**
		 * Add a wrapper div to all the content when we're using the left navbar
		 */
		function left_wrapper_open_right() {

			$cols = 12 - get_theme_mod( 'layout_secondary_width', 3 );

			echo '<div class="right-wrapper col-sm-' . $cols . '">';

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
			// if ( 'left' == get_theme_mod( 'menu_mode' ) ) {
			// 	$site_style = 'fluid';
			// }

			if ( 'boxed' == $site_style ) {
				$classes[] = 'container';
				$classes[] = 'boxed';
			}

			$navbar_position = get_theme_mod( 'navbar_position', 'normal' );
			$classes[] = 'body-nav-' . $navbar_position;

			return $classes;
		}


		/**
		 * Additional CSS rules for layout options
		 */
		function layout_css( $style ) {

			global $wp_customize;

			// $body_margin_top    = get_theme_mod( 'body_margin_top', 0 );
			// $body_margin_bottom = get_theme_mod( 'body_margin_bottom', 0 );

			// if ( 0 != $body_margin_top ) {
			// 	$style .= 'html body.bootstrap { margin-top: ' . $body_margin_top . 'px !important; }';
			// }

			// if ( 0 != $body_margin_bottom ) {
			// 	$style .= 'html body.bootstrap { margin-bottom: ' . $body_margin_bottom . 'px !important; }';
			// }

			// Customizer-only styles
			if ( $wp_customize ) {

				$screen_sm = filter_var( get_theme_mod( 'screen_tablet', 768 ), FILTER_SANITIZE_NUMBER_INT );
				$screen_md = filter_var( get_theme_mod( 'screen_desktop', 992 ), FILTER_SANITIZE_NUMBER_INT );
				$screen_lg = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
				$gutter    = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );

				$style .= '
				.container {
					padding-left: ' . round( $gutter / 2 ) . 'px;
					padding-right: ' . round( $gutter / 2 ) . 'px;
				}
				@media (min-width: ' . $screen_sm . 'px) {
					.container {
						width: ' . ( $screen_sm - ( $gutter / 2 ) ). 'px;
					}
				}
				@media (min-width: ' . $screen_lg . 'px) {
					.container {
						width: ' . ( $screen_md - ( $gutter / 2 ) ). 'px;
					}
				}
				@media (min-width: ' . $screen_lg . 'px) {
					.container {
						width: ' . ( $screen_lg - ( $gutter / 2 ) ). 'px;
					}
				}
				.container-fluid {
					padding-left: ' . round( $gutter / 2 ) . 'px;
					padding-right: ' . round( $gutter / 2 ) . 'px;
				}
				.row {
					margin-left: -' . round( $gutter / 2 ) . 'px;
					margin-right: -' . round( $gutter / 2 ) . 'px;
				}
				.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
					padding-left: ' . round( $gutter / 2 ) . 'px;
					padding-right: ' . round( $gutter / 2 ) . 'px;
				}';

			}

			return $style;

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

			// $hero = ( ( ( 1 == $visibility && is_front_page() ) || 1 != $visibility ) && is_active_sidebar( 'jumbotron' ) ) ? true : false;
			$hero = ( is_active_sidebar( 'jumbotron' ) ) ? true : false;

			if ( $hero ) : ?>

				<div class="clearfix"></div>

				<?php if ( 'boxed' == $site_style && 1 != $nocontainer ) : ?>
					<div class="container jumbotron">
				<?php else : ?>
					<div class="jumbotron">
				<?php endif; ?>

					<?php if ( ( 1 != $nocontainer && 'wide' == $site_style ) || 'boxed' == $site_style ) : ?>
						<div class="container">
					<?php endif; ?>

						<?php dynamic_sidebar( 'Jumbotron' ); ?>

					<?php if ( ( 1 != $nocontainer && 'wide' == $site_style ) || 'boxed' == $site_style ) : ?>
						</div>
					<?php endif; ?>

					</div>


				</div>
				<?php

			endif;
		}


		/**
		 * Any Jumbotron-specific CSS that can't be added in the .less stylesheet is calculated here.
		 */
		// function jumbotron_css( $styles ) {

		// 	// $center = get_theme_mod( 'jumbotron_center', 0 );
		// 	$thickness = get_theme_mod( 'jumbotron_border_bottom_thickness', 0 );
		// 	$style     = get_theme_mod( 'jumbotron_border_bottom_style', 'none');
		// 	$color     = get_theme_mod( 'jumbotron_border_bottom_color', '#eeeeee' );

		// 	if ( 0 != $center && 0 != $thickness ) {

		// 		$styles .= '.jumbotron{';

		// 		if ( $center ) {
		// 			$styles .= 'text-align:center;';
		// 		}

		// 		if ( $thickness ) {
		// 			$styles .= 'border-bottom:' . $thickness . 'px ' . $style . ' ' . $color . ';';
		// 		}

		// 		$styles .= '}';

		// 	}

		// 	return $styles;

		// }


		/*
		 * Enables the fittext.js for h1 headings
		 */
		// function fittext_init() {

		// 	$fittext_toggle   = get_theme_mod( 'jumbotron_title_fit', 0 );
		// 	$jumbo_visibility = get_theme_mod( 'jumbotron_visibility', 1 );

		// 	// Should only show on the front page if it's enabled, or site-wide when appropriate
		// 	if ( 1 == $fittext_toggle && ( 0 == $jumbo_visibility || ( 1 == $jumbo_visibility && is_front_page() ) ) ) {

		// 		echo '<script>jQuery(".jumbotron h1").fitText(1.3);</script>';

		// 	}

		// }


		/*
		 * Enqueues fittext.js when needed
		 */
		// function fittext_enqueue() {

		// 	$fittext_toggle   = get_theme_mod( 'jumbotron_title_fit', 0 );
		// 	$jumbo_visibility = get_theme_mod( 'jumbotron_visibility', 1 );

		// 	if ( 1 == $fittext_toggle && ( 0 == $jumbo_visibility || ( 1 == $jumbo_visibility && is_front_page() ) ) ) {

		// 		wp_register_script( 'fittext', get_template_directory_uri() . '/framework/bootstrap/assets/js/jquery.fittext.js', false, null, true  );
		// 		wp_enqueue_script( 'fittext' );

		// 	}

		// }


		/*
		 * The Header template
		 */
		function header_html() { ?>

			<?php if ( 1 == get_theme_mod( 'header_toggle', 0 ) ) : ?>

				<header class="page-header">

					<?php if ( 'boxed' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
						<div class="container header-boxed">
					<?php endif; ?>

						<div class="header-wrapper container-fluid">

							<?php if ( 'wide' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
								<div class="container">
							<?php endif; ?>

								<?php if ( 1 == get_theme_mod( 'header_branding', 1 ) ) : ?>
									<?php $extra_class = ( is_active_sidebar( 'header_area' ) ) ? ' col-md-6' : null; ?>
									<a class="brand-logo<?php echo $extra_class; ?>" href="<?php echo home_url(); ?>"><h1><?php echo $this->logo( get_bloginfo( 'name' ) ); ?></h1></a>
								<?php endif; ?>

								<?php $extra_class = ( 1 == get_theme_mod( 'header_branding', 1 ) ) ? ' col-md-6' : null; ?>

								<div class="header-widgets<?php echo $extra_class; ?>"><?php dynamic_sidebar( 'header_area' ); ?></div>

							<?php if ( 'wide' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
								</div>
							<?php endif; ?>

						</div>

					<?php if ( 'boxed' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
						</div>
					<?php endif; ?>

				</header>

			<?php endif;

		}


		/*
		 * Any necessary extra CSS is generated here
		 */
		function header_css( $styles ) {

			if ( 1 == get_theme_mod( 'header_toggle', 0 ) ) {

				$el = ( 'boxed' == get_theme_mod( 'site_style', 'wide' ) ) ? 'body .header-boxed' : 'body .header-wrapper';

				$styles .= $el . ',' . $el . ' a,' . $el . ' h1,' . $el . ' h2,' . $el . ' h3,' . $el . ' h4,' . $el . ' h5,' . $el . ' h6{ color:' . get_theme_mod( 'header_color', '#333333') . ';}';

				// $styles .= ( 0 < get_theme_mod( 'header_margin_top', 0 ) ) ? $element . '{margin-top:' . get_theme_mod( 'header_margin_top', 0 ) . 'px;}' : null;
				// $styles .= ( 0 < get_theme_mod( 'header_margin_bottom', 0 ) ) ? $element . '{margin-bottom:' . get_theme_mod( 'header_margin_bottom', 0 ) . 'px;}' : null;

			}

		}


		/*
		 * Get the content and widget areas for the footer
		 */
		function footer_content() {

			// Finding the number of active widget sidebars
			$num_of_sidebars = 0;

			for ( $i = 0; $i < 5; $i++ ) {
				$sidebar = 'sidebar_footer_' . $i;
				if ( is_active_sidebar( $sidebar ) ) {
					$num_of_sidebars++;
				}
			}

			// If sidebars exist, open row.
			if ( $num_of_sidebars >= 0 ) {
				echo '<div class="row">';
			}

			// Showing the active sidebars
			for ( $i = 0; $i < 5; $i++ ) {
				$sidebar = 'sidebar_footer_' . $i;

				if ( is_active_sidebar( $sidebar ) ) {
					// Setting each column width accordingly
					$col_class = 12 / $num_of_sidebars;

					echo '<div class="col-md-' . $col_class . '">';
						dynamic_sidebar( $sidebar );
					echo '</div>';

				}
			}

			// If sidebars exist, close row.
			if ( $num_of_sidebars >= 0 ) {
				echo '</div>';

				// add a clearfix div.
				echo '<div class="clearfix"></div>';
			}

		}

		/**
		 * Additional CSS rules for layout options
		 */
		function color_css( $style ) {
			global $wp_customize;

			// Customizer-only styles
			if ( ! $wp_customize ) {
				return $style;
			}

			$brand_primary = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_primary', '#428bca' ) ) );
			$brand_success = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_success', '#5cb85c' ) ) );
			$brand_warning = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_warning', '#f0ad4e' ) ) );
			$brand_danger  = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_danger', '#d9534f' ) ) );
			$brand_info    = '#' . str_replace( '#', '', Shoestrap_Color::sanitize_hex( get_theme_mod( 'color_brand_info', '#5bc0de' ) ) );

			$style .= 'a { color: ' . $brand_primary . '; }';
			$style .= '.text-primary { color: ' . $brand_primary . '; }';
			$style .= '.bg-primary { background-color: ' . $brand_primary . '; }';
			$style .= '.btn-primary { background-color: ' . $brand_primary . '; }';
			$style .= '.btn-primary.disabled, .btn-primary[disabled], fieldset[disabled] .btn-primary, .btn-primary.disabled:hover, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary:hover, .btn-primary.disabled:focus, .btn-primary[disabled]:focus, fieldset[disabled] .btn-primary:focus, .btn-primary.disabled:active, .btn-primary[disabled]:active, fieldset[disabled] .btn-primary:active, .btn-primary.disabled.active, .btn-primary[disabled].active, fieldset[disabled] .btn-primary.active { background-color: ' . $brand_primary . '; }';
			$style .= '.btn-primary .badge { color: ' . $brand_primary . '; }';
			$style .= '.btn-link { color: ' . $brand_primary . '; }';
			$style .= '.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus { background-color: ' . $brand_primary . '; }';
			$style .= '.pagination > li > a, .pagination > li > span { color: ' . $brand_primary . '; }';
			$style .= '.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus { background-color: ' . $brand_primary . '; border-color: ' . $brand_primary . '; }';

			$style .= '.text-info { color: ' . $brand_info . '; }';
			$style .= '.bg-info { background-color: ' . $brand_info . '; }';
			$style .= '.btn-info { background-color: ' . $brand_info . '; }';
			$style .= '.btn-info.disabled, .btn-info[disabled], fieldset[disabled] .btn-info, .btn-info.disabled:hover, .btn-info[disabled]:hover, fieldset[disabled] .btn-info:hover, .btn-info.disabled:focus, .btn-info[disabled]:focus, fieldset[disabled] .btn-info:focus, .btn-info.disabled:active, .btn-info[disabled]:active, fieldset[disabled] .btn-info:active, .btn-info.disabled.active, .btn-info[disabled].active, fieldset[disabled] .btn-info.active { background-color: ' . $brand_info . '; }';
			$style .= '.btn-info .badge { color: ' . $brand_info . '; }';

			$style .= '.text-warning { color: ' . $brand_warning . '; }';
			$style .= '.bg-warning { background-color: ' . $brand_warning . '; }';
			$style .= '.btn-warning { background-color: ' . $brand_warning . '; }';
			$style .= '.btn-warning.disabled, .btn-warning[disabled], fieldset[disabled] .btn-warning, .btn-warning.disabled:hover, .btn-warning[disabled]:hover, fieldset[disabled] .btn-warning:hover, .btn-warning.disabled:focus, .btn-warning[disabled]:focus, fieldset[disabled] .btn-warning:focus, .btn-warning.disabled:active, .btn-warning[disabled]:active, fieldset[disabled] .btn-warning:active, .btn-warning.disabled.active, .btn-warning[disabled].active, fieldset[disabled] .btn-warning.active { background-color: ' . $brand_warning . '; }';
			$style .= '.btn-warning .badge { color: ' . $brand_warning . '; }';

			$style .= '.text-danger { color: ' . $brand_danger . '; }';
			$style .= '.bg-danger { background-color: ' . $brand_danger . '; }';
			$style .= '.btn-danger { background-color: ' . $brand_danger . '; }';
			$style .= '.btn-danger.disabled, .btn-danger[disabled], fieldset[disabled] .btn-danger, .btn-danger.disabled:hover, .btn-danger[disabled]:hover, fieldset[disabled] .btn-danger:hover, .btn-danger.disabled:focus, .btn-danger[disabled]:focus, fieldset[disabled] .btn-danger:focus, .btn-danger.disabled:active, .btn-danger[disabled]:active, fieldset[disabled] .btn-danger:active, .btn-danger.disabled.active, .btn-danger[disabled].active, fieldset[disabled] .btn-danger.active { background-color: ' . $brand_danger . '; }';
			$style .= '.btn-danger .badge { color: ' . $brand_danger . '; }';

			return $style;

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

				shoestrap_breadcrumb_trail( $args );

			}

		}


		/**
		 * Excerpt length
		 */
		function excerpt_length() {

			return get_theme_mod( 'post_excerpt_length', 55 );

		}


		/**
		 * The "more" text
		 */
		function excerpt_more( $more, $post_id ) {

			$continue_text = get_theme_mod( 'post_excerpt_link_text', 'Continued' );
			return ' &hellip; <a href="' . get_permalink( $post_id ) . '">' . $continue_text . '</a>';

		}


		/**
		 * Disable featured images per post type.
		 * This is a simple fanction that parses the array of disabled options from the customizer
		 * and then sets their display to 0 if we've selected them in our array.
		 */
		function disable_feat_images_ppt() {
			global $post;

			$current_post_type = get_post_type( $post );
			$images_ppt        = get_theme_mod( 'feat_img_per_post_type', '' );

			// Get the array of disabled featured images per post type
			$disabled = ( '' != $images_ppt ) ? explode( ',', $images_ppt ) : '';

			// Get the default switch values for singulars and archives
			$default = ( is_singular() ) ? get_theme_mod( 'feat_img_post', 0 ) : get_theme_mod( 'feat_img_archive', 0 );

			// If the current post type exists in our array of disabled post types, then set its displaying to false
			if ( $disabled ) {
				$display = ( in_array( $current_post_type, $disabled ) ) ? 0 : $default;
			} else {
				$display = $default;
			}

			return $display;

		}

		/**
		* Build the social links
		*/
		function social_links_builder( $before = '', $after = '', $separator = '' ) {

			$social_links = array(
				'blogger'     => __( 'Blogger', 'shoestrap' ),
				'deviantart'  => __( 'DeviantART', 'shoestrap' ),
				'digg'        => __( 'Digg', 'shoestrap' ),
				'dribbble'    => __( 'Dribbble', 'shoestrap' ),
				'facebook'    => __( 'Facebook', 'shoestrap' ),
				'flickr'      => __( 'Flickr', 'shoestrap' ),
				'github'      => __( 'Github', 'shoestrap' ),
				'googleplus' => __( 'Google+', 'shoestrap' ),
				'instagram'   => __( 'Instagram', 'shoestrap' ),
				'linkedin'    => __( 'LinkedIn', 'shoestrap' ),
				'myspace'     => __( 'MySpace', 'shoestrap' ),
				'pinterest'   => __( 'Pinterest', 'shoestrap' ),
				'reddit'      => __( 'Reddit', 'shoestrap' ),
				'rss'         => __( 'RSS', 'shoestrap' ),
				'skype'       => __( 'Skype', 'shoestrap' ),
				'soundcloud'  => __( 'SoundCloud', 'shoestrap' ),
				'tumblr'      => __( 'Tumblr', 'shoestrap' ),
				'twitter'     => __( 'Twitter', 'shoestrap' ),
				'vimeo'       => __( 'Vimeo', 'shoestrap' ),
				'vkontakte'   => __( 'Vkontakte', 'shoestrap' ),
				'youtube'     => __( 'YouTube', 'shoestrap' ),
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

				$before    = '<ul class="nav navbar-nav navbar-inline-socials"><li>';
				$after     = '</li></ul>';
				$separator = '</li><li>';

			}

			if ( 'dropdown' == $social_mode ) {

				$before    = '<ul class="nav navbar-nav navbar-dropdown-socials"><li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><i class="el-icon-network"></i>&nbsp;<b class="caret"></b></a><ul class="dropdown-menu" role="menu"><li>';
				$after     = '</li></ul></li></ul>';
				$separator = '</li><li>';

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

		/**
		 * Build an array of the available/enabled networks for social sharing.
		 */
		// function get_social_shares() {

		// 	$nets   = explode(',', get_theme_mod( 'share_networks' ) );

		// 	$networks = null;

		// 	foreach ($nets as $net) {

		// 		if ( $net == 'fb') {
		// 			$networks['facebook'] = array(
		// 				'icon'      => 'facebook',
		// 				'fullname'  => 'Facebook',
		// 				'url'       => 'http://www.facebook.com/sharer.php?u=' . get_permalink() . '&amp;title=' . urlencode( html_entity_decode( get_the_title(),ENT_QUOTES,'UTF-8' ) )
		// 			);
		// 		}

		// 		if ( $net == 'tw' ) {
		// 			$networks['twitter'] = array(
		// 				'icon'      => 'twitter',
		// 				'fullname'  => 'Twitter',
		// 				'url'       => 'http://twitter.com/home/?status=' . urlencode( html_entity_decode( strip_tags( get_the_title() ),ENT_QUOTES,'UTF-8' ) ) . ' - ' . get_permalink()
		// 			);

		// 			$twittername = $this->get_tw_username();

		// 			if ( $twittername != '' ) {
		// 				$network['twitter']['username'] = $twittername;
		// 				$networks['twitter']['url'] .= ' via @' . $twittername;
		// 			}
		// 		}

		// 		if ( $net == 'rd' ) {
		// 			$networks['reddit'] = array(
		// 				'icon'      => 'reddit',
		// 				'fullname'  => 'Reddit',
		// 				'url'       => 'http://reddit.com/submit?url=' .get_permalink() . '&amp;title=' . urlencode( html_entity_decode( strip_tags( get_the_title() ),ENT_QUOTES,'UTF-8' ) )
		// 			);
		// 		}

		// 		if ( $net == 'li' ) {
		// 			$networks['linkedin'] = array(
		// 				'icon'      => 'linkedin',
		// 				'fullname'  => 'LinkedIn',
		// 				'url'       => 'http://linkedin.com/shareArticle?mini=true&amp;url=' .get_permalink() . '&amp;title=' . urlencode( html_entity_decode( strip_tags( get_the_title() ),ENT_QUOTES,'UTF-8' ) )
		// 			);
		// 		}

		// 		if ( $net == 'gp' ) {
		// 			$networks['googleplus'] = array(
		// 				'icon'      => 'googleplus',
		// 				'fullname'  => 'Google+',
		// 				'url'       => 'https://plus.google.com/share?url=' . get_permalink()
		// 			);
		// 		}

		// 		if ( $net == 'tu' ) {
		// 			$networks['tumblr'] = array(
		// 				'icon'      => 'tumblr',
		// 				'fullname'  => 'Tumblr',
		// 				'url'       =>  'http://www.tumblr.com/share/link?url=' . urlencode( get_permalink() ) . '&amp;name=' . urlencode( html_entity_decode( strip_tags( get_the_title() ),ENT_QUOTES,'UTF-8' ) ) . "&amp;description=" . urlencode( get_the_excerpt() )
		// 			);
		// 		}

		// 		if ( $net == 'pi' ) {
		// 			$networks['pinterest'] = array(
		// 				'icon'      => 'pinterest',
		// 				'fullname'  => 'Pinterest',
		// 				'url'       => 'http://pinterest.com/pin/create/button/?url=' . get_permalink()
		// 			);
		// 		}

		// 		if ( $net == 'em' ) {
		// 			$networks['email'] = array(
		// 				'icon'      => 'envelope',
		// 				'fullname'  => 'Email',
		// 				'url'       => 'mailto:?subject=' . urlencode( html_entity_decode( strip_tags( get_the_title() ),ENT_QUOTES,'UTF-8' ) ) . '&amp;body=' . get_permalink()
		// 			);
		// 		}

		// 	}

		// 	return $networks;
		// }

		/**
		 * Properly parses the twitter URL if set
		 */
		function get_tw_username() {
			$twittername  = '';
			$twitter_link = get_theme_mod( 'twitter_link' );

			if ( $twitter_link != "" ) {
				$twitter_link = explode( '/', rtrim( $twitter_link, '/' ) );
				$twittername = end( $twitter_link );
			}

			return $twittername;
		}

		/**
		 * Create the social sharing buttons
		 */
		// function social_sharing() {

		// 	// The base class for icons that will be used
		// 	$baseclass  = 'icon el-icon-';

		// 	// Don't show by default
		// 	$show = false;

		// 	// Button class
		// 	$button_color = get_theme_mod('social_sharing_button_class', 'default' );

		// 	// Button Text
		// 	$text = get_theme_mod('social_sharing_text');

		// 	// Build the content
		// 	$content  = '<div class="btn-group btn-group-sm social-share">';
		// 	$content .= '<button class="btn btn-'.$button_color.' social-share-main">'.$text.'</button>';

		// 	// An array of the available networks
		// 	$networks = $this->get_social_shares();
		// 	$networks = is_null( $networks ) ? array() : $networks;

		// 	foreach ( $networks as $network ) {
		// 		$content .= '<a class="btn btn-'.$button_color.' social-link" href="'.$network['url'].'" target="_blank">';
		// 		$content .= '<i class="' . $baseclass . $network['icon'] . '"></i>';
		// 		$content .= '</a>';
		// 	}
		// 	$content .= '</div>';

		// 	// If at least ONE social share option is enabled then echo the content
		// 	if ( ! empty( $networks ) ) {
		// 		echo $content;
		// 	}
		// }

		/**
		 * Include the custom CSS
		 */
		function custom_css() {
			$css = get_theme_mod( 'css', '' );

			if ( ! empty( $css ) ) {
				wp_add_inline_style( 'shoestrap', $css );
			}
		}

	}

}

/**
 * Include the framework
 */
function shoestrap_framework_bootstrap_include( $frameworks ) {

	// Add our framework to the array of available frameworks
	$frameworks[] = array(
		'value' => 'bootstrap',
		'label' => 'Bootstrap',
		'class' => 'SS_Framework_Bootstrap',
	);

	return $frameworks;

}
add_filter( 'shoestrap/frameworks/available', 'shoestrap_framework_bootstrap_include' );

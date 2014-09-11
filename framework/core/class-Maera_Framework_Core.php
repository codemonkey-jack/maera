<?php

/**
* The Framework
*/
class Maera_Framework_Core {

	private static $instance;

	private function __construct() {
		do_action( 'maera/framework/include_modules' );

		if ( ! defined( 'MAERA_FRAMEWORK_PATH' ) ) {
			define( 'MAERA_FRAMEWORK_PATH', dirname( __FILE__ ) );
		}

		$compiler = null;

		// Enqueue the scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 110 );

		// Add the framework Timber modifications
		add_filter( 'timber_context', array( $this, 'timber_extras' ) );

		add_theme_support( 'custom-header' );
		add_filter( 'maera/styles', array( $this, 'custom_header' ) );
		add_filter( 'maera/styles', array( $this, 'colorposts_build_css' ) );

		add_theme_support( 'tonesque' );

	}

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

		wp_register_style( 'bootstrap_min', get_template_directory_uri() . '/framework/core/assets/css/bootstrap.min.css' );
		wp_register_style( 'theme_main', get_template_directory_uri() . '/framework/core/assets/css/main.css' );

		wp_enqueue_style( 'bootstrap_min' );
		wp_enqueue_style( 'theme_main' );

		wp_register_script( 'modernizr-respond', get_template_directory_uri() . '/framework/core/assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', false, null, false );
		wp_register_script( 'panel-menu', get_template_directory_uri() . '/framework/core/assets/js/vendor/jquery.jpanelmenu.min.js', false, null, true );
		wp_register_script( 'bootstrapjs', get_template_directory_uri() . '/framework/core/assets/js/vendor/bootstrap.min.js', false, null, true );
		wp_register_script( 'mainjs', get_template_directory_uri() . '/framework/core/assets/js/main.js', false, null, true );

		wp_enqueue_script( 'modernizr-respond' );
		wp_enqueue_script( 'panel-menu' );
		wp_enqueue_script( 'bootstrapjs' );
		wp_enqueue_script( 'mainjs' );

	}

	/**
	 * Timber extras.
	 */
	function timber_extras( $data ) {

		$data['singular']['image']['switch'] = true;
		$data['singular']['image']['width']  = 550;
		$data['singular']['image']['height'] = 300;

		$data['archives']['image']['switch'] = true;
		$data['archives']['image']['width']  = 550;
		$data['archives']['image']['height'] = 300;

		return $data;
	}

	function custom_header( $styles ) {

		$url = $this->custom_header_url();

		if ( empty( $url ) ) {
			return;
		} else {
			return $styles . '.sidebar.perma { background: url("' . $url . '") no-repeat center center; }';
		}

	}

	function custom_header_url() {

		$image_url = get_header_image();
		if ( is_singular() && has_post_thumbnail() ) {
			$image_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			$image_url = $image_array[0];
		}

		if ( empty( $image_url ) ) {
			return false;
		} else {
			return $image_url;
		}

	}

	function pn_get_attachment_id_from_url( $attachment_url = '' ) {

		global $wpdb;
		$attachment_id = false;

		// If there is no url, return.
		if ( '' == $attachment_url )
			return;

		// Get the upload directory paths
		$upload_dir_paths = wp_upload_dir();

		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
		if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

			// Remove the upload path base directory from the attachment URL
			$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

			// Finally, run a custom database query to get the attachment ID from the modified attachment URL
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

		}

		return $attachment_id;
	}

	/**
	* Build CSS from Tonesque
	*
	* @uses get_the_ID(), is_single(), get_post_meta(), colorposts_get_post_image(), update_post_meta(), apply_filters()
	*
	* @since Color Posts 1.0
	*/
	function colorposts_build_css( $styles ) {
		$post_id = get_the_ID();

		$src = $this->custom_header_url();

		if ( $src ) {
			if ( is_singular() && has_post_thumbnail() ) {
				$context_id = $post_id;
			} else {
				$context_id = $this->pn_get_attachment_id_from_url( $src );
			}

			// Grab color from post meta
			$tonesque = get_post_meta( $context_id, '_post_colors', true );

			// No color? Let's get one
			if ( empty( $tonesque ) ) {

				$tonesque = new Tonesque( $src );
				$tonesque = array(
					'color'    => $tonesque->color(),
					'contrast' => $tonesque->contrast(),
				);

				if ( $tonesque['color'] ) {
					update_post_meta( $post_id, '_post_colors', $tonesque );
				} else {
					return;
				}
			}

			// Add the CSS to our page
			extract( $tonesque );
			if ( empty( $color ) || empty( $contrast ) ) {
				return $styles;
			} else {
				$white = new Jetpack_Color( '#FFFFFF' );
				$color = new Jetpack_Color( '#' . $color );
				$luminosity = $color->toLuminosity();
				$fontcolor  = ( $luminosity < 0.5 ) ? '#FFFFFF' : '#222222';
				$background = $fontcolor == '#FFFFFF' ? 'rgba(0,0,0,0.3)' : 'rgba(255,255,255,0.3)';

				$styles .= '.entry-header h1, h2.entry-title a{color:#' . $color->getReadableContrastingColor( $white, 6 )->toHex() . ' !important;}';
				$styles .= '#jPanelMenu-menu,.side-writer-icon, .writer-icon{background-color:#' . $color->getReadableContrastingColor( $white, 5 )->toHex() . ' !important;}';
				$styles .= '.sidebar.perma,.sidebar.perma a,.sidebar.perma .site-info, .primary-info{color:' . $fontcolor . ' !important;}';
				$styles .= '.site-info{background: ' . $background . '; padding: 15px;}';

				return $styles;
			}

		}

	}

}

/**
 * Include the framework
 */
function maera_framework_core_include( $frameworks ) {

	// Add our framework to the array of available frameworks
	$frameworks[] = array(
		'value' => 'core',
		'label' => 'Core',
		'class' => 'Maera_Framework_Core',
	);

	return $frameworks;

}
add_filter( 'maera/frameworks/available', 'maera_framework_core_include' );

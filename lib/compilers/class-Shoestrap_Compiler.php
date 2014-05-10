<?php

if ( ! class_exists( 'Shoestrap_Compiler' ) ) {

	/**
	* The Shoestrap Compiler
	*/
	class Shoestrap_Compiler {

		public $compiler;
		public $minimize_css = true;
		public $less_path;
		public $sass_path;
		public $custom_styles;

		function __construct() {

			if ( 'less_php' == $this->compiler ) {

				// Require the less parser
				if ( ! class_exists( 'Less_Parser' ) ) {
					require_once( 'less.php' );
				}

			} elseif ( 'sass_php' == $this->compiler ) {

				// Require the less parser
				if ( ! class_exists( 'scssc' ) ) {
					require_once( 'scss.inc.php' );
				}

			}

			$this->custom_styles = apply_filters( 'shoestrap/compiler/custom_styles', '' );

			add_filter( 'shoestrap/stylesheet_url', array( $this, 'stylesheet_url' ) );
			add_filter( 'shoestrap/stylesheet_ver', array( $this, 'stylesheet_ver' ) );
			add_action( 'admin_notices', array( $this, 'file_nag' ) );

			// If the Custom LESS exists and has changed after the last compilation, trigger the compiler.
			if ( is_writable( get_stylesheet_directory() . '/assets/less/custom.scss' ) ) {
				if ( filemtime( get_stylesheet_directory() . '/assets/less/custom.scss' ) > filemtime( self::file() ) ) {
					self::makecss();
				}
			}
		}

		/*
		 * Gets the css path or url to the stylesheet
		 * If $target = 'path', return the path
		 * If $target = 'url', return the url
		 *
		 * If echo = true then print the path or url.
		 */
		public static function file( $target = 'path', $echo = false ) {
			global $blog_id;

			// No need to process this on each page load... Use transients to improve performance.
			// Transients are valid for 24 hours, so these calculations only run once aday.
			if ( ! get_transient( 'shoestrap_stylesheet_path' ) || ! get_transient( 'shoestrap_stylesheet_uri' ) ) {

				// Get the upload directory for this site.
				$upload_dir = wp_upload_dir();

				// If this is a multisite installation, append the blogid to the filename
				if ( is_multisite() && $blog_id > 1 ) {
					$cssid = '_id-' . $blog_id;
				} else {
					$cssid = null;
				}
				$file_name = '/ss-style' . $cssid . '.css';

				// Define a default folder for the stylesheets.
				$def_folder_path = get_template_directory() . '/assets/css';

				// The folder path for the stylesheet.
				// We try to first write to the uploads folder.
				// If we can write there, then use that folder for the stylesheet.
				// This helps so that the stylesheets don't get overwritten when the theme gets updated.
				if ( is_writable( $upload_dir['basedir'] . $file_name ) || is_writable( $upload_dir['basedir'] ) ) {
					$folder_path = $upload_dir['basedir'];
				} elseif ( is_writable( ABSPATH . '/css' . $file_name ) || is_writable( ABSPATH . '/css' ) ) {
					// Fallback to the WordPress root folder /css
					$folder_path = ABSPATH . '/css';
				} else {
					// Fallback to the theme's default folder.
					$folder_path = $def_folder_path;
				}

				// The complete path to the file.
				$file_path = $folder_path . $file_name;

				// Get the URL directory of the stylesheet
				if ( $folder_path == $upload_dir['basedir'] ) {
					// Path is set to WordPress uploads dir
					$css_uri_folder = $upload_dir['baseurl'];

				} elseif ( $folder_path == ABSPATH . '/css' ) {
					// Path is set to WordPress root /css
					$css_uri_folder = site_url() . '/css';

					// On multisites use network_site_url() instead of site_url()
					if ( is_multisite() ) {
						$css_uri_folder = network_site_url() . '/css';
					}

				} else {
					// Fallback to the theme's assets/css folder.
					$css_uri_folder = get_template_directory_uri() . '/assets/css';

				}

				// If the CSS file does not exist, use the default file.
				if ( file_exists( $file_path ) ) {
					$css_uri = $css_uri_folder . $file_name;
				} else {
					$css_uri = get_template_directory_uri() . '/assets/css/style-default.css';
				}

				// If a style.css file exists in the assets/css folder, use that file instead.
				// This is mostly for backwards-compatibility with previous versions.
				// Also if the stylesheet is compiled using grunt, this will make sure the correct file is used.
				if ( ! file_exists( $file_path . $file_name ) && file_exists( $def_folder_path . $file_name) ) {
					$css_uri   = get_template_directory_uri() . '/assets/css/style' . $cssid . '.css';
					$file_path = $def_folder_path . '/style' . $cssid . '.css';
				}

				$css_path = $file_path;

				// Strip protocols
				$css_uri = str_replace( 'https://', '//', $css_uri );
				$css_uri = str_replace( 'http://', '//', $css_uri );

				// Set a transient for the stylesheet path and url.
				if ( ! get_transient( 'shoestrap_stylesheet_path' ) || ! get_transient( 'shoestrap_stylesheet_uri' ) ) {
					set_transient( 'shoestrap_stylesheet_path', $css_path, 24 * 60 *60 );
					set_transient( 'shoestrap_stylesheet_uri', $css_uri, 24 * 60 *60 );
				}
			}

			$css_path = get_transient( 'shoestrap_stylesheet_path' );
			$css_uri  = get_transient( 'shoestrap_stylesheet_uri' );

			$value = ( $target == 'url' ) ? $css_uri : $css_path;

			// Get the file version based on its filemtime
			if ( $target == 'ver' ) {
				if ( ! get_transient( 'shoestrap_stylesheet_time' ) ) {
					set_transient( 'shoestrap_stylesheet_time', filemtime( $css_path ), 24 * 60 * 60 );
				}

				$value = get_transient( 'shoestrap_stylesheet_time' );
			}

			if ( $echo ) {
				echo $value;
			} else {
				return $value;
			}
		}

		/**
		 * Get the URL of the stylesheet
		 */
		function stylesheet_url() {
			return self::file( 'url' );
		}

		/**
		 * Get the version of the stylesheet
		 */
		function stylesheet_ver() {
			return self::file( 'ver' );
		}

		/*
		 * Admin notice if css is not writable
		 */
		function file_nag( $array ) {
			global $current_screen, $wp_filesystem;

			if ( $current_screen->parent_base == 'themes' ) {
				$filename = self::file();
				$url = self::stylesheet_url( 'url' );

				if ( ! file_exists( $filename ) ) {
					if ( ! $wp_filesystem->put_contents( $filename, ' ', FS_CHMOD_FILE ) ) {
						$content = __( 'The following file does not exist and must be so in order to utilise this theme. Please create this file.', 'shoestrap' );
						$content .= '<br>' . __( 'Try visiting the theme options and clicking the "Reset All" button to attempt automatically creating it.', 'shoestrap' );
						$content .= '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $filename . '" target="_blank">' . $filename . '</a>';
						add_settings_error( 'shoestrap', 'create_file', $content, 'error' );
						settings_errors();
					}
				} else {
					if ( ! is_writable( $filename ) ) {
						$content = __( 'The following file is not writable and must be so in order to utilise this theme. Please update the permissions.', 'shoestrap' );
						$content .= '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $filename . '" target="_blank">' . $filename . '</a>';

						add_settings_error( 'shoestrap', 'create_file', $content, 'error' );
						settings_errors();
					}
				}
			}
		}

		public static function makecss() {
			global $wp_filesystem;

			$file = self::file();

			// Initialize the Wordpress filesystem.
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			$content = '/********* Compiled - Do not edit *********/

			';

			$content .= apply_filters( 'shoestrap/compiler', '' );

			// Strip protocols
			$content = str_replace( 'https://', '//', $content );
			$content = str_replace( 'http://', '//', $content );

			if ( is_writeable( $file ) || ( ! file_exists( $file ) && is_writeable( dirname( $file ) ) ) ) {
				if ( ! $wp_filesystem->put_contents( $file, $content, FS_CHMOD_FILE ) ) {
					return apply_filters( 'shoestrap/compiler/output', $content );
				}
			}

			// Force re-building the stylesheet version transient
			delete_transient( 'shoestrap_stylesheet_time' );
			delete_transient( 'shoestrap_stylesheet_path' );
			delete_transient( 'shoestrap_stylesheet_uri' );
		}

		/*
		 * This function can be used to compile a less file to css using the lessphp compiler
		 */
		public function less_compiler() {

			$options   = array( 'compress' => $this->minimize_css );
			$less_path = $this->less_path;

			$webfont_location   = get_template_directory() . '/assets/fonts/';

			$custom_less_file   = get_stylesheet_directory() . '/assets/less/custom.less';

			$css = '';
			try {

				$parser = new Less_Parser( $options );

				// The main app.less file
				$parser->parseFile( $less_path . 'app.less', '' );

				// Include the Elusive Icons
				$parser->parseFile( $webfont_location . 'elusive-webfont.less', '' );

				// Enable gradients
				if ( $ss_settings['gradients_toggle'] == 1 ) {
					$parser->parseFile( $less_path . 'gradients.less', '' );
				}

				// The custom.less file
				if ( is_writable( $custom_less_file ) ) {
					$parser->parseFile( $less_path . 'custom.less', '' );
				}

				// Parse any custom less added by the user
				if ( '' != $this->custom_styles ) {
					$parser->parse( $this->custom_styles );
				}

				// Get the extra variables & imports
				$extra_vars = do_action( 'shoestrap/compiler/variables' );
				$parser->parse( $extra_vars );

				// Add a filter to the compiler
				$parser->parse( apply_filters( 'shoestrap/compiler', '' ) );

				$css = $parser->getCss();

			} catch( Exception $e ) {

				$error_message = $e->getMessage();

			}

			// Replace relaive with absolute paths
			$css = str_replace( '../', get_template_directory_uri() . '/assets/', $css );

			// apply some custom logic to make things work with SSL
			$css = preg_replace( '|https?:\/\/([^\/]+)|i', null, $css );
			$css = str_replace( 'http:', '', $css );
			$css = str_replace( 'https:', '', $css );

			return $css;
		}

		/*
		 * This function can be used to compile a less file to css using the lessphp compiler
		 */
		function sass_compiler() {

			$scss = new scssc();
			$scss->setImportPaths( $this->sass_path );

			$css =  $scss->compile( apply_filters( 'foundation_scss', '@import "app.scss";' ) );

			// Ugly hack to properly set the path to webfonts
			$css = str_replace( "url('Elusive-Icons", "url('" . get_template_directory_uri() . '/assets/fonts/' . "Elusive-Icons", $css );

			return $css;
		}

	}
}

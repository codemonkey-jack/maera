<?php

if ( ! class_exists( 'Maera_Compiler' ) ) {

	/**
	* The Maera Compiler
	*/
	class Maera_Compiler {

		private $compiler;
		private $minimize_css = true;
		private $less_path;
		private $sass_path;
		private $custom_styles = '';

		function __construct( $args = array() ) {

			$args = wp_parse_args( $args, array(
				'compiler'      => null,
				'minimize_css'  => true,
			) );
			extract( $args );

			$this->compiler      = $compiler;
			$this->minimize_css  = $minimize_css;

			if ( 'less' == $this->compiler ) {
				add_theme_support( 'less_compiler' );
			} elseif ( 'sass' == $this->compiler ) {
				add_theme_support( 'sass_compiler' );
			}

			add_filter( 'maera/stylesheet/url', array( $this, 'stylesheet_url' ) );
			add_filter( 'maera/stylesheet/ver', array( $this, 'stylesheet_ver' ) );
			// add_action( 'admin_notices', array( $this, 'file_nag' ) );

		}

		/*
		 * Gets the css path or url to the stylesheet
		 * If $target = 'path', return the path
		 * If $target = 'url', return the url
		 *
		 * If echo = true then print the path or url.
		 */
		public static function file( $target = 'path' ) {
			global $blog_id;

			// No need to process this on each page load... Use transients to improve performance.
			// Transients are valid for 24 hours, so these calculations only run once a day.
			if ( ! get_transient( 'maera_stylesheet_path' ) || ! get_transient( 'maera_stylesheet_uri' ) ) {

				// Get the upload directory for this site.
				$upload_dir = wp_upload_dir();

				// If this is a multisite installation, append the blogid to the filename
				$cssid = ( is_multisite() && $blog_id > 1 ) ? '_id-' . $blog_id : null;

				$file_name = '/maera' . $cssid . '.css';

				// Define a default folder for the stylesheets.
				$def_folder_path = get_template_directory() . '/assets/css';
				$folder_path     = $def_folder_path;

				// The folder path for the stylesheet.
				// We try to first write to the uploads folder.
				// If we can write there, then use that folder for the stylesheet.
				// This helps so that the stylesheets don't get overwritten when the theme gets updated.
				if ( is_writable( $upload_dir['basedir'] . $file_name ) || is_writable( $upload_dir['basedir'] ) ) {
					$folder_path = $upload_dir['basedir'];
				} elseif ( is_writable( ABSPATH . '/css' . $file_name ) || is_writable( ABSPATH . '/css' ) ) {
					// Fallback to the WordPress root folder /css
					$folder_path = ABSPATH . '/css';
				} else { // No file is writable, so exit.
					return;
				}

				// The complete path to the file.
				$file_path = $folder_path . $file_name;

				// Get the URL directory of the stylesheet
				if ( $folder_path == $upload_dir['basedir'] ) {
					// Path is set to WordPress uploads dir
					$css_uri_folder = $upload_dir['baseurl'];
				} elseif ( $folder_path == ABSPATH . '/css' ) {
					// Path is set to WordPress root /css
					// On multisites use network_site_url() instead of site_url()
					$css_uri_folder = ( is_multisite() ) ? network_site_url() . '/css' : site_url() . '/css';
				}

				$css_uri = $css_uri_folder . $file_name;
				$css_path = $file_path;

				// Take care of domain mapping
				if ( defined( 'DOMAIN_MAPPING' ) && 1 == DOMAIN_MAPPING ) {
					if ( function_exists( 'domain_mapping_siteurl' ) && function_exists( 'get_original_url' ) ) {

						$mapped   = domain_mapping_siteurl( false );
						$original = get_original_url( 'siteurl' );
						$css_uri  = str_replace( $original, $mapped, $css_uri );

					}
				}

				// Strip protocols
				$css_uri = str_replace( 'https://', '//', $css_uri );
				$css_uri = str_replace( 'http://', '//', $css_uri );

				// Set a transient for the stylesheet path and url.
				if ( ! get_transient( 'maera_stylesheet_path' ) || ! get_transient( 'maera_stylesheet_uri' ) ) {
					set_transient( 'maera_stylesheet_path', $css_path, 24 * 60 *60 );
					set_transient( 'maera_stylesheet_uri', $css_uri, 24 * 60 *60 );
				}
			}

			$css_path = get_transient( 'maera_stylesheet_path' );
			$css_uri  = get_transient( 'maera_stylesheet_uri' );

			$value = ( $target == 'url' ) ? $css_uri : $css_path;

			// Get the file version based on its filemtime
			if ( $target == 'ver' ) {
				if ( ! get_transient( 'maera_stylesheet_time' ) ) {
					set_transient( 'maera_stylesheet_time', filemtime( $css_path ), 24 * 60 * 60 );
				}

				$value = get_transient( 'maera_stylesheet_time' );
			}

			return $value;

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
			global $current_screen, $wp_filesystem, $maera_i18n;

			if ( $current_screen->parent_base == 'themes' ) {
				$filename = self::file();
				$url = self::stylesheet_url( 'url' );

				if ( ! file_exists( $filename ) ) {
					if ( ! $wp_filesystem->put_contents( $filename, ' ', FS_CHMOD_FILE ) ) {
						// TODO: error message

						// $content = $maera_i18n['filedoesnotexist'];
						// $content .= '<br>' . __( 'Try visiting the theme options and clicking the "Reset All" button to attempt automatically creating it.', 'maera' );
						// $content .= '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $filename . '" target="_blank">' . $filename . '</a>';
						// add_settings_error( 'maera', 'create_file', $content, 'error' );
						// settings_errors();
					}
				} else {
					if ( ! is_writable( $filename ) ) {
						// TODO: error message

						// $content = __( 'The following file is not writable and must be so in order to utilise this theme. Please update the permissions.', 'maera' );
						// $content .= '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $filename . '" target="_blank">' . $filename . '</a>';
						//
						// add_settings_error( 'maera', 'create_file', $content, 'error' );
						// settings_errors();
					}
				}
			}
		}

		public function makecss() {
			global $wp_filesystem;

			$file = self::file();

			// Initialize the Wordpress filesystem.
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			$content = '/********* Compiled - Do not edit *********/

			';

			if ( 'less' == $this->compiler ) {

				$content = $this->compiler_less();

			} elseif ( 'sass' == $this->compiler ) {

				$content = $this->compiler_sass();

			}

			// Take care of domain mapping
			if ( defined( 'DOMAIN_MAPPING' ) && 1 == DOMAIN_MAPPING ) {
				if ( function_exists( 'domain_mapping_siteurl' ) && function_exists( 'get_original_url' ) ) {

					$mapped = domain_mapping_siteurl( false );
					$mapped = str_replace( 'https://', '//', $mapped );
					$mapped = str_replace( 'http://', '//', $mapped );

					$original = get_original_url( 'siteurl' );
					$original = str_replace( 'https://', '//', $original );
					$original = str_replace( 'http://', '//', $original );

					$content = str_replace( $original, $mapped, $content );

				}
			}

			// Strip protocols
			$content = str_replace( 'https://', '//', $content );
			$content = str_replace( 'http://', '//', $content );

			if ( is_writeable( $file ) || ( ! file_exists( $file ) && is_writeable( dirname( $file ) ) ) ) {
				if ( ! $wp_filesystem->put_contents( $file, $content, FS_CHMOD_FILE ) ) {
					return apply_filters( 'maera/compiler/output', $content );
				}
			}

			// Force re-building the stylesheet version transient
			delete_transient( 'maera_stylesheet_time' );
			delete_transient( 'maera_stylesheet_path' );
			delete_transient( 'maera_stylesheet_uri' );
		}

		/*
		 * This function can be used to compile a less file to css using the lessphp compiler
		 */
		public function compiler_less() {

			$options   = array( 'compress' => $this->minimize_css );

			$css = '';

			try {

				$parser = new Less_Parser( $options );

				$parser->parse( apply_filters( 'maera/compiler', null ) );

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
		function compiler_sass() {
			// TODO: THIS IS FAR FROM COMPLETE

			$scss = new scssc();
			$scss->setImportPaths( $this->sass_path );

			$css = $scss->compile( apply_filters( 'maera/compiler', null ) );

			return $css;
		}

	}
}

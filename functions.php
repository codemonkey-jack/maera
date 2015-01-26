<?php

class Maera {

	private static $instance;

	public $template;

	function __construct() {

		require_once( locate_template( '/lib/class-Maera_Required_Plugins.php' ) );

		$this->required_plugins();
		$this->requires();

		Maera_Helper::define( 'MAERA_VERSION', '1.0.3' );
		Maera_Helper::define( 'MAERA_ASSETS_URL', get_stylesheet_directory_uri() . '/assets' );

		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_action( 'init', array( $this, 'content_width' ) );
		add_filter( 'get_search_form', array( $this, 'get_search_form' ) );
		add_filter( 'kirki/config', array( $this, 'customizer_config' ) );

		global $maera_shell;
		$maera_shell    = new Maera_Shell();
		$maera_init     = new Maera_Init();

		$this->timber   = new Maera_Timber();
		$this->styles   = new Maera_Styles();
		$this->dev      = new Maera_Development();
		$this->cache    = new Maera_Caching();
		$this->cc       = new Maera_Core_Customizer();
		$this->template = new Maera_Template();

		global $maera_admin;
		$maera_admin  = new Maera_Admin();

		// This is not ready yet so hide it.
		// For dev you can add this line to your wp-config.php file:
		// define( 'MAERA_HIDE_CORE_CUSTOMIZER', false );
		if ( ! defined( 'MAERA_HIDE_CORE_CUSTOMIZER' ) ) {
			define( 'MAERA_HIDE_CORE_CUSTOMIZER', true );
		}

		add_action( 'init', array( $this, 'licensing' ) );

	}

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Include all the necessary files for the theme here
	 */
	function requires() {

		$files = array(
			'/lib/class-Maera_Helper.php',
			'/lib/template-hierarchy.php',
			'/lib/utils.php',
			'/lib/class-Maera_Template.php',
			'/lib/class-Maera_Shell.php',
			'/lib/class-Maera_Timber.php',
			'/lib/class-Maera_Init.php',
			'/lib/class-Maera_Styles.php',
			'/lib/widgets.php',
			'/lib/admin/class-Maera_Admin.php',
			'/lib/updater/class-Maera_Updater.php',
			'/lib/class-Maera_Development.php',
			'/lib/class-Maera_Caching.php',
			'/lib/class-Maera_Core_Customizer.php',
			'/lib/remote-installer/client.php'
		);

		foreach ( $files as $file ) {
			require_once locate_template( $file );
		}

	}

	/**
	 * Test if all required plugins are active or not.
	 * If they are not, returns true;
	 */
	public static function test_missing() {

		$plugins = apply_filters( 'maera/plugins/required', array() );
		$status  = get_transient( 'maera_required_plugins_status' );

		// If the transient exists and is set to 'ok' then no need to proceed.
		if ( false === $status && 'ok' == $status ) {
			return 'ok';
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		foreach ( $plugins as $plugin ) {
			if ( ! is_plugin_active( $plugin['slug'] . '/' . $plugin['file'] ) ) {
				return 'bad';
			}
		}

		// If we're good to go, set the transient value to 'ok' for 2 minutes
		set_transient( 'maera_required_plugins_status', 'ok', 60 * 2 );

		return 'ok';

	}

	/*
	 * Set the content width
	 * Uses the 'maera/content_width' filter.
	 */
	function content_width() {

		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = apply_filters( 'maera/content_width', 960 );
		}

	}

	/**
	 * Add and remove body_class() classes
	 */
	function body_class( $classes ) {

		// Add post/page slug
		if ( is_single() || is_page() && ! is_front_page() ) {

			$permalink = basename( get_permalink() );
			$classes[] = sanitize_html_class( $permalink );

		}

		$classes[] = get_theme_mod( 'shell', 'core' );

		// Remove unnecessary classes
		$home_id_class  = 'page-id-' . get_option( 'page_on_front' );
		$remove_classes = array(
			'page-template-default',
			$home_id_class
		);

		$classes = array_diff( $classes, $remove_classes );

		return $classes;

	}

	/**
	 * Tell WordPress to use searchform.php from the templates/ directory
	 */
	function get_search_form( $form ) {
		$form = '';
		locate_template( '/searchform.php', true, false );
		return $form;
	}

	/**
	 * The configuration options for the Kirki Customizer
	 */
	function customizer_config() {

		$args = array( 'stylesheet_id' => 'maera' );
		return $args;

	}

	/**
	 * Build the array of required plugins.
	 * You can use the 'maera/required_plugins' filter to add or remove plugins.
	 */
	function required_plugins() {

		$plugins = array(
			array(
				'name' => 'Timber',
				'file' => 'timber.php',
				'slug' => 'timber-library',
			),
			array(
				'name' => 'Jetpack',
				'file' => 'jetpack.php',
				'slug' => 'jetpack',
			),
			array(
				'name' => 'Kirki',
				'file' => 'kirki.php',
				'slug' => 'kirki',
			),
		);

		if ( current_theme_supports( 'breadcrumbs' ) ) {
			$plugins[] = array( 'name' => 'Breadcrumb Trail', 'file' => 'breadcrumb-trail.php', 'slug' => 'breadcrumb-trail' );
		}

		if ( current_theme_supports( 'less_compiler' ) || current_theme_supports( 'sass_compiler' ) ) {
			$plugins[] = array( 'name' => 'Less & scss compilers', 'file' => 'less-plugin.php', 'slug' => 'lessphp' );
		}

		$jetpack_active_modules = get_option( 'jetpack_active_modules' );
		if ( isset( $jetpack_active_modules['photon'] ) && $jetpack_active_modules['photon'] ) {
			$plugins[] = array( 'name' => 'Timber with Jetpack Photon', 'file' => 'TimberPhoton.php', 'slug' => 'timber-with-jetpack-photon' );
		}

		$plugins = new Maera_Required_Plugins( $plugins );

	}

	function licensing() {

		if ( is_admin() && class_exists( 'Maera_Updater' ) ) {
			$maera_md_license = new Maera_Updater( 'theme', __FILE__, 'Maera', MAERA_VERSION );
		}

	}

}

function Maera() {
	return Maera::get_instance();
}

// Global for backwards compatibility.
$GLOBALS['maera'] = maera();
global $maera;

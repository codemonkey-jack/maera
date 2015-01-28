<?php

// Require all necessary files
require_once( locate_template( '/lib/class-Maera_Required_Plugins.php' ) );
require_once( locate_template( '/lib/class-Maera_Helper.php' ) );
require_once( locate_template( '/lib/template-hierarchy.php' ) );
require_once( locate_template( '/lib/utils.php' ) );
require_once( locate_template( '/lib/class-Maera_Template.php' ) );
require_once( locate_template( '/lib/class-Maera_Shell.php' ) );
require_once( locate_template( '/lib/class-Maera_Timber.php' ) );
require_once( locate_template( '/lib/class-Maera_Init.php' ) );
require_once( locate_template( '/lib/class-Maera_Styles.php' ) );
require_once( locate_template( '/lib/widgets.php' ) );
require_once( locate_template( '/lib/admin/class-Maera_Admin.php' ) );
require_once( locate_template( '/lib/updater/class-Maera_Updater.php' ) );
require_once( locate_template( '/lib/class-Maera_Development.php' ) );
require_once( locate_template( '/lib/class-Maera_Caching.php' ) );
require_once( locate_template( '/lib/class-Maera_Core_Customizer.php' ) );
require_once( locate_template( '/lib/remote-installer/client.php' ) );

class Maera {

	private static $instance;

	public $shell;
	public $template;
	public $timber;
	public $styles;
	public $dev;
	public $cache;
	public $plugins;

	function __construct() {

		Maera_Helper::define( 'MAERA_VERSION', '1.0.3' );
		Maera_Helper::define( 'MAERA_ASSETS_URL', get_stylesheet_directory_uri() . '/assets' );

		add_filter( 'kirki/config', array( $this, 'customizer_config' ) );

		global $maera_shell;
		$maera_shell    = new Maera_Shell();
		$maera_init     = new Maera_Init();

		$this->shell    = $maera_shell;
		$this->timber   = new Maera_Timber();
		$this->styles   = new Maera_Styles();
		$this->dev      = new Maera_Development();
		$this->cache    = new Maera_Caching();
		$this->cc       = new Maera_Core_Customizer();
		$this->template = new Maera_Template();
		$this->plugins  = new Maera_Required_Plugins( $this->required_plugins() );

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
			array( 'name' => 'Timber',  'file' => 'timber.php',  'slug' => 'timber-library' ),
			array( 'name' => 'Jetpack', 'file' => 'jetpack.php', 'slug' => 'jetpack' ),
			array( 'name' => 'Kirki',   'file' => 'kirki.php',   'slug' => 'kirki' ),
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

		return $plugins;

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

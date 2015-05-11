<?php

class Maera {

	private static $instance;

	public $shell;
	public $template;
	public $timber;
	public $styles;
	public $dev;
	public $cache;
	public $plugins;
	public $admin;
	public $views;

	function __construct() {

		Maera_Helper::define( 'MAERA_VERSION', '1.1.1' );
		Maera_Helper::define( 'MAERA_ASSETS_URL', get_stylesheet_directory_uri() . '/assets' );

		add_filter( 'kirki/config', array( $this, 'customizer_config' ) );

		$maera_init     = new Maera_Init();

		$this->shell    = new Maera_Shell();
		$this->timber   = new Maera_Timber();
		$this->styles   = new Maera_Styles();
		$this->dev      = new Maera_Development();
		$this->cache    = new Maera_Caching();
		$this->cc       = new Maera_Core_Customizer();
		$this->views    = new Maera_Template();
		$this->template = $this->views;
		$this->plugins  = new Maera_Required_Plugins( $this->required_plugins() );
		$this->admin    = new Maera_Admin();

		// This is not ready yet so hide it.
		// For dev you can add this line to your wp-config.php file:
		// define( 'MAERA_HIDE_CORE_CUSTOMIZER', false );
		if ( ! defined( 'MAERA_HIDE_CORE_CUSTOMIZER' ) ) {
			define( 'MAERA_HIDE_CORE_CUSTOMIZER', true );
		}

		add_action( 'init', array( $this, 'licensing' ) );

		add_action( 'wp', array( $this, 'updates' ) );

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

		$args = array(
			'stylesheet_id' => 'maera',
			// 'color_active'  => '#ffab00',
			// 'color_light'   => '#ffc107',
			// 'color_select'  => '#ff9800',
			// 'color_accent'  => '#ff5722',
			// 'color_back'    => '#222',
		);

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
			$maera_md_license = new Maera_Updater( 'theme', __FILE__, 'Maera', MAERA_VERSION, '3ac52694580f66e9a3de48b56692dd45' );
		}

	}

	/**
	 * We can handle any db updates here for backwards-compatibility
	 */
	function updates() {

		if ( ! get_option( 'maera_version' ) ) {
			update_option( 'maera_version', MAERA_VERSION );
		}

	}

}

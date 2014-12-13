<?php

class Maera {

	function __construct() {

		self::define( 'MAERA_ASSETS_URL', get_stylesheet_directory_uri() . '/assets' );

		// If the Timber plugin is not already installed, load it from the theme.
		if ( ! class_exists( 'Timber' ) ) {
			// TODO: ERROR MESSAGE
		}

		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_action( 'init', array( $this, 'content_width' ) );
        add_filter( 'get_search_form', array( $this, 'get_search_form' ) );
		add_filter( 'kirki/config', array( $this, 'customizer_config' ) );
		add_action( 'customize_save_after', array( $this, 'reset_style_cache_on_customizer_save' ) );

		$this->requires();

		global $maera_shell;
		$maera_shell = new Maera_Shell();

		$maera_timber = new Maera_Timber();
		$maera_init   = new Maera_Init();
		$maera_styles = new Maera_Styles();

		$this->required_plugins();

	}

	function requires() {

		$files = array(
			'/lib/class-Maera_Required_Plugins.php',
			'/lib/utils.php',
			'/lib/class-Maera_Shell.php',
			'/lib/class-Maera_Timber.php',
			'/lib/class-Maera_Init.php',
			'/lib/class-Maera_Styles.php',
			'/lib/widgets.php',
			'/lib/admin/class-Maera_Admin.php',
			'/lib/updater/updater.php',
		);

		foreach ( $files as $file ) {
			require_once locate_template( $file );
		}

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
	* Reset the cache when saving the customizer
	*/
	function reset_style_cache_on_customizer_save() {
		remove_theme_mod( 'css_cache' );
	}

	/**
	* Check if a constand is already defined, and if not then give it a value
	*/
	public static function define( $define, $value ) {
		if ( ! defined( $define ) ) {
			define( $define, $value );
		}
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

}

$maera = new Maera();

/**
 * Helpre function.
 * See Maera_Timber for more details.
 */
function timber_get_template_part( $slug, $name = null, $context = array() ) {
	Maera_Timber::get_template_part( $slug, $name = null, $context = array() );
}

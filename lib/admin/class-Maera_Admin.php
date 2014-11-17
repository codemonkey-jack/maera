<?php

/**
* The theme options class.
* This can hold options like import/export and layout selection.
* Things that in general don't belong to a shell but the theme in general.
* Shell-Specific options should use the customizer instead.
*/
class Maera_Admin {

	function __construct() {

		// Load only if we are viewing the admin page
		if ( ! is_admin() || ! isset ( $_GET['page'] ) || ! 'theme_options' == $_GET['page'] ) {
			return;
		}

		add_action( 'admin_init', array( $this, 'register_settings') );
		add_action( 'admin_menu', array( $this, 'maera_admin_options' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );

	}

	/**
	 * Register our settings
	 */
	function register_settings() {

		register_setting( 'maera_admin_options', 'maera_admin_options', array( $this, 'validate' ) );

	}

	/**
	 * Add the admin page
	 */
	function maera_admin_options() {

		add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', array( $this, 'admin_page' ) );

	}

	/**
	 * Enqueue necessary scripts and styles
	 */
	function scripts() {

		// wp_enqueue_style( 'dashicons' );
		wp_enqueue_scripts( 'jquery-ui-core' );
		wp_enqueue_scripts( 'jquery-ui-tabs' );

		wp_register_style( 'maera-admin-css', get_template_directory_uri() . '/assets/css/admin-style.css', false, '1.0.0' );
		wp_enqueue_style( 'maera-admin-css' );

	}

	/**
	 * returns an array of the available tabs.
	 */
	function tabs() {

		return apply_filters( 'maera/admin/tabs', array(
			'settings' => __( 'Settings', 'maera' ),
			'addons'   => __( 'Addons', 'maera' ),
			'docs'     => __( 'Documentation', 'maera' )
		) );

	}

	function tabs_head( $current = 'settings' ) {

		$tabs    = $this->tabs();
		$content = '<h2 class="nav-tab-wrapper">';

	    foreach( $tabs as $tab => $name ){

	        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
			$content .= '<a class="nav-tab' . $class . '" href="?page=theme_options&tab=' . $tab . '">' . $name . '</a>';

	    }

		$content .= '</h2>';

		return $content;

	}

	/**
	 * The admin page contents
	 */
	function admin_page() {

		global $maera_i18n, $pagenow;

		$tabs    = $this->tabs();
		$current = ( isset ( $_GET['tab'] ) ) ? $_GET['tab'] : 'settings';

		// This checks whether the form has just been submitted.
		if ( ! isset( $_REQUEST['updated'] ) ) {
			$_REQUEST['updated'] = false;
		} ?>

		<div class="wrap metabox-holder">
			<h2><?php echo $maera_i18n['maerathemeoptions']; ?></h2>

			<?php if ( false !== $_REQUEST['updated'] ) : ?>
				<div class="updated fade"><p><?php _e( 'Options saved', 'maera' ); ?></p></div>
			<?php endif; ?>

			<?php echo $this->tabs_head( $current ); ?>
			<?php foreach ( $tabs as $tab => $label ) : ?>
				<?php if ( $current == $tab ) : ?>
					<?php include( dirname( __FILE__ ) . '/tabs/' . $tab . '.php' ); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<?php

	}

	/**
	 * Trigger the compiler and reset cached CSS on save.
	 * This is necessary for the imports to properly work.
	 */
	function validate( $settings ) {

		// Import the imported options
		if ( ! empty( $settings['import_data'] ) ) {

			$theme_mods = json_decode( $settings['import_data'], true );

			foreach ( $theme_mods as $theme_mod => $value ) {
				set_theme_mod( $theme_mod, $value );
			}

			// The import data should not be saved, save the field as empty.
			$settings['import_data'] = '';

		}

		do_action( 'maera/admin/save' );

		return $settings;

	}

}
$maera_admin = new Maera_Admin();

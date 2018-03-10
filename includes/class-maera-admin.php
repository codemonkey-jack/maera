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
		if ( is_admin() && isset ( $_GET['page'] ) && 'theme_options' == $_GET['page'] ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		}

		add_action( 'admin_init', array( $this, 'register_settings') );
		add_action( 'admin_menu', array( $this, 'maera_admin_options' ) );
		add_action( 'after_switch_theme', array( $this, 'activation' ) );

		add_action('admin_notices', array( $this, 'admin_notice' ) );
		add_action('admin_init', array( $this, 'nag_ignore' ) );

	}

	/**
	 * Go to the theme options page after theme activation
	 */
	function activation() {
		if ( current_user_can( 'edit_theme_options' ) ) {
		wp_redirect( self_admin_url( 'themes.php?page=theme_options' ) );
	}
	else {
		wp_die( 'Sorry you can\'t do that' );
	}
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
		add_theme_page( __( 'Theme Options', 'maera' ), __( 'Theme Options', 'maera' ), 'edit_theme_options', 'theme_options', array( $this, 'admin_page' ) );
	}

	/**
	 * Enqueue necessary scripts and styles
	 */
	function scripts() {

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tabs' );

		wp_enqueue_style( 'maera_theme_admin_css', get_template_directory_uri() . '/assets/css/admin-style.css', false, '1.0.0' );

		wp_enqueue_style( 'dashicons' );

	}

	/**
	 * returns an array of the available tabs.
	 */
	function tabs() {

		return apply_filters( 'maera/admin/tabs', array(
			'general'   => esc_html__( 'General', 'maera' ),
			'settings'  => esc_html__( 'Settings', 'maera' ),
			'docs'      => esc_html__( 'Documentation', 'maera' ),
		) );

	}

	function tabs_head( $current = 'settings' ) {

		$tabs    = $this->tabs();
		$content = '<h2 class="nav-tab-wrapper">';

		foreach( $tabs as $tab => $name ){

			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			$href = esc_url( '?page=theme_options&tab=' . $tab );
			$content .= '<a class="nav-tab' . $class . '" href="' . $href . '">' . $name . '</a>';

		}

		$content .= '</h2>';

		return $content;

	}

	/**
	 * The admin page contents
	 */
	function admin_page() {

		global $pagenow;

		$tabs    = $this->tabs();
		$current = ( isset ( $_GET['tab'] ) ) ? $_GET['tab'] : 'general';

		// This checks whether the form has just been submitted.
		if ( ! isset( $_REQUEST['updated'] ) ) {
			$_REQUEST['updated'] = false;
		} ?>

		<div class="wrap metabox-holder">
			<?php if ( false !== $_REQUEST['updated'] ) : ?>
				<div class="updated fade"><p><?php _e( 'Options saved', 'maera' ); ?></p></div>
			<?php endif; ?>

			<?php echo $this->tabs_head( $current ); ?>
			<?php foreach ( $tabs as $tab => $label ) : ?>
				<?php if ( $current == $tab ) : ?>
					<?php if ( file_exists( get_template_directory() . '/includes/admin/tabs/' . $tab . '.php' ) ) : ?>
						<?php include( get_template_directory() . '/includes/admin/tabs/' . $tab . '.php' ); ?>
					<?php endif; ?>
					<?php do_action( 'maera/admin/' . $tab ); ?>
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
		if ( isset( $settings['import_data'] ) && ! empty( $settings['import_data'] ) ) {

			if ( 'RESET' == $settings['import_data'] ) {
				remove_theme_mods();
			} else {
				$theme_mods = json_decode( $settings['import_data'], true );

				foreach ( $theme_mods as $theme_mod => $value ) {
					set_theme_mod( $theme_mod, $value );
				}
			}

			// The import data should not be saved, save the field as empty.
			$settings['import_data'] = '';

		}

		do_action( 'maera/admin/save' );

		return $settings;

	}

	function admin_notice() {

		global $current_user ;
		$user_id = $current_user->ID;

		$maera_admin_options = apply_filters( 'maera/admin/options', array(
			'shell'       => 'core',
			'import_data' => '',
			'dev_mode'    => 1,
			'cache'       => '0',
			'cache_mode'  => 'default',
		) );

		// Get the available shells
		$available_shells = apply_filters( 'maera/shells/available', array() );

		$cache_modes = array(
			array( 'value' => 'none',      'label' => esc_html__( 'No Caching', 'maera' ) ),
			array( 'value' => 'object',    'label' => esc_html__( 'WP Object Caching', 'maera' ) ),
			array( 'value' => 'transient', 'label' => esc_html__( 'Transients', 'maera' ) ),
			array( 'value' => 'default',   'label' => esc_html__( 'Default', 'maera' ) ),
		);

		$settings = get_option( 'maera_admin_options', $maera_admin_options );

		$display_core_notification  = ( 1 >= count( $available_shells ) ) ? true : false;
		$display_shell_notification = ( 1 < count( $available_shells ) && 'core' == $settings['shell'] ) ? true : false;

		if ( ! get_user_meta( $user_id, 'maera_multiple_shells_notification_ignore' ) && $display_shell_notification ) : ?>
			<div class="updated">
				<p>
					<?php
						printf(
							esc_html__( 'We have detected that you are have installed a Maera Shell but still have the Core shell active. Please visit the <a href="%1$s">Settings</a> tab in your theme options to activate your new shell. | <a href="%2$s">Hide this notice</a>', 'maera' ),
							esc_url( admin_url( 'themes.php?page=theme_options&tab=settings' ) ),
							esc_url( '?maera_multiple_shells_notification_ignore=0' )
						);
					?>
				</p>
			</div>
		<?php endif;

	}


	function nag_ignore() {

		global $current_user;
		$user_id = $current_user->ID;
		// If user clicks to ignore the notice, add that to their user meta
		if ( isset( $_GET['maera_core_shell_notification_ignore'] ) && '0' == $_GET['maera_core_shell_notification_ignore'] ) {
			add_user_meta( $user_id, 'maera_core_shell_notification_ignore', 'true', true );
		}

		if ( isset( $_GET['maera_multiple_shells_notification_ignore'] ) && '0' == $_GET['maera_multiple_shells_notification_ignore'] ) {
			add_user_meta( $user_id, 'maera_multiple_shells_notification_ignore', 'true', true );
		}

	}

}

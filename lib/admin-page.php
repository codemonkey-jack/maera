<?php

/**
* The theme options class.
* This can hold options like import/export and layout selection.
* Things that in general don't belong to a CSS framework but the theme in general.
* CSS-Framework-Specific options should use the customizer instead.
*/
class Shoestrap_Admin_Page {

	function __construct() {

		// Load only if we are viewing an admin page
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_init', array( $this, 'register_settings') );
		add_action( 'admin_menu', array( $this, 'shoestrap_admin_options' ) );

	}

	/**
	 * Register our settings
	 */
	function register_settings() {

		register_setting( 'shoestrap_admin_options', 'shoestrap_admin_options' );

	}

	/**
	 * Add the admin page
	 */
	function shoestrap_admin_options() {

		add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', array( $this, 'admin_page' ) );

	}

	/**
	 * The admin page contents
	 */
	function admin_page() {

		// The available options
		$shoestrap_admin_options = apply_filters( 'shoestrap/admin/options', array(
			'framework' => 'bootstrap',
		) );

		// Get the available frameworks
		$available_frameworks = apply_filters( 'shoestrap/frameworks/available', array() );

		// This checks whether the form has just been submitted.
		if ( ! isset( $_REQUEST['updated'] ) ) {
			$_REQUEST['updated'] = false;
		} ?>

		<div class="wrap">
			<h2><?php echo get_current_theme() . __( ' Theme Options', 'shoestrap' ); ?></h2>

			<?php if ( false !== $_REQUEST['updated'] ) : ?>
				<div class="updated fade"><p><?php _e( 'Options saved', 'shoestrap' ); ?></p></div>
			<?php endif; ?>

			<form method="post" action="options.php">

				<?php $settings = get_option( 'shoestrap_admin_options', $shoestrap_admin_options ); ?>
				<?php settings_fields( 'shoestrap_admin_options' ); ?>

				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( 'Choose a framework', 'shoestrap' ); ?></th>
						<td>
							<?php foreach( $available_frameworks as $available_framework ) : ?>
								<input type="radio" id="<?php echo $available_framework['value']; ?>" name="shoestrap_admin_options[framework]" value="<?php esc_attr_e( $available_framework['value'] ); ?>" <?php checked( $settings['framework'], $available_framework['value'] ); ?> />
								<label for="<?php echo $available_framework['value']; ?>"><?php echo $available_framework['label']; ?></label><br />
							<?php endforeach; ?>
						</td>
					</tr>
				</table>

				<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

			</form>

		</div>
		<?php
	}

}
$admin_page = new Shoestrap_Admin_Page();

<?php

/**
* The theme options class.
* This can hold options like import/export and layout selection.
* Things that in general don't belong to a CSS framework but the theme in general.
* CSS-Framework-Specific options should use the customizer instead.
*/
class Maera_Admin_Page {

	function __construct() {

		// Load only if we are viewing an admin page
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_init', array( $this, 'register_settings') );
		add_action( 'admin_menu', array( $this, 'maera_admin_options' ) );

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
	 * The admin page contents
	 */
	function admin_page() {

		// The available options
		$maera_admin_options = apply_filters( 'maera/admin/options', array(
			'framework'   => 'bootstrap',
			'import_data' => '',
		) );

		// Get the available frameworks
		$available_frameworks = apply_filters( 'maera/frameworks/available', array() );

		// This checks whether the form has just been submitted.
		if ( ! isset( $_REQUEST['updated'] ) ) {
			$_REQUEST['updated'] = false;
		} ?>

		<div class="wrap">
			<h2><?php echo __( 'Maera Theme Options', 'maera' ); ?></h2>

			<?php if ( false !== $_REQUEST['updated'] ) : ?>
				<div class="updated fade"><p><?php _e( 'Options saved', 'maera' ); ?></p></div>
			<?php endif; ?>

			<form method="post" action="options.php">

				<?php $settings = get_option( 'maera_admin_options', $maera_admin_options ); ?>
				<?php settings_fields( 'maera_admin_options' ); ?>

				<table class="form-table">

					<tr valign="top">
						<th scope="row"><?php _e( 'Choose a framework', 'maera' ); ?></th>
						<td>
							<?php foreach( $available_frameworks as $available_framework ) : ?>
								<input type="radio" id="<?php echo $available_framework['value']; ?>" name="maera_admin_options[framework]" value="<?php esc_attr_e( $available_framework['value'] ); ?>" <?php checked( $settings['framework'], $available_framework['value'] ); ?> />
								<label for="<?php echo $available_framework['value']; ?>"><?php echo $available_framework['label']; ?></label><br />
							<?php endforeach; ?>
						</td>
					</tr>

					<tr>
						<th><?php _e( 'Export Customizer Options', 'maera' ); ?></th>
						<td>
							<?php
								// Get an array of all the theme mods
								$theme_mods = get_theme_mods();

								$options = array();
								foreach ( $theme_mods as $theme_mod => $value ) {
									$options[$theme_mod] = maybe_unserialize( $value );
								}

								$json = json_encode( $options );

								echo '<textarea rows="10" cols="50" disabled>' . $json . '</textarea>';
							?>
						</td>
					</tr>

					<tr>
						<th><?php _e( 'Import Customizer Options', 'maera' ); ?></th>
						<td>
							<textarea id="import_data" name="maera_admin_options[import_data]" rows="10" cols="50"><?php echo stripslashes($settings['import_data']); ?></textarea>
						</td>
					</tr>


				</table>

				<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

			</form>

		</div>
		<?php
	}

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

		return $settings;

	}

}
$admin_page = new Maera_Admin_Page();

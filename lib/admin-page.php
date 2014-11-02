<?php

/**
* The theme options class.
* This can hold options like import/export and layout selection.
* Things that in general don't belong to a shell but the theme in general.
* Shell-Specific options should use the customizer instead.
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

		global $maera_i18n;

		// The available options
		$maera_admin_options = apply_filters( 'maera/admin/options', array(
			'shell'       => 'core',
			'import_data' => '',
			'dev_mode'    => 1,
			'cache'       => '0'
		) );

		// Get the available shells
		$available_shells = apply_filters( 'maera/shells/available', array() );

		// This checks whether the form has just been submitted.
		if ( ! isset( $_REQUEST['updated'] ) ) {
			$_REQUEST['updated'] = false;
		} ?>

		<div class="wrap metabox-holder">
			<h2><?php echo $maera_i18n['maerathemeoptions']; ?></h2>

			<?php if ( false !== $_REQUEST['updated'] ) : ?>
				<div class="updated fade"><p><?php _e( 'Options saved', 'maera' ); ?></p></div>
			<?php endif; ?>

			<form method="post" action="options.php">

				<?php $settings = get_option( 'maera_admin_options', $maera_admin_options ); ?>
				<?php settings_fields( 'maera_admin_options' ); ?>

				<div id="maera_shell_select" class="postbox ">
					<h3 class="hndle"><span><?php echo $maera_i18n['shellselection']; ?></span></h3>
					<div class="inside">
						<?php echo apply_filters( 'maera/admin/shell_select_description', $maera_i18n['shellselectdescr'] ); ?>
						<br><br>
						<?php foreach( $available_shells as $available_shell ) : ?>
							<input type="radio" id="<?php echo $available_shell['value']; ?>" name="maera_admin_options[shell]" value="<?php esc_attr_e( $available_shell['value'] ); ?>" <?php checked( $settings['shell'], $available_shell['value'] ); ?> />
							<label for="<?php echo $available_shell['value']; ?>"><?php echo $available_shell['label']; ?></label><br />
						<?php endforeach; ?>
					</div>
				</div>

				<div id="maera_dev_mode" class="postbox">
					<h3 class="hndle"><span><?php echo $maera_i18n['devandcache']; ?></span></h3>
					<div class="inside">
						<p><h4><?php echo $maera_i18n['developmentmode']; ?></h4></p>
						<input type="checkbox" name="maera_admin_options[dev_mode]" <?php checked( @$settings['dev_mode'], 1 ); ?> value='1'>
						<label for="maera_admin_options[dev_mode]"><?php echo $maera_i18n['enabledevmode']; ?></label>
						<p><h4><?php echo $maera_i18n['cachingminutes']; ?></h4></p>
						<input type="number" name="maera_admin_options[cache]" min="0" max="1440" value="<?php echo @$settings['cache']; ?>">
						<label for="maera_admin_options[cache]"><?php echo $maera_i18n['setcacheminutes']; ?></label>
					</div>
				</div>

				<div id="maera_exporter_importer" class="postbox">
					<h3 class="hndle"><span><?php echo $maera_i18n['exportimport']; ?></span></h3>
					<div class="inside">
						<p><h4><?php echo $maera_i18n['exportcustomizer']; ?></h4></p>
						<?php
							// Get an array of all the theme mods
							$theme_mods = get_theme_mods();

							$options = array();
							foreach ( $theme_mods as $theme_mod => $value ) {
								$options[$theme_mod] = ( 'css_cache' != $theme_mod ) ? maybe_unserialize( $value ) : '';
							}

							$json = json_encode( $options );

							echo '<textarea rows="3" cols="50" disabled style="width: 100%;">' . $json . '</textarea>';
						?>

						<p><h4><?php echo $maera_i18n['importcustomizer']; ?></h4></p>
						<textarea id="import_data" name="maera_admin_options[import_data]" rows="3" cols="50" style="width: 100%;"><?php echo stripslashes($settings['import_data']); ?></textarea>
					</div>
				</div>
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

		do_action( 'maera/admin/save' );

		return $settings;

	}

}
$admin_page = new Maera_Admin_Page();

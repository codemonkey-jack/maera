<?php

// The available options
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
	array( 'value' => 'none',      'label' => __( 'No Caching', 'maera' ) ),
	array( 'value' => 'object',    'label' => __( 'WP Object Caching', 'maera' ) ),
	array( 'value' => 'transient', 'label' => __( 'Transients', 'maera' ) ),
	array( 'value' => 'default',   'label' => __( 'Default', 'maera' ) ),
);

$settings = get_option( 'maera_admin_options', $maera_admin_options );

$settings['shell']       = ! isset( $settings['shell'] )       ? 'core' : $settings['shell'];
$settings['import_data'] = ! isset( $settings['import_data'] ) ? ''     : $settings['import_data'];
$settings['dev_mode']    = ! isset( $settings['dev_mode'] )    ? 0      : $settings['dev_mode'];
$settings['cache']       = ! isset( $settings['cache'] )       ? 0      : $settings['cache'];
$settings['cache_mode']  = ! isset( $settings['cache_mode'] )  ? 'none' : $settings['cache_mode'];

?>
<form method="post" action="options.php">

	<?php settings_fields( 'maera_admin_options' ); ?>

	<?php if ( 1 < count( $available_shells ) ) : ?>
		<div id="maera_shell_select" class="postbox ">
			<h3 class="hndle"><span><?php _e( 'Select a Shell', 'maera' ); ?></span></h3>
			<div class="inside">
				<?php echo apply_filters( 'maera/admin/shell_select_description', __( 'You can select the shell that you want to activate here. Please note that when changing shells all your settings are lost so you should keep a backup of them.', 'maera' ) ); ?>
				<br>
				<?php foreach( $available_shells as $available_shell ) : ?>
					<input type="radio" id="<?php echo $available_shell['value']; ?>" name="maera_admin_options[shell]" value="<?php esc_attr_e( $available_shell['value'] ); ?>" <?php checked( $settings['shell'], $available_shell['value'] ); ?> />
					<label for="<?php echo $available_shell['value']; ?>"><?php echo $available_shell['label']; ?></label><br />
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<div id="maera_dev_mode" class="postbox">
		<h3 class="hndle"><span><?php _e( 'Development Mode & Caching', 'maera' ); ?></span></h3>
		<div class="inside">
			<p><h4><?php _e( 'Development Mode', 'maera' ); ?></h4></p>
			<input type="checkbox" name="maera_admin_options[dev_mode]" <?php checked( @$settings['dev_mode'], 1 ); ?> value='1'>
			<label for="maera_admin_options[dev_mode]"><?php _e( 'Enable development mode. Please keep in mind that the actual implementation of the dev mode depends on the shell you have chosen', 'maera' ); ?></label>
			<p><h4><?php _e( 'Caching (minutes)', 'maera' ); ?></h4></p>
			<input type="number" name="maera_admin_options[cache]" min="0" max="1440" value="<?php echo @$settings['cache']; ?>">
			<label for="maera_admin_options[cache]"><?php _e( 'Set the time (in minutes) you want your pages cached. CAUTION: If you have any context dependent sub-views (eg. current user), this mode won\'t do. In that case, set this to 0.', 'maera' ); ?></label>
			<br>
			<hr>
			<p><?php _e( 'Choose a caching mode for your theme templates', 'maera' ); ?></p>
			<?php foreach( $cache_modes as $cache_mode ) : ?>
				<input type="radio" id="<?php echo $cache_mode['value']; ?>" name="maera_admin_options[cache_mode]" value="<?php esc_attr_e( $cache_mode['value'] ); ?>" <?php checked( $settings['cache_mode'], $cache_mode['value'] ); ?> />
				<label for="<?php echo $cache_mode['value']; ?>"><?php echo $cache_mode['label']; ?></label>
			<?php endforeach; ?>
		</div>
	</div>

	<div id="maera_exporter_importer" class="postbox">
		<h3 class="hndle"><span><?php _e( 'Export/Import customizer options', 'maera' ); ?></span></h3>
		<div class="inside">
			<p><h4><?php _e( 'Export Customizer options', 'maera' ); ?></h4></p>
			<?php
				// Get an array of all the theme mods
				$theme_mods = get_theme_mods();

				$options = array();
				if ( ! empty( $theme_mods ) ) {
					foreach ( $theme_mods as $theme_mod => $value ) {
						$options[$theme_mod] = ( 'css_cache' != $theme_mod ) ? maybe_unserialize( $value ) : '';
					}

					$json = json_encode( $options );
				} else {
					$json = '[]';
				}

				echo '<textarea rows="3" cols="50" disabled style="width: 100%;">' . $json . '</textarea>';
			?>

			<p><h4><?php _e( 'Import Customizer options. If you want to reset the customizer, you will have to simply enter RESET in the import field (all capitals).', 'maera' ); ?></h4></p>
			<textarea id="import_data" name="maera_admin_options[import_data]" rows="3" cols="50" style="width: 100%;"><?php echo stripslashes( @$settings['import_data'] ); ?></textarea>
		</div>
	</div>
	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

</form>

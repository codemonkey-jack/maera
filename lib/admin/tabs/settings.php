<?php

global $maera_i18n;

// The available options
$maera_admin_options = apply_filters( 'maera/admin/options', array(
	'shell'       => 'core',
	'import_data' => '',
	'dev_mode'    => 1,
	'cache'       => '0'
) );

// Get the available shells
$available_shells = apply_filters( 'maera/shells/available', array() ); ?>

<form method="post" action="options.php">

	<?php $settings = get_option( 'maera_admin_options', $maera_admin_options ); ?>
	<?php settings_fields( 'maera_admin_options' ); ?>

	<?php if ( 1 < count( $available_shells ) ) : ?>
		<div id="maera_shell_select" class="postbox ">
			<h3 class="hndle"><span><?php echo $maera_i18n['shellselection']; ?></span></h3>
			<div class="inside">
				<?php echo apply_filters( 'maera/admin/shell_select_description', $maera_i18n['shellselectdescr'] ); ?>
				<br>
				<?php foreach( $available_shells as $available_shell ) : ?>
					<input type="radio" id="<?php echo $available_shell['value']; ?>" name="maera_admin_options[shell]" value="<?php esc_attr_e( $available_shell['value'] ); ?>" <?php checked( $settings['shell'], $available_shell['value'] ); ?> />
					<label for="<?php echo $available_shell['value']; ?>"><?php echo $available_shell['label']; ?></label><br />
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

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

			<p><h4><?php echo $maera_i18n['importcustomizer']; ?></h4></p>
			<textarea id="import_data" name="maera_admin_options[import_data]" rows="3" cols="50" style="width: 100%;"><?php echo stripslashes( @$settings['import_data'] ); ?></textarea>
		</div>
	</div>
	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

</form>

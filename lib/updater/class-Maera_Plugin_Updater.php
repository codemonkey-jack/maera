<?php

class Maera_Plugin_Updater {

	private $file;
	private $license;
	private $item_name;
	private $item_shortname;
	private $version;
	private $author  = 'PressCodes Team';
	private $api_url = 'https://press.codes/';

	private $args = array();

	function __construct( $_file, $_item_name, $_version, $_author = null, $_optname = null, $_api_url = null ) {

		$this->slug           = $_file;
		$this->item_name      = $_item_name;
		$this->item_shortname = is_null( $_optname ) ? preg_replace( '/[^a-zA-Z0-9_\s]/', '', str_replace( ' ', '_', strtolower( $this->item_name ) ) ) : $_optname;
		$this->version        = $_version;
		$this->license        = get_option( $this->item_shortname . '_license_key' );
		$this->author         = is_null( $_author ) ? $this->author : $_author;
		$this->api_url        = is_null( $_api_url ) ? $this->api_url : $_api_url;

		// Load the custom Updater if not already loaded
		if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
		}

		add_action( 'admin_init', array( $this, 'plugin_updater' ), 0 );
		add_action( 'admin_init', array( $this, 'register_option' ) );
		add_action( 'admin_init', array( $this, 'activate_license') );
		add_action( 'admin_init', array( $this, 'deactivate_license' ) );

		add_action( 'maera/admin/licensing', array( $this, 'form' ) );

	}

	function plugin_updater() {

		// retrieve our license key from the DB
		$license_key = trim( get_option( $this->item_shortname ) );

		// setup the updater
		$edd_updater = new EDD_SL_Plugin_Updater( $this->api_url, $this->slug, array(
			'version'   => $this->version,
			'license'   => $this->license,
			'item_name' => $this->item_name,
			'author'    => $this->author
		) );

	}

	function form() {
		$status  = get_option( $this->item_shortname . '_status' );
		?>

		<div class="maera licensing item">
			<h2 class="title"><?php echo $this->item_name ?></h2>
			<div class="content">
				<form method="post" action="options.php">
					<?php settings_fields( $this->item_shortname ); ?>
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row" valign="top"><?php _e( 'License Key', 'maera' ); ?></th>
								<td>
									<input id="<?php echo $this->item_shortname . '_license_key'; ?>" name="<?php echo $this->item_shortname . '_license_key'; ?>" type="text" class="regular-text" value="<?php esc_attr_e( $this->license ); ?>" />
									<label class="description" for="<?php echo $this->item_shortname . '_license_key'; ?>"><?php _e( 'Enter your license key', 'maera' ); ?></label>
								</td>
							</tr>
							<?php if ( false !== $this->license ) { ?>
								<tr valign="top">
									<th scope="row" valign="top"><?php _e( 'Activate License', 'maera' ); ?></th>
									<td>
										<?php if ( $status !== false && $status == 'valid' ) { ?>
											<span style="color:green;"><?php _e( 'active', 'maera' ); ?></span>
											<?php wp_nonce_field( $this->item_shortname . '_nonce', $this->item_shortname . '_nonce' ); ?>
											<input type="submit" class="button-secondary" name="<?php echo $this->item_shortname . '_deactivate'; ?>" value="<?php _e( 'Deactivate License', 'maera' ); ?>"/>
										<?php } else {
											wp_nonce_field( $this->item_shortname . '_nonce', $this->item_shortname . '_nonce' ); ?>
											<input type="submit" class="button-secondary" name="<?php echo $this->item_shortname . '_activate'; ?>" value="<?php _e( 'Activate License', 'maera' ); ?>"/>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php submit_button(); ?>
				</form>
			</div>
		</div>
		<?php
	}

	function register_option() {
		register_setting( $this->item_shortname, $this->item_shortname . '_license_key', array( $this, 'sanitize_license' ) );
	}

	function sanitize_license( $new ) {

		$old = get_option( $this->license );

		if ( $old && $old != $new ) {
			// new license has been entered, so must reactivate
			delete_option( $this->item_shortname . '_license_status' );
		}

		return $new;

	}

	function activate_license() {

		// listen for our activate button to be clicked
		if ( isset( $_POST[$this->item_shortname . '_activate'] ) ) {

			// run a quick security check
			if ( ! check_admin_referer( $this->item_shortname . '_nonce', $this->item_shortname . '_nonce' ) ) {
				return; // get out if we didn't click the Activate button
			}

			// retrieve the license from the database
			$license = trim( $this->license );

			// data to send in our API request
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => $license,
				'item_name'  => urlencode( $this->item_name ),
				'url'        => home_url()
			);

			// Call the custom API.
			$response = wp_remote_get( add_query_arg( $api_params, $this->api_url ), array( 'timeout' => 15, 'sslverify' => false ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) ) {
				return false;
			}

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			// $license_data->license will be either "valid" or "invalid"

			update_option( $this->item_shortname . '_status', $license_data->license );

		}

	}

	function deactivate_license() {

		// listen for our activate button to be clicked
		if ( isset( $_POST[$this->item_shortname . '_deactivate'] ) ) {

			// run a quick security check
			if ( ! check_admin_referer( $this->options_id . '_nonce', $this->item_shortname . '_nonce' ) ) {
				return; // get out if we didn't click the Deactivate button
			}

			// retrieve the license from the database
			$license = trim( $this->license );

			// data to send in our API request
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => $license,
				'item_name'  => urlencode( $this->item_name ),
				'url'        => home_url()
			);

			// Call the custom API.
			$response = wp_remote_get( add_query_arg( $api_params, $this->api_url ), array( 'timeout' => 15, 'sslverify' => false ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) ) {
				return false;
			}

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			// $license_data->license will be either "deactivated" or "failed"

			if ( 'deactivated' == $license_data->license ) {
				delete_option( $this->item_shortname . '_status' );
			}

		}

	}

}

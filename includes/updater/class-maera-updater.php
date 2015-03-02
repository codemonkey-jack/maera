<?php

class Maera_Updater {

	private $context;
	private $file;
	private $license;
	private $item_name;
	private $item_shortname;
	private $version;
	private $author  = 'PressCodes Team';
	private $api_url = 'https://press.codes/';
	private $license_status;

	function __construct( $context = 'plugin', $_file, $_item_name, $_version, $license = '', $_author = null, $_optname = null, $_api_url = null ) {

		$this->context        = $context;
		$this->slug           = $_file;
		$this->item_name      = $_item_name;
		$this->item_shortname = is_null( $_optname ) ? preg_replace( '/[^a-zA-Z0-9_\s]/', '', str_replace( ' ', '_', strtolower( $this->item_name ) ) ) : $_optname;
		$this->version        = $_version;
		$this->license        = trim( get_option( $this->item_shortname . '_license_key' ) );
		if ( false !== $this->license || empty( $this->license ) ) {
			$this->license = $license;
		}
		$this->author         = is_null( $_author ) ? $this->author : $_author;
		$this->api_url        = is_null( $_api_url ) ? $this->api_url : $_api_url;
		$this->license_status = get_option( $this->item_shortname . '_license_status', '' );

		if ( 'plugin' == $this->context ) {
			if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
				include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
			}
		} else if ( 'theme' == $this->context ) {
			if ( ! class_exists( 'EDD_SL_Theme_Updater' ) ) {
				include( dirname( __FILE__ ) . '/EDD_SL_Theme_Updater.php' );
			}
		}

		if ( 'plugin' == $this->context ) {
			add_action( 'admin_init', array( $this, 'plugin_updater' ), 0 );
		} else if ( 'theme' == $this->context ) {
			add_action( 'admin_init', array( $this, 'theme_updater' ), 0 );
		}
		add_action( 'admin_init', array( $this, 'register_option' ) );
		add_action( 'admin_init', array( $this, 'activate_license') );

		add_action( 'maera/admin/licensing', array( $this, 'form' ) );

		add_action('admin_notices', array( $this, 'admin_notice' ) );
		add_action('admin_init', array( $this, 'nag_ignore' ) );


	}


	function plugin_updater() {

		// setup the updater
		$edd_updater = new EDD_SL_Plugin_Updater( $this->api_url, $this->slug, array(
			'version'   => $this->version,
			'license'   => $this->license,
			'item_name' => $this->item_name,
			'author'    => $this->author
		) );

	}

	function theme_updater() {

		$edd_updater = new EDD_SL_Theme_Updater( array(
			'remote_api_url' => $this->api_url,
			'version'        => $this->version,
			'license'        => $this->license,
			'item_name'      => $this->item_name,
			'author'         => $this->author,
		) );

	}

	function form() { ?>

		<div class="maera licensing item">
			<h3 class="title"><?php echo $this->item_name ?></h3>
			<div class="content">
				<form method="post" action="options.php">
					<?php settings_fields( $this->item_shortname ); ?>
					<label class="description" for="<?php echo $this->item_shortname . '_license_key'; ?>"><?php _e( 'Enter your license key', 'maera' ); ?></label>
					<input id="<?php echo $this->item_shortname . '_license_key'; ?>" name="<?php echo $this->item_shortname . '_license_key'; ?>" type="text" class="regular-text" value="<?php esc_attr_e( $this->license ); ?>" />

					<?php submit_button( __( 'Save', 'maera' ), 'primary', 'submit', false ) ?>

					<?php if ( false !== $this->license ) : ?>
						<?php if ( 'valid' == $this->license_status ) : ?>
							<span class="maera active license indicator"><?php _e( 'active', 'maera' ); ?></span>
						<?php elseif ( 'invalid' == $this->license_status ) : ?>
							<span class="maera inactive license indicator"><?php _e( 'invalid', 'maera' ); ?></span>
						<?php else : ?>
							<?php wp_nonce_field( $this->item_shortname . '_nonce', $this->item_shortname . '_nonce' ); ?>
							<input type="submit" class="button-secondary" name="<?php echo $this->item_shortname . '_activate'; ?>" value="<?php _e( 'Activate License', 'maera' ); ?>"/>
						<?php endif; ?>
					<?php endif; ?>

				</form>
			</div>
		</div>
		<?php
	}

	function admin_notice() {

		global $current_user ;
		$user_id = $current_user->ID;
		// Check that the user hasn't already clicked to ignore the message and the licence is not valid.
		if ( ! get_user_meta( $user_id, $this->item_shortname . '_license_key_notice' ) && 'valid' != $this->license_status ) : ?>
			<div class="updated">
				<p><?php printf(
					__( 'A valid licence for <strong>%1$s</strong> has not been activated. Please visit the <a href="%2$s">licensing page</a> and activate your licence to get automatic updates. | <a href="%3$s">Hide this notice</a>' ),
					$this->item_name,
					admin_url( 'themes.php?page=theme_options&tab=licensing' ),
					'?example_nag_ignore=0'
				); ?></p>
			</div>
		<?php endif;

	}


	function nag_ignore() {

		global $current_user;
		$user_id = $current_user->ID;
		// If user clicks to ignore the notice, add that to their user meta
		if ( isset( $_GET['example_nag_ignore'] ) && '0' == $_GET['example_nag_ignore'] ) {
			add_user_meta( $user_id, $this->item_shortname . '_license_key_notice', 'true', true );
		}

	}

	function register_option() {
		register_setting( $this->item_shortname, $this->item_shortname . '_license_key', array( $this, 'sanitize_license' ) );
	}

	function sanitize_license( $new ) {

		$old = $this->license;

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

			// data to send in our API request
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => $this->license,
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

			update_option( $this->item_shortname . '_license_status', $license_data->license );

		}

	}

}

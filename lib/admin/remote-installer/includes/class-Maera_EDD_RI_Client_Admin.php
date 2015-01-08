<?php

class Maera_EDD_RI_Client_Admin extends Maera_EDD_RI_Client {

	private $api_url;

	function __construct( $store_url ) {

		if ( ! is_admin() ) {
			return;
		}

		$this->api_url = trailingslashit( $store_url );

		add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'admin_menu',   array( $this, 'admin_menu' ) );

	}

	function admin_menu () {

		add_theme_page( __( 'Maera Addons', 'maera' ), __( 'Maera Addons', 'maera' ), 'install_plugins', 'edd-ri-demo', array( $this, 'settings_page' ) );
	}

	public function register_scripts() {

		wp_register_script( 'edd_ri_script', EDD_RI_PLUGIN_URL . 'assets/js/edd-ri.js', array( 'jquery' ) );
		wp_enqueue_script( 'edd_ri_script' );

		wp_register_style( 'edd_ri_css', EDD_RI_PLUGIN_URL . 'assets/css/style.css', false );
        wp_enqueue_style( 'edd_ri_css' );

		add_thickbox();

	}

	function get_downloads() {

		$domain = parse_url( $this->api_url );
		$domain = str_replace( '.', '', $domain['host'] );

		// Get the cache from the transient.
		$cache = get_transient( 'remote_installer_' . $domain );

		// If the cache does not exist, get the json and save it as a transient.
		if ( ! $cache ) {

			$api_params = array( 'edd_action' => 'get_downloads' );
			$request    = wp_remote_post( $this->api_url . '/?edd_action=get_downloads' );

			if ( is_wp_error( $request ) ) {
				return;
			}

			$request = json_decode( wp_remote_retrieve_body( $request ), true );

			set_transient( 'remote_installer_' . $domain, $request, 60 * 60 );

			$cache = $request;

		}

		return $cache;

	}

	function settings_page() { ?>

		<div class="wrap metabox-holder">
			<h2><?php _e( 'EDD Remote Installer', 'maera' ); ?></h2>

			<?php
			$downloads = $this->get_downloads();

			$i = 0;

			$plugins = $downloads['plugins'];
			$themes  = $downloads['themes'];
			?>

			<?php foreach ( $plugins as $download ) : ?>

				<?php if ( ! $download['bundle'] ) : ?>

					<?php
					$data_free   = (int) $download['free'];
					$disabled    = $this->is_plugin_installed( $download['title'] ) ? ' disabled="disabled" ' : '';
					$button_text = $this->is_plugin_installed( $download['title'] ) ? __( 'Installed', 'maera' ) : __( 'Install', 'maera' );

					$i = $i == 3 ? 0 : $i;
					?>

					<?php if ( $i == 0 ) : ?>
						<div style="clear:both; display: block; float: none;"></div>
					<?php endif; ?>

					<div id="<?php echo sanitize_title( $download['title'] ); ?>" class="edd-ri-item postbox plugin">
						<h3 class="hndle"><span><?php echo $download['title']; ?></span></h3>
						<div class="inside">
							<div class="main">
								<?php if ( '' != $download['thumbnail'] ) : ?>
									<img class="edd-ri-item-image" src="<?php echo $download['thumbnail'][0]; ?>">
								<?php endif; ?>

								<?php if ( '' != $download['description'] ) : ?>
									<p class="edd-ri-item-description"><?php echo $download['description']; ?></p>
								<?php endif; ?>

								<p class="edd-ri-actions">
									<span class="spinner"></span>
									<button class="button button-primary" data-free="<?php echo $data_free; ?>"<?php echo $disabled; ?> data-edd-ri="<?php echo $download['title']; ?>"><?php echo $button_text; ?></button>
									<a class="button" target="_blank" href="<?php echo trailingslashit( $this->api_url ) . '?p=' . $download['id']; ?>"><?php _e( 'Details', 'maera' ); ?></a>
								</p>
							</div>
						</div>
					</div>

					<?php $i++; ?>

				<?php endif; ?>

			<?php endforeach; ?>

			<div id="edd_ri_license_thickbox" style="display:none;">
				<h3><?php _e( 'Enter your license', 'maera' ); ?></h3>
				<form action="" method="post" id="edd_ri_license_form">
					<input style="width: 100%" type="text" id="edd_ri_license"/>
					<button style="margin-top: 10px" type="submit" class="button button-primary"><?php _e( 'Submit', 'maera' ); ?></button>
				</form>
			</div>
			<div class="message-popup" id="MessagePopup" style="display:none;"></div>
		</div>
		<?php

	}
}

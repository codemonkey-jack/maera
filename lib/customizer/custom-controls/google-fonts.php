<?php

/**
 * A class to create a dropdown for all google fonts
 */
 class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control {

	private $fonts = false;

	public $description = '';

	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		$this->fonts = $this->get_fonts();
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the content of the category dropdown
	 *
	 * @return HTML
	 */
	public function render_content() {

		if ( ! empty( $this->fonts ) ) { ?>
			<label>
				<span class="customize-category-select-control">
					<?php echo esc_html( $this->label ); ?>
					<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
						<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
					<?php } ?>
				</span>

				<select <?php $this->link(); ?>>
					<?php foreach ( $this->fonts as $k => $v ) {
						printf( '<option value="%s" %s>%s</option>', $k, selected( $this->value(), $k, false ), $v->family );
					} ?>
				</select>
			</label>
			<?php
		}
	}

	/**
	 * Get the google fonts from the API or in the cache
	 *
	 * @param  integer $amount
	 *
	 * @return String
	 */
	public function get_fonts( $amount = 200 ) {

		$api_key = 'AIzaSyCDiOc36EIOmwdwspLG3LYwCg9avqC5YLs';

		$font_cache = dirname( __FILE__ ) . '/cache/google-web-fonts.txt';

		// Total time the file will be cached in seconds, set to a week
		$cachetime = 86400 * 7;

		if ( file_exists( $font_cache ) && $cachetime < filemtime( $font_cache ) ) {

			$content = json_decode( file_get_contents( $font_cache ) );

		} else {

			$googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=' . $api_key;

			$fontContent = wp_remote_get( $googleApi, array( 'sslverify' => false ) );

			$fp = fopen( $font_cache, 'w' );
			fwrite( $fp, $fontContent['body'] );
			fclose( $fp );

			$content = json_decode( $fontContent['body'] );

		}

		if ( $amount == 'all' ) {
			return $content->items;
		} else {
			return array_slice( $content->items, 0, $amount );
		}
	}
 }

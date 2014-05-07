<?php

/**
 * A class to create a dropdown for all google fonts
 */
 class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control {

	private $fonts = false;

	public $description = '';

	public $subtitle = '';

	public $separator = false;

	public $required;

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
				<?php if ( '' != $this->subtitle ) : ?>
					<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
				<?php endif; ?>
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
			<?php if ( $this->separator ) echo '<hr class="customizer-separator">'; ?>
			<?php foreach ( $this->required as $id => $value ) :
			
			if ( isset($id) && isset($value) && get_theme_mod($id,0)==$value ) { ?>
				<script>
				jQuery(document).ready(function($) {
					$( "#customize-control-<?php echo $this->id; ?>" ).show();
					$( "#<?php echo $id . get_theme_mod($id,0); ?>" ).click(function(){
						$( "#customize-control-<?php echo $this->id; ?>" ).fadeOut(300);
					});
					$( "#<?php echo $id . $value; ?>" ).click(function(){
						$( "#customize-control-<?php echo $this->id; ?>" ).fadeIn(300);
					});
				});
				</script>
			<?php }

			if ( isset($id) && isset($value) && get_theme_mod($id,0)!=$value ) { ?>
				<script>
				jQuery(document).ready(function($) {
					$( "#customize-control-<?php echo $this->id; ?>" ).hide();
					$( "#<?php echo $id . get_theme_mod($id,0); ?>" ).click(function(){
						$( "#customize-control-<?php echo $this->id; ?>" ).fadeOut(300);
					});
					$( "#<?php echo $id . $value; ?>" ).click(function(){
						$( "#customize-control-<?php echo $this->id; ?>" ).fadeIn(300);
					});
				});
				</script>
			<?php }

		endforeach; 
		
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

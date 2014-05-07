<?php

class SS_Customize_Sortable_Control extends WP_Customize_Control {

	public $type = 'sortable';

	public $description = '';

	public $mode = 'checkbox';

	public $subtitle = '';

	public $separator = false;

	private static $firstLoad = true;

	public function enqueue() {

		if ( 'checkbox' == $this->mode ) {
			wp_enqueue_script( 'jquery-ui' );
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

	}

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}

		// the saved value is an array. convert it to csv
		if ( is_array( $this->value() ) ) {
			$savedValueCSV = implode( ',', $this->value() );
			$values = $this->value();
		} else {
			$savedValueCSV = $this->value();
			$values = explode( ',', $this->value() );
		}

		if ( self::$firstLoad ) {
			self::$firstLoad = false;

			?>
			<script>
			jQuery(document).ready(function($) {
				"use strict";

				$('input.tf-multicheck').change(function(event) {
					event.preventDefault();
					var csv = '';

					$(this).parents('li:eq(0)').find('input[type=checkbox]').each(function() {
						if ($(this).is(':checked')) {
							csv += $(this).attr('value') + ',';
						}
					});

					csv = csv.replace(/,+$/, "");

					$(this).parents('li:eq(0)').find('input[type=hidden]').val(csv)
					// we need to trigger the field afterwards to enable the save button
					.trigger('change');
					return true;
				});
			});
			</script>
			<?php
		}

		$name = '_customize-sortable-' . $this->id;

		?>
		<span class="customize-control-title">
			<?php echo esc_html( $this->label ); ?>
			<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
				<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
			<?php } ?>
		</span>

		<?php if ( '' != $this->subtitle ) : ?>
			<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
		<?php endif; ?>

		<div id="input_<?php echo $this->id; ?>" class="<?php echo $this->mode; ?>">
			WARNING: The 'sortable' control is not yet functional.
			<ul id="input_<?php echo $this->id; ?>">

				<?php foreach ( $this->choices as $value => $label ) : ?>
					<li class="ui-state-default">
						<?php printf('<label for="%s"><input class="tf-multicheck" id="%s" type="checkbox" value="%s" %s/> %s</label><br>',
							$this->id . $value,
							$this->id . $value,
							esc_attr( $value ),
							checked( in_array( $value, $values ), true, false ),
							$label
						); ?>
					</li>
				<?php endforeach; ?>
				<input type="hidden" value="<?php echo esc_attr( $savedValueCSV ); ?>" <?php $this->link(); ?> />
			</ul>
		</div>
		<?php if ( $this->separator ) echo '<hr class="customizer-separator">'; ?>
		<script>jQuery(document).ready(function($) { $( "#input_<?php echo $this->id; ?>" ).sortable(); }); </script>
		<?php
	}
}

<?php

class SS_Customize_Sortable_Control extends WP_Customize_Control {

	public $type = 'sortable';

	public $description = '';

	public $mode = 'checkbox';

	public $subtitle = '';

	public $separator = false;

	public function enqueue() {

		if ( 'checkbox' == $this->mode ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

	}

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
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
					<label for="<?php echo $this->id . $value; ?>">
						<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" id="<?php echo $this->id . $value; ?>" <?php echo checked( in_array( $value, $this->choices ), true, false ); ?>/>
						<?php echo $label; ?>
					</label>
				</li>
			<?php endforeach; ?>

			</ul>
		</div>
		<?php if ( $this->separator ) echo '<hr class="customizer-separator">'; ?>
		<script>jQuery(document).ready(function($) { $( "#input_<?php echo $this->id; ?>" ).sortable(); }); </script>
		<?php
	}
}

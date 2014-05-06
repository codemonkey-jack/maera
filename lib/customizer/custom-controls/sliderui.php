<?php

class SS_Customize_Sliderui_Control extends WP_Customize_Control {

	public $type = 'text';

	public function render_content() {

		add_action( $this->setting, array( $this, $this->setting ) );

		$s_val   = $s_min = $s_max = $s_step = $s_edit = ''; //no errors, please
		$choices = $this->choices;
		$s_val   = $this->value;

		$s_min  = ! isset( $choices['min'] )  ? '0' : $choices['min'];
		$s_max  = ! isset( $choices['max'] )  ? $s_min + 1 : $choices['max'];
		$s_step = ! isset( $choices['step'] ) ? '1' : $choices['step'];
		$s_edit = ! isset( $choices['edit'] ) ?' readonly="readonly"' : '';

		if ( $s_val == '' ) {
			$s_val = $s_min;
		}

		//values
		$s_data = 'data-id="' . $this->setting . '" data-val="' . $this->value() . '" data-min="' . $s_min . '" data-max="' . $s_max . '" data-step="' . $s_step . '"';

		//html output
		$output .= '<input type="text" ' . $this->get_link() . ' name="' . $this->setting . '" id="' . $this->setting . '" value="' . $this->value() . '" class="mini" ' . $s_edit . ' />';
		$output .= '<div id="' . $this->setting . '-slider" class="smof_sliderui" style="margin-left: 7px;" ' . $s_data . '></div>';

		?>

		<label class="customizer-sliderui">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>

			<?php echo $output; ?>

			<?php if ( '' != $this->description ) { ?>
				<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
			<?php } ?>
		</label>
		<?php
	}
}

<?php

class Shoestrap_Customize_Control_Textarea extends WP_Customize_Control {

	public $type = 'textarea';

	public function render_content() { ?>

		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea <?php $this->link(); ?> rows="12" style="width: 98%;"><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
		<?php

	}

}

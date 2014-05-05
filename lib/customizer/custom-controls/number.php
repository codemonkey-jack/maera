<?php

class Shoestrap_Customize_Control_Number extends WP_Customize_Control {

	public $type = 'number';

	public function render_content() { ?>

		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<input type="number" <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>" style="width: 98%;"/>
		</label>
		<?php

	}

}

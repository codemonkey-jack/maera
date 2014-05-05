<?php

class Shoestrap_Customize_Control_Sub_Title extends WP_Customize_Control {

	public $type = 'sub-title';

	public function render_content() { ?>

		<h4 class="customize-sub-title"><?php echo esc_html( $this->label ); ?></h4>

		<?php
	}

}

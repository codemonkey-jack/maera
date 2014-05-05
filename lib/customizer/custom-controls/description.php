<?php

class Shoestrap_Customize_Control_Description extends WP_Customize_Control {

	public $type = 'description';

	public function render_content() { ?>

		<p class="customize-description"><span>INFO:</span> <?php echo esc_html( $this->label ); ?></p>

		<?php
	}

}

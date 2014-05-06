<?php

class SS_Customize_Textarea_Control extends WP_Customize_Control {

	public $type = 'textarea';

	public $description = '';

	public function render_content() { ?>
		<label class="customizer-textarea">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>
			<textarea class="of-input" rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
		<?php
	}
}

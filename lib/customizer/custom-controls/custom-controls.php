<?php


if ( class_exists( 'WP_Customize_Control' ) ) {
	class Shoestrap_Customize_Text_Control extends WP_Customize_Control {

		public $type = 'text';

		public function render_content() { ?>

			<label class="customizer-text">
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>

				<input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
				<?php if ( ! empty( $this->description ) ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
					<a href="#" class="button pointer" style="display: none;" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">P</a>
				<?php } ?>
			</label>
			<?php
		}
	}

	class Shoestrap_Customize_Select_Control extends WP_Customize_Control {

		public $type = 'select';

		public function render_content() {

			$value = $this->value();
			if ( empty( $this->choices ) ) {
				return;
			}

			$mini ='';

			if ( ! isset( $value['mod'] ) ) {
				$value['mod'] = '';
			}

			if ( $value['mod'] == 'mini' ) {
				$mini = 'mini';
			}
			?>

			<label class="customizer-select">
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
					<?php if ( $this->description != '' ) { ?>
						<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
					<?php } ?>
				</span>

				<div class="select_wrapper <?php echo $mini; ?>">
					<select data-customize-setting-link="<?php echo $this->setting; ?>" class="select of-input" name="<?php echo $this->label; ?>" id="<?php echo $this->setting; ?>">
						<?php foreach ( $value['options'] as $select_ID => $option ) { ?>
							<?php $selected = ( in_array( $select_ID, $this->value() ) ) ? selected( 1, 1, false ) : ''; ?>
							<option id="<?php echo $select_ID; ?>" value="<?php echo $option; ?>" <?php echo $selected; ?> /><?php echo $option; ?></option>
						<?php } ?>
					</select>
				</div>';

			</label>
			<?php
		}
	}

	class Shoestrap_Customize_Textarea_Control extends WP_Customize_Control {

		public $type = 'textarea';

		public function render_content() { ?>
			<label class="customizer-textarea">
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?> <?php if ( $this->description != '' ) { ?>
						<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
					<?php } ?>
				</span>

				<textarea class="of-input" rows="12" style="width:98%;" <?php $this->link(); ?>>
					<?php echo esc_textarea( $this->value() ); ?>
				</textarea>
			</label>
			<?php
		}
	}

	class Shoestrap_Customize_Radio_Control extends WP_Customize_Control {

		public $type = 'radio';

		public function render_content() {

			$name = '_customize-radio-' . $this->setting; ?>

			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>

				<?php if ( $this->description != '' ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>

			<?php foreach ( $this->choices as $value => $label ) : ?>
				<label class="customizer-radio">
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
					<?php echo esc_html( $label ); ?><br/>
				</label>
			<?php endforeach;
		}
	}
}

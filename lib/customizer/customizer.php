<?php

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

require_once locate_template( '/lib/customizer/custom-controls/checkbox.php' );
require_once locate_template( '/lib/customizer/custom-controls/color.php' );
require_once locate_template( '/lib/customizer/custom-controls/google-fonts.php' );
require_once locate_template( '/lib/customizer/custom-controls/image.php' );
require_once locate_template( '/lib/customizer/custom-controls/radio.php' );
require_once locate_template( '/lib/customizer/custom-controls/select.php' );
require_once locate_template( '/lib/customizer/custom-controls/sliderui.php' );
require_once locate_template( '/lib/customizer/custom-controls/text.php' );
require_once locate_template( '/lib/customizer/custom-controls/textarea.php' );
require_once locate_template( '/lib/customizer/custom-controls/upload.php' );

function shoestrap_customizer_controls( $wp_customize ) {

	$controls = apply_filters( 'shoestrap/customizer/controls', array() );

	if ( isset( $controls ) ) {
		foreach ( $controls as $control ) {

			// Add settings
			$wp_customize->add_setting( $control['setting'], array(
				'default'    => $control['default'],
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options'
			) );

			// Checkbox controls
			if ( 'checkbox' == $control['type'] ) {

				$wp_customize->add_control( new SS_Customize_Checkbox_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => $control['description'],
					) )
				);

			// Slider Controls
			} elseif ( 'slider' == $control['type'] ) {

				$wp_customize->add_control( new SS_Customize_Sliderui_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => $control['description'],
					) )
				);
			}
		}
	}
}
add_action( 'customize_register', 'shoestrap_customizer_controls' );

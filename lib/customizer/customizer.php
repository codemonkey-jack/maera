<?php

require_once locate_template( '/lib/customizer/custom-controls/description.php' );
require_once locate_template( '/lib/customizer/custom-controls/multi-select.php' );
require_once locate_template( '/lib/customizer/custom-controls/number.php' );
require_once locate_template( '/lib/customizer/custom-controls/slider.php' );
require_once locate_template( '/lib/customizer/custom-controls/subtitle.php' );
require_once locate_template( '/lib/customizer/custom-controls/textarea.php' );

function shoestrap_customizer_controls( $wp_customize ) {

	$controls = apply_filters( 'shoestrap/customizer/controls', array() );

	if ( isset( $controls ) ) {
		foreach ( $controls as $control ) {

			// Checkbox controls
			if ( 'checkbox' == $control['type'] ) {

				$wp_customize->add_setting( $control['setting'], array(
					'default'    => $control['default'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_control( $control['setting'], array(
					'label'       => __( $control['label'], 'shoestrap' ),
					'section'     => $control['section'],
					'settings'    => $control['setting'],
					'type'        => 'checkbox',
					'priority'    => $control['priority'],
				) );

			// Slider Controls
			} elseif ( 'slider' == $control['type'] ) {

				$wp_customize->add_setting( $control['setting'], array(
					'default'    => $control['default'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_control( new Shoestrap_Customize_Control_Slider( $wp_customize, $control['setting'], array(
						'label'    => $control['label'],
						'section'  => $control['section'],
						'settings' => $control['setting'],
						'priority' => $control['priority'],
						'choices'  => $control['choices']
					) )
				);

			// Multiselect Controls
			} elseif ( 'multiselect' == $control['type'] ) {

				$wp_customize->add_setting( $control['setting'], array(
					'default'    => $control['default'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_control( new Shoestrap_Customize_Control_Multiple_Select( $wp_customize, $control['setting'], array(
						'label'    => $control['label'],
						'section'  => $control['section'],
						'settings' => $control['setting'],
						'priority' => $control['priority'],
						'choices'  => $control['choices']
					) )
				);
			}
		}
	}
}
add_action( 'customize_register', 'shoestrap_customizer_controls' );

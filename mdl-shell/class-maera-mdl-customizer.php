<?php

class Maera_MDL_Customizer {

    public function __construct() {
        /**
         * Early exit if Kirki does not exists
         */
        if ( ! class_exists( 'Kirki' ) ) {
            return;
        }

        $this->add_config();
        $this->add_panels();
        $this->add_sections();
        $this->add_fields();
    }

    public function add_config() {
        Kirki::add_config( 'maera_mdl', array(
            'option_type' => 'theme_mod',
            'capability'  => 'edit_theme_options',
        ) );
    }

    public function add_panels() {

    }

    public function add_sections() {
        Kirki::add_section( 'header', array(
            'title'          => __( 'Header', 'maera' ),
            'description'    => __( 'Edit your header options', 'maera' ),
            'priority'       => 10,
        ) );
    }

    public function add_fields() {
        Kirki::add_field( 'maera_mdl', array(
            'type'        => 'color',
            'settings'    => 'header_bg_color',
            'label'       => __( 'Header Background Color', 'maera' ),
            'section'     => 'header',
            'default'     => '#de3495',
            'priority'    => 10,
            'output'      => array(
                array(
                    'element'  => '.mdl-layout__header',
                    'property' => 'background-color'
                ),
                array(
                    'element'           => '.mdl-layout__header-row .mdl-navigation__link',
                    'property'          => 'color',
                    'sanitize_callback' => array( $this, 'max_readability' ),
                )
            )
        ) );
    }

    public function max_readability( $value ) {

        $difference_from_white = Kirki_Color::lumosity_difference( $value, '#FFFFFF' );
        $difference_from_dark  = Kirki_Color::lumosity_difference( $value, '#222222' );

        return ( $difference_from_white > $difference_from_dark ) ? '#FFFFFF' : '#222222';

    }
}

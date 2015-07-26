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
            'priority'       => 10,
        ) );
        Kirki::add_section( 'layout', array(
            'title'          => __( 'Layout', 'maera' ),
            'priority'       => 10,
        ) );
        Kirki::add_section( 'featured_images', array(
            'title'          => __( 'Featured Images Area', 'maera' ),
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

        Kirki::add_field( 'maera_mdl', array(
            'type'        => 'color',
            'settings'    => 'logo_background_color',
            'label'       => __( 'Logo Background Color', 'maera' ),
            'section'     => 'header',
            'default'     => '#de3495',
            'priority'    => 10,
            'output'      => array(
                array(
                    'element'  => '.mdl-layout__drawer > .mdl-layout-title',
                    'property' => 'background-color'
                ),
            ),
        ) );

        Kirki::add_field( 'maera_mdl', array(
            'type'     => 'slider',
            'settings' => 'single_post_max_width',
            'label'    => __( 'Max-Width for single-posts content (in px)', 'maera' ),
            'section'  => 'layout',
            'default'  => 900,
            'choices'  => array(
                'min'  => 400,
                'max'  => 1200,
                'step' => 1,
            ),
            'output'   => array(
                array(
                    'element'  => '.single-post-content-wrapper',
                    'property' => 'max-width',
                    'units'    => 'px',
                )
            )
        ) );

        Kirki::add_field( 'maera_mdl', array(
            'type'     => 'slider',
            'settings' => 'single_post_inner_padding',
            'label'    => __( 'Inner Padding on single-posts main content (in px)', 'maera' ),
            'section'  => 'layout',
            'default'  => 180,
            'choices'  => array(
                'min'  => 20,
                'max'  => 400,
                'step' => 1,
            ),
            'output'   => array(
                array(
                    'element'  => '.single-post-content-wrapper .mdl-card__supporting-text .inner',
                    'property' => 'padding-left',
                    'units'    => 'px',
                ),
                array(
                    'element'  => '.single-post-content-wrapper .mdl-card__supporting-text .inner',
                    'property' => 'padding-right',
                    'units'    => 'px',
                )
            )
        ) );

        Kirki::add_field( 'maera_mdl', array(
            'type'     => 'slider',
            'settings' => 'archive_post_max_width',
            'label'    => __( 'Max-Width for single-posts content (in px)', 'maera' ),
            'section'  => 'layout',
            'default'  => 900,
            'choices'  => array(
                'min'  => 400,
                'max'  => 1200,
                'step' => 1,
            ),
            'output'   => array(
                array(
                    'element'  => '.archive-post-content-wrapper',
                    'property' => 'max-width',
                    'units'    => 'px',
                )
            )
        ) );

        Kirki::add_field( 'maera_mdl', array(
            'type'     => 'slider',
            'settings' => 'archive_post_inner_padding',
            'label'    => __( 'Inner Padding on single-posts main content (in px)', 'maera' ),
            'section'  => 'layout',
            'default'  => 25,
            'choices'  => array(
                'min'  => 20,
                'max'  => 400,
                'step' => 1,
            ),
            'output'   => array(
                array(
                    'element'  => '.archive-post-content-wrapper .mdl-card__supporting-text .inner',
                    'property' => 'padding-left',
                    'units'    => 'px',
                ),
                array(
                    'element'  => '.archive-post-content-wrapper .mdl-card__supporting-text .inner',
                    'property' => 'padding-right',
                    'units'    => 'px',
                )
            )
        ) );

        Kirki::add_field( 'maera_mdl', array(
            'type'     => 'slider',
            'settings' => 'featured_image_height',
            'label'    => __( 'Featured Images min-height (in px)', 'maera' ),
            'section'  => 'featured_images',
            'default'  => 280,
            'choices'  => array(
                'min'  => 100,
                'max'  => 700,
                'step' => 1,
            ),
            'output'   => array(
                array(
                    'element'  => '.single-post-featured-image',
                    'property' => 'min-height',
                    'units'    => 'px',
                ),
            ),
        ) );

        Kirki::add_field( 'maera_mdl', array(
            'type'     => 'color',
            'settings' => 'featured_images_background_color',
            'label'    => __( 'Background Color', 'maera' ),
            'default'  => '#37474f',
            'output'      => array(
                array(
                    'element'  => '.mdl-card__media',
                    'property' => 'background-color'
                ),
                array(
                    'element'           => '.archive-post-content-wrapper .mdl-card__media h3.entry-title a',
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

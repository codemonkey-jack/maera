<?php

/**
 * The Maera Material Design Lite shell
 */
class Maera_MDL {

    public $customizer = null;

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
        $this->customizer = new Maera_MDL_Customizer();
    }

    /**
     * Enqueue scripts & styles
     */
    public function enqueue() {
        /**
         * Add MDL assets
         */
        wp_enqueue_style( 'maera-mdl', MAERA_SHELL_URL . '/assets/css/material.css' );
        wp_enqueue_style( 'maera-mdl-custom', MAERA_SHELL_URL . '/assets/css/maera-mdl.css' );
        wp_enqueue_script( 'maera-mdl-style', MAERA_SHELL_URL . '/assets/js/material.js' );

    }

    /**
     * The container class
     *
     * @return string
     */
    public function container() {
        return 'container';
    }

    /**
     * The row class
     *
     * @return string
     */
    public function row() {
        return 'mdl-grid';
    }

    /**
     * The column classes
     *
     * @param $columns      int|string      the number of columns.
     * @param $tablet       int|string      the number of columns on a tablet.
     * @param $mobile       int|string      the number of columns on a mobile.
     * @return string
     */
    public function column( $columns = 12, $tablet = null, $mobile = null ) {

        $classes  = 'mdl-cell';
        $classes .= ' mdl-cell--' . intval( $columns ) . '-col';
        if ( null !== $tablet ) {
            $classes .= ' mdl-cell--' . intval( $tablet ) . '-col-tablet';
        }
        if ( null !== $mobile ) {
            $classes .= ' mdl-cell--' . intval( $mobile ) . '-col-mobile';
        }

        return $classes;

    }

    /**
     * The column classes
     *
     * @param $color        string          the button color
     * @param $size         string          the button size
     * @param $type         string          the button type
     * @return string
     */
    public function button( $color = null, $size = null, $type = null ) {

        $classes = 'mdl-button mdl-js-button mdl-js-ripple-effect';
        if ( null !== $color ) {
            if ( 'accent' == $color ) {
                $classes .= ' mdl-button--accent';
            } else {
                $classes .= ' mdl-button--primary';
            }
        }
        if ( null !== $type ) {
            if ( 'round' == $type ) {
                $classes .= ' mdl-button--fab';
            }
        }

        return $classes;

    }

}

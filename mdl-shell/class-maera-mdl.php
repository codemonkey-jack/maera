<?php

/**
 * The Maera Material Design Lite shell
 */
class Maera_MDL extends Maera_Shell {

    /**
     * The class constructor
     */
    public function __construct() {
        parent::__construct();
        $customizer = new Maera_MDL_Customizer();
    }

    /**
     * Define the shell's path.
     *
     * @return string   absolute path to the shell
     */
    public function path() {
        return get_template_directory() . '/mdl-shell';
    }

    /**
     * Define the shell's path.
     *
     * @return string   absolute path to the shell's templates folder.
     */
    public function templates_path() {
        return get_template_directory() . '/mdl-shell/templates';
    }

    /**
     * Define the shell's path.
     *
     * @return string   URL of the shell.
     */
    public function url() {
        return get_template_directory_uri() . '/mdl-shell';
    }

    /**
     * Enqueue the shell's scripts and styles.
     *
     * @return void
     */
    public function enqueue() {
        wp_enqueue_style( 'maera-mdl', trailingslashit( Maera()->shell->url ) . 'assets/css/material.css' );
        wp_enqueue_style( 'maera-mdl-custom', trailingslashit( Maera()->shell->url ) . 'assets/css/maera-mdl.css' );
        wp_enqueue_script( 'maera-mdl-style', trailingslashit( Maera()->shell->url ) . 'assets/js/material.js' );
    }

    /**
     * Define the shell's container CSS class.
     *
     * @return string   the CSS class of the shell's container class for grids.
     */
    public function container() {
        return 'container';
    }

    /**
     * Define the shell's row CSS class.
     *
     * @return string   the CSS class of the shell's row class for grids.
     */
    public function row() {
        return 'mdl-grid';
    }

    /**
     * Define the shell's column CSS class.
     * Returns a string containing CSS classes
     * depending on the arguments passed to it.
     * The default is using a 12-column grid,
     * but that can change depending on the shell's implementation.
     *
     * @param $columns_desktop  int     The number of columns for desktop.
     * @param $columns_tablet   int     The number of columns for tablets.
     * @param $columns_mobile   int     The number of columns for mobiles.
     * @return                  string  The CSS class of the shell's container class for grids.
     */
    public function column( $columns_desktop = 12, $columns_tablet = null, $columns_mobile = null ) {

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
     * Define the shell's button CSS classes.
     * Returns a string containing the CSS classes of the button
     * depending on the arguments passed to it.
     *
     * @param $color    string  The button color.
     * @param $size     string  The button size.
     * @param $type     string  The button type (example: round).
     * @return          string  The CSS classes needed to properly render the button.
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

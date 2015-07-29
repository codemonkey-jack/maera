<?php

class Maera {

    /**
     * The defined shell array.
     * See the add_shell method for more details.
     */
    public $shell = array();
    /**
     * This holds the instance of the Maera_Template class.
     */
    public $template = null;

    /**
     * The class constructor.
     */
    public function __construct() {
        /**
         * Make sure the shell is instantiated on 'after_setup_theme'.
         */
        add_action( 'after_setup_theme', array( $this, 'add_shell' ) );
        /**
         * instantiate the Maera_Template class.
         */
        $this->template = new Maera_Template();
    }

    /**
     * Add the shell.
     * The current shell can be changed by using Maera()->shell = array();
     */
    public function add_shell() {
        /**
         * Set some defaults (core shell)
         */
        $defaults = array(
            'name'     => 'Material Design Lite',
            'id'       => 'maera_mdl',
            'class'    => 'Maera_MDL',
        );
        /**
         * Merge args and use our defined shell (if another one is defined)
         */
        $args = wp_parse_args( $this->shell, $defaults );

        /**
         * Instantiate the selected shell class
         */
        if ( ! isset( $args['instance'] ) ) {
            $shell_class = $args['class'];
            if ( class_exists( $shell_class ) ) {
                $args['instance'] = new $shell_class();
            } else {
                die( sprintf( __( 'class %s was not found. Please make sure that the "%s" Maera shell is properly installed', 'maera' ), $args['class'], $args['name'] ) );
            }
        }

        /**
         * Set the class's $shell property.
         */
        $this->shell = $args;
    }

}

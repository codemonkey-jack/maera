<?php

class Maera {

    public $shell         = array();
    public $template      = null;

    public function __construct() {
        add_action( 'init', array( $this, 'add_shell' ) );
        $this->add_shell();
        $this->template = new Maera_Template();
    }

    public function add_shell() {
        $defaults = array(
            'name'     => 'Material Design Lite',
            'id'       => 'maera_mdl',
            'class'    => 'Maera_MDL',
        );
        $args = wp_parse_args( $this->shell, $defaults );

        if ( ! isset( $args['instance'] ) ) {
            $shell_class = $args['class'];
            if ( class_exists( $shell_class ) ) {
                $args['instance'] = new $shell_class();
            } else {
                die( sprintf( __( 'class %s was not found. Please make sure that the "%s" Maera shell is properly installed', 'maera' ), $args['class'], $args['name'] ) );
            }
        }

        $this->shell = $args;
    }

    /**
     * This is an alias of the static method in the Maera_Wrapping class.
     */
    public static function get_template_part( $slug, $name = null ) {
        return Maera_Template::get_template_part( $slug, $name );
    }

}

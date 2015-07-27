<?php

class Maera {

    public $shell_handler = null;
    public $shell         = null;
    public $template      = null;

    public function __construct() {
        $this->shell_handler = new Maera_Shell_Handler();
        $this->shell = $this->shell_handler->active_shell;
        $this->template = new Maera_Template();
    }

    /**
     * This is an alias of the static method in the Maera_Wrapping class.
     */
    public static function get_template_part( $slug, $name = null ) {
        return Maera_Template::get_template_part( $slug, $name );
    }

}

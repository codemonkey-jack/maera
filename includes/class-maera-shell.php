<?php

class Maera_Shell {

    public $active_shell = null;

    /**
     * Instantiate the shell
     */
     public function __construct() {
         $this->load_shell();
     }

     /**
      * If no shell is loaded, load the core shell.
      */
     public function load_shell() {

         $active_shell = apply_filters( 'maera/shell/active_shell', 'Maera_MDL' );
         if ( class_exists( $active_shell ) ) {
             $this->$active_shell = new $active_shell();
         } else {
             die( sprintf( __( 'class %s was not found make sure that the active Maera shell is properly installed', 'maera' ), $active_shell ) );
         }

     }

 }

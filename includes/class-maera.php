<?php

class Maera {

    public $shell_handler = null;
    public $shell         = null;

    public function __construct() {
        $this->shell_handler = new Maera_Shell_Handler();
        $this->shell = $this->shell_handler->active_shell;
    }

}

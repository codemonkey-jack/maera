<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package  WordPress
 * @subpackage  Maera
 * @since    Maera 0.1
 */

Maera()->template->dependencies();

Maera_Template::header();
Maera_Template::main( '404.twig' );
Maera_Template::footer();

<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package  WordPress
 * @subpackage  Maera
 * @since    Maera 0.1
 */

Maera_Template::dependencies();

Maera_Template::get_header();
Maera_Template::content( '404.twig' );
Maera_Template::get_footer();

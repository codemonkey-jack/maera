<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package  WordPress
 * @subpackage  Maera
 * @since    Maera 0.1
 */

Maera()->views->dependencies();

Maera()->views->header();
Maera()->views->render( '404.twig' );
Maera()->views->footer();
